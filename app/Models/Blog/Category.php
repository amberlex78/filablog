<?php

namespace App\Models\Blog;

use Database\Factories\Blog\CategoryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Blog\Category
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $image
 * @property bool $image_show
 * @property string|null $description
 * @property bool $enabled
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static CategoryFactory factory($count = null, $state = [])
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @mixin Eloquent
 */
class Category extends Model
{
    use HasFactory;

    public const IMG_BLOG_CATEGORY = 'blog/category';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'image',
        'image_show',
        'description',
        'enabled',
        'seo_title',
        'seo_description',
    ];

    /**
     * @var string
     */
    protected $table = 'blog_categories';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'enabled' => 'boolean',
        'image_show' => 'boolean',
    ];


    /** @return HasMany<Post> */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'blog_category_id');
    }
}
