<?php
namespace Ktree\CustomerAddress\Observer;

use Ktree\CustomerAddress\Helper\Data;
use \Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session;
use \Magento\Framework\App\Response\Http;
use \Magento\Framework\Event\Observer;
use Magento\Framework\App\ResponseFactory;
use Magento\Framework\UrlInterface;

class CheckoutPreDispatch implements ObserverInterface{
  protected $_checkoutSession;
  public function __construct(
    Session $session,
    Data $helperData,
    Http $http,
    ResponseFactory $responseFactory,
    \Magento\Checkout\Model\Session $checkoutSession,
    UrlInterface $url){
        $this->session = $session;
        $this->responseFactory = $responseFactory;
        $this->helperData = $helperData;
        $this->url = $url;
        $this->http = $http;
        $this->_checkoutSession = $checkoutSession;
  }
  public function execute(Observer $observer){
      $order = $this->helperData->getLastOrder();
      if($order && $order->getId()){
        $this->helperData->saveCustomerAddressFromOrder($order);
      }
  }
}

 ?>
