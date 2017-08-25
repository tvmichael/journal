;(function () {
    function l(s) { console.log(s);} l('ADMIN');

    var baseUrl = $('#t-main').attr('data-url'),
        adminPage = $('#t-main').attr('data-admin');

/** Сторінка роботи з викладачами ======================================================= */

if( adminPage == 'teacher' ) {
    var teacher = {
        action: '',
        teacherId: '',
        subjectId: '',
        groupId: ''
    };

    // відправляємо дані на сервер
    function sendToServer() {
        $.get(baseUrl, teacher)
            .done(function (data) {
                $('#teacher-working-load').html(data);
                // встановлюємо "кліки" в таблиці на кнопки для видалення
                removeTeacherLoad();
            });
    }

    // видалити навантаження по викладачу
    function removeTeacherLoad() {
        $("#teacher-working-load a").on("click", function () {
            teacher.action = 'removeTeacherLoad';
            teacher.teacherId = $(this).attr('data-id-teacher');
            teacher.subjectId = $(this).attr('data-id-subject');
            teacher.groupId = $(this).attr('data-id-group');
            sendToServer();
        });
    }

    // ВИКЛАДАЧ ------------
    // додаємо 'id' вчителя
    function setActiveTeacher(e) {
        teacher.subjectId = '';
        teacher.groupId = '';
        teacher.teacherId = e.value;
        teacher.action = 'teacherWorkingLoad';                                       // можна так: l($(this).val());
        $('#header-teacher').html($("#sel-teacher-list option:selected").text());  // можна так: l($('option:checked', this).text());
        $('#teacher-current-choice').html($("#sel-teacher-list option:selected").text());

        // очистити текстове поле
        $('#subject-current-choice').html('');
        $('#group-current-choice').html('');

        // зберігаємо
        sendToServer();
    };

    // вибираємо викладача для якого будем змінювати дані
    $('#sel-teacher-list').click(function () {
        setActiveTeacher(this);
    });
    $('#sel-teacher-list').keyup(function () {
        setActiveTeacher(this);
    });

    // ПРЕДМЕТ -------------
    // вибираємо предмет
    $('#sel-subject-list').click(function () {
        teacher.subjectId = this.value;
        $('#subject-current-choice').html($('option:checked', this).text());
    });
    $('#sel-subject-list').keyup(function () {
        teacher.subjectId = this.value;
        $('#subject-current-choice').html($('option:checked', this).text());
    });

    // ГРУПА ---------------
    // вибираємо групу
    $('#sel-group-list').click(function () {
        teacher.groupId = this.value;
        $('#group-current-choice').html($('option:checked', this).text());
    });
    $('#sel-group-list').keyup(function () {
        teacher.groupId = this.value;
        $('#group-current-choice').html($('option:checked', this).text());
    });

    // додати предмет-група по викладачу
    $('#button-add').click(function () {
        teacher.action = 'teacherWorkingWrite';
        if (teacher.teacherId != '' && teacher.subjectId != '' && teacher.groupId != '') {
            $("#save-choice").show(0).delay(1000).hide(0);
            sendToServer()
        }
    });

} // END TEACHER


/** Сторінка роботи зі студентами ======================================================= */

if( adminPage == 'student' ) {

    var sGroup = {
        action: '',
        groupId: '',
        studentId: ''
    }

    // відправляємо дані на сервер
    function sSendToServer() {
        $.get(baseUrl, sGroup)
            .done(function (data) {
                $('#sel-s-student-list').html(data);
                $('#teacher-current-choice').html();

                $('#sel-s-count-student').html(
                    $('#sel-s-student-list option').length + '  ' +
                    "<label class='label label-default'>" +
                    $("#sel-s-group-list option:selected").text() + "</label>"
                );
            });
    }

    //
    $('#sel-s-group-list').click(function () {
        sGroup.groupId = this.value;
        sGroup.action = 'readGroupIdStudent';
        sSendToServer();
        l(sGroup);
    });
    $('#sel-s-group-list').keyup(function () {
        sGroup.groupId = this.value;
        sGroup.action = 'readGroupIdStudent';
        sSendToServer();
        l(sGroup);
    });

} // END STUDENT


})();