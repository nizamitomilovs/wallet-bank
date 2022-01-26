<?php

namespace App\Repositories\CurrenciesRepositories;

use App\Models\Rate;
use Illuminate\Support\Facades\DB;
use Orchestra\Parser\Xml\Facade as XmlParser;

class LatvijasBankRepository implements CurrenciesRepositoryInterface
{
    public function getRates(): void
    {
        $ratesData = $this->loadRatesXml();

        //get rate names from array
        $rateNames = array_filter($ratesData, function($value) {
            return ctype_alpha($value);
        });

        //get rate values from array
        $rateValue = array_filter($ratesData, function($value) {
            return is_numeric($value);
        });

        //make associative array to store or update in mysql
        $rates = array_combine($rateNames, $rateValue);

        $this->storeOrUpdateRates($rates);
    }

    private function loadRatesXml(): array
    {
        $xml = XmlParser::load('https://www.bank.lv/vk/ecb_rss.xml');

        $rates = $xml->parse([
            'item' => ['uses' => 'channel.item.description'],
        ]);

        return explode(' ', $rates['item']);
    }

    private function storeOrUpdateRates(array $rates): void
    {
        foreach($rates as $name => $value){
            Rate::updateOrCreate(
                ['name' => $name],
                ['rate' => $value]
            );
        }
    }
}
