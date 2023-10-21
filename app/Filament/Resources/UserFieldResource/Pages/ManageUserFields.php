<?php

namespace App\Filament\Resources\UserFieldResource\Pages;

use App\Filament\Resources\UserFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUserFields extends ManageRecords
{
    protected static string $resource = UserFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create User Field')->modalHeading('Create User Field'),
        ];
    }
}
