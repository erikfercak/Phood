<?php
namespace Phood\Restaurants;

use Phood\Restaurants\IRestaurant;
use duzun\hQuery;

class MlsnejKocour implements IRestaurant {

    private $wantedSections = ['POLÉVKY', 'HLAVNÍ JÍDLO'];

    public function getTitle() {
        return 'Mlsnej Kocour';
    }

    public function getMenu() {
        $menu = [];
        $dom = hQuery::fromUrl('http://www.mlsnejkocour.cz/');

        $cells = $dom->find('table.dailyMenuTable td');
        $section = 'N/A';
        $name = 'N/A';
        $price = 'N/A';

        foreach ($cells as $cell) {
            if ($cell->attr('colspan') == 3) {
                $section = $cell->find('h2:first');
                $section = preg_replace('~\s+~u', ' ', $section);
                continue;
            }

            if ($cell->attr('class') == 'td-popis') {
                $name = $cell->text();
                $name = preg_replace('~\s+~u', ' ', $name);
                continue;
            }

            if ($cell->attr('class') == 'td-cena') {
                $price = $cell->text();

                $menu[$section][] = [
                    'name' => $name,
                    'price' => $price,
                ];

                $name = 'N/A';
                $price = 'N/A';
            }
        }

        foreach ($menu as $section => $unused) {
            if (!in_array($section, $this->wantedSections)) {
                unset($menu[$section]);
            }
        }

        return $menu;
    }
}
