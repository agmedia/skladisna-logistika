<?php

namespace App\Models\Back\Design;

use App\Models\Helpers\Url;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Widget extends Model
{

    /**
     * @var string
     */
    protected $table = 'widgets';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    private $request;

    /**
     * @var
     */
    private $url;


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeGroups($query)
    {
        return $query->groupBy('group');
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
            'group' => 'required',
            'title' => 'required'
        ]);

        // Set Product Model request variable
        $this->setRequest($request);

        return $this;
    }


    /**
     * @return $this
     */
    public function setUrl()
    {
        $this->url = $this->request->url;

        if ( ! $this->url && $this->request->link && $this->request->link_id) {
            $this->url = Url::set($this->request->link, $this->request->link_id);
        }

        return $this;
    }


    /**
     * @return mixed
     */
    public function store()
    {
        $id = $this->insertGetId([
            'group'      => Str::upper($this->request->group),
            'title'      => $this->request->title,
            'subtitle'   => $this->request->subtitle,
            'link'       => $this->request->link ? $this->request->link : null,
            'link_id'    => $this->request->link_id ? $this->request->link_id : null,
            'url'        => $this->url,
            'badge'      => $this->request->badge ? $this->request->badge : null,
            'width'      => $this->request->width ? $this->request->width : null,
            'sort_order' => $this->request->sort_order ? $this->request->sort_order : 0,
            'status'     => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
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
        Log::warning($this->request);

        $ok = $this->where('id', $id)->update([
            'group'      => Str::upper($this->request->group),
            'title'      => $this->request->title,
            'subtitle'   => $this->request->subtitle,
            'link'       => $this->request->link ? $this->request->link : null,
            'link_id'    => $this->request->link_id ? $this->request->link_id : null,
            'url'        => $this->url,
            'badge'      => $this->request->badge ? $this->request->badge : null,
            'width'      => $this->request->width ? $this->request->width : null,
            'sort_order' => $this->request->sort_order ? $this->request->sort_order : 0,
            'status'     => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'created_at' => Carbon::now()
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

        Storage::disk('widget')->put($path, $img);

        $default_path = config('filesystems.disks.widget.url') . 'default.jpg';

        if ($this->image && $this->image != $default_path) {
            $delete_path = str_replace(config('filesystems.disks.widget.url'), '', $this->image);

            Storage::disk('widget')->delete($delete_path);
        }

        return $this->update([
            'image' => config('filesystems.disks.widget.url') . $path
        ]);
    }


    public function sizes()
    {
        return [
            [
                'value' => 12,
                'title' => '1:1 - Puna širina'
            ],
            [
                'value' => 6,
                'title' => '1:2 - Pola širine'
            ],
            [
                'value' => 4,
                'title' => '1:3 - Trećina širine'
            ],
            [
                'value' => 8,
                'title' => '2:3 - 2 trećine širine'
            ],
        ];
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