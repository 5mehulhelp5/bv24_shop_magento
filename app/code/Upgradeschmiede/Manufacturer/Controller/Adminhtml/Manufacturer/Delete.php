<?php
namespace Upgradeschmiede\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Upgradeschmiede\Manufacturer\Model\ManufacturerFactory;

class Delete extends Action
{
    protected $manufacturerFactory;

    public function __construct(
        Context $context,
        ManufacturerFactory $manufacturerFactory
    ) {
        parent::__construct($context);
        $this->manufacturerFactory = $manufacturerFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('manufacturer_id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $model = $this->manufacturerFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('Der Hersteller wurde gelöscht.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['manufacturer_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('Hersteller konnte nicht gefunden werden.'));
        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Upgradeschmiede_Manufacturer::manufacturer');
    }
}