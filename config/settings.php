<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'roles' => [
        'admin' => 'Administrator',
        'editor' => 'Editor',
        'customer' => 'Korisnik'
    ],
    /**
     *
     */
    'pagination' => [
        'items' => 12
    ],
    /**
     *
     */
    'payments' => [
        //'cash' => 'Gotovina',
        'bank' => 'Bankovna Transakcija',
        //'card' => 'Kartica',
    ],
    /**
     *
     */
    'shipping' => [
        //'hand' => 'Osobna dostava',
        //'pickup' => 'Osobno podizanje',
        'shipping' => 'Dostava Poštom',
    ],
    /**
     *
     */
    'tax' => 25,
    /**
     *
     */
    'totals' => [
        'subtotal' => [
            'title' => 'Iznos bez rabata',
            'status' => 1,
            'sort_order' => 0,
        ],
        'discount' => [
            'title' => 'Rabat',
            'status' => 1,
            'sort_order' => 1,
        ],
        'shipping' => [
            'title' => 'Poštarina',
            'status' => 0,
            'sort_order' => 2
        ],
        'tax' => [
            'title' => 'PDV',
            'status' => 1,
            'sort_order' => 3
        ],
        'total' => [
            'title' => 'Sveukupno',
            'status' => 1,
            'sort_order' => 4
        ]
    ]

];
