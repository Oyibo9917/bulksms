<?php

namespace App\Filament\Resources\ContactsResource\Pages;

use App\Filament\Resources\ContactsResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Models\Groups;
use App\Models\Contacts;
use Filament\Forms;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use App\Traits\SMSManager;
use App\Traits\ImportHelper;
use Filament\Forms\Components\Radio;
use Filament\Forms\Get;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListContacts extends ListRecords
{
    use SMSManager, ImportHelper;

    protected static string $resource = ContactsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('fas-address-book'),
            Action::make('Upload')
                ->icon('fas-upload')
                ->action(function (array $data) {
                    $this->upload($data);
                })
                ->form([FileUpload::make('attachment')])->modalWidth(MaxWidth::Large),
            Action::make('Sms')
                ->label('SMS')
                ->action(function (array $data) {
                    $this->sendSMS($data);
                })
                ->form([
                    Radio::make('groups')
                        ->label('Please select option')
                        ->options([
                            'all' => 'All',
                            'select_group' => 'Groups',
                            'from_contacts' => 'Contacts',
                            'enter_numbers' => 'Enter numbers',
                        ])
                        ->inline()
                        ->default('all')
                        ->required()
                        ->live(),
                    Select::make('Groups')
                        ->label('Groups')
                        ->options(Groups::all()->pluck('name', 'id'))
                        ->searchable()
                        ->multiple()
                        ->required()
                        ->hidden(fn (Get $get) => $get('groups') !== 'select_group'),
                    Select::make('numbers_from_contacts')
                        ->label('From Contacts')
                        ->multiple()
                        ->getSearchResultsUsing(fn (string $search): array => Contacts::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                        ->getOptionLabelsUsing(fn (array $values): array => Contacts::whereIn('id', $values)->pluck('mobile_no', 'id')->toArray())
                        // ->options(Contacts::all()->pluck('mobile_no', 'id'))
                        ->searchable()
                        ->hidden(fn (Get $get) => $get('groups') !== 'from_contacts'),
                    TextInput::make('numbers')
                        ->label('Enters numbers')
                        ->prefixIcon('heroicon-m-phone')
                        ->required()
                        ->hidden(fn (Get $get) => $get('groups') !== 'enter_numbers'),
                    Textarea::make('content')
                        ->autosize()
                        ->minLength(10)
                        ->maxLength(155)
                        ->required()
                ])->modalWidth(MaxWidth::Large)
                    ->icon('fas-comment-sms'),
        ];
    }

    protected function getHeaderWidgets(): array {
        return [
            // ContactsResource\Widgets\ContactResourceOverview::class,
        ];
    }

    public function getTabs(): array
    {
        // $groups = Groups::inRandomOrder()->limit(10)->pluck('id', 'name')->toArray();
        // $ret = [];

        // foreach($groups as $name => $id) {
        //     $ret[$name] = Tab::make()
        //         ->modifyQueryUsing(fn (Builder $query) => $query->where('contact_group_id', $id));
        // }

        // return $ret;

        return [
            'all' => Tab::make('All')
                ->icon('fas-check-double')
                ->badge(Contacts::query()->count())
                ->badgeColor('success'),
        
            'Patients' => Tab::make('Patient')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotIn('contact_group_id', [4, 5, 6, 7, 8, 9, 12, 14, 15])) // Updated whereNotIn clause
                ->icon('fas-bed-pulse')
                ->badge(Contacts::query()->whereNotIn('contact_group_id', [4, 5, 6, 7, 8, 9, 12, 14, 15])->count()) // Updated badge count
                ->badgeColor('primary'),
        
            'Staffs' => Tab::make('Staffs')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('contact_group_id', [4, 5, 6, 7, 8, 9, 12, 14, 15])) // Updated whereIn clause
                ->icon('fas-users-gear')
                ->badge(Contacts::query()->whereIn('contact_group_id', [4, 5, 6, 7, 8, 9, 12, 14, 15])->count()), // Updated badge count
        ];
        
    }
}
