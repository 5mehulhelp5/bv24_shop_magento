<?php
namespace Upgradeschmiede\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action;
use Upgradeschmiede\Manufacturer\Model\ManufacturerFactory;
use Magento\Framework\Controller\Result\RedirectFactory;

class Save extends Action
{
    protected $manufacturerFactory;
    protected $resultRedirectFactory;

    public function __construct(
        Action\Context $context,
        ManufacturerFactory $manufacturerFactory,
        RedirectFactory $resultRedirectFactory
    ) {
        parent::__construct($context);
        $this->manufacturerFactory = $manufacturerFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            try {
                $manufacturer = $this->manufacturerFactory->create();
                if (isset($data['manufacturer_id'])) {
                    $manufacturer->load($data['manufacturer_id']);
                }
                $manufacturer->setData($data);
                $manufacturer->save();
                $this->messageManager->addSuccessMessage(__('Hersteller gespeichert.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');
        return $resultRedirect;
    }
}
