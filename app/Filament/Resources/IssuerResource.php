<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IssuerResource\Pages;
use App\Models\Issuer;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class IssuerResource extends Resource
{
    protected static ?string $model = Issuer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Issuers / المصدِرون';

    protected static ?string $modelLabel = 'Issuer / مصدِر';

    protected static ?string $pluralModelLabel = 'Issuers / المصدِرون';

    protected static ?string $navigationGroup = 'Settings / الإعدادات';

    public static function canViewAny(): bool
    {
        return Auth::user()?->hasRole('admin') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Issuer Information')
                    ->schema([
                        Forms\Components\TextInput::make('full_name')
                            ->required()
                            ->maxLength(255)
                            ->label('Full Name / الاسم الكامل'),

                        Forms\Components\DatePicker::make('id_expiration')
                            ->label('ID Expiration Date / تاريخ انتهاء البطاقة')
                            ->nullable(),

                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required()
                            ->maxLength(255)
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->label('Password / الكلمة السرية'),

                        Forms\Components\FileUpload::make('photo')
                            ->label('Photo / الصورة')
                            ->image()
                            ->directory('issuer-photos')
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('User Account')
                    ->schema([
                        Forms\Components\TextInput::make('user_email')
                            ->email()
                            ->required()
                            ->label('Email / البريد الإلكتروني')
                            ->unique(
                                table: User::class,
                                column: 'email',
                                ignoreRecord: true,
                                modifyRuleUsing: function ($rule, $livewire) {
                                    if ($livewire instanceof \Filament\Resources\Pages\EditRecord && $livewire->record->user) {
                                        return $rule->ignore($livewire->record->user->id);
                                    }
                                    return $rule;
                                }
                            ),

                        Forms\Components\TextInput::make('user_name')
                            ->required()
                            ->maxLength(255)
                            ->label('Name / الاسم'),
                    ])->columns(2),

                // Forms\Components\Section::make('Access Permissions')
                //     ->schema([
                //         Forms\Components\Select::make('can_view_issuers')
                //             ->multiple()
                //             ->relationship('canViewIssuers', 'full_name')
                //             ->label('Can View Other Issuers')
                //             ->preload()
                //             ->searchable(),
                //     ])
                //     ->collapsible(),
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
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Photo ' . PHP_EOL . 'الصورة')
                    ->circular()
                    ->defaultImageUrl('data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50" fill="#e5e7eb"/><circle cx="50" cy="35" r="15" fill="#9ca3af"/><path d="M25 75c0-13.8 11.2-25 25-25s25 11.2 25 25" fill="#9ca3af"/></svg>')),

                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name ' . PHP_EOL . 'الاسم الكامل')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email ' . PHP_EOL . 'البريد الإلكتروني')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('id_expiration')
                    ->label('ID Expiration ' . PHP_EOL . 'تاريخ انتهاء البطاقة')
                    ->date()
                    ->sortable()
                    ->badge()
                    ->color(fn($state) => $state && $state->isPast() ? 'danger' : 'success'),

                // Tables\Columns\TextColumn::make('canViewIssuers.full_name')
                //     ->label('Can View')
                //     ->badge()
                //     ->separator(', '),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At ' . PHP_EOL . 'تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\Filter::make('expired_ids')
                    ->label('Expired IDs')
                    ->query(fn(Builder $query): Builder => $query->where('id_expiration', '<', now())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListIssuers::route('/'),
            'create' => Pages\CreateIssuer::route('/create'),
            'edit' => Pages\EditIssuer::route('/{record}/edit'),
        ];
    }
}
