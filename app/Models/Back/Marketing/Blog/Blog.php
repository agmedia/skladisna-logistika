<?php

namespace App\Models\Back\Marketing\Blog;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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
     * @var Request
     */
    protected $request;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blocks()
    {
        return $this->hasMany(BlogBlock::class, 'blog_id');
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
            'title'       => 'required',
            'category_id' => 'required'
        ]);

        $this->request = $request;

        return $this;
    }


    /**
     * @return bool
     * @throws \Exception
     */
    public function storeBlog()
    {
        $description = preg_replace('/ style=("|\')(.*?)("|\')/', '', $this->request->description);
        $description = preg_replace('/ face=("|\')(.*?)("|\')/', '', $description);

        $id = $this->insertGetId([
            'category_id'      => $this->request->category_id,
            'title'            => $this->request->title,
            'slug'             => isset($this->request->slug) ? Str::slug($this->request->slug) : Str::slug($this->request->title),
            'description'      => $description,
            'seo_title'        => $this->request->seo_title,
            'meta_description' => $this->request->meta_description,
            'meta_keywords'    => $this->request->tags,
            'publish_date'     => isset($this->request->date_published) ? new Carbon($this->request->date_published) : Carbon::now(),
            'is_published'     => (isset($this->request->is_published) and $this->request->is_published == 'on') ? 1 : 0,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        if ($id) {
            return $this->find($id);
        }

        return false;
    }


    /**
     * @param array $id
     *
     * @return bool
     * @throws \Exception
     */
    public function updateBlog($id)
    {
        $description = preg_replace('/ style=("|\')(.*?)("|\')/', '', $this->request->description);
        $description = preg_replace('/ face=("|\')(.*?)("|\')/', '', $description);

        return $this->where('id', $id)->update([
            'category_id'      => $this->request->category_id,
            'title'            => $this->request->title,
            'slug'             => isset($this->request->slug) ? Str::slug($this->request->slug) : Str::slug($this->request->title),
            'description'      => $description,
            'seo_title'        => $this->request->seo_title,
            'meta_description' => $this->request->meta_description,
            'meta_keywords'    => $this->request->tags,
            'publish_date'     => isset($this->request->date_published) ? new Carbon($this->request->date_published) : Carbon::now(),
            'is_published'     => (isset($this->request->is_published) and $this->request->is_published == 'on') ? 1 : 0,
            'updated_at'       => Carbon::now()
        ]);
    }


    /**
     * @param $blog_id
     *
     * @return mixed
     */
    public function resolveMainImage($blog_id)
    {
        $blog = $this->where('id', $blog_id)->first();

        $path = $this->saveImage($blog_id, $this->request->main_image);

        if ($blog->image && $path) {
            $this->deleteImage($blog->image);
        }

        return $this->where('id', $blog_id)->update([
            'image' => $path
        ]);
    }


    /**
     * @param $blog_id
     *
     * @return mixed
     */
    public function resolveGallery($blog_id)
    {
        $blog_block = new BlogBlock();

        if (isset($this->request->gallery_images)) {
            foreach ($this->request->gallery_images as $key => $image) {
                if ($image['image']) {
                    $path = $this->saveImage($blog_id, $image['image']);

                    $this->deleteImage($blog_block->where('id', $key)->pluck('path'));

                    $blog_block->updateImagePath($key, $path);
                }

                $blog_block->updateSortOrder($key, $image['sort_order']);
            }
        }

        if (isset($this->request->new_gallery_images)) {
            foreach ($this->request->new_gallery_images as $image) {
                $path = $this->saveImage($blog_id, $image['image']);

                $blog_block->insertImageBlock($blog_id, $path, $image);
            }
        }

        return true;
    }


    /**
     * @param      $blog_id
     * @param null $files
     *
     * @return bool
     */
    public function resolveDocuments($blog_id, $files = null)
    {
        $blog_block = new BlogBlock();

        foreach ($this->request->blocks_docs as $key => $doc) {
            if ($doc['id']) {
                $block        = BlogBlock::where('id', $doc['id'])->first();
                $doc['paths'] = [
                    'path'  => $block->path,
                    'thumb' => $block->thumb
                ];

                if (isset($files[$key])) {
                    $doc['paths']          = $this->saveDocument($blog_id, $doc, $files[$key]);
                    $doc['paths']['thumb'] = $blog_block->resolveFileThumb($files[$key]['file']->hashName());
                }

                $blog_block->updateDocBlock($doc);
            } else {
                if (isset($files[$key])) {
                    $doc['paths']          = $this->saveDocument($blog_id, $doc, $files[$key]);
                    $doc['paths']['thumb'] = $blog_block->resolveFileThumb($files[$key]['file']->hashName());
                }

                $blog_block->insertDocBlock($blog_id, $doc);
            }
        }

        return true;
    }


    /**
     * @param $blog_id
     * @param $doc
     * @param $file
     *
     * @return array
     */
    private function saveDocument($blog_id, $doc, $file)
    {
        $path = Storage::disk('blog')->put($blog_id, $file['file']);

        if ($doc['id'] != '0') {
            $this->deleteOldDocument($doc);
        }

        return [
            'path'  => config('filesystems.disks.blog.url') . $path,
            'thumb' => isset($thumb_path) ? config('filesystems.disks.blog.url') . $thumb_path : ''
        ];
    }


    /**
     * @param $doc
     *
     * @return bool
     */
    private function deleteOldDocument($doc)
    {
        $block = BlogBlock::where('id', $doc['id'])->first();

        return Storage::disk('blog')->delete(str_replace(config('filesystems.disks.blog.url'), '', $block->path));
    }


    /**
     * @param      $blog_id
     * @param      $image
     * @param bool $thumb
     *
     * @return string
     */
    private function saveImage($blog_id, $image, $thumb = false)
    {
        $data = json_decode($image);
        $path = $blog_id . '/' . time() . '_' . $data->output->name;
        $img  = Image::make($data->output->image)->encode(str_replace('image/', '', $data->output->type));

        Storage::disk('blog')->put($path, $img);

        return config('filesystems.disks.blog.url') . $path;
    }


    /**
     * @param      $_path
     * @param bool $thumb
     *
     * @return bool
     */
    private function deleteImage($_path, $thumb = false)
    {
        $path = str_replace(config('filesystems.disks.blog.url'), '', $_path);

        return Storage::disk('blog')->delete($path);
    }
}
