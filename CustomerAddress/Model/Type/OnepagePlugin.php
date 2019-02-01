<?php
namespace Ktree\CustomerAddress\Model\Type;
use Ktree\CustomerAddress\Helper\Data;

class OnepagePlugin
{
  protected $_localHelper;
  public function __construct(Data $localhelper){
    $this->_localHelper = $localhelper;
  }


  public function afterInitCheckout(\Magento\Checkout\Model\Type\Onepage $checkout, $result)
  {
      $customerSession = $checkout->getCustomerSession();

      /*
       * want to load the correct customer information by assigning to address
       * instead of just loading from sales/quote_address
       */
      $customer = $customerSession->getCustomerDataObject();
      if ($customer) {

          $order = $this->_localHelper->getLastOrder();
          if($order && $order->getId()){
            $this->_localHelper ->saveCustomerAddressFromOrder($order);
          }
      }

      return $result;
  }
}
 ?>
