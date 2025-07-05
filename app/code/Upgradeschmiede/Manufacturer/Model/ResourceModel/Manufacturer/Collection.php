<?php
namespace Upgradeschmiede\Manufacturer\Model\ResourceModel\Manufacturer;

use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Api\SearchCriteriaInterface;
use Upgradeschmiede\Manufacturer\Model\Manufacturer;

class Collection extends AbstractCollection implements SearchResultInterface
{
    protected $aggregations;

    protected function _construct()
    {
        $this->_init(
            Manufacturer::class,
            \Upgradeschmiede\Manufacturer\Model\ResourceModel\Manufacturer::class
        );
    }

    public function getItems()
    {
        $logger = \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Psr\Log\LoggerInterface::class);
        $logger->debug('Hersteller Collection: getItems() ausgeführt');

        if (!$this->isLoaded()) {
            $this->load();
        }

        $items = parent::getItems();

        if (!is_array($items)) {
            $logger->debug('Hersteller Collection: getItems() liefert keinen Array!');
        } else {
            $logger->debug('Hersteller Collection: ' . count($items) . ' Einträge gefunden');
        }

        return $items;
    }

    public function getAggregations() { return $this->aggregations; }
    public function setAggregations($aggregations) { $this->aggregations = $aggregations; }
    public function getSearchCriteria() { return null; }
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null) { return $this; }
    public function getTotalCount() { return $this->getSize(); }
    public function setTotalCount($totalCount) { return $this; }
    public function setItems(array $items = null) { return $this; }
}
