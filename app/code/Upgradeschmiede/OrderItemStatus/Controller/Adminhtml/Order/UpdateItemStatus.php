<?php
namespace Upgradeschmiede\OrderItemStatus\Controller\Adminhtml\Order;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Sales\Model\OrderFactory;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class UpdateItemStatus extends Action
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var OrderFactory
     */
    protected $orderFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param OrderFactory $orderFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        OrderFactory $orderFactory,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->orderFactory = $orderFactory;
        $this->logger = $logger;
    }

    /**
     * Update order item status
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        
        try {
            $itemId = (int) $this->getRequest()->getParam('item_id');
            $status = $this->getRequest()->getParam('status');
            
            if (!$itemId || !$status) {
                throw new LocalizedException(__('Invalid parameters provided.'));
            }
            
            // Load order item through resource model
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $orderItemResource = $objectManager->create(\Magento\Sales\Model\ResourceModel\Order\Item::class);
            $orderItem = $objectManager->create(\Magento\Sales\Model\Order\Item::class);
            
            $orderItemResource->load($orderItem, $itemId);
            
            if (!$orderItem->getId()) {
                throw new LocalizedException(__('Order item not found.'));
            }
            
            $orderItem->setCustomStatus($status);
            $orderItemResource->save($orderItem);
            
            $result->setData([
                'success' => true,
                'message' => __('Order item status updated successfully.')
            ]);
            
        } catch (\Exception $e) {
            $this->logger->error('Error updating order item status: ' . $e->getMessage());
            $result->setData([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        
        return $result;
    }

    /**
     * Check if user has permission to access this controller
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magento_Sales::sales_order');
    }
}