;(function () {
    function l(s){ console.log(s);} l('START-TEACHER-MESSAGE');

    var notice = {
        action: '',
        id: '',
        message: '',
        date: ''
    };

    var url = '';

    // формуємо блок з повідомленням, і відображаємо на сторінці
    function addNewDiv() {
        var str = $('#list-message').html();
        str = '<div class="bg-warning m-message-text">'
            + 'Дата: <b>' + notice.date + '</b><br>'
            + notice.message
            + '</div>'
            + str;
        $('#list-message').html(str);
    };

    // відправляємо повідомлення на сервер
    function sendMessage() {
        $.get( url, notice )
            .done(function( data ) {
                if (data == 1)
                    addNewDiv();
            });
    };

    // кнопка - відправити повідомлення
    $('#send-message').click(function () {
        var d = new Date();
        notice.action = 'sendMessage';
        notice.message = $('#textarea-message').val();
        $('#textarea-message').val('');
        notice.id = $(this).attr('data-user-id');
        notice.date = d.getFullYear() + '-' + (d.getMonth()+1) + '-' + d.getDate() + ' ' +
                      d.getHours()+ ':' + d.getMinutes() + ':' + d.getSeconds();
        url = $(this).attr('data-url');
        if (notice.message.length < 251 && notice.message != '' )
            sendMessage();
    })

})();