<?php
namespace Phood\Restaurants;

use Phood\Restaurants\IRestaurant;
use duzun\hQuery;

class RetroMusicHall implements IRestaurant {

    private $wantedSections = ['Polévka', 'Hlavní jídla'];

    public function getTitle() {
        return 'Retro';
    }

    public function getMenu() {
        $menu = [];
        $dom = hQuery::fromUrl('https://www.zomato.com/widgets/daily_menu.php?entity_id=16506269');

        $divs = $dom->find('div.tmi.tmi-daily');
        $section = 'N/A';
        $name = 'N/A';
        $price = 'N/A';

        if (!$divs) {
            return $menu;
        }

        foreach ($divs as $div) {
            if (preg_match('~bold~', $div->attr('class'))) {
                $section = $div->find('div.tmi-name:first');
                $section = trim($section->text());
                continue;
            } else {
                $name = $div->find('div.tmi-name:first');
                $name = trim($name->text());

                $price = $div->find('div.tmi-price');
                $price = trim($price->text());
                if (preg_match('~^(\d+)~u', $price, $m)) {
                    $price = $m[1];
                }

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
