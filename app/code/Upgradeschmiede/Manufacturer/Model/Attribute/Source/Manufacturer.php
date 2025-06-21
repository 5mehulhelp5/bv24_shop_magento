<?php
namespace Upgradeschmiede\Manufacturer\Model\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Upgradeschmiede\Manufacturer\Model\ResourceModel\Manufacturer\CollectionFactory;

class Manufacturer extends AbstractSource
{
    protected $manufacturerCollectionFactory;

    public function __construct(CollectionFactory $manufacturerCollectionFactory)
    {
        $this->manufacturerCollectionFactory = $manufacturerCollectionFactory;
    }

    public function getAllOptions()
    {
        if ($this->_options === null) {
            $collection = $this->manufacturerCollectionFactory->create();
            $this->_options = [];

            foreach ($collection as $manufacturer) {
                $this->_options[] = [
                    'label' => $manufacturer->getName(),
                    'value' => $manufacturer->getId()
                ];
            }
        }
        return $this->_options;
    }
}
