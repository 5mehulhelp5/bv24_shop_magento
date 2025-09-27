<?php
namespace Upgradeschmiede\OrderItemStatus\Block\Adminhtml\Order\View;

use Magento\Sales\Block\Adminhtml\Order\View\Items as OriginalItems;

class Items extends OriginalItems
{
    /**
     * Optional: eigenes Format, nutzt die Parent-getOrder()
     */
    public function formatPrice($price)
    {
        $order = parent::getOrder();
        return $order ? $order->formatPrice($price) : number_format((float)$price, 2);
    }
}
