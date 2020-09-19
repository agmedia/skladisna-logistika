<?php

namespace App\Models\Back;

use App\Models\CategoryMenu;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Category extends Model
{

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }


    /**
     * @param $request
     *
     * @return bool
     */
    public function resolveImage($request)
    {
        $data = json_decode($request->image);
        $type = str_replace('image/', '', $data->output->type);
        $name = str_replace('.' . $type, '', $data->output->name);

        $path = time() . '_' . Str::slug($name) . '.' . $type;
        $img  = Image::make($data->output->image)->encode($type);

        Storage::disk('category')->put($path, $img);

        $default_path = config('filesystems.disks.category.url') . 'default.jpg';

        if ($this->image && $this->image != $default_path) {
            $delete_path = str_replace(config('filesystems.disks.category.url'), '', $this->image);

            Storage::disk('category')->delete($delete_path);
        }

        return $this->update([
            'image' => config('filesystems.disks.category.url') . $path
        ]);
    }


    /**
     * Get the categories for the
     * navigation menu.
     *
     * @return mixed
     */
    public static function getList()
    {
        return (new CategoryMenu())->list();
    }


    /**
     * Get the categories for the
     * navigation menu.
     *
     * @return mixed
     */
    public static function adminList($group = 'TOYOTA VILIČARI')
    {
        if (is_array($group)) {
            $collection = collect((new CategoryMenu())->list());

            for ($i = 0; $i < count($group); $i++) {
                $collection->where('group', $group[$i]);
            }

            return $collection;

        } else {
            return collect((new CategoryMenu())->list())->where('group', $group);
        }
    }


    /**
     * Get the categories for the
     * navigation menu.
     *
     * @return mixed
     */
    public static function getListWithoutTop()
    {
        return (new CategoryMenu())->list(false);
    }


    /**
     * Get the categories menu.
     * List for the select component.
     *
     * @param bool $admin
     *
     * @return mixed
     */
    public static function getMenu($admin = false)
    {
        return (new CategoryMenu())->menu($admin);
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public static function parents()
    {
        return DB::table('categories')->where('parent_id', '==', '')->pluck('name', 'id');
    }


    /**
     * Store new category.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public static function store(Request $request)
    {
        $top    = (isset($request->top) and $request->top == 'on') ? 1 : 0;
        $parent = ( ! $top and isset($request->parent)) ? intval($request->parent) : 0;
        $group  = isset($request->group) ? $request->group : 0;

        //dd($top, $parent, $group, $request);

        if ($parent) {
            $topcat = self::where('id', $parent)->first();
            $group  = $topcat->group;
        }

        //dd($top, $parent, $group, $request);

        $id = self::insertGetId([
            'name'             => $request->name,
            'description'      => $request->description,
            'meta_description' => $request->meta_description,
            'meta_keyword'     => $request->meta_keyword,
            'parent_id'        => $parent,
            'group'            => $group,
            'top'              => $top,
            'status'           => (isset($request->status) and $request->status == 'on') ? 1 : 0,
            'slug'             => isset($request->slug) ? Str::slug($request->slug) : Str::slug($request->name),
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        if ($id) {
            return self::find($id);
        }

        return false;
    }


    /**
     * Update category.
     *
     * @param Request $request
     * @param         $category
     *
     * @return mixed
     */
    public static function edit(Request $request, $category)
    {
        $top    = (isset($request->top) and $request->top == 'on') ? 1 : 0;
        $parent = ( ! $top and isset($request->parent)) ? intval($request->parent) : 0;
        $group  = isset($request->group) ? $request->group : 0;

        if ($parent) {
            $topcat = self::where('id', $parent)->first();
            $group  = $topcat->group;
        }

        $updated = self::where('id', $category->id)->update([
            'name'             => $request->name,
            'description'      => $request->description,
            'meta_description' => $request->meta_description,
            'meta_keyword'     => $request->meta_keyword,
            'parent_id'        => $parent,
            'group'            => $group,
            'top'              => $top,
            'status'           => (isset($request->status) and $request->status == 'on') ? 1 : 0,
            'slug'             => isset($request->slug) ? Str::slug($request->slug) : Str::slug($request->name),
            'updated_at'       => Carbon::now()
        ]);

        if ($updated) {
            return self::find($category->id);
        }

        return false;
    }


    /**
     * @param $category
     * @param $path
     *
     * @return mixed
     */
    public static function updateImagePath($category, $path)
    {
        return self::where('id', $category->id)->update([
            'image' => $path
        ]);
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public static function withSubDestroy($id)
    {
        $category = self::find($id);

        // If it's a Top Category
        if ( ! $category['parent_id']) {
            self::where('parent_id', $id)->delete();
        }

        return self::where('id', $id)->delete();
    }
}
