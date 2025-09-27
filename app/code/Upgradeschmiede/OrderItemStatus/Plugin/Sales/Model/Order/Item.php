<?php
namespace Upgradeschmiede\OrderItemStatus\Plugin\Sales\Model\Order;

use Magento\Sales\Model\Order\Item as OrderItem;

class Item
{
    /**
     * After load plugin to add custom status
     *
     * @param OrderItem $subject
     * @param OrderItem $result
     * @return OrderItem
     */
    public function afterLoad(OrderItem $subject, $result)
    {
        if (!$result->getCustomStatus()) {
            $result->setCustomStatus('offen');
        }
        return $result;
    }

    /**
     * Before save plugin
     *
     * @param OrderItem $subject
     * @return array
     */
    public function beforeSave(OrderItem $subject)
    {
        if (!$subject->getCustomStatus()) {
            $subject->setCustomStatus('offen');
        }
        return [];
    }
}