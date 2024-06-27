<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchedulerResource\Pages;
use App\Filament\Resources\SchedulerResource\RelationManagers;
use App\Models\Scheduler;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Forms\Components\Textarea;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\Select;
use App\Models\Contacts;

class SchedulerResource extends Resource
{
    protected static ?string $model = Scheduler::class;

    protected static ?string $pluralModelLabel = 'Schedule';

    protected static ?string $navigationIcon = 'fas-calendar-days';

    protected static ?string $navigationGroup = 'MENU ITEMS';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('frequency')
                    ->required()
                    ->options([
                        'once'          => 'Date (Once)',
                        'every_weekday' => 'Date (Every Weekday)',
                        'every_day'     => 'Every Day',
                    ])
                    ->native(false),
                Forms\Components\DateTimePicker::make('scheduled_at')
                    ->prefixIcon('heroicon-m-calendar-days'),
                Forms\Components\Select::make('scheduled_contact')
                    ->label('Contacts')
                    ->options(Contacts::all()->pluck('name', 'mobile_no'))
                    ->searchable()
                    ->multiple()
                    ->preload()
                    ->required()
                    ->prefixIcon('fas-address-book'),
                Forms\Components\Select::make('message_id')
                    ->label('Message')
                    ->relationship('message', 'content')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->prefixIcon('fas-message')
                    ->createOptionForm([
                        Textarea::make('content')
                            ->required()
                            ->autosize()
                            ->maxLength(255),
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
                    ]),
                ToggleButtons::make('active')
                    ->label('set active?')
                    ->boolean()
                    ->default(true)
                    ->inline(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('scheduled_contact')
                    ->formatStateUsing(fn (string $state): string => substr(str_replace('"', '', $state), 1, -1))
                    ->badge()
                    ->separator(',')
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->listWithLineBreaks(),
                Tables\Columns\TextColumn::make('message_id')
                    ->label('Message')
                    ->limit(60)
                    ->formatStateUsing(fn (string $state): string => \App\Models\Messages::find($state)->content),
                Tables\Columns\TextColumn::make('scheduled_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('frequency')
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state)))
                    ->badge(),
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
            'index' => Pages\ListSchedulers::route('/'),
            'create' => Pages\CreateScheduler::route('/create'),
            'edit' => Pages\EditScheduler::route('/{record}/edit'),
        ];
    }
}
