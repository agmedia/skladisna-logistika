<?php

namespace App\Models\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    
    /**
     * @var string $table
     */
    protected $table = 'product_images';
    
    /**
     * @var array $guarded
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    
    /**
     * Save stack of images to the
     * product_images database.
     *
     * @param array $paths
     * @param       $product_id
     *
     * @return array|bool
     */
    public static function saveStack(array $paths, $product_id)
    {
        $images = [];
        
        foreach ($paths as $key => $path) {
            $images[] = self::create([
                'product_id' => $product_id,
                'image'      => $path,
                'sort_order' => $key,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        
        if ( ! empty($images)) {
            return $images;
        }
        
        return false;
    }
    
    
    /**
     * Save temporary stored images
     * to newly saved product folder.
     * The folder is based on product ID.
     *
     * @param array $paths
     * @param       $product_id
     *
     * @return array|bool
     */
    public static function transferTemporaryImages(array $paths, $product_id)
    {
        $targets = [];
        
        foreach ($paths as $key => $path) {
            $target    = str_replace('temp', $product_id, $path);
            $targets[] = $target;
            
            if ($key == 0) {
                self::setDefault($target, $product_id);
            }
            
            $_path   = str_replace(config('filesystems.disks.products.url'), '', $path);
            $_target = str_replace(config('filesystems.disks.products.url'), '', $target);
            
            Storage::disk('products')->move($_path, $_target);
            Storage::disk('products')->delete($_path);
        }
        
        return self::saveStack($targets, $product_id);
    }
    
    
    /**
     * Set default product image.
     *
     * @param string $path
     * @param        $id
     *
     * @return mixed
     */
    public static function setDefault(string $path, $id)
    {
        return Product::where('id', $id)->update([
            'image' => $path
        ]);
    }
}
