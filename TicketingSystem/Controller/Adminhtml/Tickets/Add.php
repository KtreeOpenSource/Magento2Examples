<?php
namespace Ktree\TicketingSystem\Controller\Adminhtml\Tickets;

use Magento\Framework\Controller\ResultFactory;

class Add extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    protected $_ticketsFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Ktree\TicketingSystem\Model\TicketsFactory $ticketsFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->_ticketsFactory = $ticketsFactory;
    }

    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($rowId) {
            $rowData = $this->_ticketsFactory->create()->load($rowId);

            if (!$rowData->getId()) {
                $this->messageManager->addError(__('row data no longer exist.'));
                $this->_redirect('ticketingsystem/tickets');
                return;
            }
        }

        $this->coreRegistry->register('row_data', $rowData);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $rowId ? __('Edit Row Data ') : __('Add Row Data');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ktree_TicketingSystem::add');
    }
}
