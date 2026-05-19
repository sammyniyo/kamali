<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public studio contact (shown in nav, footer, contact page)
    |--------------------------------------------------------------------------
    */

    'phone_display' => env('KAMALI_PHONE_DISPLAY', '+250 780 525 403'),
    'phone_tel' => env('KAMALI_PHONE_TEL', '+250780525403'),

    'email' => env('KAMALI_EMAIL', 'sales@kamaliarchitects.com'),

    'website_url' => env('KAMALI_WEBSITE_URL', 'https://www.kamaliarchitects.com'),
    'website_host' => env('KAMALI_WEBSITE_HOST', 'www.kamaliarchitects.com'),

    'address' => [
        'street' => env('KAMALI_ADDRESS_STREET', 'KN 7 St'),
        'city' => env('KAMALI_ADDRESS_CITY', 'Kigali'),
        'country' => env('KAMALI_ADDRESS_COUNTRY', 'Rwanda'),
    ],

    /** Google Maps embed search string */
    'map_embed_query' => env('KAMALI_MAP_QUERY', 'KN 7 St, Kigali, Rwanda'),

    /** Year the studio was founded (used for “years experience” on the homepage). */
    'founded_year' => (int) env('KAMALI_FOUNDED_YEAR', 2010),

    /** Press / award features shown on About and counted in homepage stats. */
    'recognition' => [
        'A+ Awards',
        'ArchDaily',
        'Dezeen',
        'RIBA',
        'IF Design',
        'WAF',
    ],

    /*
    |--------------------------------------------------------------------------
    | Placeholder media (no upload yet)
    |--------------------------------------------------------------------------
    */

    /** Relative to /public — used when a team member has no photo */
    'placeholder_avatar' => 'images/placeholders/avatar.svg',

    /** Public project grids (3 columns — 12 = 4 rows). */
    'projects_per_page' => (int) env('KAMALI_PROJECTS_PER_PAGE', 12),

    /** Admin project list default and selectable page sizes. */
    'admin_projects_per_page' => (int) env('KAMALI_ADMIN_PROJECTS_PER_PAGE', 15),
    'admin_projects_per_page_options' => [12, 20, 40],

    /** Rotated when a project has no cover image (paths under /public) */
    'placeholder_project_covers' => [
        'images/renders/villa-greenwall.png',
        'images/renders/apartments-court.png',
        'images/renders/mansion-symmetry.png',
        'images/renders/villa-evening.png',
        'images/renders/fashion-house.png',
        'images/renders/apartments-rooftop.png',
    ],

];
