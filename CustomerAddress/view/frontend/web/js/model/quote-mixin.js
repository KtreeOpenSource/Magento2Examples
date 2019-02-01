define([
    'ko',
    'underscore'
], function (ko, _) {
    'use strict';
  
    return function (quote) {

      /**
       * @return {quote shipping address_id or null}
       */
      var quoteShippingAddress = function () {

          return (window.checkoutConfig.quoteData['quote_shipping_address']);
      };
      /**
       * @return {quote billing address_id or null}
       */
      var quoteBillingAddress = function () {
          return (window.checkoutConfig.quoteData['quote_billing_address']);
      };
      /**
       * @return {previous order payment method or null}
       */
      var quoteOrderPaymentMethod = function () {
          return (window.checkoutConfig.quoteData['quote_paymentmethod']);
      };
      quote.quoteShippingAddress = quoteShippingAddress;
      quote.quoteBillingAddress = quoteBillingAddress;
      quote.quoteOrderPaymentMethod = quoteOrderPaymentMethod;
      return quote;
    };
  });
