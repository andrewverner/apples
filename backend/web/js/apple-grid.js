$(function () {
    let eatId;

    $(document).on('click', '.fall-btn', function (e) {
        e.preventDefault();

        let $btn = $(this);

        $.ajax({
            url: $btn.data('url'),
            method: 'POST',
            success: function () {
                $.pjax.reload({container: '#apples-list', async: false});
            },
        });
    });

    $(document).on('click', '.eat-btn', function (e) {
        e.preventDefault();

        let $btn = $(this);

        eatId = $btn.data('id');
        $('#eat-btn').attr('data-url', $btn.data('url'));
        $('#eatVolume').val($btn.data('volume'));
        $('#eat-modal').modal('show');
    });

    $(document).on('click', '#eat-btn', function () {
        let $btn = $(this);

        $.ajax({
            url: $btn.data('url'),
            method: 'POST',
            data: {
                volume: $('#eatVolume').val(),
                id: eatId,
            },
            success: function () {
                $.pjax.reload({container: '#apples-list', async: false});
            },
        });
    });
});
