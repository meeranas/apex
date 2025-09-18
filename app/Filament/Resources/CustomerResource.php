<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use App\Models\City;
use App\Models\Issuer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;


class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Customers / العملاء';

    protected static ?string $modelLabel = 'Customer / عميل';

    protected static ?string $pluralModelLabel = 'Customers / العملاء';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Customer Information / معلومات العميل')
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
                                // Disable for issuers (they can only create customers for themselves)
                                $user = Auth::user();
                                return $user && $user->hasRole('issuer');
                            }),

                        Forms\Components\TextInput::make('customer_name')
                            ->label('Customer Name / اسم العميل')
                            ->required()
                            ->maxLength(255)
                            ->unique(Customer::class, 'customer_name', ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'A customer with this name already exists. Please use a different customer name. / يوجد عميل بهذا الاسم مسبقاً. يرجى استخدام اسم مختلف.',
                            ]),
                        Forms\Components\TextInput::make('account_number')
                            ->label('Account Number / رقم الحساب')
                            ->required()
                            ->unique(Customer::class, 'account_number', ignoreRecord: true)
                            ->maxLength(255)
                            ->validationMessages([
                                'unique' => 'A customer with this account number already exists. Please use a different account number. / يوجد عميل برقم الحساب هذا مسبقاً. يرجى استخدام رقم حساب مختلف.',
                            ]),

                        Forms\Components\Select::make('city_id')
                            ->label('City / المدينة')
                            ->relationship('city', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->label('City Name'),
                                Forms\Components\Toggle::make('is_active')
                                    ->default(true)
                                    ->label('Active'),
                            ])
                            ->createOptionUsing(function (array $data): int {
                                return \App\Models\City::create($data)->getKey();
                            }),
                        Forms\Components\TextInput::make('representative_name')
                            ->label('Representative Name / اسم المسؤول')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('mobile_number')
                            ->label('Mobile Number / رقم الجوال')
                            ->required()
                            ->tel()
                            ->maxLength(10)
                            ->minLength(10)
                            ->regex('/^05\d{8}$/')
                            ->helperText('Must start with 05 and be exactly 10 digits (e.g., 0512345678)')
                            ->validationMessages([
                                'regex' => 'Mobile number must start with 05 and be exactly 10 digits.',
                                'min' => 'Mobile number must be exactly 10 digits.',
                                'max' => 'Mobile number must be exactly 10 digits.',
                            ]),
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Textarea::make('address')
                                ->label('Address / وصف الموقع')
                                ->required()
                                ->rows(3),
                            Forms\Components\Textarea::make('remarks')
                                ->label('Remarks / ملاحظات')
                                ->rows(3),
                        ])->columns(2),
                    ])->columns(2),

                Forms\Components\Section::make('Financial Information / المعلومات المالية')
                    ->schema([
                        Forms\Components\TextInput::make('old_balance')
                            ->label('Old Balance / الرصيد السابق')
                            ->numeric()
                            ->default(0)
                            ->prefix('SAR'),
                        Forms\Components\TextInput::make('current_balance')
                            ->label('Current Balance' . PHP_EOL . 'الرصيد الحالي')
                            ->prefix('SAR')
                            ->disabled()
                            ->dehydrated(false)
                            ->afterStateHydrated(function (Forms\Components\TextInput $component, $state, $record) {
                                if ($record) {
                                    $component->state(number_format($record->current_balance, 2));
                                } else {
                                    $component->state('0.00');
                                }
                            }),
                    ])->columns(2),

                Forms\Components\Section::make('Calculated Financial Summary / الملخص المالي المحسوب')
                    ->schema([
                        Forms\Components\TextInput::make('overall_payments')
                            ->label('Overall Payments / اجمالي المدفوع')
                            ->prefix('SAR')
                            ->disabled()
                            ->dehydrated(false)
                            ->afterStateHydrated(function (Forms\Components\TextInput $component, $state, $record) {
                                if ($record) {
                                    $component->state(number_format($record->overall_payments, 2));
                                } else {
                                    $component->state('0.00');
                                }
                            }),
                        Forms\Components\TextInput::make('overall_discount')
                            ->label('Discount / الخصم')
                            ->prefix('SAR')
                            ->disabled()
                            ->dehydrated(false)
                            ->afterStateHydrated(function (Forms\Components\TextInput $component, $state, $record) {
                                if ($record) {
                                    $component->state(number_format($record->overall_discount, 2));
                                } else {
                                    $component->state('0.00');
                                }
                            }),
                        Forms\Components\TextInput::make('overall_returned_goods')
                            ->label('Return Goods / المرتجع')
                            ->prefix('SAR')
                            ->disabled()
                            ->dehydrated(false)
                            ->afterStateHydrated(function (Forms\Components\TextInput $component, $state, $record) {
                                if ($record) {
                                    $component->state(number_format($record->overall_returned_goods, 2));
                                } else {
                                    $component->state('0.00');
                                }
                            }),
                        Forms\Components\TextInput::make('overall_invoices')
                            ->label('Overall Invoices / اجمالي الفواتير')
                            ->prefix('SAR')
                            ->disabled()
                            ->dehydrated(false)
                            ->afterStateHydrated(function (Forms\Components\TextInput $component, $state, $record) {
                                if ($record) {
                                    $component->state(number_format($record->overall_invoices, 2));
                                } else {
                                    $component->state('0.00');
                                }
                            }),
                        Forms\Components\TextInput::make('calculated_payment_percentage')
                            ->label('Calculated Payment % / نسبة المدفوع المحسوبة')
                            ->suffix('%')
                            ->disabled()
                            ->dehydrated(false)
                            ->afterStateHydrated(function (Forms\Components\TextInput $component, $state, $record) {
                                if ($record) {
                                    $component->state(number_format($record->calculated_payment_percentage, 2));
                                } else {
                                    $component->state('0.00');
                                }
                            }),
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
                Tables\Columns\TextColumn::make('issuer.full_name')
                    ->label('Issuer / الموظف')
                    ->searchable()
                    ->sortable()
                    ->width('150px'),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer Name / اسم العميل')
                    ->searchable()
                    ->sortable()
                    ->width('180px'),
                Tables\Columns\TextColumn::make('account_number')
                    ->label('Account Number / رقم الحساب')
                    ->searchable()
                    ->sortable()
                    ->width('120px'),
                Tables\Columns\TextColumn::make('city.name')
                    ->label('City / المدينة')
                    ->searchable()
                    ->sortable()
                    ->width('120px'),
                Tables\Columns\TextColumn::make('representative_name')
                    ->label('Representative / المسؤول')
                    ->searchable()
                    ->sortable()
                    ->width('150px'),
                Tables\Columns\TextColumn::make('mobile_number')
                    ->label('Mobile Number / رقم الجوال')
                    ->searchable()
                    ->sortable()
                    ->width('120px'),
                Tables\Columns\TextColumn::make('current_balance')
                    ->label('Current Balance / الرصيد الحالي')
                    ->money('SAR')
                    ->sortable()
                    ->width('140px'),
                // Tables\Columns\TextColumn::make('invoices_count')
                //     ->label('Invoices Count / عدد الفواتير')
                //     ->counts('invoices')
                //     ->badge()
                //     ->width('120px'),
                // Tables\Columns\TextColumn::make('transactions_count')
                //     ->label('Transactions Count / عدد المعاملات')
                //     ->counts('transactions')
                //     ->badge()
                //     ->width('140px'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At / تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->width('150px'),
            ])
            ->filters([
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
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

        // Issuer can only see their own customers and those from issuers they have access to
        if ($user->hasRole('issuer') && $user->issuer) {
            $issuer = $user->issuer;
            $viewableIssuerIds = $issuer->getAllViewableIssuers()->pluck('id');

            return parent::getEloquentQuery()->whereIn('issuer_id', $viewableIssuerIds);
        }

        // No access for other roles
        return parent::getEloquentQuery()->whereRaw('1 = 0');
    }
}
