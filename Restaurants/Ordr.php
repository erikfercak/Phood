<?php
namespace Phood\Restaurants;

use Phood\Restaurants\IRestaurant;
use duzun\hQuery;

class Ordr implements IRestaurant {
    public function getTitle() {
        return 'Ordr';
    }

    public function getMenu() {
        $menu = [];
        $dom = hQuery::fromUrl('https://www.ordr.cz/');

        $food = $dom->find('div.meal__desc-inner');
        foreach ($food as $entry) {
            $name = $entry->find('h2.meal__name')->text();
            $price = $entry->find('p.meal__price')->text();
            if (preg_match('~Cena (\d+) Kč~u', $price, $m)) {
                $price = $m[1];
            }
            $menu['Menu'][] = [
                'name' => $name,
                'price' => $price,
            ];
        }
        return $menu;
    }
}
