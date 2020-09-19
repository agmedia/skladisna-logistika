<?php

namespace App\Models\Back\Settings;


use App\Models\Back\Photo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Bouncer;

class Page extends Model
{

    /**
     * @var string
     */
    protected $table = 'pages';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/
    // Static functions

    /**
     * @return mixed
     */
    public static function getMenu()
    {
        if (Bouncer::is(auth()->user())->an('editor')) {
            return self::where('status', 1)->where('client_id', auth()->user()->clientId())->select('id', 'name')->get();
        }

        return self::where('status', 1)->select('id', 'name')->get();
    }


    /**
     * @return mixed
     */
    public static function groups()
    {
        return self::groupBy('group')->pluck('group');
    }


    /**
     * @param $id
     * @param $path
     *
     * @return mixed
     */
    public static function updateImagePath($id, $path)
    {
        return self::where('id', $id)->update([
            'image' => $path
        ]);
    }



    /**
     * @param $request
     *
     * @return bool
     * @throws \Exception
     */
    public static function store($request)
    {
        $_id = self::insertGetId([
            'name'             => $request->name,
            'slug'             => isset($request->slug) ? Str::slug($request->slug) : Str::slug($request->name),
            'description'      => $request->description,
            'seo_title'        => $request->seo_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'group'            => isset($request->group) ? $request->group : 0,
            'status'           => (isset($request->status) and $request->status == 'on') ? 1 : 0,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        if ($_id) {
            return self::find($_id);
        }

        return false;
    }


    /**
     * @param $request
     *
     * @return bool
     * @throws \Exception
     */
    public static function renew($request, $id)
    {

        $_id = self::where('id', $id)->update([
            'name'             => $request->name,
            'slug'             => isset($request->slug) ? Str::slug($request->slug) : Str::slug($request->name),
            'description'      => $request->description,
            'seo_title'        => $request->seo_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'group'            => isset($request->group) ? $request->group : 0,
            'status'           => (isset($request->status) and $request->status == 'on') ? 1 : 0,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        return self::find($id);
    }

}
