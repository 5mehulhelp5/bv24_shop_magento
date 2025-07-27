<?php
namespace Upgradeschmiede\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Upgradeschmiede\Manufacturer\Model\ManufacturerFactory;

class Save extends Action
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
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $model = $this->manufacturerFactory->create();
            $id = $this->getRequest()->getParam('manufacturer_id');

            if ($id) {
                $model->load($id);
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('Hersteller wurde erfolgreich gespeichert.'));
                $this->_session->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['manufacturer_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Beim Speichern ist ein Fehler aufgetreten.'));
            }

            $this->_session->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['manufacturer_id' => $this->getRequest()->getParam('manufacturer_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Upgradeschmiede_Manufacturer::manufacturer');
    }
}