jQuery(document).ready(function ($) {
    $("#graduation_batch").on("change", function () {
        const selectedOption = $(this).find(":selected");
        const totalPrice = $("#total_price");
        const info = selectedOption.data("info");
        const date = selectedOption.data("date");
        const session = selectedOption.data("session");
        const price = selectedOption.data("price");
        const value = selectedOption.val();
    
        totalPrice.text(new Intl.NumberFormat("vi-VN").format(price) + " VNĐ");
        $("#hidden_total_price").val(price || 0);
    
        if (date && session) {
            $("#graduation_date_display").text(date);
            $("#graduation_session_display").text(session);
            $("#hidden_graduation_date").val(date); 
            $("#hidden_graduation_session").val(session); 
            $("#date-session-box").show(); 
        } else {
            $("#graduation_date_display").text("");
            $("#graduation_session_display").text("");
            $("#hidden_graduation_date").val("");
            $("#hidden_graduation_session").val("");
            $("#date-session-box").hide();
        }

        if (value === "Lễ tốt nghiệp - Tiến sĩ - Tháng 12/2024" || value === "Lễ tốt nghiệp - Thạc sĩ - Tháng 12/2024") {
            alert(info);
            totalPrice.text("0 VNĐ");
            $("#graduation_address").html('<option value="" selected></option>');
            return;
        }
    
        if (info) {
            $("#graduation_address").html(`<option value="${info}">${info}</option>`);
            $("#hidden_graduation_address").val(info); 
        } else {
            $("#graduation_address").html('<option value="" selected></option>');
            $("#hidden_graduation_address").val("");
        }
    });
    
    
    
    
    


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

        const totalPriceText = $('#total_price').text().trim();
        if (totalPriceText === '0 VNĐ') {
            isValid = false;
            errors.push('Vui lòng chọn đợt tốt nghiệp.');
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
            data: $(this).serialize() + '&action=hte_form_submit_graduation&msv=' + msv,
            success: function (response) {
                if (response.success) {
                    alert('Yêu cầu của bạn đã được gửi thành công!');
                    location.reload();
                } else {
                    alert( response.data);
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
