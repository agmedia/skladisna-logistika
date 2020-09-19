<?php

namespace App\Models\Back\Marketing\Landing;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class LandingSection extends Model
{

    /**
     * @var string
     */
    protected $table = 'landing_sections';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var int
     */
    protected $landing_id;

    /**
     * @var array
     */
    public $section;


    /**
     * @param $section
     *
     * @return bool
     */
    public function validateInput($landing_id, $section)
    {
        $this->landing_id = $landing_id;
        $this->section    = $section;

        return true;
        //return ($section['title'] != '' && $section['content_1'] != '') ? true : false;
    }


    /**
     * @param $section
     *
     * @return bool
     * @throws \Exception
     */
    public function storeSection($section)
    {
        $content = $this->section['content_1'];

        if ($section == 6) {
            $content = $this->cleanHtml($this->section['content_1']);
            Log::info($content);
        }

        $id = $this->insertGetId([
            'landing_id'   => $this->landing_id,
            'section'      => $section,
            'title'        => $this->section['title'],
            'subtitle'     => isset($this->section['subtitle']) ? $this->section['subtitle'] : '',
            'content_1'    => $content,
            'image'        => '',
            'video'        => isset($this->section['video']) ? $this->section['video'] : '',
            'sort'         => isset($this->section['sort']) ? $this->section['sort'] : 0,
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now()
        ]);

        if ($id && isset($this->section['image']) && $this->section['image'] != null) {
            $this->resolveImage($id);
        }
    }


    /**
     * @param $section
     *
     * @return bool
     * @throws \Exception
     */
    public function updateSection($section)
    {
        $id = $this->where('id', $this->section['id'])->update([
            'section'      => $section,
            'title'        => $this->section['title'],
            'subtitle'     => isset($this->section['subtitle']) ? $this->section['subtitle'] : '',
            'content_1'    => $this->section['content_1'],
            'video'        => isset($this->section['video']) ? $this->section['video'] : '',
            'sort'         => isset($this->section['sort']) ? $this->section['sort'] : 0,
            'updated_at'   => Carbon::now()
        ]);

        if ($id && isset($this->section['image']) && $this->section['image'] != null) {
            $this->resolveImage($this->section['id']);
        }
    }


    /**
     * @param $section_id
     *
     * @return mixed
     */
    public function resolveImage($section_id)
    {
        $section = $this->where('id', $section_id)->first();

        $path = $this->saveImage($this->landing_id, $this->section['image']);

        if ($section->image && $path) {
            $this->deleteImage($section->image);
        }

        return $this->where('id', $section_id)->update([
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
     * @param $text
     *
     * @return string|string[]
     */
    private function cleanHtml($text)
    {
        $text = str_replace('<p>', '', $text);

        return str_replace('</p>', '<br>', $text);
    }

}
