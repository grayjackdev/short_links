$("#short-url-form").on('submit', function (e) {
    e.preventDefault();

    let form = $(this);
    let submitBtn = $('#submit-button');
    let infoMsg = $(".block-links-info .info-message")
    let loader = $(".block-links-info .loader-block")
    let linksInfoContainer = $(".block-links-info .links-info-container")

    infoMsg.addClass('d-none')
    submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Генерация...');
    loader.removeClass('d-none')
    linksInfoContainer.html('')
    $("#short-url-form").yiiActiveForm('updateMessages', {}, true);

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function (response) {
            if (response.status === 'success') {
                linksInfoContainer.html(response.html)
            } else if (response.status === 'validation_error') {
                $("#short-url-form").yiiActiveForm('updateMessages', response.validation_errors, true);
            } else if (response.status === 'error') {
                infoMsg.html(response.message)
                infoMsg.removeClass('d-none')
            }
        },
        error: function () {
            infoMsg.html('Произошла неизвестная ошибка!')
            infoMsg.removeClass('d-none')
        },
        complete: function () {
            submitBtn.prop('disabled', false).html('Сгенерировать');
            loader.addClass('d-none')

        }
    });

    return false;
});

