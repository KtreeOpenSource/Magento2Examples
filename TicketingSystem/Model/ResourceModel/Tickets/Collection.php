<?php
namespace Ktree\TicketingSystem\Model\ResourceModel\Tickets;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'ktree_ticketingsystem_ticket_collection';
    protected $_eventObject = 'ticket_collection';

    /**
     * Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Ktree\TicketingSystem\Model\Tickets', 'Ktree\TicketingSystem\Model\ResourceModel\Tickets');
    }
}
