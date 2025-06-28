<?php
namespace Weapptec\Bv24Tools\Model;

use Magento\Framework\Model\AbstractModel;

class File extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Weapptec\Bv24Tools\Model\ResourceModel\File::class);
    }
}
