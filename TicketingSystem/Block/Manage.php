<?php

namespace Ktree\TicketingSystem\Block;

class Manage extends \Magento\Framework\View\Element\Template
{
    protected $_ticketsFactory;

    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $_currentCustomer;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Ktree\TicketingSystem\Model\TicketsFactory $ticketsFactory,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->pageConfig->getTitle()->set(__('Manage Tickets'));
        $this->_ticketsFactory = $ticketsFactory;
        $this->_currentCustomer = $currentCustomer;
        $this->setCollection($this->_ticketsFactory->create()->getCollection());
    }



    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getCollection()) {
            // create pager block for collection
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'tickets.manage.pager'
            );
            $pager->setAvailableLimit(array(5 => 5));//set limit - how many records we want per page
            // setting ticket collection to pager based on customer id
            $pager->setCollection($this->getCollection()->setOrder('ticket_id', 'DESC')->addFieldToFilter('custmer_id', array('eq'=>$this->_currentCustomer->getCustomer()->getId())));
            $this->setChild('pager', $pager);// set pager block in layout
        }
        return $this;
    }


    /**
     * @return string
     */
    // method for get pager html
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
