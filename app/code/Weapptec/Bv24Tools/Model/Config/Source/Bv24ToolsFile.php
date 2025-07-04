<?php

namespace Weapptec\Bv24Tools\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\App\ResourceConnection;

class Bv24ToolsFile extends AbstractSource
{
    protected $resource;

    public function __construct(ResourceConnection $resource)
    {
        $this->resource = $resource;
    }

    public function getAllOptions()
    {
        if ($this->_options === null) {
            $connection = $this->resource->getConnection();
            $tableName = $this->resource->getTableName('weapptec_bv24tools_file');

            $select = $connection->select()
                ->from($tableName, ['value' => 'id', 'label' => 'title']);

            $this->_options = $connection->fetchAll($select);
        }

        return $this->_options;
    }

     public function getData()
    {
        if ($this->_options === null) {
            $connection = $this->resource->getConnection();
            $tableName = $this->resource->getTableName('weapptec_bv24tools_file');

            $select = $connection->select()
                ->from($tableName, ['id', 'title', 'description', 'file_name', 'created_at']);

            $this->_options = $connection->fetchAll($select);
        }

        return $this->_options;
    }
}

