<?php
namespace Upgradeschmiede\Manufacturer\Controller\Adminhtml\MailLog;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Upgradeschmiede_Manufacturer::maillog');
        $resultPage->getConfig()->getTitle()->prepend(__('Mail-Log'));
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Upgradeschmiede_Manufacturer::manufacturer');
    }
}