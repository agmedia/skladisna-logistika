<?php

namespace App\Models\Front;

use App\Models\Back\Marketing\Blog\BlogBlock;
use App\Models\Back\Marketing\Blog\BlogTag;
use App\Models\Back\Marketing\Landing\LandingProduct;
use App\Models\Back\Marketing\Landing\LandingSection;
use App\Models\Back\Tag;
use App\Models\Front\Category\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Landing extends Model
{

    /**
     * @var string
     */
    protected $table = 'landings';

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
    public function sections()
    {
        return $this->hasMany(LandingSection::class, 'landing_id')->orderBy('sort');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function products()
    {
        return $this->hasMany(LandingProduct::class, 'landing_id');
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

}
