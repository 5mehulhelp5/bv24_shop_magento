<?php
namespace Upgradeschmiede\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Upgradeschmiede\Manufacturer\Model\ManufacturerFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
    protected $manufacturerFactory;
    protected $dataPersistor;
	
    public function __construct(
        Context $context,
        ManufacturerFactory $manufacturerFactory,
        DataPersistorInterface $dataPersistor,
    ) {
        parent::__construct($context);
        $this->manufacturerFactory = $manufacturerFactory;
        $this->dataPersistor = $dataPersistor;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $id = $this->getRequest()->getParam('manufacturer_id');
            $model = $this->manufacturerFactory->create()->load($id);

            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('Dieser Hersteller existiert nicht mehr.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
			    $model->save();
               	$this->messageManager->addSuccessMessage(__('Hersteller wurde erfolgreich gespeichert.'));
                $this->dataPersistor->clear('manufacturer_manufacturer');				
				
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['manufacturer_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Beim Speichern ist ein Fehler aufgetreten.'));
            }

            $this->dataPersistor->set('manufacturer_manufacturer', $data);
            return $resultRedirect->setPath('*/*/edit', ['manufacturer_id' => $this->getRequest()->getParam('manufacturer_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Upgradeschmiede_Manufacturer::manufacturer_manage');
    }
}