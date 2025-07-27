<?php
namespace Upgradeschmiede\Manufacturer\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Upgradeschmiede\Manufacturer\Model\ResourceModel\Manufacturer\CollectionFactory;

class Manufacturer extends AbstractSource
{
    protected $manufacturerCollectionFactory;
    protected $_options;

    public function __construct(CollectionFactory $manufacturerCollectionFactory)
    {
        $this->manufacturerCollectionFactory = $manufacturerCollectionFactory;
    }

    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [['label' => __('Please Select'), 'value' => '']];
            try {
                $collection = $this->manufacturerCollectionFactory->create();
                foreach ($collection as $manufacturer) {
                    $this->_options[] = [
                        'label' => $manufacturer->getName(),
                        'value' => $manufacturer->getManufacturerId()
                    ];
                }
            } catch (\Exception $e) {
                // If table doesn't exist yet, return empty options
            }
        }
        return $this->_options;
    }

    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}