<?php
namespace Upgradeschmiede\Manufacturer\Model;

use Magento\Framework\Model\AbstractModel;

class Manufacturer extends AbstractModel
{
    const CACHE_TAG = 'upgradeschmiede_manufacturer';

    protected $_cacheTag = 'upgradeschmiede_manufacturer';
    protected $_eventPrefix = 'upgradeschmiede_manufacturer';

    protected function _construct()
    {
        $this->_init('Upgradeschmiede\Manufacturer\Model\ResourceModel\Manufacturer');
    }
    
    public function getManufacturerId()
    {
        return $this->getData('manufacturer_id');
    }
    
    public function setManufacturerId($id)
    {
        return $this->setData('manufacturer_id', $id);
    }
    
    public function getName()
    {
        return $this->getData('name');
    }
    
    public function setName($name)
    {
        return $this->setData('name', $name);
    }
    
    public function getDescription()
    {
        return $this->getData('description');
    }
    
    public function setDescription($description)
    {
        return $this->setData('description', $description);
    }
    
    public function getUrl()
    {
        return $this->getData('url');
    }
    
    public function setUrl($url)
    {
        return $this->setData('url', $url);
    }
    
    public function getLogo()
    {
        return $this->getData('logo');
    }
    
    public function setLogo($logo)
    {
        return $this->setData('logo', $logo);
    }
    
    public function getAnschrift()
    {
        return $this->getData('anschrift');
    }
    
    public function setAnschrift($anschrift)
    {
        return $this->setData('anschrift', $anschrift);
    }
    
    public function getBestellMail()
    {
        return $this->getData('bestell_mail');
    }
    
    public function setBestellMail($bestellMail)
    {
        return $this->setData('bestell_mail', $bestellMail);
    }
    
    public function getMusterMail()
    {
        return $this->getData('muster_mail');
    }
    
    public function setMusterMail($musterMail)
    {
        return $this->setData('muster_mail', $musterMail);
    }
}