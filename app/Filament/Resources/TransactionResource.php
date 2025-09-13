<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Issuer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Transactions / المعاملات';

    protected static ?string $modelLabel = 'Transaction / معاملة';

    protected static ?string $pluralModelLabel = 'Transactions / المعاملات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Transaction Information / معلومات المعاملة')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Type / النوع')
                            ->options([
                                'debit' => 'سند قبض / Debit',
                                'return_goods' => 'مرتجع / Return Goods',
                                'discount' => 'خصم / Discount',
                            ])
                            ->required()
                            ->live()
                            ->native(false),

                        Forms\Components\TextInput::make('document_number')
                            ->label('Document Number / رقم السند')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('transaction_date')
                            ->label('Date / التاريخ')
                            ->required()
                            ->default(now()),

                        Forms\Components\Grid::make(2) // creates 2 equal columns
                            ->schema([
                                Forms\Components\Select::make('customer_id')
                                    ->label('Customer / العميل')
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        if ($state) {
                                            $customer = Customer::find($state);
                                            if ($customer) {
                                                $set('customer_city', $customer->city);
                                                $set('customer_name', $customer->customer_name);
                                            }
                                        }
                                    })
                                    ->options(function () {
                                        $user = Auth::user();
                                        
                                        if (!$user) {
                                            return [];
                                        }
                                        
                                        // Admin can see all customers
                                        if ($user->hasRole('admin')) {
                                            return Customer::pluck('customer_name', 'id')->toArray();
                                        }
                                        
                                        // Issuer can only see their own customers and assigned customers
                                        if ($user->hasRole('issuer') && $user->issuer) {
                                            $issuer = $user->issuer;
                                            $viewableIssuerIds = $issuer->getAllViewableIssuers()->pluck('id');
                                            return Customer::whereIn('issuer_id', $viewableIssuerIds)
                                                ->pluck('customer_name', 'id')
                                                ->toArray();
                                        }
                                        
                                        return [];
                                    })
                                    ->getSearchResultsUsing(function (string $search) {
                                        $user = Auth::user();
                                        
                                        if (!$user) {
                                            return [];
                                        }
                                        
                                        $query = Customer::query();
                                        
                                        // Admin can see all customers
                                        if ($user->hasRole('admin')) {
                                            return $query
                                                ->where('customer_name', 'like', "%{$search}%")
                                                ->orWhere('account_number', 'like', "%{$search}%")
                                                ->limit(50)
                                                ->get()
                                                ->mapWithKeys(function ($customer) {
                                                    return [$customer->id => $customer->customer_name . ' (' . $customer->account_number . ')'];
                                                });
                                        }
                                        
                                        // Issuer can only see their own customers and assigned customers
                                        if ($user->hasRole('issuer') && $user->issuer) {
                                            $issuer = $user->issuer;
                                            $viewableIssuerIds = $issuer->getAllViewableIssuers()->pluck('id');
                                            
                                            return $query
                                                ->whereIn('issuer_id', $viewableIssuerIds)
                                                ->where(function ($query) use ($search) {
                                                    $query->where('customer_name', 'like', "%{$search}%")
                                                        ->orWhere('account_number', 'like', "%{$search}%");
                                                })
                                                ->limit(50)
                                                ->get()
                                                ->mapWithKeys(function ($customer) {
                                                    return [$customer->id => $customer->customer_name . ' (' . $customer->account_number . ')'];
                                                });
                                        }
                                        
                                        return [];
                                    })
                                    ->getOptionLabelUsing(function ($value) {
                                        $customer = Customer::find($value);
                                        return $customer ? $customer->customer_name . ' (' . $customer->account_number . ')' : '';
                                    })
                                    ->required(),

                                Forms\Components\TextInput::make('customer_city')
                                    ->label('City / المدينة')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated(),
                            ]),

                        // Hidden field for customer_name - required by database
                        Forms\Components\Hidden::make('customer_name')
                            ->dehydrated(),

                    ])->columns(3),

                Forms\Components\Section::make('Transaction Items / بنود المعاملة')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('item_name')
                                    ->label('Item Name / اسم المنتج')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('item_number')
                                    ->label('Item Number / رقم المنتج')
                                    ->numeric()
                                    ->required()
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('yards')
                                    ->label('Yards / الياردات')
                                    ->numeric()
                                    ->required()
                                    ->step(0.01)
                                    ->suffix('yards')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        $pricePerYard = $get('price_per_yard') ?? 0;
                                        // Convert to numbers before calculation
                                        $yards = is_numeric($state) ? (float) $state : 0;
                                        $price = is_numeric($pricePerYard) ? (float) $pricePerYard : 0;
                                        $total = $yards * $price;
                                        $set('total', number_format($total, 2, '.', ''));
                                    })
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('price_per_yard')
                                    ->label('Price per Yard / السعر بالياردة')
                                    ->numeric()
                                    ->required()
                                    ->step(0.01)
                                    ->prefix('SAR')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        $yards = $get('yards') ?? 0;
                                        // Convert to numbers before calculation
                                        $price = is_numeric($state) ? (float) $state : 0;
                                        $yardsNum = is_numeric($yards) ? (float) $yards : 0;
                                        $total = $yardsNum * $price;
                                        $set('total', number_format($total, 2, '.', ''));
                                    })
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('total')
                                    ->label('Total / المجموع')
                                    ->numeric()
                                    ->prefix('SAR')
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(1),
                            ])
                            ->columns(6)
                            ->addActionLabel('Add Item / إضافة منتج')
                            ->defaultItems(1)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['item_name'] ?? null)
                            ->live()
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                $items = $get('items') ?? [];
                                $totalAmount = 0;
                                $totalYards = 0;

                                foreach ($items as $item) {
                                    if (isset($item['total']) && is_numeric($item['total'])) {
                                        $totalAmount += (float) $item['total'];
                                    }
                                    if (isset($item['yards']) && is_numeric($item['yards'])) {
                                        $totalYards += (float) $item['yards'];
                                    }
                                }

                                $set('total_amount', $totalAmount);
                            })
                            ->addAction(
                                fn (Forms\Components\Actions\Action $action) => $action
                                    ->label('Add Item / إضافة منتج')
                                    ->icon('heroicon-m-plus')
                                    ->action(function (Forms\Get $get, Forms\Set $set) {
                                        $items = $get('items') ?? [];
                                        $items[] = [
                                            'item_name' => '',
                                            'item_number' => '',
                                            'yards' => '',
                                            'price_per_yard' => '',
                                            'total' => 0, // Set as number instead of empty string
                                        ];
                                        $set('items', $items);
                                    })
                            ),
                    ]),

                Forms\Components\Section::make('Payment Information / معلومات الدفع')
                    ->schema([
                        Forms\Components\TextInput::make('amount')
                            ->label('Amount / المبلغ')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('SAR')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                $items = $get('items') ?? [];
                                $totalFromItems = 0;

                                foreach ($items as $item) {
                                    if (isset($item['total']) && is_numeric($item['total'])) {
                                        $totalFromItems += (float) $item['total'];
                                    }
                                }

                                // If amount is not set, use total from items
                                if (!$state && $totalFromItems > 0) {
                                    $set('amount', $totalFromItems);
                                }

                                // Update total_amount
                                $set('total_amount', $state ?: $totalFromItems);
                            }),

                        Forms\Components\Select::make('payment_method')
                            ->label('Payment Method / طريقة الدفع')
                            ->options([
                                'cash' => 'نقداً / Cash',
                                'bank_transfer' => 'تحويل بنكي / Bank Transfer',
                                'check' => 'شيك / Check',
                                'credit_card' => 'بطاقة ائتمان / Credit Card',
                                'other' => 'أخرى / Other',
                            ])
                            ->searchable()
                            ->preload()
                            ->native(false),

                        Forms\Components\TextInput::make('total_amount')
                            ->label('Total Amount / إجمالي المبلغ')
                            ->numeric()
                            ->prefix('SAR')
                            ->disabled()
                            ->dehydrated(),
                    ])->columns(3),

                Forms\Components\Section::make('Additional Information / معلومات إضافية')
                    ->schema([
                        Forms\Components\Select::make('issuer_id')
                            ->label('Issuer / الموظف')
                            ->relationship('issuer', 'full_name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default(function () {
                                // If user is an issuer, auto-select their issuer record
                                $user = Auth::user();
                                if ($user && $user->hasRole('issuer') && $user->issuer) {
                                    return $user->issuer->id;
                                }
                                return null;
                            })
                            ->disabled(function () {
                                // Disable for issuers (they can only create transactions for themselves)
                                $user = Auth::user();
                                return $user && $user->hasRole('issuer');
                            }),

                        Forms\Components\Grid::make(2) // creates 2 equal columns
                            ->schema([
                                Forms\Components\Textarea::make('remarks')
                                    ->label('Remarks / ملاحظات')
                                    ->rows(5),
                            ])->columns(1),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Type' . PHP_EOL . 'النوع')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'debit' => 'success',
                        'return_goods' => 'warning',
                        'discount' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'debit' => 'سند قبض / Debit',
                        'return_goods' => 'مرتجع / Return Goods',
                        'discount' => 'خصم / Discount',
                    })
                    ->width('140px'),
                Tables\Columns\TextColumn::make('document_number')
                    ->label('Document #' . PHP_EOL . 'رقم السند')
                    ->searchable()
                    ->sortable()
                    ->width('130px'),
                Tables\Columns\TextColumn::make('transaction_date')
                    ->label('Date' . PHP_EOL . 'التاريخ')
                    ->date()
                    ->sortable()
                    ->width('100px'),
                Tables\Columns\TextColumn::make('customer.customer_name')
                    ->label('Customer Name' . PHP_EOL . 'اسم العميل')
                    ->searchable()
                    ->sortable()
                    ->width('180px'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount' . PHP_EOL . 'المبلغ')
                    ->money('SAR')
                    ->sortable()
                    ->toggleable()
                    ->width('120px'),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Payment Method' . PHP_EOL . 'طريقة الدفع')
                    ->searchable()
                    ->toggleable()
                    ->width('150px'),
                Tables\Columns\TextColumn::make('items_count')
                    ->label('Items Count' . PHP_EOL . 'عدد المنتجات')
                    ->counts('items')
                    ->badge()
                    ->width('120px'),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total' . PHP_EOL . 'المجموع')
                    ->money('SAR')
                    ->sortable()
                    ->toggleable()
                    ->width('120px'),
                Tables\Columns\TextColumn::make('issuer.full_name')
                    ->label('Issuer' . PHP_EOL . 'اسم الموظف')
                    ->searchable()
                    ->sortable()
                    ->width('150px'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At' . PHP_EOL . 'تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->width('150px'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Type / النوع')
                    ->options([
                        'debit' => 'سند قبض / Debit',
                        'return_goods' => 'مرتجع / Return Goods',
                        'discount' => 'خصم / Discount',
                    ]),
                Tables\Filters\SelectFilter::make('customer_id')
                    ->label('Customer / العميل')
                    ->relationship('customer', 'customer_name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('issuer_id')
                    ->label('Issuer / الموظف')
                    ->relationship('issuer', 'full_name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('created_from')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Created From / من تاريخ'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            );
                    }),
                Tables\Filters\Filter::make('created_until')
                    ->form([
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Created Until / إلى تاريخ'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        
        if (!$user) {
            return parent::getEloquentQuery()->whereRaw('1 = 0'); // No access if not authenticated
        }

        // Admin can see everything
        if ($user->hasRole('admin')) {
            return parent::getEloquentQuery();
        }

        // Issuer can only see their own transactions and those they have access to
        if ($user->hasRole('issuer') && $user->issuer) {
            $issuer = $user->issuer;
            $viewableIssuerIds = $issuer->getAllViewableIssuers()->pluck('id');
            
            return parent::getEloquentQuery()->whereIn('issuer_id', $viewableIssuerIds);
        }

        // No access for other roles
        return parent::getEloquentQuery()->whereRaw('1 = 0');
    }
}
