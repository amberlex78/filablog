<?php

namespace App\Models\Blog;

use Database\Factories\Blog\PostFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Blog\Post
 *
 * @property int $id
 * @property int|null $blog_category_id
 * @property string $title
 * @property string $slug
 * @property string|null $image
 * @property bool $image_show
 * @property string $content
 * @property bool $published
 * @property string|null $published_at
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Category|null $category
 * @method static PostFactory factory($count = null, $state = [])
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post query()
 * @mixin Eloquent
 */
class Post extends Model
{
    use HasFactory;

    public const IMG_BLOG_POST = 'blog/post';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'slug',
        'image',
        'image_show',
        'content',
        'enabled',
        'published_at',
        'seo_title',
        'seo_description',
    ];

    /**
     * @var string
     */
    protected $table = 'blog_posts';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'enabled' => 'boolean',
        'published_at' => 'date',
        'image_show' => 'boolean',
    ];


    /** @return BelongsTo<Category,self> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'blog_category_id');
    }
}
