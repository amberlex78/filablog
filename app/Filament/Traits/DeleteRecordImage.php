<?php

namespace App\Filament\Traits;

use Filament\Actions;
use Illuminate\Support\Facades\Storage;

trait DeleteRecordImage
{
    protected function deleteImage($recordClass): Actions\DeleteAction
    {
        return Actions\DeleteAction::make()->after(function ($record) use ($recordClass) {
            if ($record->image) {
                Storage::disk('public')->delete($record->image);
            }
        });
    }
}
