<?php
namespace Ktree\CustomerAddress\Helper;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Checkout\Model\Session;
use Magento\Customer\Api\AddressRepositoryInterface;
class Data extends AbstractHelper{
  protected $_ordersFactory;
  protected $_session;
  protected $_checkoutSession;
  /**
   * @var AddressRepositoryInterface
   */
  protected $addressRepository;
  protected $_lastOrder ;

  public function __construct(\Magento\Customer\Model\Session $session,
  Session $checkoutSession,
  \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $ordersFactory,
    AddressRepositoryInterface $addressRepository
  )
  {
    $this->_session = $session;
    $this->_ordersFactory = $ordersFactory;
    $this->_checkoutSession = $checkoutSession;
    $this->addressRepository = $addressRepository;
  }
  public function saveCustomerAddressFromOrder($order)
    {
        if ($this->_checkoutSession->getQuote() && $order->getId()) {
          $shippingAddressObj = $billingAddressObj = $order->getBillingAddress()->getData();
          $paymentDetails = $order->getPayment()->getData();

          if(!$order->getIsVirtual()){
            $shippingAddressObj = $order->getShippingAddress()->getData();
          }
          $quote = $this->_checkoutSession->getQuote();
          $quote->getBillingAddress()->addData($billingAddressObj);
          $quote->getShippingAddress()->addData($shippingAddressObj);
          $quote->getPayment()->addData($paymentDetails);
          $quote->save();
          return;
        }
    }
    public function getLastOrder()
    {
      if(!$this->_lastOrder){
      $customerId = $this->_session->getCustomer()->getId();
        $collection = $this->_ordersFactory->create()->addFieldToFilter(
            'customer_id',
            $customerId
        )->setOrder(
            'created_at',
            'desc'
        )->setPageSize(
            1
        )->load();
        foreach ($collection as $order) {
            $this->_lastOrder = $order;
            break;
        }
      }
        return $this->_lastOrder;
    }
}
 ?>
