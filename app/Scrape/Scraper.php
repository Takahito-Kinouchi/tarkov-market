<?php

namespace App\Scrape;

final class Scraper
{
    public static function itemList()
    {
        $crawler = \Goutte::request('GET', 'https://tarkov-market.com/');
        $data = $crawler->filter('div.table-list > div.row')->each(function ($node) {
            if (!$node->filter('div.cell.pointer')->count()) {
                $title = self::getTitle($node);
                $PriceDetails = self::getPriceDetails($node);
                $priceChanges = self::getPriceChange($node);
                $sellTraderInfo = self::getTraderToSell($node);
                return [
                    'name' => $title['name'],
                    'category_tags' => $title['category_tags'],
                    'price' => $PriceDetails['price'],
                    'price_per_slot' => $PriceDetails['price_per_slot'],
                    'price_day_change' => $priceChanges['24h'],
                    'price_week_change' => $priceChanges['week'],
                    'sell_to' => $sellTraderInfo['sell_to'],
                    'price_to_trader' => $sellTraderInfo['price_to_trader'],
                ];
            }
        });
        return $data;
    }

    public static function getTitle($node)
    {
        $titleInfo = $node->filter('div.cell > div.full-width.text-center');
        $name = $titleInfo->filter('a > span.name')->text();
        $categoryTags = $titleInfo->filter('div.breadcrumbs.alt.sub')->each(function ($categoryNode) {
            return $categoryNode->filter('a')->text();
        });
        return [
            'name' => $name,
            'category_tags' => implode(',', $categoryTags)
        ];
    }

    public static function getPriceDetails($node)
    {
        $priceDetails = $node->filter('div.cell.alt > div.no-wrap');
        $price = $priceDetails->filter('span.price-main')->text();
        $pricePerSlotNode = $priceDetails->filter('span.price-sec');
        if ($pricePerSlotNode->count()) {
            $pricePerSlot = $pricePerSlotNode->text();
        } else {
            $pricePerSlot = null;
        }
        return [
            'price' => $price,
            'price_per_slot' => $pricePerSlot,
        ];
    }

    public static function getPriceChange($node)
    {
        $priceChange = $node->filter('div.cell.plus');


        return [
            '24h' => $priceChange->eq(0)->text(),
            'week' => $priceChange->eq(1)->text(),
        ];
    }

    public static function getTraderToSell($node)
    {
        $traderInfoNode = $node->filter('div.cell')
            ->eq(6)
            ->filter('div');
        $traderInfo = explode(' ', $traderInfoNode->text());
        return [
            'sell_to' => $traderInfo[1],
            'price_to_trader' => $traderInfo[0],
        ];
    }
}
