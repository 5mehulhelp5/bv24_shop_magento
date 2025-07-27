<?php
namespace Upgradeschmiede\Manufacturer\Block\Adminhtml\Manufacturer\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        $data = [];
        if ($this->getManufacturerId()) {
            $data = [
                'label' => __('Löschen'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Sind Sie sicher, dass Sie diesen Hersteller löschen möchten?'
                ) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['manufacturer_id' => $this->getManufacturerId()]);
    }
}