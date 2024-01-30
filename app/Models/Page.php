<?php

namespace App\Models;

use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Page
 *
 * @property int $id
 * @property int|null $page_id
 * @property string $title
 * @property string $slug
 * @property string|null $image
 * @property int $show_on_page
 * @property string|null $description
 * @property string $content
 * @property int $is_published
 * @property int $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Page> $children
 * @property-read int|null $children_count
 * @property-read Page|null $parent
 *
 * @method static PageFactory factory($count = null, $state = [])
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page query()
 */
class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'page_id',
        'title',
        'slug',
        'image',
        'show_on_page',
        'description',
        'content',
        'is_published',
        'position',
    ];

    /**
     * Get the parent page.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Get the children's pages of the parent page.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Page::class);
    }
}
