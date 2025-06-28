<?php
namespace Weapptec\Bv24Tools\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;

class Delete extends Action
{
    protected $resultJsonFactory;
    protected $fileModel;

    public function __construct(
        Action\Context $context,
        JsonFactory $resultJsonFactory,
        \Weapptec\Bv24Tools\Model\File $fileModel
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->fileModel = $fileModel;
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $id = $this->getRequest()->getParam('id');
        try {
            if ($id) {
                $model = $this->fileModel->load($id);
                if ($model->getId()) {
                    $model->delete();
                    return $result->setData(['success' => true]);
                }
            }
        } catch (\Exception $e) {}
        return $result->setData(['success' => false]);
    }
}