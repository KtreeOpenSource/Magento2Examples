<?php
namespace Ktree\TicketingSystem\Model;

class Tickets extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'ktree_ticketingsystem_ticket';

    protected $_cacheTag = 'ktree_ticketingsystem_ticket';

    protected $_eventPrefix = 'ktree_ticketingsystem_ticket';

    protected function _construct()
    {
        $this->_init('Ktree\TicketingSystem\Model\ResourceModel\Tickets');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
