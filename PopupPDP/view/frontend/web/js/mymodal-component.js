  require(
        [
            'jquery',
            'Magento_Ui/js/modal/modal'
        ],
        function(
            $,
            modal
        ) {
            var options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                buttons: [{
                    text: $.mage.__('Continue'),
                    class: 'mymodal1',
                    click: function () {
                        this.closeModal();
                    }
                }]
            };

            var popup = modal(options, $('#myModal'));
            $("#popupButton").on('click',function(){
                $("#myModal").modal("openModal");
            });
        });
