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

    public function getAggregations() { return $this->aggregations; }
    public function setAggregations($aggregations) { $this->aggregations = $aggregations; }
    public function getSearchCriteria() { return null; }
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null) { return $this; }
    public function getTotalCount() { return $this->getSize(); }
    public function setTotalCount($totalCount) { return $this; }
    public function setItems(array $items = null) { return $this; }

    public function getItems()
    {
        if (!$this->isLoaded()) {
            $this->load();
        }
        return parent::getItems();
    }
}
