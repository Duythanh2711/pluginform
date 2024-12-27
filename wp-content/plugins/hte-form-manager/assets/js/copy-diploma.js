jQuery(document).ready(function ($) {
    
    const unitPrice = 100000;
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


        if (!$('#contact_phone').val() || !/^\d+$/.test($('#contact_phone').val())) {
            errors.push('Số điện thoại liên hệ không hợp lệ.');
        }
        const diplomaYear = $('#diploma_year').val();
        const currentYear = new Date().getFullYear();
        if (!diplomaYear || !/^\d{4}$/.test(diplomaYear) || diplomaYear < 1900 || diplomaYear > currentYear) {
            isValid = false;
            errors.push('Năm cấp bằng phải là số hợp lệ từ 1900 đến ' + currentYear + '.');
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
            data: $(this).serialize() + '&action=hte_form_submit_copy_diploma&msv=' + msv ,
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
