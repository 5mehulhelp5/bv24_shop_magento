<?php
namespace Weapptec\Bv24Tools\Controller\Adminhtml\File;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Weapptec\Bv24Tools\Model\FileFactory;
use Magento\Framework\App\ResourceConnection;

class Delete extends Action
{
    protected $fileFactory;
    protected $resource;

    public function __construct(
        Action\Context $context,
        FileFactory $fileFactory,
        ResourceConnection $resource
    ) {
        parent::__construct($context);
        $this->fileFactory = $fileFactory;
        $this->resource = $resource;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $connection = $this->resource->getConnection();
                $table = $this->resource->getTableName('weapptec_bv24tools_file');
                $connection->delete($table, ['id = ?' => $id]);
                $this->messageManager->addSuccessMessage(__('Datei erfolgreich gelöscht.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Fehler: %1', $e->getMessage()));
            }
        }
        return $this->_redirect('*/*/index');
    }
}
