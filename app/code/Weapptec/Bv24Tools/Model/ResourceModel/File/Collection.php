<?php
namespace Weapptec\Bv24Tools\Model\ResourceModel\File;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Weapptec\Bv24Tools\Model\File::class,
            \Weapptec\Bv24Tools\Model\ResourceModel\File::class
        );
    }
}