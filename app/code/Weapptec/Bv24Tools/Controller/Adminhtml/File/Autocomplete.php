<?php
namespace Weapptec\Bv24Tools\Controller\Adminhtml\File;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;

class Autocomplete extends Action
{
    protected $resultJsonFactory;
    protected $fileCollectionFactory;

    public function __construct(
        Action\Context $context,
        JsonFactory $resultJsonFactory,
        \Weapptec\Bv24Tools\Model\ResourceModel\File\CollectionFactory $fileCollectionFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->fileCollectionFactory = $fileCollectionFactory;
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $query = $this->getRequest()->getParam('query');
        $collection = $this->fileCollectionFactory->create();
        if ($query) {
            $collection->addFieldToFilter('title', ['like' => "%$query%"]);
        }
        $items = [];
        foreach ($collection as $file) {
            $items[] = [
                'value' => $file->getId(),
                'label' => $file->getTitle()
            ];
        }
        return $result->setData($items);
    }
}