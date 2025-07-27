<?php
namespace Upgradeschmiede\Manufacturer\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class ManufacturerActions extends Column
{
    const URL_PATH_EDIT = 'manufacturer/manufacturer/edit';
    const URL_PATH_DELETE = 'manufacturer/manufacturer/delete';

    protected $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['manufacturer_id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'manufacturer_id' => $item['manufacturer_id']
                                ]
                            ),
                            'label' => __('Bearbeiten')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'manufacturer_id' => $item['manufacturer_id']
                                ]
                            ),
                            'label' => __('Löschen'),
                            'confirm' => [
                                'title' => __('Hersteller löschen'),
                                'message' => __('Sind Sie sicher, dass Sie diesen Hersteller löschen möchten?')
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}