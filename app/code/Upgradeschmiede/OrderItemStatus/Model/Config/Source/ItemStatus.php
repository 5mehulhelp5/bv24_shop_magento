<?php
namespace Upgradeschmiede\OrderItemStatus\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class ItemStatus implements ArrayInterface
{
    const STATUS_OPEN = 'offen';
    const STATUS_AUTO_ORDER = 'automatische_bestellung';
    const STATUS_COMPLETED = 'bestellung_abgeschlossen';

    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::STATUS_OPEN, 'label' => __('Offen')],
            ['value' => self::STATUS_AUTO_ORDER, 'label' => __('Automatische Bestellung')],
            ['value' => self::STATUS_COMPLETED, 'label' => __('Bestellung abgeschlossen')]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::STATUS_OPEN => __('Offen'),
            self::STATUS_AUTO_ORDER => __('Automatische Bestellung'),
            self::STATUS_COMPLETED => __('Bestellung abgeschlossen')
        ];
    }
}