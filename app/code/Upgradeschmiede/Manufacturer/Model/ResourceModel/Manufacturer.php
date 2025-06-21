<?php
namespace Upgradeschmiede\Manufacturer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Manufacturer extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('upgradeschmiede_manufacturer', 'manufacturer_id');
    }
}
