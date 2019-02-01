<?php
namespace Ktree\CustomerAddress\Model;

use Magento\Checkout\Model\Session as CheckoutSession;

class DefaultConfigProviderPlugin
{
    /**
     * @var CheckoutSession
     */
    private $checkoutSession;
    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    private $quoteRepository;

    public function __construct(
      CheckoutSession $checkoutSession,
      \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
  ) {
        $this->checkoutSession = $checkoutSession;
        $this->quoteRepository = $quoteRepository;
    }
    public function afterGetConfig(
      \Magento\Checkout\Model\DefaultConfigProvider $config,
  $output
  ) {
        $output= $this->getCustomQuoteData($output);
        return $output;
    }
    private function getCustomQuoteData($output)
    {
        if ($this->checkoutSession->getQuote()->getId()) {
            $quote = $this->quoteRepository->get($this->checkoutSession->getQuote()->getId());
            if (!$this->checkoutSession->getQuote()->isVirtual()) {
                if (isset($quote->getShippingAddress()->getData()['customer_address_id'])) {
                    $output['quoteData']['quote_shipping_address'] = $quote->getShippingAddress()->getData()['customer_address_id'];
                }
            }
            if (isset($quote->getBillingAddress()->getData()['customer_address_id'])) {
                $output['quoteData']['quote_billing_address'] = $quote->getBillingAddress()->getData()['customer_address_id'];
            }
            $output['quoteData']['quote_paymentmethod'] = $quote->getPayment()->getMethod();
        }
        return $output;
    }
}
