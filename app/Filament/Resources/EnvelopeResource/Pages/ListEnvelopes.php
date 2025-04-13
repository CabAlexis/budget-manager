<?php

namespace App\Filament\Resources\EnvelopeResource\Pages;

use App\Filament\Resources\EnvelopeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEnvelopes extends ListRecords
{
    protected static string $resource = EnvelopeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
