<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessagesResource\Pages;
use App\Models\Messages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MessagesResource\RelationManagers;

class MessagesResource extends Resource
{
    protected static ?string $model = Messages::class;

    protected static ?string $navigationIcon = 'fas-message';

    protected static ?string $navigationGroup = 'MENU ITEMS';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('content')
                            ->required()
                            ->autosize()
                            ->maxLength(1000)
                            ->columnSpan(3)
                            ->rows(10)
                            ->cols(20),
                Forms\Components\Select::make('type')
                    ->options([
                        'BIRTHDAY' => 'Birthday',
                        'SCHEDULE' => 'schedule',
                    ])
                    ->native(false),
                ToggleButtons::make('active')
                    ->label('set active?')
                    ->boolean()
                    ->default(true)
                    ->inline(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('content')
                    ->limit(60),
                Tables\Columns\TextColumn::make('type'),
                ToggleColumn::make('active')
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\EditAction::make(),
                ])
                ->button()
                ->label('Actions')
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
            'index' => Pages\ListMessages::route('/'),
            // 'create' => Pages\CreateMessages::route('/create'),
            // 'edit' => Pages\EditMessages::route('/{record}/edit'),
        ];
    }
}
