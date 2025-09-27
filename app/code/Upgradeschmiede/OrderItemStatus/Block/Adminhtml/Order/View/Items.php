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
	
	/**
	public function get_itemstatus()
	{
		$statusOptions = [
			'offen' => __('Offen'),
			'automatische_bestellung' => __('Automatische Bestellung'),
			'automatische_bestellung_done' => __('Automatische Bestellung abgeschlossen'),
			'dpd_versand' => __('Versand per DPD'),
			'orhan_bringts' => __('Orhan bringts.'),
			];
		return $statusOptions;
	}
	**/
	
    public function get_itemstatus(): array
    {
        // Fallback-Defaults
        $defaults = [
            'offen'                        => __('Offen'),
            'automatische_bestellung'      => __('Automatische Bestellung'),
            'automatische_bestellung_done' => __('Automatische Bestellung abgeschlossen'),
            'dpd_versand'                  => __('Versand per DPD'),
            'orhan_bringts'                => __('Orhan bringts.'),
        ];

        try {
            /** @var \Magento\Framework\App\ResourceConnection $resource */
            $resource = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Framework\App\ResourceConnection::class);

            $conn  = $resource->getConnection();
            $table = $resource->getTableName('upgradeschmiede_order_item_status'); // <— dein Tabellenname

            // Tabelle vorhanden?
            if (!$conn->isTableExists($table)) {
                return $defaults;
            }

            // code => label als Key/Value holen
            $select = $conn->select()
                ->from($table, ['code','label'])
                ->where('is_active = ?', 1)
                ->order(['sort_order ASC', 'status_id ASC']);

            $pairs = $conn->fetchPairs($select); // ['code' => 'Label', ...]

            if (!$pairs) {
                return $defaults;
            }

            // In __()-Strings verwandeln (Übersetzbar)
            $out = [];
            foreach ($pairs as $code => $label) {
                if ($code === '' || $code === null) { continue; }
                $out[$code] = __($label ?: $code);
            }

            return $out ?: $defaults;

        } catch (\Throwable $e) {
            // Optional: leise loggen
            // \Magento\Framework\App\ObjectManager::getInstance()
            //     ->get(\Psr\Log\LoggerInterface::class)
            //     ->error('[OrderItemStatus] get_itemstatus failed: ' . $e->getMessage());
            return $defaults;
        }
    }	

}
