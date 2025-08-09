<?php
namespace Upgradeschmiede\Manufacturer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class MailLog extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('upgradeschmiede_maillog', 'id');
    }
}