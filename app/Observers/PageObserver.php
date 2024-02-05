<?php

namespace App\Observers;

use App\Models\Page;

class PageObserver extends BaseObserver
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
        $this->handleRemoveImageOnUpdated($page);
    }

    /**
     * Handle the Page "deleted" event.
     */
    public function deleted(Page $page): void
    {
        $this->handleRemoveImageOnDeleted($page);
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
        $this->handleRemoveImageOnForceDeleted($page);
    }
}
