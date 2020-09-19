<?php


namespace App\Models\Helpers;


class Payment
{

    public static function getList()
    {
        return [
            0 => [
                'code'  => 'cash',
                'label' => 'Gotovina'
            ],
            1 => [
                'code'  => 'bank',
                'label' => 'Bankovna Transakcija'
            ]
        ];
    }
}
