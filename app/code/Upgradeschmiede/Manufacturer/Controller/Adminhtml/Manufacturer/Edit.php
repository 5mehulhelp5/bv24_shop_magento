<?php
namespace Upgradeschmiede\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    protected $resultPageFactory;

    public function __construct(Action\Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Upgradeschmiede_Manufacturer::manufacturer');
        $resultPage->getConfig()->getTitle()->prepend(__('Hersteller bearbeiten'));
        return $resultPage;
    }
}
