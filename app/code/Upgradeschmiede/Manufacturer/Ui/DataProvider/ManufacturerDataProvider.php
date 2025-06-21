<?php
namespace Upgradeschmiede\Manufacturer\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Upgradeschmiede\Manufacturer\Model\ResourceModel\Manufacturer\CollectionFactory;

class ManufacturerDataProvider extends AbstractDataProvider
{
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
}
