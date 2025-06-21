<?php
namespace Upgradeschmiede\Manufacturer\Model;

use Magento\Framework\Model\AbstractModel;

class Manufacturer extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Upgradeschmiede\Manufacturer\Model\ResourceModel\Manufacturer::class);
    }
}
