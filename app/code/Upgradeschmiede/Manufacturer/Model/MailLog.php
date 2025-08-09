<?php
namespace Upgradeschmiede\Manufacturer\Model;

use Magento\Framework\Model\AbstractModel;

class MailLog extends AbstractModel
{
    const CACHE_TAG = 'upgradeschmiede_maillog';

    protected $_cacheTag = 'upgradeschmiede_maillog';
    protected $_eventPrefix = 'upgradeschmiede_maillog';

    protected function _construct()
    {
        $this->_init('Upgradeschmiede\Manufacturer\Model\ResourceModel\MailLog');
    }
    
    public function getId()
    {
        return $this->getData('id');
    }
    
    public function setId($id)
    {
        return $this->setData('id', $id);
    }
    
    public function getSubject()
    {
        return $this->getData('subject');
    }
    
    public function setSubject($subject)
    {
        return $this->setData('subject', $subject);
    }
    
    public function getRecipient()
    {
        return $this->getData('recipient');
    }
    
    public function setRecipient($recipient)
    {
        return $this->setData('recipient', $recipient);
    }
    
    public function getSender()
    {
        return $this->getData('sender');
    }
    
    public function setSender($sender)
    {
        return $this->setData('sender', $sender);
    }
    
    public function getBody()
    {
        return $this->getData('body');
    }
    
    public function setBody($body)
    {
        return $this->setData('body', $body);
    }
    
    public function getStatus()
    {
        return $this->getData('status');
    }
    
    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }
    
    public function getSentAt()
    {
        return $this->getData('sent_at');
    }
    
    public function setSentAt($sentAt)
    {
        return $this->setData('sent_at', $sentAt);
    }
}