<?php

namespace Phood;
use duzun\hQuery;

require_once __DIR__ . '/vendor/duzun/hquery/hquery.php';
require_once __DIR__ . '/Restaurants/IRestaurant.php';
require_once __DIR__ . '/Restaurants/Kravin.php';
require_once __DIR__ . '/Restaurants/MlsnejKocour.php';
require_once __DIR__ . '/Restaurants/Ordr.php';
require_once __DIR__ . '/Restaurants/RetroMusicHall.php';
require_once __DIR__ . '/Restaurants/ZlutaPumpa.php';

hQuery::$cache_path = __DIR__ . '/cache';

function renderMenu(Restaurants\IRestaurant $restaurant) {
    printf(
        "\n%s\n%s",
        $restaurant->getTitle(),
        str_repeat('=', mb_strlen($restaurant->getTitle()))
    );

    foreach ($restaurant->getMenu() as $section => $entries) {
        printf(
            "\n%s\n%s\n",
            $section,
            str_repeat('-', mb_strlen($section))
        );
        foreach ($entries as $entry) {
            printf(
                "%s %d,-\n",
                $entry['name'],
                $entry['price']
            );
        }
    }
}

$availableRestaurants = array('kravin', 'kocour', 'ordr', 'retro', 'pumpa');
$options = getopt('', $availableRestaurants);

$restaurants = array();
foreach ($options as $restaurant => $nothing) {
    if (in_array($restaurant, $availableRestaurants)) {
        $restaurants[] = $restaurant;
    }
}

if (empty($restaurants)) {
    $restaurants = $availableRestaurants;
}

foreach ($restaurants as $restaurant) {
    switch ($restaurant) {
        case 'kravin':
            renderMenu(new Restaurants\Kravin());
            break;
        case 'kocour':
            renderMenu(new Restaurants\MlsnejKocour());
            break;
        case 'ordr':
            renderMenu(new Restaurants\Ordr());
            break;
        case 'retro':
            renderMenu(new Restaurants\RetroMusicHall());
            break;
        case 'pumpa':
            renderMenu(new Restaurants\ZlutaPumpa());
            break;
    }
}
