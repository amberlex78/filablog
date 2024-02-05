<?php

namespace App\Observers;

use Illuminate\Support\Facades\Storage;

abstract class BaseObserver
{
    protected function handleRemoveImageOnUpdated($model): void
    {
        if ($model->isDirty('image') && $model->getOriginal('image') !== null) {
            Storage::disk('public')->delete($model->getOriginal('image'));
        }
    }

    protected function handleRemoveImageOnDeleted($model): void
    {
        if (! is_null($model->image)) {
            Storage::disk('public')->delete($model->image);
        }
    }
}
