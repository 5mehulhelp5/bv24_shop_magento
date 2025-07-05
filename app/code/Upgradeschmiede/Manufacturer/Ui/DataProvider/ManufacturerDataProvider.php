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
        $logger = \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Psr\Log\LoggerInterface::class);
        $logger->debug('ManufacturerDataProvider: Konstruktor ausgeführt');

        $this->collection = $collectionFactory->create();
        $logger->debug('ManufacturerDataProvider: Collection gesetzt');

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
}
