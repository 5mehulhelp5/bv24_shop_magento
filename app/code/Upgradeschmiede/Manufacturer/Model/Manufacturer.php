<?php
namespace Upgradeschmiede\Manufacturer\Model;

use Magento\Framework\Model\AbstractModel;

class Manufacturer extends AbstractModel
{
    const CACHE_TAG = 'upgradeschmiede_manufacturer';

    protected $_cacheTag = 'upgradeschmiede_manufacturer';
    protected $_eventPrefix = 'upgradeschmiede_manufacturer';

    protected function _construct()
    {
        $this->_init('Upgradeschmiede\Manufacturer\Model\ResourceModel\Manufacturer');
    }
}