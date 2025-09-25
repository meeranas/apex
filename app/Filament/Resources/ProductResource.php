<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationLabel = 'Products / المنتجات';

    protected static ?string $modelLabel = 'Product / منتج';

    protected static ?string $pluralModelLabel = 'Products / المنتجات';

    protected static ?string $navigationGroup = 'Settings / الإعدادات';

    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return Auth::user()?->hasRole('admin') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Product Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(50)
                            ->unique(Product::class, 'name', ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'The name has already been taken.',
                            ])
                            ->label('Name / الاسم'),

                        Forms\Components\TextInput::make('number')
                            ->required()
                            ->maxLength(50)
                            ->unique(Product::class, 'number', ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'The number has already been taken.',
                            ])
                            ->label('Number / الرقم'),
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

                Tables\Columns\TextColumn::make('name')
                    ->label('Name ' . PHP_EOL . 'الاسم')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('number')
                    ->label('Number ' . PHP_EOL . 'الرقم')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),


                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At ' . PHP_EOL . 'تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('id')
                    ->label('Product / المنتج')
                    ->options(
                        Product::pluck('name', 'id')->toArray()
                    )
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
