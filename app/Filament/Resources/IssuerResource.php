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

    protected static ?string $navigationLabel = 'Issuers';

    protected static ?string $modelLabel = 'Issuer';

    protected static ?string $pluralModelLabel = 'Issuers';

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
                            ->label('Full Name'),
                        
                        Forms\Components\DatePicker::make('id_expiration')
                            ->label('ID Expiration Date')
                            ->nullable(),
                        
                        Forms\Components\FileUpload::make('photo')
                            ->label('Photo')
                            ->image()
                            ->directory('issuer-photos')
                            ->nullable(),
                        
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required()
                            ->maxLength(255)
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->label('Password'),
                    ])->columns(2),
                
                Forms\Components\Section::make('User Account')
                    ->schema([
                        Forms\Components\TextInput::make('user_email')
                            ->email()
                            ->required()
                            ->label('Email')
                            ->unique(User::class, 'email', ignoreRecord: true),
                        
                        Forms\Components\TextInput::make('user_name')
                            ->required()
                            ->maxLength(255)
                            ->label('Name'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Access Permissions')
                    ->schema([
                        Forms\Components\Select::make('can_view_issuers')
                            ->multiple()
                            ->relationship('canViewIssuers', 'full_name')
                            ->label('Can View Other Issuers')
                            ->preload()
                            ->searchable(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Photo')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('id_expiration')
                    ->label('ID Expiration')
                    ->date()
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => $state && $state->isPast() ? 'danger' : 'success'),
                
                Tables\Columns\TextColumn::make('canViewIssuers.full_name')
                    ->label('Can View')
                    ->badge()
                    ->separator(', '),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('expired_ids')
                    ->label('Expired IDs')
                    ->query(fn (Builder $query): Builder => $query->where('id_expiration', '<', now())),
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
