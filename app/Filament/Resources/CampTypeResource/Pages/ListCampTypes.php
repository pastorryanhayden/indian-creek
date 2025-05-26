<?php

namespace App\Filament\Resources\CampTypeResource\Pages;

use App\Filament\Resources\CampTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCampTypes extends ListRecords
{
    protected static string $resource = CampTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
