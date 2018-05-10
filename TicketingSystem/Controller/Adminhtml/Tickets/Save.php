<?php

namespace Ktree\TicketingSystem\Controller\Adminhtml\Tickets;

class Save extends \Magento\Backend\App\Action
{
    protected $_ticketsFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Ktree\TicketingSystem\Model\TicketsFactory $ticketsFactory
    ) {
        $this->_ticketsFactory = $ticketsFactory;
        parent::__construct($context);
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('ticketingsystem/tickets/add');
            return;
        }
        try {
            $rowData =  $this->_ticketsFactory->create()->load($data['id']);
            if (!$rowData->getId()) {
                $this->messageManager->addError(__('row data no longer exist.'));
                $this->_redirect('ticketingsystem/tickets');
                return;
            }
            $rowData->setData($data);
            $rowData->save();
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('ticketingsystem/tickets');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ktree_TicketingSystem::save');
    }
}
