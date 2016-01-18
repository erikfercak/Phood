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

renderMenu(new Restaurants\Kravin());
renderMenu(new Restaurants\MlsnejKocour());
renderMenu(new Restaurants\Ordr());
renderMenu(new Restaurants\RetroMusicHall());
renderMenu(new Restaurants\ZlutaPumpa());
