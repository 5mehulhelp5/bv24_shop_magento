<?php
namespace Weapptec\Bv24Tools\Model\Autocomplete;

use Magento\Search\Model\Autocomplete\DataProviderInterface;

class CustomDataProvider implements DataProviderInterface
{
    public function getItems()
    {
        return [
            [
                'title' => 'Beispiel-Eintrag',
                'url' => '/beispiel-url.html',
                'type' => 'custom'
            ]
        ];
    }
}