<?php

namespace Ktree\TicketingSystem\Controller\Create;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ObjectManager;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_ticketsFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Ktree\TicketingSystem\Model\TicketsFactory $ticketsFactory
    ) {
        $this->_ticketsFactory = $ticketsFactory;
        return parent::__construct($context);
    }

    /**
     * Booking action
     *
     * @return void
     */
    public function execute()
    {

        /* Checking customer is logged or not -  if not logged in redirecting to login page */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get('\Magento\Customer\Model\Session');
        $urlInterface = $objectManager->get('\Magento\Framework\UrlInterface');
        if (!$customerSession->isLoggedIn()) {
            $customerSession->setAfterAuthUrl($urlInterface->getCurrentUrl());
            $customerSession->authenticate();
        }


        $postData = (array) $this->getRequest()->getPost();
        if (!empty($postData)) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $session = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Customer\Model\Session');

            $model = $this->_ticketsFactory->create();
            $ticketCollection = $model->getCollection()->setOrder('id', 'DESC')->setPageSize(1)->getFirstItem();
            $ticketId = ($ticketCollection->getData()) ? filter_var($ticketCollection->getTicketId(), FILTER_SANITIZE_NUMBER_INT)+1:1000;
            // Setting data to model to save
            $model->setData($postData);
            $model->setTicketId("#".$ticketId);
            $model->setCustmerId($session->getCustomer()->getId());
            $model->setstatus("1");
            try {
                $model->save();
                $this->messageManager->addSuccessMessage('Ticket raise successfully!');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addSuccessMessage('Opps! Something went wrong. Please try again later.');
                //echo $e->message;
            }
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl('/ticketingsystem/manage');

            return $resultRedirect;
        }
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
