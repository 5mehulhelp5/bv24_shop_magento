<?php
namespace Weapptec\Bv24Tools\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\App\Filesystem\DirectoryList; // ✅ DIESE ZEILE IST ENTSCHEIDEND!
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\ResourceConnection;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Weapptec_Bv24Tools::main';

    protected $uploaderFactory;
    protected $filesystem;
    protected $resource;
    protected $resultRedirectFactory;

    public function __construct(
        Context $context,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        ResourceConnection $resource,
        RedirectFactory $resultRedirectFactory
    ) {
        parent::__construct($context);
        $this->uploaderFactory = $uploaderFactory;
        $this->filesystem = $filesystem;
        $this->resource = $resource;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    public function execute()
    {
        $title = $this->getRequest()->getParam('title');
        $description = $this->getRequest()->getParam('description');

        try {
            $uploader = $this->uploaderFactory->create(['fileId' => 'pdf_file']);
            $uploader->setAllowedExtensions(['pdf']);
            $uploader->setAllowRenameFiles(true);

            $mediaDir = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('bv24tools');
            $result = $uploader->save($mediaDir);

            if (!$result) {
                throw new \Exception('Datei konnte nicht gespeichert werden.');
            }

            $fileName = $result['file'];

            // Speichern in der Datenbank
            $connection = $this->resource->getConnection();
            $connection->insert('weapptec_bv24tools_file', [
                'title' => $title,
                'description' => $description,
                'file_name' => $fileName,
                'created_at' => (new \DateTime())->format('Y-m-d H:i:s')
            ]);

            $this->messageManager->addSuccessMessage(__('Eintrag wurde erfolgreich gespeichert.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Fehler beim Speichern: %1', $e->getMessage()));
        }

        return $this->resultRedirectFactory->create()->setPath('bv24tools/index/index');
    }
}