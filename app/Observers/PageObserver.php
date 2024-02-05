<?php

namespace App\Observers;

use App\Models\Page;
use Illuminate\Support\Facades\Storage;

class PageObserver
{
    /**
     * Handle the Page "created" event.
     */
    public function created(Page $page): void
    {
        //
    }

    /**
     * Handle the Page "updated" event.
     */
    public function updated(Page $page): void
    {
        if ($page->isDirty('image') && $page->getOriginal('image') !== null) {
            Storage::disk('public')->delete($page->getOriginal('image'));
        }
    }

    /**
     * Handle the Page "deleted" event.
     */
    public function deleted(Page $page): void
    {
        if (! is_null($page->image)) {
            Storage::disk('public')->delete($page->image);
        }
    }

    /**
     * Handle the Page "restored" event.
     */
    public function restored(Page $page): void
    {
        //
    }

    /**
     * Handle the Page "force deleted" event.
     */
    public function forceDeleted(Page $page): void
    {
        //
    }
}
