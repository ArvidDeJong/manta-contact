<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Manta Contact Configuration
    |--------------------------------------------------------------------------
    |
    | Hier kan je de configuratie voor de Manta Contact package aanpassen.
    |
    */

    // Route prefix voor de contact module
    'route_prefix' => 'cms/contact',

    // Database instellingen
    'database' => [
        'table_name' => 'contacts',
    ],

    // Email instellingen
    'email' => [
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS', 'noreply@example.com'),
            'name' => env('MAIL_FROM_NAME', 'Manta Contact'),
        ],
        'enabled' => true,
        'default_subject' => 'Nieuw contactformulier bericht',
        'default_receivers' => env('MAIL_TO_ADDRESS', 'admin@example.com'),
    ],

    // UI instellingen
    'ui' => [
        'items_per_page' => 25,
        'show_breadcrumbs' => true,
    ],


];
