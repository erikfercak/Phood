<?php
namespace Phood\Restaurants;

use Phood\Restaurants\IRestaurant;
use duzun\hQuery;

class Kravin implements IRestaurant {
    public function getTitle() {
        return 'Kravín';
    }

    public function getMenu() {
        $menu = [];
        $dom = hQuery::fromUrl('http://www.restauracekravin.cz/');

        $soups = $dom->find('div.entry-content td>strong');
        foreach ($soups as $soup) {
            if (preg_match('~(.*) \(.+ (\d+),-\)$~ui', trim($soup->text(), " \t\n\r\0\x0B\xC2\xA0"), $m)) {
                $menu['Polievka'][] = [
                    'name' => $m[1],
                    'price' => $m[2],
                ];
            }
        }

        $food = $dom->find('div.entry-content li>strong');
        foreach ($food as $entry) {
            if (preg_match('~Menu č.\d (.*) (\d+),-$~ui', trim($entry->text(), " \t\n\r\0\x0B\xC2\xA0"), $m)) {
                $menu['Menu'][] = [
                    'name' => $m[1],
                    'price' => $m[2],
                ];
            }
        }
        return $menu;
    }
}
