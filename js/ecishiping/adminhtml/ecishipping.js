var Ecishipping = new Class.create();

Ecishipping.prototype = {

    initialize:function (baserUrl) {
        this.baserUrl = baserUrl;
    },

    shippingGridRowClick:function (grid, event) {
        var trElement = Event.findElement(event, 'tr');
        var isInput = Event.element(event).tagName == 'INPUT';
        if (trElement) {
            var checkbox = Element.getElementsBySelector(trElement, 'input');
            if (checkbox[0]) {
                var checked = isInput ? checkbox[0].checked : !checkbox[0].checked;
                grid.setCheckboxChecked(checkbox[0], checked);
            }
        }
    },

    shippingItemGridCheckboxCheck:function (grid, element, checked) {
        var data = {};

        data['ecishipping[item]'] = element.value;
        data['ecishipping[item_status]'] = checked ? 1 : 0;
        data['ecishipping[delivery_date]'] = $('shipping_method_delivery_date').value;
        data['ecishipping[shipping_date]'] = $('shipping_method_shipping_date').value;
        /*data['ecishipping[tour]'] = $('shipping_method_tour').value;*/
        data['ecishipping[carrier_label]'] = $('shipping_method_carrier_label') ? $('shipping_method_carrier_label').value : '';
        data['ecishipping[method_label]'] = $('shipping_method_method_label') ? $('shipping_method_method_label').value : '';
        data['ecishipping[shipping_amount]'] = $('shipping_method_shipping_amount') ? $('shipping_method_shipping_amount').value : '';

        if ($('shipping_method_manually_price_checkbox')) {
            data['ecishipping[manually_price_checkbox]'] = $('shipping_method_manually_price_checkbox').checked ? '1' : '0';
        }

        order.loadArea(['shipping_method', 'totals'], true, data);
    },

    shippingMethodGridCheckboxCheck:function (grid, element, checked) {
        var data = {};

        data['ecishipping[method]'] = element.value;
        data['ecishipping[delivery_date]'] = $('shipping_method_delivery_date').value;
        data['ecishipping[shipping_date]'] = $('shipping_method_shipping_date').value;
        /*data['ecishipping[tour]'] = $('shipping_method_tour').value;*/

        order.loadArea(['shipping_method', 'totals'], true, data);
    },

    shippingApply:function () {
        var data = {};

        data['collect_shipping_rates'] = '1';
        data['order[shipping_method]'] = 'ecishippingadmin_ecishippingadmin';
        data['ecishipping[delivery_date]'] = $('shipping_method_delivery_date').value;
        data['ecishipping[shipping_date]'] = $('shipping_method_shipping_date').value;
        /*data['ecishipping[tour]'] = $('shipping_method_tour').value;*/
        data['ecishipping[carrier_label]'] = $('shipping_method_carrier_label') ? $('shipping_method_carrier_label').value : '';
        data['ecishipping[method_label]'] = $('shipping_method_method_label') ? $('shipping_method_method_label').value : '';
        data['ecishipping[shipping_amount]'] = $('shipping_method_shipping_amount') ? $('shipping_method_shipping_amount').value : '';

        if ($('shipping_method_manually_price_checkbox')) {
            data['ecishipping[manually_price_checkbox]'] = $('shipping_method_manually_price_checkbox').checked ? '1' : '0';
        }

        order.loadArea(['shipping_method', 'totals'], true, data);
    },

    shippingViewManual:function () {
        var data = {};
        data['ecishipping[manual]'] = 1;
        order.loadArea(['shipping_method'], true, data);
    },

    shippingViewDefault:function () {
        var data = {};
        data['ecishipping[manual]'] = 0;
        order.loadArea(['shipping_method'], true, data);
    },

    updateAfterShippingAddressChange:function () {
        var event = {};
        event.target = $('order-shipping_address_firstname');
        event.reload = true;
        order.changeAddressField(event);
    },

    manuallyPrice:function (checkbox) {
        if (checkbox.checked) {
            $('shipping_method_shipping_amount').disabled = false;
        } else {
            $('shipping_method_shipping_amount').disabled = true;
        }
    }

};

AdminOrder.addMethods({

    changeAddressField : function(event){
        var field = Event.element(event);
        var re = /[^\[]*\[([^\]]*)_address\]\[([^\]]*)\](\[(\d)\])?/;
        var matchRes = field.name.match(re);

        if (!matchRes) {
            return;
        }

        var type = matchRes[1];
        var name = matchRes[2];
        var data;

        if(this.isBillingField(field.id)){
            data = this.serializeData(this.billingAddressContainer)
        }
        else{
            data = this.serializeData(this.shippingAddressContainer)
        }
        data = data.toObject();

        if( (type == 'billing' && this.shippingAsBilling)
            || (type == 'shipping' && !this.shippingAsBilling) ) {
            data['reset_shipping'] = true;
        }

        data['order['+type+'_address][customer_address_id]'] = $('order-'+type+'_address_customer_address_id').value;

        if (data['reset_shipping']) {
            if(event.reload) {
                this.resetShippingMethod(data);
            } else {
                $$('#order-shipping_method .shipping-reload').first().show();
                $$('#order-shipping_method .shipping-reload-button').first().show();
                $$('#order-totals button').invoke('hide');
            }
        }
        else {
            this.saveData(data);
            if (name == 'country_id' || name == 'customer_address_id') {
                this.loadArea(['shipping_method', 'billing_method', 'totals', 'items'], true, data);
            }
            // added for reloading of default sender and default recipient for giftmessages
            //this.loadArea(['giftmessage'], true, data);
        }
    }
});