<?php
namespace Upgradeschmiede\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Upgradeschmiede\Manufacturer\Model\ManufacturerFactory;

class Edit extends Action
{
    protected $resultPageFactory;
    protected $coreRegistry;
    protected $manufacturerFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        ManufacturerFactory $manufacturerFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->manufacturerFactory = $manufacturerFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('manufacturer_id');
        $model = $this->manufacturerFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('Dieser Hersteller existiert nicht mehr.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->coreRegistry->register('manufacturer', $model);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Upgradeschmiede_Manufacturer::manufacturer');
        $resultPage->getConfig()->getTitle()->prepend(
            $model->getId() ? $model->getName() : __('Neuer Hersteller')
        );

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Upgradeschmiede_Manufacturer::manufacturer');
    }
}