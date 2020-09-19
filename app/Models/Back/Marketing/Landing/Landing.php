<?php

namespace App\Models\Back\Marketing\Landing;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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
     * @var Request
     */
    protected $request;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sections()
    {
        return $this->hasMany(LandingSection::class, 'landing_id')->orderBy('sort');
    }


    /**
     * @return string[]
     */
    public function product_ids()
    {
        $ids = $this->hasMany(LandingProduct::class, 'landing_id')->pluck('product_id');
        $arr = [];

        foreach ($ids as $id) {
            $arr[] = $id;
        }

        return collect($arr)->flatten()->all();
    }


    /**
     * Validate Blog Request.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'client' => 'required'
        ]);

        $this->request = $request;

        return $this;
    }


    /**
     * @return bool
     * @throws \Exception
     */
    public function storePage()
    {
        $pin = Str::random(4);

        $description = preg_replace('/ style=("|\')(.*?)("|\')/', '', isset($this->request->content_1) ? $this->request->content_1 : '');
        $description = preg_replace('/ face=("|\')(.*?)("|\')/', '', $description);

        $id = $this->insertGetId([
            'client'       => $this->request->client,
            'title'        => isset($this->request->title) ? $this->request->title : $this->request->client,
            'content_1'    => $description,
            'image'        => '',
            'video'        => '',
            'pin'          => Str::slug($pin),
            'slug'         => Str::slug($this->request->client . '-' . $pin),
            'download_url' => '',
            'statement'    => isset($this->request->statement) ? $this->request->statement : '',
            'date_start'   => isset($this->request->date_start) ? new Carbon($this->request->date_start) : null,
            'date_end'     => isset($this->request->date_end) ? new Carbon($this->request->date_end) : null,
            'is_published' => (isset($this->request->is_published) and $this->request->is_published == 'on') ? 1 : 0,
            'viewed'       => 0,
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now()
        ]);

        if ($id) {
            return $this->find($id);
        }

        return false;
    }


    /**
     * @return bool
     * @throws \Exception
     */
    public function updatePage($id)
    {
        $pin = $this->select('pin')->where('id', $id)->first();

        Log::debug($pin);

        $description = preg_replace('/ style=("|\')(.*?)("|\')/', '', isset($this->request->content_1) ? $this->request->content_1 : '');
        $description = preg_replace('/ face=("|\')(.*?)("|\')/', '', $description);

        return $this->where('id', $id)->update([
            'client'       => $this->request->client,
            'title'        => isset($this->request->title) ? $this->request->title : $this->request->client,
            'content_1'    => $description,
            'slug'         => Str::slug($this->request->client . '-' . $pin->pin),
            'statement'    => isset($this->request->statement) ? $this->request->statement : '',
            'date_start'   => isset($this->request->date_start) ? new Carbon($this->request->date_start) : null,
            'date_end'     => isset($this->request->date_end) ? new Carbon($this->request->date_end) : null,
            'is_published' => (isset($this->request->is_published) and $this->request->is_published == 'on') ? 1 : 0,
            'updated_at'   => Carbon::now()
        ]);
    }


    /**
     * @param $landing_id
     *
     * @return mixed
     */
    public function resolveMainImage($landing_id)
    {
        $landing = $this->where('id', $landing_id)->first();

        $path = $this->saveImage($landing_id, $this->request->main_image);

        if ($landing->image && $path) {
            $this->deleteImage($landing->image);
        }

        return $this->where('id', $landing_id)->update([
            'image' => $path
        ]);
    }


    /**
     * @param      $landing_id
     * @param      $image
     * @param bool $thumb
     *
     * @return string
     */
    private function saveImage($landing_id, $image, $thumb = false)
    {
        $data = json_decode($image);
        $path = $landing_id . '/' . time() . '_' . $data->output->name;
        $img  = Image::make($data->output->image)->encode(str_replace('image/', '', $data->output->type));

        Storage::disk('landing')->put($path, $img);

        return config('filesystems.disks.landing.url') . $path;
    }


    /**
     * @param      $_path
     * @param bool $thumb
     *
     * @return bool
     */
    private function deleteImage($_path, $thumb = false)
    {
        $path = str_replace(config('filesystems.disks.landing.url'), '', $_path);

        return Storage::disk('landing')->delete($path);
    }


    /**
     * @param $landing
     * @param $file
     *
     * @return string
     */
    public function saveDocument($landing, $file)
    {
        $path = Storage::disk('landing')->put($landing->id, $file);

        if ( ! empty($landing->download_url)) {
            Storage::disk('landing')->delete(str_replace(config('filesystems.disks.landing.url'), '', $landing->download_url));
        }

        $this->where('id', $landing->id)->update([
            'download_url' => config('filesystems.disks.landing.url') . $path
        ]);

        return config('filesystems.disks.landing.url') . $path;
    }


    /**
     * @param $landing_id
     * @param $sections
     *
     * @return int
     * @throws \Exception
     */
    public function resolveSections($landing_id, $sections)
    {
        $ls = new LandingSection();

        foreach ($sections as $key => $subsections) {
            foreach ($subsections as $section) {
                if ($ls->validateInput($landing_id, $section)) {
                    $ls->storeSection($key);
                }
            }
        }

        return 1;
    }


    public function updateSections($landing_id, $sections)
    {
        $ls = new LandingSection();

        $ls->where('landing_id', $landing_id)->whereIn('section', [2, 6])->delete();

        foreach ($sections as $key => $subsections) {
            if ($key == 2 || $key == 6) {
                foreach ($subsections as $section) {
                    if ($ls->validateInput($landing_id, $section)) {
                        $ls->storeSection($key);
                    }
                }
            }

            if ($key == 3) {
                foreach ($subsections as $section) {
                    if ($ls->validateInput($landing_id, $section)) {
                        $ls->updateSection($key);
                    }
                }
            }
        }
    }


    /**
     * @param $landing_id
     * @param $products
     *
     * @return int
     * @throws \Exception
     */
    public function resolveProducts($landing_id, $products)
    {
        $lp = new LandingProduct();

        $lp->where('landing_id', $landing_id)->delete();

        if ($products) {
            foreach ($products as $product) {
                $lp->storeProduct($landing_id, $product);
            }
        }

        return 1;
    }
}
