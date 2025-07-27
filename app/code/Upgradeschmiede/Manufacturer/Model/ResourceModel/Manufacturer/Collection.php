<?php
namespace Upgradeschmiede\Manufacturer\Model\ResourceModel\Manufacturer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'manufacturer_id';

    protected function _construct()
    {
        $this->_init(
            'Upgradeschmiede\Manufacturer\Model\Manufacturer',
            'Upgradeschmiede\Manufacturer\Model\ResourceModel\Manufacturer'
        );
    }
}