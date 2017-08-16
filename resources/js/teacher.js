;(function () {
    console.log('TEACHER-JOURNAL');
    var journal = {action:'', teacher:'', group:'', subject:'', student:'', date:'', mark:''};

    // завантажуємо журнал
    $('#list-teacher-group a').click(function () {
        journal.action = 'openJournal';
        journal.teacher = $(this).attr('data-id-teacher');
        journal.group = $(this).attr('data-id-group');
        journal.subject = $(this).attr('data-id-subject');
        //відправляємо запит на серевер
        $.get($('#header-journal').attr('data-url'), journal)
            .done(function (data ) {
                $('#table-journal').html(data);
        });
        //console.log(journal);
    })


})();