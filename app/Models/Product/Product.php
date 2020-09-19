<?php

namespace App\Models\Product;


use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    
    /**
     * @var string $table
     */
    protected $table = 'products';
    
    /**
     * @var array $guarded
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    /**
     * @var Request $request
     */
    protected $request;
    
    
    /**
     * @return Relation
     */
    public function details()
    {
        return $this->hasOne(ProductAttributes::class, 'product_id');
    }
    
    
    /**
     * @return Relation
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    
    
    /**
     * @return Relation
     */
    public function actions()
    {
        return $this->hasOne(ProductAction::class, 'product_id');
    }
    
    
    /**
     * @return Relation
     */
    public function categories()
    {
        return $this->hasManyThrough(Category::class, ProductCategory::class, 'product_id', 'id', 'id', 'category_id');
    }
    
    
    /**
     * Validate New Product Request.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        // Validate the request.
        $request->validate([
            'name' => 'required',
            'sku'  => 'required'
        ]);
        
        // Set Product Model request variable
        $this->setRequest($request);
        
        return $this;
    }
    
    
    /**
     * Boot up new product.
     * Create all dependencies.
     * Return Product if stored, false if not.
     *
     * @param array $request
     *
     * @return $this|bool
     */
    public function stored($request = [])
    {
        // If the $request is not empty,
        // set Model request variable and then process.
        if ( ! empty($request)) {
            $this->setRequest($request);
        }
        
        // Create new product.
        $product = $this->storeData();
        
        // If product is created. Create all dependencies.
        if ($product) {
            ProductAttributes::storeData($this->request, $product->id);
    
            if (isset($this->request->categories)) {
                ProductCategory::storeData($this->request->categories, $product->id);
            }
    
            if ($this->hasAction()) {
                $this->storeAction($product->id);
            }
            
            return $product;
        }
        
        return false;
    }
    
    
    /**
     * Update apartment data.
     *
     * @param $id
     *
     * @return bool|mixed
     */
    public function edited($id)
    {
        // Update product.
        $product = $this->updateData($id);
        
        // If product is updated. Update dependencies.
        if ($product) {
            ProductAttributes::updateData($this->request, $id);
            
            if (isset($this->request->categories)) {
                ProductCategory::storeData($this->request->categories, $id);
            }
    
            if ($this->hasAction()) {
                $this->storeAction($id);
            }
            
            return $product;
        }
        
        return false;
    }
    
    
    /**
     * Create and return
     * New Product Model.
     *
     * @return mixed
     */
    private function storeData()
    {
        // Insert request and get new product ID.
        $id = $this->insertGetId([
            'name'             => $this->request->name,
            'sku'              => $this->request->sku,
            'ean'              => $this->request->ean,
            'quantity'         => isset($this->request->quantity) ? 1 : 0,
            'pdf'              => isset($this->request->pdf) ? $this->request->pdf : 0,
            'description'      => $this->request->description,
            'seo_title'        => $this->request->seo_title,
            'meta_description' => $this->request->meta_description,
            'meta_keywords'    => $this->request->meta_keywords,
            // Related products (string comma separated product_id's)
            'slug'             => isset($this->request->slug) ? Str::slug($this->request->slug) : Str::slug($this->request->name),
            'price'            => isset($this->request->price) ? $this->request->price : 0,
            'viewed'           => 0,
            'sort_order'       => 0,
            'used'             => (isset($this->request->used) and $this->request->used == 'on') ? 1 : 0,
            'topponuda'             => (isset($this->request->topponuda) and $this->request->topponuda == 'on') ? 1 : 0,
            'status'           => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);
        
        // Return Apartment Model.
        return $this->find($id);
    }
    
    
    /**
     * Update and return
     * New Product Model.
     *
     * @return mixed
     */
    private function updateData($id)
    {
        // Update the model by it's ID.
        $updated = $this->where('id', $id)->update([
            'name'             => $this->request->name,
            'sku'              => $this->request->sku,
            'ean'              => $this->request->ean,
            'quantity'         => isset($this->request->quantity) ? 1 : 0,
            'pdf'              => isset($this->request->pdf) ? $this->request->pdf : 0,
            'description'      => $this->request->description,
            'seo_title'        => $this->request->seo_title,
            'meta_description' => $this->request->meta_description,
            'meta_keywords'    => $this->request->meta_keywords,
            // Related products (string comma separated product_id's)
            'slug'             => isset($this->request->slug) ? Str::slug($this->request->slug) : Str::slug($this->request->name),
            'price'            => isset($this->request->price) ? $this->request->price : 0,
            'viewed'           => 0,
            'sort_order'       => 0,
            'used'             => (isset($this->request->used) and $this->request->used == 'on') ? 1 : 0,
            'topponuda'             => (isset($this->request->topponuda) and $this->request->topponuda == 'on') ? 1 : 0,
            'status'           => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'updated_at'       => Carbon::now()
        ]);
        
        if ($updated) {
            // Return Apartment Model.
            return $this->find($id);
        }
        
        // Return false because Model is not updated.
        return false;
    }
    
    
    /**
     * Check if the request has Action.
     *
     * @return bool
     */
    public function hasAction()
    {
        if ($this->request->date_start != '' or $this->request->date_end != '' or $this->request->discount != '') {
            return true;
        }
        
        return false;
    }
    
    
    /**
     * Store Action data.
     * Delete old if exist and store new.
     * Return action data.
     *
     * @param $id
     *
     * @return mixed
     */
    public function storeAction($id)
    {
        // Delete, if any action on the product
        ProductAction::where('product_id', $id)->delete();
        
        // Insert new action
        $_id = ProductAction::insertGetId([
            'product_id' => $id,
            'price'      => $this->request->price,
            'discount'   => $this->request->discount,
            'date_start' => new Carbon($this->request->date_start),
            'date_end'   => new Carbon($this->request->date_end),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        // Return ProductAction Model.
        return ProductAction::find($_id);
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
    
    
    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/
    // Static functions
    //
    public static function getMenu()
    {
        return self::where('status', 1)->select('id', 'name')->get();
    }
    
    
    /**
     * @param $blog
     * @param $path
     *
     * @return mixed
     */
    public static function updateFilePath($product, $path)
    {
        return self::where('id', $product->id)->update([
            'pdf' => $path
        ]);
    }
    
    
    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/
    // Testing functions
    //
    public function getImages($apartment_id, $images)
    {
        $disk   = Storage::disk('products');
        $images = $disk->files($apartment_id);
        
        if ( ! empty($images)) {
            $response = [];
            
            foreach ($images as $image) {
                $response[] = [
                    'name' => basename($image),
                    'size' => $disk->size($image),
                    'path' => str_replace('storage', 'media/images/gallery/apartments', $disk->url($image)),
                ];
            }
            
            return json_encode($response);
        }
        
        return json_encode(['status' => false]);
    }
}
