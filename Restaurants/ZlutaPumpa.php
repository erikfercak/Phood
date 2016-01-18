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
        foreach ($food as $entry) {
            $entry = trim($entry->text(), " \t\n\r\0\x0B\xC2\xA0");
            if (preg_match('~Polévka:(?: \d\.)?(.*)$~ui', $entry, $m)) {
                $menu['Polievky'][] = [
                    'name' => $m[1],
                    'price' => 25,
                ];
            } elseif (preg_match('~Předkrm:(?: \d\.)?(.*)$~ui', $entry, $m)) {
                $menu['Predkrm'][] = [
                    'name' => $m[1],
                    'price' => 0,
                ];
            } elseif (preg_match('~Hlavní jídlo(?: \d)?:(?: \d\. ?)?(.*)$~mui', $entry, $m)) {
                $menu['Hlavne jedlo'][] = [
                    'name' => $m[1],
                    'price' => 99,
                ];
            }
        }
        return $menu;
    }
}
