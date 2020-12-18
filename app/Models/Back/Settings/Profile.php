<?php

namespace App\Models\Back\Settings;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Profile extends Model
{

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @param $id
     *
     * @return Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function settings($id)
    {
        $settings = DB::table('app_settings')->where('user_id', $id)->get();

        if ($settings->count()) {
            return $settings->first();
        }

        return self::make($id);
    }


    /**
     * @param $id
     *
     * @return int
     */
    public static function updateSidebarInverseToggle($id)
    {
        $settings = DB::table('app_settings')->where('user_id', $id)->get();

        if ($settings->count()) {
            return DB::table('app_settings')->where('user_id', $id)->update([
                'sidebar_inverse' => DB::raw('NOT sidebar_inverse'),
                'updated_at'      => Carbon::now(),
            ]);
        }

        return self::make($id, 1);
    }


    /**
     * @param     $id
     * @param int $sidebar
     *
     * @return bool
     */
    public static function make($id, $sidebar = 0)
    {
        return DB::table('app_settings')->insert([
            'user_id'         => $id,
            'sidebar_inverse' => $sidebar,
            'created_at'      => Carbon::now(),
            'updated_at'      => Carbon::now(),
        ]);
    }
}
