<?php

namespace App\Filament\Resources\CampWeekResource\Pages;

use App\Filament\Resources\CampWeekResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCampWeeks extends ListRecords
{
    protected static string $resource = CampWeekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
