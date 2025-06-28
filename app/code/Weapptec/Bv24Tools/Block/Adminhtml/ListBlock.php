<?php
namespace Weapptec\Bv24Tools\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Framework\App\ResourceConnection;
use Magento\Store\Model\StoreManagerInterface;

class ListBlock extends Template
{
    protected $resource;
    protected $storeManager;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        ResourceConnection $resource,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->resource = $resource;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    public function getItems()
    {
        $connection = $this->resource->getConnection();
        $tableName = $this->resource->getTableName('weapptec_bv24tools_file');
        return $connection->fetchAll("SELECT * FROM {$tableName} ORDER BY created_at DESC");
    }

    public function getMediaUrl($fileName)
    {
        $mediaBaseUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaBaseUrl . 'bv24tools/' . ltrim($fileName, '/');
    }

    public function getFormKey()
    {
        return $this->getFormKeyBlock()->getFormKey();
    }

    public function getFormKeyBlock()
    {
        return $this->getLayout()->createBlock(\Magento\Framework\View\Element\FormKey::class);
    }
}