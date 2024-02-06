<?php

namespace App\Models;

use Database\Factories\PageFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Page
 *
 * @property int $id
 * @property int|null $page_id
 * @property string $title
 * @property string $slug
 * @property string|null $image
 * @property bool $image_show
 * @property string|null $description
 * @property string $content
 * @property bool $published
 * @property int $position
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Page> $children
 * @property-read int|null $children_count
 * @property-read Page|null $parent
 * @method static PageFactory factory($count = null, $state = [])
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page onlyTrashed()
 * @method static Builder|Page query()
 * @method static Builder|Page withTrashed()
 * @method static Builder|Page withoutTrashed()
 * @mixin Eloquent
 */
class Page extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'page_id',
        'title',
        'slug',
        'image',
        'image_show',
        'description',
        'content',
        'published',
        'position',
    ];
    protected $casts = [
        'published' => 'boolean',
        'image_show' => 'boolean',
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
