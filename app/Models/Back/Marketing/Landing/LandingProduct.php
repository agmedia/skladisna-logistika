<?php

namespace App\Models\Back\Marketing\Landing;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class LandingProduct extends Model
{

    /**
     * @var string
     */
    protected $table = 'landing_products';


    /**
     * @param $section
     *
     * @return bool
     * @throws \Exception
     */
    public function storeProduct($landing_id, $product)
    {
        return $this->insert([
            'landing_id'   => $landing_id,
            'product_id'   => $product,
            'sort'         => 0
        ]);
    }

}
