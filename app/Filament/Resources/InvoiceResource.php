<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Issuer;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Invoices / الفواتير';

    protected static ?string $modelLabel = 'Invoice / فاتورة';

    protected static ?string $pluralModelLabel = 'Invoices / الفواتير';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Invoice Information / معلومات الفاتورة')
                    ->schema([
                        Forms\Components\TextInput::make('goods_delivery_document_number')
                            ->label('Delivery Doc # / رقم سند التسليم')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('invoice_date')
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
                                                $set('customer_city_display', $customer->city ? $customer->city->name : '');
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

                                Forms\Components\TextInput::make('customer_city_display')
                                    ->label('City / المدينة')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        $customerId = $get('customer_id');
                                        if ($customerId) {
                                            $customer = \App\Models\Customer::with('city')->find($customerId);
                                            if ($customer && $customer->city) {
                                                $set('customer_city_display', $customer->city->name);
                                            }
                                        }
                                    })
                                    ->formatStateUsing(function ($record) {
                                        if ($record && $record->customer && $record->customer->city) {
                                            return $record->customer->city->name;
                                        }
                                        return null;
                                    }),
                            ]),

                    ])->columns(3),

                Forms\Components\Section::make('Invoice Items / بنود الفاتورة')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->label('Product / المنتج')
                                    ->searchable()
                                    ->preload()
                                    ->options(Product::pluck('name', 'id'))
                                    ->required()
                                    ->reactive() // important for triggering updates
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        if ($state) {
                                            $product = Product::find($state);
                                            $set('item_number', $product?->number ?? '');
                                        } else {
                                            $set('item_number', '');
                                        }
                                    })
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('item_number')
                                    ->label('Item Number / رقم المنتج')
                                    ->disabled()
                                    ->dehydrated()
                                    ->reactive()
                                    ->default('')
                                    ->formatStateUsing(function ($state, $record) {
                                        if ($record && $record->product_id) {
                                            $product = Product::find($record->product_id);
                                            return $product?->number ?? $state;
                                        }
                                        return $state;
                                    })
                                    ->columnSpan(1),


                                Forms\Components\TextInput::make('yards')
                                    ->label('Yards / الياردات')
                                    ->numeric()
                                    ->required()
                                    ->step(0.01)
                                    ->placeholder('0.00')
                                    ->suffix('yards')
                                    ->live()
                                    ->extraInputAttributes([
                                        'onfocus' => 'this.select()',
                                        'onclick' => 'this.select()'
                                    ])
                                    ->disabled(fn(Forms\Get $get) => blank($get('item_number'))) // ✅ disable if no item_number
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        $pricePerYard = (float) $get('price_per_yard');
                                        $yards = (float) $state;
                                        $set('total', number_format($yards * $pricePerYard, 2, '.', ''));
                                    })
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('price_per_yard')
                                    ->label('Price per Yard / السعر بالياردة')
                                    ->numeric()
                                    ->required()
                                    ->step(0.01)
                                    ->placeholder('0.00')
                                    ->prefix('SAR')
                                    ->live()
                                    ->extraInputAttributes([
                                        'onfocus' => 'this.select()',
                                        'onclick' => 'this.select()'
                                    ])
                                    ->disabled(fn(Forms\Get $get) => blank($get('item_number'))) // ✅ disable if no item_number
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        $yards = (float) $get('yards');
                                        $price = (float) $state;
                                        $set('total', number_format($yards * $price, 2, '.', ''));
                                    })
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('total')
                                    ->label('Total / المجموع')
                                    ->numeric()
                                    ->prefix('SAR')
                                    ->disabled()
                                    ->dehydrated()
                                    ->default('0.00')
                                    ->columnSpan(1),
                            ])

                            ->columns(6)
                            ->addActionLabel('Add Item / إضافة منتج')
                            ->defaultItems(1)
                            ->minItems(1)
                            // ->collapsible()
                            // ->itemLabel(
                            //     fn(array $state): ?string =>
                            //     isset($state['product_id']) && $state['product_id']
                            //     ? 'Product Item'
                            //     : 'New Item'
                            // )
                            ->rules(['required', 'array', 'min:1'])
                            ->validationMessages([
                                'required' => 'At least one item is required / يجب إضافة منتج واحد على الأقل',
                                'min' => 'At least one item is required / يجب إضافة منتج واحد على الأقل',
                            ])
                            ->deleteAction(
                                fn(Forms\Components\Actions\Action $action, Forms\Get $get) => $action
                                    ->requiresConfirmation()
                                    ->modalHeading('Delete Item / حذف المنتج')
                                    ->modalDescription('Are you sure you want to delete this item? / هل أنت متأكد من حذف هذا المنتج؟')
                                    ->modalSubmitActionLabel('Yes, delete it / نعم، احذفه')
                                    ->modalCancelActionLabel('Cancel / إلغاء')
                                    ->visible(fn(Forms\Get $get): bool => count($get('items') ?? []) > 1)
                            ),
                    ]),

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
                                // Disable for issuers (they can only create invoices for themselves)
                                $user = Auth::user();
                                return $user && $user->hasRole('issuer');
                            }),

                        Forms\Components\DatePicker::make('due_date')
                            ->label('Due Date / تاريخ السداد')
                            ->required()
                            ->default(now()->addDays(30)),
                        Forms\Components\Grid::make(2) // creates 2 equal columns
                            ->schema([
                                Forms\Components\Textarea::make('remarks')
                                    ->label('ملاحظات / Remarks')
                                    ->rows(5),
                            ])->columns(1),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('row_number')
                    ->label('#')
                    ->getStateUsing(function ($record, $rowLoop) {
                        return $rowLoop->iteration;
                    })
                    ->width('60px')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('Invoice ID' . PHP_EOL . 'رقم الفاتورة')
                    ->searchable()
                    ->sortable()
                    ->width('120px'),
                Tables\Columns\TextColumn::make('goods_delivery_document_number')
                    ->label('Delivery Doc #' . PHP_EOL . 'رقم سند التسليم')
                    ->searchable()
                    ->sortable()
                    ->width('150px'),
                Tables\Columns\TextColumn::make('invoice_date')
                    ->label('Date' . PHP_EOL . 'التاريخ')
                    ->date()
                    ->sortable()
                    ->width('100px'),
                Tables\Columns\TextColumn::make('customer.customer_name')
                    ->label('Customer Name' . PHP_EOL . 'اسم العميل')
                    ->searchable()
                    ->sortable()
                    ->width('180px'),
                Tables\Columns\TextColumn::make('items_count')
                    ->label('Items Count' . PHP_EOL . 'عدد المنتجات')
                    ->counts('items')
                    ->badge()
                    ->width('120px'),
                Tables\Columns\TextColumn::make('calculated_total_amount')
                    ->label('Total Amount' . PHP_EOL . 'إجمالي المبلغ')
                    ->getStateUsing(fn($record) => $record->items->sum('total'))
                    ->money('SAR')
                    ->sortable()
                    ->width('140px'),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Due Date' . PHP_EOL . 'تاريخ السداد')
                    ->date()
                    ->sortable()
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
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
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
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
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
            return parent::getEloquentQuery()->with(['customer.city']);
        }

        // Issuer can only see their own invoices and those they have access to
        if ($user->hasRole('issuer') && $user->issuer) {
            $issuer = $user->issuer;
            $viewableIssuerIds = $issuer->getAllViewableIssuers()->pluck('id');

            return parent::getEloquentQuery()->whereIn('issuer_id', $viewableIssuerIds)->with(['customer.city']);
        }

        // No access for other roles
        return parent::getEloquentQuery()->whereRaw('1 = 0');
    }
}
