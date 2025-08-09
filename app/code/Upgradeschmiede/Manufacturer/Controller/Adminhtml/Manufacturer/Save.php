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
        DataPersistorInterface $dataPersistor
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
            
            if ($id) {
                // Bearbeitung eines bestehenden Herstellers
                $model = $this->manufacturerFactory->create()->load($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('Dieser Hersteller existiert nicht mehr.'));
                    return $resultRedirect->setPath('*/*/');
                }
            } else {
                // Neuer Hersteller
                $model = $this->manufacturerFactory->create();
            }

            // Entferne form_key aus den Daten
            if (isset($data['form_key'])) {
                unset($data['form_key']);
            }

            $model->setData($data);

            try {
                $model->save();
                
                if ($id) {
                    $this->messageManager->addSuccessMessage(__('Hersteller wurde erfolgreich aktualisiert.'));
                } else {
                    $this->messageManager->addSuccessMessage(__('Neuer Hersteller wurde erfolgreich erstellt.'));
                }
                
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
            
            if ($id) {
                return $resultRedirect->setPath('*/*/edit', ['manufacturer_id' => $id]);
            } else {
                return $resultRedirect->setPath('*/*/new');
            }
        }
        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Upgradeschmiede_Manufacturer::manufacturer_manage');
    }
}