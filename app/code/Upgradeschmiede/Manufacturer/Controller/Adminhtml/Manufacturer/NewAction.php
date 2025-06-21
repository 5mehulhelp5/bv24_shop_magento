<?php
namespace Upgradeschmiede\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\RedirectFactory;

class NewAction extends Action
{
    protected $resultRedirectFactory;

    public function __construct(Action\Context $context, RedirectFactory $resultRedirectFactory)
    {
        parent::__construct($context);
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/edit');
        return $resultRedirect;
    }
}
