<?php

namespace App\Filament\Resources\Blog\CategoryResource\Pages;

use App\Filament\Resources\Blog\CategoryResource;
use App\Filament\Traits\DeleteRecordImage;
use App\Models\Blog\Category;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    use DeleteRecordImage;

    protected static string $resource = CategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Save changes')->action('save'),
            $this->deleteImage(),
        ];
    }
}
