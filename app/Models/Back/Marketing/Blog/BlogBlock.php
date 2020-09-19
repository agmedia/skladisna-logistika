<?php

namespace App\Models\Back\Marketing\Blog;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Bouncer;

class BlogBlock extends Model
{

    /**
     * @var string
     */
    protected $table = 'blog_block';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @param $blog_id
     * @param $path
     * @param $image
     *
     * @return mixed
     */
    public function insertImageBlock($blog_id, $path, $image)
    {
        return $this->insertGetId([
            'blog_id'    => $blog_id,
            'type'       => 'image',
            'path'       => $path,
            'thumb'      => '',
            'title'      => '',
            'group'      => '',
            'sort_order' => $image['sort_order'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }


    /**
     * @param $blog_id
     * @param $doc
     */
    public function insertDocBlock($blog_id, $doc)
    {
        return $this->insertGetId([
            'blog_id'     => $blog_id,
            'type'        => 'pdf',
            'path'        => $doc['paths']['path'],
            'thumb'       => $doc['paths']['thumb'],
            'title'       => $doc['title'],
            'description' => $doc['description'],
            'group'       => '',
            'sort_order'  => $doc['sort_order'],
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);
    }


    /**
     * @param $blog_id
     * @param $doc
     */
    public function updateDocBlock($doc)
    {
        return $this->where('id', $doc['id'])->update([
            'path'        => $doc['paths']['path'],
            'thumb'       => $doc['paths']['thumb'],
            'title'       => $doc['title'],
            'description' => $doc['description'],
            'group'       => '',
            'sort_order'  => $doc['sort_order'],
            'updated_at'  => Carbon::now()
        ]);
    }


    /**
     * @param $id
     * @param $path
     *
     * @return mixed
     */
    public function updateImagePath($id, $path)
    {
        return $this->where('id', $id)->update([
            'path' => $path
        ]);
    }


    /**
     * @param $id
     * @param $sort_order
     *
     * @return mixed
     */
    public function updateSortOrder($id, $sort_order)
    {
        return $this->where('id', $id)->update([
            'sort_order' => $sort_order
        ]);
    }


    /**
     * @param $filename
     *
     * @return string
     */
    public function resolveFileThumb($filename)
    {
        $ext = substr($filename, strrpos($filename, '.') + 1);

        if ($ext == 'pdf') {
            return 'media/images/fileicons/pdf.jpg';
        } elseif ($ext == 'xls' || $ext == 'xlsx') {
            return 'media/images/fileicons/excel.jpg';
        } elseif ($ext == 'doc' || $ext == 'docx') {
            return 'media/images/fileicons/word.jpg';
        } elseif ($ext == 'zip') {
            return 'media/images/fileicons/zip.jpg';
        } elseif ($ext == 'rar') {
            return 'media/images/fileicons/rar.jpg';
        } else {
            return 'media/images/fileicons/unknown.jpg';
        }

        return false;
    }

}
