define([
  'Magento_Customer/js/model/address-list',
  'Magento_Checkout/js/model/quote',
  'Magento_Checkout/js/checkout-data',
  'Magento_Checkout/js/action/create-shipping-address',
  'Magento_Checkout/js/action/select-shipping-address',
  'Magento_Checkout/js/action/select-shipping-method',
  'Magento_Checkout/js/model/payment-service',
  'Magento_Checkout/js/action/select-payment-method',
  'Magento_Checkout/js/model/address-converter',
  'Magento_Checkout/js/action/select-billing-address',
  'Magento_Checkout/js/action/create-billing-address',
  'underscore'],
function (
  addressList,
  quote,
  checkoutData,
  createShippingAddress,
  selectShippingAddress,
  selectShippingMethodAction,
  paymentService,
  selectPaymentMethodAction,
  addressConverter,
  selectBillingAddress,
  createBillingAddress,
  _){
    'use strict';

    return function (checkoutDataResolver) {
      //  return checkoutDataResolver.extend({

          var applyShippingAddress =  function(isEstimatedAddress){
              var address,
                  shippingAddress,
                  isConvertAddress,
                  addressData,
                  isShippingAddressInitialized;

              if (addressList().length === 0) {
                  address = addressConverter.formAddressDataToQuoteAddress(
                      checkoutData.getShippingAddressFromData()
                  );
                  selectShippingAddress(address);
              }
              shippingAddress = quote.shippingAddress();
              isConvertAddress = isEstimatedAddress || false;

              if (!shippingAddress) {
                  isShippingAddressInitialized = addressList.some(function (addressFromList) {
                      if (checkoutData.getSelectedShippingAddress() == addressFromList.getKey()) { //eslint-disable-line
                          addressData = isConvertAddress ?
                              addressConverter.addressToEstimationAddress(addressFromList)
                              : addressFromList;
                          selectShippingAddress(addressData);

                          return true;
                      }

                      return false;
                  });

                  if (!isShippingAddressInitialized) {
                      isShippingAddressInitialized = addressList.some(function (addrs) {
                        /*edit shipping*/
                        if (quote.quoteShippingAddress()){
                          if(addrs.customerAddressId == quote.quoteShippingAddress()) {
                              addressData = isConvertAddress ?
                                  addressConverter.addressToEstimationAddress(addrs)
                                  : addrs;
                              selectShippingAddress(addressData);

                              return true;
                          }
                        }
                        else if(addrs.isDefaultShipping()){
                           addressData = isConvertAddress ?
                              addressConverter.addressToEstimationAddress(addrs)
                              : addrs;
                            selectShippingAddress(addressData);

                             return true;
                           }
                      });
                  }

                  if (!isShippingAddressInitialized && addressList().length === 1) {
                      addressData = isConvertAddress ?
                          addressConverter.addressToEstimationAddress(addressList()[0])
                          : addressList()[0];
                      selectShippingAddress(addressData);
                  }
              }
          };
        var resolveBillingAddress = function(){
          var selectedBillingAddress = checkoutData.getSelectedBillingAddress(),
              newCustomerBillingAddressData = checkoutData.getNewCustomerBillingAddress();

          if (selectedBillingAddress) {
              if (selectedBillingAddress == 'new-customer-address' && newCustomerBillingAddressData) { //eslint-disable-line
                  selectBillingAddress(createBillingAddress(newCustomerBillingAddressData));
              } else {
                  addressList.some(function (address) {
                      if (selectedBillingAddress == address.getKey()) { //eslint-disable-line eqeqeq
                          selectBillingAddress(address);
                      }
                  });
              }
          } else {
            /*assign billing address*/
            if(quote.quoteBillingAddress()){
              addressList.some(function (addrs) {
                if (addrs.customerAddressId == quote.quoteBillingAddress()) {
                      selectBillingAddress(addrs);
                  }
              });
            }
            this.applyBillingAddress();
          }
        };
        var resolvePaymentMethod = function(){
          var availablePaymentMethods = paymentService.getAvailablePaymentMethods(),
              selectedPaymentMethod = checkoutData.getSelectedPaymentMethod();

          if (selectedPaymentMethod) {
              availablePaymentMethods.some(function (payment) {
                  if (payment.method == selectedPaymentMethod) { //eslint-disable-line eqeqeq
                      selectPaymentMethodAction(payment);
                  }
              });
          }
          else{
              if(quote.quoteOrderPaymentMethod()){
                availablePaymentMethods.some(function (payment) {
                  if (payment.method == quote.quoteOrderPaymentMethod()) { //previous order dat
                      selectPaymentMethodAction(payment);
                  }
                });
            }
          }
        };
      checkoutDataResolver.applyShippingAddress = applyShippingAddress;
      checkoutDataResolver.resolveBillingAddress = resolveBillingAddress;
      checkoutDataResolver.resolvePaymentMethod = resolvePaymentMethod;
        //});
        return checkoutDataResolver;
    }
});
