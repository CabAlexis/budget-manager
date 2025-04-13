<?php

namespace App\Filament\Resources\EnvelopeResource\Pages;

use App\Filament\Resources\EnvelopeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEnvelope extends EditRecord
{
    protected static string $resource = EnvelopeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
