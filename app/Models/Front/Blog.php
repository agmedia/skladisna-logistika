<?php

namespace App\Models\Front;

use App\Models\Back\Marketing\Blog\BlogBlock;
use App\Models\Back\Marketing\Blog\BlogTag;
use App\Models\Back\Tag;
use App\Models\Front\Category\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Blog extends Model
{

    /**
     * @var string
     */
    protected $table = 'blogs';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blocks()
    {
        return $this->hasMany(BlogBlock::class, 'blog_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cat()
    {
        return $this->belongsTo(Category::class, 'category_id')->where('parent_id', 0);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subcat()
    {
        return $this->belongsTo(Category::class, 'category_id')->where('parent_id', '!=', 0);
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', 1)->where('publish_date', '<=', now())->orWhere('publish_date', '0000-00-00 00:00:00')->orderBy('publish_date', 'desc');
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }



    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeLast($query, $count = null)
    {
        $query->orderBy('created_at', 'desc');

        if ($count) {
            $query->limit($count);
        }

        return $query;
    }


    /**
     * @param $query
     * @param $category
     *
     * @return mixed
     */
    public function scopeArticle($query, $category)
    {
        return $query->where('category_id', $category->id);
    }


    /**
     * @param $query
     * @param $category
     *
     * @return mixed
     */
    public function scopeNews($query, $category)
    {
        if ($category->subcategories()->count()) {
            $ids = [];
            foreach ($category->subcategories() as $sub) {
                array_push($ids, $sub->id);
            }

            return $query->whereIn('category_id', $ids);
        }

        return $query->where('category_id', $category->id);
    }


//    /**
//     * @return Relation
//     */
//    public function tags()
//    {
//        return $this->hasManyThrough(Tag::class, BlogTag::class, 'blog_id', 'id', 'id', 'tag_id');
//    }
//
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function client()
//    {
//        return $this->belongsTo(Client::class, 'client_id', 'id');
//    }
//
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\HasOne
//     */
//    public function user()
//    {
//        return $this->hasOne(User::class, 'id', 'user_id');
//    }
//
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function author()
//    {
//        return $this->belongsTo(Client::class, 'client_id', 'id');
//    }
//
//
//    /**
//     * @param $query
//     *
//     * @return mixed
//     */
//    public function scopePublished($query)
//    {
//        return $query->where('is_published', 1);
//    }
//
//
//    /**
//     * @param $query
//     *
//     * @return mixed
//     */
//    public function scopePopular($query)
//    {
//        return $query->orderBy('viewed', 'desc');
//    }
//
//
//    /**
//     * @param $query
//     * @param $limit
//     *
//     * @return mixed
//     */
//    public function scopeLast($query, $count = 3)
//    {
//        return $query->orderBy('updated_at', 'desc')->limit($count)->with('tags');
//    }

}
