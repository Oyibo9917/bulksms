<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactsResource\Pages;
use App\Filament\Resources\ContactsResource\RelationManagers;
use App\Models\Contacts;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Set;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Radio;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Actions\ActionGroup;

class ContactsResource extends Resource
{
    protected static ?string $model = Contacts::class;

    protected static ?string $navigationIcon = 'fas-address-card';

    protected static ?string $navigationBadgeTooltip = 'The number of contacts';

    protected static ?string $navigationGroup = 'MENU ITEMS';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->prefixIcon('heroicon-m-user'),
                Forms\Components\TextInput::make('mobile_no')
                    ->required()
                    ->numeric()
                    ->maxLength(11)
                    ->prefixIcon('heroicon-m-phone'),
                ToggleButtons::make('gender')
                    ->options([
                        'M' => 'Male',
                        'F' => 'Female',
                    ])
                    ->icons([
                        'M' => 'fas-person',
                        'F' => 'fas-person-dress',
                    ])
                    ->inline()
                    ->default('M'),
                Forms\Components\DatePicker::make('birth_date')
                    ->required()
                    ->maxDate(now())
                    ->prefixIcon('heroicon-m-calendar-days'),
                Forms\Components\TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->maxLength(255)
                    ->prefixIcon('heroicon-m-at-symbol'),
                Forms\Components\TextInput::make('Address')
                    ->maxLength(255)
                    ->prefixIcon('heroicon-m-map'),
                Forms\Components\Select::make('contact_group_id')
                    ->relationship('group', 'name')
                    ->preload()
                    ->native(false)
                    ->searchable()
                    ->required()
                    ->prefixIcon('heroicon-m-rectangle-group')
                    ->createOptionForm([
                        Fieldset::make('Add a group')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(25)
                                    ->prefixIcon('heroicon-m-user')
                                    ->live()
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('ref_code', str_replace(' ', '_', strtoupper($state)))),
                                Forms\Components\TextInput::make('ref_code')
                                    ->dehydrated()
                                    ->maxLength(30)
                                    ->prefixIcon('fas-barcode')
                                ])
                       
                    ]),
                ToggleButtons::make('active')
                    ->label('Is the contact active?')
                    ->boolean()
                    ->default(true)
                    ->inline(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        $groups = \App\Models\Groups::all()->pluck('name', 'id');

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('gender')
                    ->icon(fn (string $state): string => match ($state) {
                        'M' => 'fas-person',
                        'F' => 'fas-person-breastfeeding',
                        default => 'fas-person',
                    }),
                Tables\Columns\TextColumn::make('mobile_no')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('birth_date'),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('group.name')
                    ->badge()
                    ->color(fn (string $state) => static::getColor($state)),
                ToggleColumn::make('active')
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('contact_group_id')
                    ->label('Groups')
                    ->options($groups),
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

    protected static function getColor(string $state): string
    {
        return match ($state) {
            'Cleaners' => 'primary',
            'Nurses' => 'primary',
            'Lab' => 'warning',
            'Security' => 'gray',
            'Doctors' => 'success',
            'Partners' => 'info',
            'Pharmacy' => 'success',
            'Seplat' => 'primary',
            'Life Flour Mills' => 'warning',
            'Management' => 'gray',
            'Patients' => 'success',
            'Admin' => 'gray',
            'I.T Dep' => 'primary',
            'Dialysis_Unit' => 'info',
            'RINGARDAS' => 'warning',
            'ANCHOR' => 'primary',
            'MANSARD' => 'success',
            'fCARD' => 'gray',
            'DIALYSIS' => 'warning',
            'THT' => 'info',
            'AWT' => 'primary',
            'Derm' => 'gray',
            'STERLING' => 'success',
            'SMATHEALTH' => 'info',
            'HYGEIA' => 'warning',
            'MONTEGO' => 'success',
            'MARINAHMO' => 'gray',
            'PHEALTH' => 'info',
            'MEDIFIELD' => 'primary',
            'IHMS' => 'warning',
            'NHIS' => 'success',
            'PRINCETON' => 'gray',
            'LIBERTYBLUE' => 'primary',
            default => 'info',
        };
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContacts::route('/create'),
            'edit' => Pages\EditContacts::route('/{record}/edit'),
        ];
    }
}
