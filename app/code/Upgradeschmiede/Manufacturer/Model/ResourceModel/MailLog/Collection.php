<?php
namespace Upgradeschmiede\Manufacturer\Model\ResourceModel\MailLog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(
            'Upgradeschmiede\Manufacturer\Model\MailLog',
            'Upgradeschmiede\Manufacturer\Model\ResourceModel\MailLog'
        );
    }
}