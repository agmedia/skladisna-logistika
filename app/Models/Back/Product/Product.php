<?php

namespace App\Models\Back\Product;


use App\Models\Back\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Bouncer;

class Product extends Model
{

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    protected $request;


    /**
     * @return Relation
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('sort_order');
    }


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
    public function blocks()
    {
        return $this->hasMany(ProductBlock::class, 'product_id');
    }
    
    
    /**
     * @return Relation
     */
    public function actions()
    {
        return $this->hasOne(ProductAction::class, 'product_id')
            ->where('date_start', '<', Carbon::now())
            ->where('date_end', '>', Carbon::now())
            ->orWhere('date_start', null)
            ->orWhere('date_end', null);
    }
    
    
    /**
     * @return Relation
     */
    public function all_actions()
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
     * @param $query
     *
     * @return mixed
     */
    public function scopeClients($query)
    {
        if (Bouncer::is(auth()->user())->an('editor')) {
            $query->where('client_id', auth()->user()->clientId());
        }

        return $query;
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
            'name'        => 'required',
            'sku'         => 'required'
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
     * @param null $id
     *
     * @return $this|bool
     */
    public function store($id = null)
    {
        $product = $id ? $this->updateData($id) : $this->storeData();

        if ($product) {
            if ($id) {
                ProductAttributes::updateData($this->request, $id);
                // Delete, if any action on the product
                ProductAction::where('product_id', $id)->delete();

            } else {
                ProductAttributes::storeData($this->request, $product->id);
            }

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
     * Create and return
     * New Product Model.
     *
     * @return mixed
     */
    private function storeData()
    {
        $id = $this->insertGetId([
            'name'             => $this->request->name,
            'sku'              => $this->request->sku,
            'ean'              => isset($this->request->ean) ? $this->request->ean : '',
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
            'sort_order'       => isset($this->request->sort_order) ? $this->request->sort_order : 0,
            'used'             => (isset($this->request->used) and $this->request->used == 'on') ? 1 : 0,
            'rent'             => (isset($this->request->rent) and $this->request->rent == 'on') ? 1 : 0,
            'topponuda'        => (isset($this->request->topponuda) and $this->request->topponuda == 'on') ? 1 : 0,
            'status'           => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        if ($id) {
            return $this->find($id);
        }

        return false;
    }


    /**
     * Update and return
     * New Product Model.
     *
     * @param $id
     *
     * @return mixed
     */
    private function updateData($id)
    {
        $updated = $this->where('id', $id)->update([
            'name'             => $this->request->name,
            'sku'              => $this->request->sku,
            'ean'              => isset($this->request->ean) ? $this->request->ean : '',
            'quantity'         => $this->request->quantity,
            'pdf'              => isset($this->request->pdf) ? $this->request->pdf : 0,
            'description'      => $this->request->description,
            'seo_title'        => $this->request->seo_title,
            'meta_description' => $this->request->meta_description,
            'meta_keywords'    => $this->request->meta_keywords,
            // Related products (string comma separated product_id's)
            'slug'             => isset($this->request->slug) ? Str::slug($this->request->slug) : Str::slug($this->request->name),
            'price'            => isset($this->request->price) ? $this->request->price : 0,
            'sort_order'       => isset($this->request->sort_order) ? $this->request->sort_order : 0,
            'used'             => (isset($this->request->used) and $this->request->used == 'on') ? 1 : 0,
            'rent'             => (isset($this->request->rent) and $this->request->rent == 'on') ? 1 : 0,
            'topponuda'        => (isset($this->request->topponuda) and $this->request->topponuda == 'on') ? 1 : 0,
            'status'           => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'updated_at'       => Carbon::now()
        ]);

        if ($updated) {
            return $this->find($id);
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
        // Insert new action
        $_id = ProductAction::insertGetId([
            'product_id' => $id,
            'name'       => $this->request->action_name,
            'coupon'     => $this->request->action_code,
            'price'      => $this->request->action_price,
            'discount'   => $this->request->discount,
            'date_start' => $this->request->date_start ? new Carbon($this->request->date_start) : null,
            'date_end'   => $this->request->date_end ? new Carbon($this->request->date_end) : null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // Return ProductAction Model.
        return ProductAction::find($_id);
    }


    public function storeImages($request)
    {
        return (new ProductImage())->store($this, $request);
    }


    /**
     * Check if the request has Action.
     *
     * @return bool
     */
    public function hasAction()
    {
        if ($this->request->discount != '' or $this->request->action_price != '') {
            return true;
        }

        return false;
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


    /**
     * Return the list usually for
     * select or autocomplete html element.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function list()
    {
        $query = (new self())->newQuery();

        if (Bouncer::is(auth()->user())->an('editor')) {
            $query->where('client_id', auth()->user()->clientId());
        }

        return $query->where('status', 1)->select('id', 'name')->get();
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public static function trashComplete($id)
    {
        ProductAction::where('product_id', $id)->delete();

        return self::where('id', $id)->delete();
    }




    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/
    public static function importFromExcel($product)
    {
        $images = explode(';', $product['images']);

        $id = self::insertGetId([
            'name'             => $product['pagetitle'],
            'sku'              => $product['product_sku'],
            'ean'              => '',
            'quantity'         => 1,
            'pdf'              => str_replace('http://www.skladisna-logistika.hr/upload/artikli/', 'media/pdf/', $product['catalogfull']),
            'description'      => $product['content'],
            'seo_title'        => $product['longtitle'],
            'meta_description' => $product['description'],
            'meta_keywords'    => $product['product_sku'],
            // Related products (string comma separated product_id's)
            'slug'             => $product['alias'],
            'image'            => $images[0],
            'price'            => 0,
            'viewed'           => 0,
            'sort_order'       => 0,
            'used'             => 0,
            'status'           => 1,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        // details
        ProductAttributes::create([
            'product_id'       => $id,
            'serial'           => '',
            'year'             => '',
            'hours'            => '',
            'charger'          => '',
            'weight_capacity'  => $product['max_kapacitet_nosivosti'],
            'lift_height'      => $product['max_visina_dizanja'],
            'commision_height' => $product['max_visina_komisioniranja'],
            'battery'          => $product['max_jacina_baterije'],
            'speed'            => $product['max_brzina_voznje'],
            'application'      => $product['primjena_vilicara'],
            'width'            => $product['radni_hodnik'],
            'options'          => $product['opcije'],
            'center_mass'      => $product['teziste'],
            'radius'           => $product['okretni_radius'],
            'wheels'           => '',
            'engine'           => $product['vrsta_motora'],
            'tow_capacity'     => $product['vucni_kapacitet'],
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        foreach ($images as $image) {
            ProductImage::create([
                'product_id' => $id,
                'image'      => $image,
                'sort_order' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        return $id;
    }

}
