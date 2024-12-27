jQuery(document).ready(function ($) {
    
    const unitPrice = 30000;
    const $quantitySelect = $('#quantity');
    const $totalPrice = $('#total_price');

    // Hàm cập nhật giá tiền
    function updatePrice() {
        const quantity = parseInt($quantitySelect.val());
        const totalPrice = unitPrice * quantity;
        $totalPrice.text(totalPrice.toLocaleString('vi-VN') + ' VNĐ');
    }

    $quantitySelect.on('change', updatePrice);
    updatePrice();


    const $shippingMethod = $("#shipping_method");
    const $domesticShipping = $("#domestic_shipping");
    const $internationalShipping = $("#international_shipping");
    const $shippingDetails = $(".shipping-details");

    function toggleShippingFields() {
        const selectedMethod = $shippingMethod.val();

        if (selectedMethod === "Ship trong nước") {
            $domesticShipping.show();
            $internationalShipping.hide();
            $shippingDetails.show();
        } else if (selectedMethod === "Ship nước ngoài") {
            $domesticShipping.hide();
            $internationalShipping.show();
            $shippingDetails.show();
        } else {
            $domesticShipping.hide();
            $internationalShipping.hide();
            $shippingDetails.hide();
        }
    }
    $shippingMethod.on("change", toggleShippingFields);
    toggleShippingFields();


    $('#shipping_method').on('change', function () {
        const shippingMethod = $(this).val();
        const shippingAddress = $('#shipping_address');
        const shippingPhone = $('#shipping_phone');

        if (shippingMethod === 'Không ship') {
            shippingAddress.prop('required', false).closest('.form-group').hide();
            shippingPhone.prop('required', false).closest('.form-group').hide();
        } else {
            shippingAddress.prop('required', true).closest('.form-group').show();
            shippingPhone.prop('required', true).closest('.form-group').show();
        }
    });
    $('#shipping_method').trigger('change');

    //gửi form
    $('.hte_form').on('submit', function (event) {
        event.preventDefault();
        const $form = $(this);
        const $submitButton = $form.find('[type="submit"]');
        const $buttonText = $submitButton.find('.button-text');
        const $spinner = $submitButton.find('.fa-spinner');

        $buttonText.hide();
        $spinner.show();
        $submitButton.prop('disabled', true);

        let isValid = true;
        let errors = [];

        function getParameterByName(name) {
            const url = new URL(window.location.href);
            return url.searchParams.get(name);
        }

        const msv = getParameterByName('msv');

        if (!msv) {
            isValid = false;
            errors.push('Không tìm thấy thông tin MSV.');
        }

        const shippingMethod = $('#shipping_method').val();
        if (shippingMethod !== 'Không ship') {
            if (!$('#shipping_address').val()) errors.push('Địa chỉ nhận ship không được để trống.');
            if (!$('#shipping_phone').val() || !/^\d+$/.test($('#shipping_phone').val())) {
                errors.push('Số điện thoại liên hệ khi ship không hợp lệ.');
            }
        }

        if (!$('#contact_phone').val() || !/^\d+$/.test($('#contact_phone').val())) {
            errors.push('Số điện thoại liên hệ không hợp lệ.');
        }

        if (!isValid || errors.length) {
            alert(errors.join('\n')); 
            $spinner.hide();
            $buttonText.show(); 
            $submitButton.prop('disabled', false); 
            return;
        }

        $.ajax({
            url: hteAjax.ajax_url,
            method: 'POST',
            data: $(this).serialize() + '&action=hte_form_submit_cert&msv=' + msv ,
            success: function (response) {
                if (response.success) {
                    alert('Yêu cầu của bạn đã được gửi thành công!');
                     location.reload();
                } else {
                    alert('Có lỗi xảy ra: ' + response.data);
                }
            },
            error: function () {
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            },
            complete: function () {
                $spinner.hide();
                $buttonText.show();
                $submitButton.prop('disabled', false);
            },
        });
    });
});
