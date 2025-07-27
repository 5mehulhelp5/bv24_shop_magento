<?php
namespace Upgradeschmiede\Manufacturer\Model\Manufacturer;

use Upgradeschmiede\Manufacturer\Model\ResourceModel\Manufacturer\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $dataPersistor;
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $manufacturerCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $manufacturerCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $manufacturer) {
            $this->loadedData[$manufacturer->getId()] = $manufacturer->getData();
        }

        $data = $this->dataPersistor->get('manufacturer');
        if (!empty($data)) {
            $manufacturer = $this->collection->getNewEmptyItem();
            $manufacturer->setData($data);
            $this->loadedData[$manufacturer->getId()] = $manufacturer->getData();
            $this->dataPersistor->clear('manufacturer');
        }

        return $this->loadedData;
    }
}