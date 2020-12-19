<?php

namespace App\Models\Back\Catalog;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Manufacturer extends Model
{

    /**
     * @var string
     */
    protected $table = 'manufacturers';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    private $request;


    public static function list()
    {
        return self::orderBy('sort_order')->pluck('name', 'id');
    }


    /**
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        // Validate the request.
        $request->validate([
            'name' => 'required'
        ]);

        // Set Product Model request variable
        $this->setRequest($request);

        return $this;
    }


    /**
     * @return mixed
     */
    public function store()
    {
        $id = $this->insertGetId([
            'name'        => $this->request->name,
            'description' => $this->request->description,
            'slug'        => empty($this->request->slug) ? Str::slug($this->request->name) : Str::slug($this->request->slug),
            'sort_order'  => $this->request->sort_order,
            'status'      => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

        return $this->find($id);
    }


    /**
     * @param $id
     *
     * @return false
     */
    public function edit($id)
    {
        $ok = $this->where('id', $id)->update([
            'name'        => $this->request->name,
            'description' => $this->request->description,
            'slug'        => empty($this->request->slug) ? Str::slug($this->request->name) : Str::slug($this->request->slug),
            'sort_order'  => $this->request->sort_order,
            'status'      => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'updated_at'  => Carbon::now()
        ]);

        if ($ok) {
            return $this->find($id);
        }

        return false;
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

        Storage::disk('manufacturer')->put($path, $img);

        $default_path = config('filesystems.disks.manufacturer.url') . 'default.jpg';

        if ($this->image && $this->image != $default_path) {
            $delete_path = str_replace(config('filesystems.disks.manufacturer.url'), '', $this->image);

            Storage::disk('manufacturer')->delete($delete_path);
        }

        return $this->update([
            'image' => config('filesystems.disks.manufacturer.url') . $path
        ]);
    }


    /**
     * Set Product Model request variable.
     *
     * @param $request
     */
    private function setRequest($request)
    {
        $this->request = $request;
    }
}