<?php
namespace Upgradeschmiede\OrderItemStatus\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class OrderItemSaveAfter implements ObserverInterface
{
    /**
     * Set default status for new order items
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $orderItem = $observer->getEvent()->getItem();
        
        if (!$orderItem->getCustomStatus()) {
            $orderItem->setCustomStatus('offen');
        }
    }
}