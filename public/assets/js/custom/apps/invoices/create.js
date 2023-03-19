
"use strict";

// Class definition
var KTAppInvoicesCreate = function () {
    var form;

	// Private functions
	var updateTotal = function() {
		var items = [].slice.call(form.querySelectorAll('[data-kt-element="items"] [data-kt-element="item"]'));
		var grandTotal = 0;

		var format = wNumb({
			//prefix: '$ ',
			decimals: 2,
			thousand: ','
		});

		items.map(function (item) {
            var quantity = item.querySelector('[data-kt-element="quantity"]');
			var price = item.querySelector('[data-kt-element="price"]');

            var unit_quantity = item.querySelector('[data-kt-element="unit_quantity"]');
			var unit_price = item.querySelector('[data-kt-element="unit_price"]');

			var priceValue = format.from(price.value);
			priceValue = (!priceValue || priceValue < 0) ? 0 : priceValue;

			var quantityValue = parseInt(quantity.value);
			quantityValue = (!quantityValue || quantityValue < 0) ?  0 : quantityValue;

            if(unit_price != null){
                var unitpriceValue = format.from(unit_price.value);
                unitpriceValue = (!unitpriceValue || unitpriceValue < 0) ? 0 : unitpriceValue;

                var unitquantityValue = parseInt(unit_quantity.value);
                unitquantityValue = (!unitquantityValue || unitquantityValue < 0) ?  0 : unitquantityValue;

            }else{
              var unitpriceValue = 0
              var unitquantityValue = 0
            }


			item.querySelector('[data-kt-element="total"]').innerText = format.to((priceValue * quantityValue) + (unitpriceValue * unitquantityValue ));

			grandTotal += priceValue * quantityValue;
		});

		// form.querySelector('[data-kt-element="sub-total"]').innerText = format.to(grandTotal);
		form.querySelector('[data-kt-element="grand-total"]').value = format.to(grandTotal);
	}

	var handleEmptyState = function() {
		if (form.querySelectorAll('[data-kt-element="items"] [data-kt-element="item"]').length === 0) {
			var item = form.querySelector('[data-kt-element="empty-template"] tr').cloneNode(true);
			form.querySelector('[data-kt-element="items"] tbody').prepend(item);
		} else {
			KTUtil.remove(form.querySelector('[data-kt-element="items"] [data-kt-element="empty"]'));
		}
	}

	var handeForm = function (element) {
		// Add item
		form.querySelector('[data-kt-element="items"] [data-kt-element="add-item"]').addEventListener('click', function(e) {
			e.preventDefault();

			var item = form.querySelector('[data-kt-element="item-template"] tr').cloneNode(true);

			form.querySelector('[data-kt-element="items"] tbody').prepend(item);

            $(item.querySelectorAll('[data-value="new"]')).select2();
            $(".kt_datepicker_1").flatpickr();
            $('.products').change(function(event){
                event.preventDefault();
                let product_id = $( this ).val();
                let store_id = $('.store option:selected').val();
                $.ajax({
                    url: '/admin/product-details/'+product_id,
                    type: 'get',
                    data: {
                        _method : 'get',
                        _token : $('meta[name="csrf-token"]').attr('content'),
                        store_id: store_id,
                    },
                    success: function (res) {
                        const trElement = event.target.parentNode.parentNode;

                        const max_wholesale_quantity = trElement.querySelector('td:nth-child(2)');
                        const store_wholesale_quantity = trElement.querySelector('td:nth-child(3)');

                        const max_unit_quantity = trElement.querySelector('td:nth-child(4)');
                        const store_unit_quantity = trElement.querySelector('td:nth-child(5)');

                        const wholesale_price = trElement.querySelector('td:nth-child(6)');
                        const unit_price = trElement.querySelector('td:nth-child(7)');
                        var unit_value = res.selling_type != 'جمله وقطاعى' ? 0 : (res.lower_limit * res.wholesale_quantity_units)

                        max_wholesale_quantity.innerHTML = `<label class="fs-6 fw-bold"> بحد ادنى <span class="text-danger">(${res.lower_limit})</span> </label>
                                        <input class="form-control form-control-solid" type="number" min="${res.lower_limit}"
                                        name="wholesale_quantity[]" value="${res.lower_limit}" data-kt-element="quantity" />`;

                        store_wholesale_quantity.innerHTML = `<label class="fs-6 fw-bold"><span></span></label>
                            <input disabled class="form-control form-control-solid" type="text"
                            value="${res.wholesale_quantity} (${res.wholesale_type})" />`;

                        max_unit_quantity.innerHTML = `<label class="fs-6 fw-bold"> بحد ادنى <span class="text-danger">(${res.lower_limit * res.wholesale_quantity_units})</span> </label>
                                        <input ${res.selling_type != 'جمله وقطاعى' ? 'readonly': ''} class="form-control form-control-solid" type="number" min="${res.lower_limit * res.wholesale_quantity_units}"
                                        name="unit_quantity[]" value="${unit_value.toString().trim()}" data-kt-element="unit_quantity" />`;

                        store_unit_quantity.innerHTML = `<label class="fs-6 fw-bold"><span></span></label>
                            <input disabled class="form-control form-control-solid" type="text"
                            value="${res.unit_quantity} (${res.item_type})" />`;

                        wholesale_price.innerHTML = `<label class="fs-6 fw-bold"></label>
                                        <input class="form-control form-control-solid" type="text"
                                            value="${res.sell_wholesale_price}" data-kt-element="price" />`;

                        unit_price.innerHTML = `<label class="fs-6 fw-bold"><span></span></label>
                            <input disabled class="form-control form-control-solid" type="text"
                            value="${res.sell_item_price}" data-kt-element="unit_price" />`;

                    }
                });
            })
			handleEmptyState();
			updateTotal();

		});

		// Remove item
		KTUtil.on(form, '[data-kt-element="items"] [data-kt-element="remove-item"]', 'click', function(e) {
			e.preventDefault();

			KTUtil.remove(this.closest('[data-kt-element="item"]'));

			handleEmptyState();
			updateTotal();
		});

		// Handle price and quantity changes
		KTUtil.on(form, '[data-kt-element="items"] [data-kt-element="quantity"],[data-kt-element="items"] [data-kt-element="unit_quantity"]', 'change', function(e) {
			e.preventDefault();
			updateTotal();
		});
	}

	var initForm = function(element) {
		// Due date. For more info, please visit the official plugin site: https://flatpickr.js.org/
		var invoiceDate = $(form.querySelector('[name="invoice_date"]'));
		invoiceDate.flatpickr({
			enableTime: false,
			dateFormat: "d, M Y",
		});

        // Due date. For more info, please visit the official plugin site: https://flatpickr.js.org/
		var dueDate = $(form.querySelector('[name="invoice_due_date"]'));
		dueDate.flatpickr({
			enableTime: false,
			dateFormat: "d, M Y",
		});
	}

	// Public methods
	return {
		init: function(element) {
            form = document.querySelector('#kt_invoice_form');

			handeForm();
            initForm();
			updateTotal();
        }
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppInvoicesCreate.init();
});
