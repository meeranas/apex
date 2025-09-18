<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Issuer;
use App\Models\Product;
use App\Models\Invoice;
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

    protected static ?string $navigationIcon = 'heroicon-m-banknotes';

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
                            ->native(false)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                // When type changes to return_goods, ensure at least one item exists
                                if ($state === 'return_goods') {
                                    $items = $get('items') ?? [];
                                    if (empty($items)) {
                                        // Add a default empty item
                                        $items[] = [
                                            'product_id' => null,
                                            'item_number' => '',
                                            'yards' => '',
                                            'price_per_yard' => '',
                                            'total' => 0,
                                        ];
                                        $set('items', $items);
                                    }
                                    // Set amount to 0 for return goods
                                    $set('amount', 0);
                                }
                            }),

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

                // Transaction Items Section - Only show for return_goods
                Forms\Components\Section::make('Transaction Items / بنود المعاملة')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->label('Product / المنتج')
                                    ->searchable()
                                    ->preload()
                                    ->options(function (Forms\Get $get) {
                                        $transactionType = $get('type');
                                        $customerId = $get('customer_id');

                                        // For return_goods, filter products based on customer's invoice items
                                        if ($transactionType === 'return_goods' && $customerId) {
                                            $productIds = Invoice::where('customer_id', $customerId)
                                                ->with('items')
                                                ->get()
                                                ->pluck('items')
                                                ->flatten()
                                                ->pluck('product_id')
                                                ->unique()
                                                ->filter()
                                                ->toArray();

                                            return Product::whereIn('id', $productIds)
                                                ->pluck('name', 'id')
                                                ->toArray();
                                        }

                                        // For other transaction types, show all products
                                        return Product::pluck('name', 'id')->toArray();
                                    })
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get, $component) {
                                        // Auto-populate item_number based on selected product
                                        if ($state) {
                                            $product = Product::find($state);
                                            if ($product && $product->number) {
                                                $set('item_number', $product->number);
                                            }
                                        }
                                    })
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('item_number')
                                    ->label('Item Number / رقم المنتج')
                                    ->numeric()
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->live()
                                    ->formatStateUsing(function ($state, $record) {
                                        // If we're editing and have a record, get the product number
                                        if ($record && $record->product_id) {
                                            $product = Product::find($record->product_id);
                                            return $product ? $product->number : $state;
                                        }
                                        return $state;
                                    })
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        // This ensures the field is reactive to changes
                                        $productId = $get('product_id');
                                        if ($productId && !$state) {
                                            $product = Product::find($productId);
                                            if ($product && $product->number) {
                                                $set('item_number', $product->number);
                                            }
                                        }
                                    })
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

                                        // Update total_amount for return_goods
                                        $transactionType = $get('../../type');
                                        if ($transactionType === 'return_goods') {
                                            $items = $get('../../items') ?? [];
                                            $totalAmount = 0;
                                            foreach ($items as $item) {
                                                if (isset($item['total']) && is_numeric($item['total'])) {
                                                    $totalAmount += (float) $item['total'];
                                                }
                                            }
                                            $set('../../total_amount', $totalAmount);
                                        }
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

                                        // Update total_amount for return_goods
                                        $transactionType = $get('../../type');
                                        if ($transactionType === 'return_goods') {
                                            $items = $get('../../items') ?? [];
                                            $totalAmount = 0;
                                            foreach ($items as $item) {
                                                if (isset($item['total']) && is_numeric($item['total'])) {
                                                    $totalAmount += (float) $item['total'];
                                                }
                                            }
                                            $set('../../total_amount', $totalAmount);
                                        }
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
                            ->minItems(1)
                            // ->collapsible()
                            ->itemLabel(fn(array $state): ?string => $state['product_id'] ? Product::find($state['product_id'])?->name : null)
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

                                // Update total_amount for return_goods transactions
                                $transactionType = $get('type');
                                if ($transactionType === 'return_goods') {
                                    $set('total_amount', $totalAmount);
                                    $set('amount', 0); // Ensure amount is always 0 for return_goods
                                }
                            })
                            ->addAction(
                                fn(Forms\Components\Actions\Action $action) => $action
                                    // ->label('Add Item / إضافة منتج')
                                    ->icon('heroicon-m-plus')
                                    ->action(function (Forms\Get $get, Forms\Set $set) {
                                        $items = $get('items') ?? [];
                                        $items[] = [
                                            'product_id' => null,
                                            'item_number' => '',
                                            'yards' => '',
                                            'price_per_yard' => '',
                                            'total' => 0, // Set as number instead of empty string
                                        ];
                                        $set('items', $items);
                                    })
                            )
                            ->deleteAction(
                                fn(Forms\Components\Actions\Action $action) => $action
                                    ->requiresConfirmation()
                                    ->visible(fn($state, $get) => count($get('items') ?? []) > 1)
                            ),
                    ])
                    ->visible(fn(Forms\Get $get): bool => $get('type') === 'return_goods'),

                // Return Goods Summary Section - Only show for return_goods
                Forms\Components\Section::make('Return Goods Summary / ملخص المرتجع')
                    ->schema([
                        Forms\Components\TextInput::make('amount')
                            ->label('Amount / المبلغ')
                            ->numeric()
                            ->prefix('SAR')
                            ->disabled()
                            ->dehydrated()
                            ->hidden()
                            ->default(0)
                            ->formatStateUsing(function ($state, $record, Forms\Get $get) {
                                // For return_goods, always return 0
                                $transactionType = $get('type');
                                if ($transactionType === 'return_goods') {
                                    return 0;
                                }
                                return $state;
                            })
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                // For return_goods, always set amount to 0
                                $transactionType = $get('type');
                                if ($transactionType === 'return_goods') {
                                    $set('amount', 0);
                                }
                            })
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('total_amount')
                            ->label('Total Amount / إجمالي المبلغ')
                            ->numeric()
                            ->prefix('SAR')
                            ->disabled()
                            ->dehydrated()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                // For return_goods, calculate total from items
                                $transactionType = $get('type');
                                if ($transactionType === 'return_goods') {
                                    $items = $get('items') ?? [];
                                    $totalFromItems = 0;

                                    foreach ($items as $item) {
                                        if (isset($item['total']) && is_numeric($item['total'])) {
                                            $totalFromItems += (float) $item['total'];
                                        }
                                    }

                                    $set('total_amount', $totalFromItems);
                                }
                            })
                            ->formatStateUsing(function ($state, $record, Forms\Get $get) {
                                // For return_goods, always calculate from items
                                $transactionType = $get('type');
                                if ($transactionType === 'return_goods') {
                                    $items = $get('items') ?? [];
                                    $totalFromItems = 0;

                                    foreach ($items as $item) {
                                        if (isset($item['total']) && is_numeric($item['total'])) {
                                            $totalFromItems += (float) $item['total'];
                                        }
                                    }

                                    return $totalFromItems;
                                }
                                return $state;
                            })
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->visible(fn(Forms\Get $get): bool => $get('type') === 'return_goods'),

                // Payment Information Section - Only show for debit and discount
                Forms\Components\Section::make('Payment Information / معلومات الدفع')
                    ->schema([
                        Forms\Components\TextInput::make('amount')
                            ->label('Amount / المبلغ')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('SAR')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                $transactionType = $get('type');
                                $items = $get('items') ?? [];
                                $totalFromItems = 0;

                                foreach ($items as $item) {
                                    if (isset($item['total']) && is_numeric($item['total'])) {
                                        $totalFromItems += (float) $item['total'];
                                    }
                                }

                                // For return_goods, amount should always be 0
                                if ($transactionType === 'return_goods') {
                                    $set('amount', 0);
                                    $set('total_amount', $totalFromItems);
                                } else {
                                    // For other types, if amount is not set, use total from items
                                    if (!$state && $totalFromItems > 0) {
                                        $set('amount', $totalFromItems);
                                    }
                                    // Update total_amount
                                    $set('total_amount', $state ?: $totalFromItems);
                                }
                            }),

                        Forms\Components\Select::make('payment_product_id')
                            ->label('Product / المنتج')
                            ->options(Product::all()->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->live()
                            ->visible(false) // Hide the Product field for both debit and discount
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                if ($state) {
                                    $items = $get('items') ?? [];

                                    // Check if product already exists in items
                                    $productExists = false;
                                    foreach ($items as $index => $item) {
                                        if (isset($item['product_id']) && $item['product_id'] == $state) {
                                            $productExists = true;
                                            break;
                                        }
                                    }

                                    // If product doesn't exist, add it to items
                                    if (!$productExists) {
                                        $items[] = [
                                            'product_id' => $state,
                                            'item_number' => '',
                                            'yards' => 0,
                                            'price_per_yard' => 0,
                                            'total' => 0,
                                        ];
                                        $set('items', $items);
                                    }
                                }
                            }),

                        Forms\Components\Select::make('payment_method')
                            ->label('Payment Method / طريقة الدفع')
                            ->options([
                                'cash' => ' Cash / نقداً',
                                'bank_transfer' => 'Bank Transfer / تحويل بنكي',
                                'check' => 'Check / شيك',
                                'credit_card' => 'Credit Card / بطاقة ائتمان',
                                'other' => 'Other / أخرى',
                            ])
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->visible(fn(Forms\Get $get): bool => $get('type') === 'debit'),

                        Forms\Components\TextInput::make('total_amount')
                            ->label('Total Amount / إجمالي المبلغ')
                            ->numeric()
                            ->prefix('SAR')
                            ->disabled()
                            ->dehydrated()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                // For return_goods, calculate total from items
                                $transactionType = $get('type');
                                if ($transactionType === 'return_goods') {
                                    $items = $get('items') ?? [];
                                    $totalFromItems = 0;

                                    foreach ($items as $item) {
                                        if (isset($item['total']) && is_numeric($item['total'])) {
                                            $totalFromItems += (float) $item['total'];
                                        }
                                    }

                                    $set('total_amount', $totalFromItems);
                                }
                            }),
                    ])
                    ->columns(4)
                    ->visible(fn(Forms\Get $get): bool => in_array($get('type'), ['debit', 'discount'])),

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

                Tables\Columns\TextColumn::make('row_number')
                    ->label('#')
                    ->getStateUsing(function ($record, $rowLoop) {
                        return $rowLoop->iteration;
                    })
                    ->width('60px')
                    ->alignCenter(),

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
