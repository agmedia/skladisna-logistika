<?php

namespace App\Models\Back\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductBlock extends Model
{

    /**
     * @var string
     */
    protected $table = 'product_block';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @param $request
     * @param $resource_id
     *
     * @return array|bool
     */
    public static function store($request, $resource_id)
    {
        foreach ($request->blocks as $block) {
            $data = json_decode($block['image']);

            // Ako je novi blok i nema id
            // snimi sve... sliku i podatke
            if ($data && $block['id'] == '0') {
                $img = Image::make($data->output->image)->encode('jpg');
                Storage::disk('products')->put($resource_id . '/' . $data->output->name, $img);

                $blocks[] = self::create([
                    'product_id'  => $resource_id,
                    'title'       => $block['title'],
                    'description' => $block['description'],
                    'image'       => config('filesystems.disks.products.url') . $resource_id . '/' . $data->output->name,
                    'image_align' => 'left',
                    'sort_order'  => $block['sort_order'],
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now()
                ]);
            } else { // Ako ima postojeći ID
                $old  = self::where('id', $block['id'])->first();
                $path = str_replace('media/images/gallery/products/', '', $old['image']);

                // Ako ima novu sliku... inaće je slika NULL.
                if ($data) {
                    Storage::disk('products')->delete($path);

                    $path = $old['product_id'] . '/' . $data->output->name;

                    $img = Image::make($data->output->image)->encode(str_replace('image/', '', $data->output->type));
                    Storage::disk('products')->put($path, $img);
                }

                $id = self::where('id', $old['id'])->update([
                    'title'       => $block['title'],
                    'description' => $block['description'],
                    'image'       => config('filesystems.disks.products.url') . $path,
                    'image_align' => 'left',
                    'sort_order'  => $block['sort_order'],
                    'updated_at'  => Carbon::now()
                ]);

                $blocks[] = self::find($id);
            }
        }

        if (isset($blocks)) {
            return $blocks;
        }

        return false;
    }


    /**
     * @param $request
     *
     * @return mixed
     */
    public static function renew($request)
    {
        $id = self::where('id', $request['id'])->update([
            'title'       => $request['title'],
            'description' => $request['description'],
            'image_align' => 'left',
            'sort_order'  => $request['sort_order'],
            'updated_at'  => Carbon::now()
        ]);

        return self::find($id);
    }


    public static function storeNew($request)
    {
        Log::info('storeNew');
        Log::info($request);

        return $request;

        foreach ($request->blocks as $image) {
            $data = json_decode($image['image']);

            if ($data) {
                $img = Image::make($data->output->image)->encode('jpg');

                Storage::disk('products')->put($resource_id . '/' . $data->output->name, $img);

                $blocks[] = self::create([
                    'product_id'  => $resource_id,
                    'title'       => $image['title'],
                    'description' => $image['description'],
                    'image'       => config('filesystems.disks.products.url') . $resource_id . '/' . $data->output->name,
                    'image_align' => 'left',
                    'sort_order'  => $image['sort_order'],
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now()
                ]);
            }
        }

        if (isset($blocks)) {
            return $blocks;
        }

        return false;
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public static function flush($id)
    {
        return self::where('id', $id)->delete();
    }
}
