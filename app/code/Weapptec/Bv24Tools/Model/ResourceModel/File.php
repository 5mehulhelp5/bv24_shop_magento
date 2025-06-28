<?php
namespace Weapptec\Bv24Tools\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class File extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('weapptec_bv24tools_file', 'id');
    }
}
