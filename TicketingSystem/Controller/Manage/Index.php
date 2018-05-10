<?php

namespace Ktree\TicketingSystem\Controller\Manage;

class Index extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get('\Magento\Customer\Model\Session');
        $urlInterface = $objectManager->get('\Magento\Framework\UrlInterface');
        if (!$customerSession->isLoggedIn()) {
            $customerSession->setAfterAuthUrl($urlInterface->getCurrentUrl());
            $customerSession->authenticate();
        }
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
