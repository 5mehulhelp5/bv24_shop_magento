<?php
namespace Upgradeschmiede\OrderItemStatus\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Upgradeschmiede\OrderItemStatus\Model\Config\Source\ItemStatus as ItemStatusSource;

class ItemStatus extends Column
{
    /**
     * @var ItemStatusSource
     */
    protected $itemStatusSource;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param ItemStatusSource $itemStatusSource
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        ItemStatusSource $itemStatusSource,
        array $components = [],
        array $data = []
    ) {
        $this->itemStatusSource = $itemStatusSource;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $statusOptions = $this->itemStatusSource->toArray();
            
            foreach ($dataSource['data']['items'] as & $item) {
                $status = $item['custom_status'] ?? 'offen';
                $item['custom_status'] = $statusOptions[$status] ?? __('Offen');
            }
        }

        return $dataSource;
    }
}