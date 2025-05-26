<?php

namespace App\Filament\Resources\CampWeekResource\Pages;

use App\Filament\Resources\CampWeekResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCampWeek extends EditRecord
{
    protected static string $resource = CampWeekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
