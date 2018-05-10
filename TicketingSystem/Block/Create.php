<?php

namespace Ktree\TicketingSystem\Block;

class Create extends \Magento\Framework\View\Element\Template
{


    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->pageConfig->getTitle()->set(__('Create Ticket'));
    }


    /**
     * Get form action URL for POST booking request
     *
     * @return string
     */
    public function getFormAction()
    {
        // companymodule is given in routes.xml
        // controller_name is folder name inside controller folder
        // action is php file name inside above controller_name folder
        return '/ticketingsystem/create/index';
        // here controller_name is index, action is booking
    }

    public function getPriorities($val = '')
    {
        $priorities = array(0 => 'Urgent',1 => 'High',2 => 'Medium',3 => 'Low');
        return ($val != '') ?  $priorities[$val] : $priorities;
    }

    public function getCategories($val = '')
    {
        $categories =  array(1 => 'Order',2 => 'Payment',3 => 'Others');
        return ($val != '') ? $categories[$val] : $categories;
    }
    public function getStatus($val = '')
    {
        $status =  array(1 => 'New',2 => 'Open',3 => 'Pending',4 => 'Closed');
        return ($val != '') ? $status[$val] : $status;
    }
}
