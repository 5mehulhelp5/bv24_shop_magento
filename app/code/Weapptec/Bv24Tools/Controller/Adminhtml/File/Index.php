<?php
namespace Weapptec\Bv24Tools\Controller\Adminhtml\File;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Weapptec_Bv24Tools::main';

    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Weapptec_Bv24Tools::main');
        $resultPage->getConfig()->getTitle()->prepend(__('PDF Uploads'));
        return $resultPage;
    }
}
