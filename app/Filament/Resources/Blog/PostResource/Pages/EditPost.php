<?php

namespace App\Filament\Resources\Blog\PostResource\Pages;

use App\Filament\Resources\Blog\PostResource;
use App\Filament\Traits\DeleteRecordImage;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    use DeleteRecordImage;

    protected static string $resource = PostResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Save changes')->action('save'),
            Actions\DeleteAction::make(),
        ];
    }
}
