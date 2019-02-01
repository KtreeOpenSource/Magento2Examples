var config = {
    config: {
        'mixins': {
            'Magento_Checkout/js/model/checkout-data-resolver': {
                'Ktree_CustomerAddress/js/model/checkout-data-resolver-mixin': true
            },
            "Magento_Checkout/js/model/quote" : {
              "Ktree_CustomerAddress/js/model/quote-mixin": true
            }
        }
    }
};
