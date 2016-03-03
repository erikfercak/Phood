<?php
namespace Phood\Restaurants;

use Phood\Restaurants\IRestaurant;
use duzun\hQuery;

class ZlutaPumpa implements IRestaurant {

    public function getTitle() {
        return 'Žlutá Pumpa';
    }

    public function getMenu() {
        $menu = [];
        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36',
        ];
        $dom = hQuery::fromUrl('http://www.zluta-pumpa.info/denni-menu/', $headers);
        $food = $dom->find('div.post h4 strong');

        if ($food == NULL) {
            $food = $dom->find('div.post h4');
        }

        if ($food == NULL) {
            return $menu;
        }

        foreach ($food as $entry) {
            $entry = trim($entry->text(), " \t\n\r\0\x0B\xC2\xA0");
            if (preg_match('~Polévka:\s*(?:\d\.)?(.*)$~mui', $entry, $m)) {
                $menu['Polievky'][] = [
                    'name' => $m[1],
                    'price' => 25,
                ];
            }
            if (preg_match('~Předkrm:(.*)$~mui', $entry, $m)) {
                $menu['Predkrm'][] = [
                    'name' => preg_replace('~\s+~u', ' ', trim($m[1])),
                    'price' => 0,
                ];
            }
            if (preg_match('~Hlavní jídlo:(?:\s*\d\.\s*)?(.*)$~mui', $entry, $m)) {
                $menu['Hlavne jedlo'][] = [
                    'name' => preg_replace('~\s+~u', ' ', trim($m[1])),
                    'price' => 99,
                ];
            }
        }
        return $menu;
    }
}
