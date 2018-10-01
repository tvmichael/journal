function l(s){ console.log(s);} l('START-TEACHER-MAIN');

var mainJournal = document.getElementById('teacher-main'),
    dataUrl = mainJournal.getAttribute('data-url'),
    dataAjax = mainJournal.getAttribute('data-ajax'),
    adminPage = mainJournal.getAttribute('data-teacher');

/** Робота з групами викладача =========================================== */
if( adminPage == 'main' ) {

    l('adminPage');
    // формуємо таблицю груп-предметів для викладача
    function tableView() {
        var container = document.getElementById('list-gt');
        var table = "<table class='table table-bordered table-hover'>"
            + "<thead>"
            + "<tr>"
            + "<th>№</th>"
            + "<th><span class='glyphicon glyphicon-menu-hamburger'></span> Курс</th>"
            + "<th><span class='glyphicon glyphicon-modal-window'></span> Група</th>"
            + "<th><span class='glyphicon glyphicon-list-alt'></span> Підгрупа</th>"
            + "<th><span class='glyphicon glyphicon-book'></span> Предмет</th>"
            + "<th>Журнал</th>"
            + "</tr>"
            + "</thead>";
        +"<body>";
        var tr = '';
        for (var i = 0; i < listGT.length; i++) {
            // course fullname groupe id_group id_subject id_teacher shortname subgroup
            tr = tr
                + "<tr>"
                + "<td>" + (i + 1) + "</td>"
                + "<td>" + listGT[i]['course'] + "</td>"
                + "<td>" + listGT[i]['groupe'] + "</td>"
                + "<td>" + listGT[i]['subgroup'] + "</td>"
                + "<td>" + listGT[i]['fullname'] + "</td>"
                + "<td>"
                + "<a href='" + dataUrl
                + "?teacher=" + listGT[i]['id_teacher'] + "&group=" + listGT[i]['id_group'] + "&subject=" + listGT[i]['id_subject']
                + "'>" + "Відкрити сторінку журнала" + "</a>"
                + "</td>"
                + "</tr>";
        }
        table = table + tr + "</tbody></table>";
        container.innerHTML = table;
    }

    // формуємо блоки груп-предметів для викладача
    function blockView() {

        function sb1234(sb) {
            if (sb.search('1/2') > 0) return '1-2';
            if (sb.search('1/3') > 0) return '1-3';
            if (sb.search('1/4') > 0) return '1-4';
            return '1';
        }

        var container = document.getElementById('list-gt');
        var block = '';
        for (var i = 0; i < listGT.length; i++) {
            block = block
                + "<div class='col-sm-6 col-lg-4'>"
                + "<a href='" + dataUrl
                + "?teacher=" + listGT[i]['id_teacher'] + "&group=" + listGT[i]['id_group'] + "&subject=" + listGT[i]['id_subject']
                + "' style='text-decoration: none;'>"
                + "<div id='list-group-teacher'>"
                + "<h5 class='m-course-name"
                + " list-group-teacher-" + sb1234(listGT[i]['subgroup'])
                + "'>" + listGT[i]['course']
                + "</h5>"
                + "<h3 class='m-group-name'>" + listGT[i]['groupe'] + "</h3>"
                + "<p class='m-subgroup-name'>" + listGT[i]['subgroup'] + "</p>"
                + "<p class='m-fullname-name'>" + listGT[i]['fullname'] + "</p>"
                + "</div>"
                + "</a>"
                + "</div>";
        }
        container.innerHTML = block;
    }

    // відобразити таблицю
    if (settings.view == 1) {
        blockView();
    }
    else tableView();

    // у вигляді блоків
    $('.glyphicon-th-large').parent().click(function () {
        settings.view = 1;
        blockView();
        saveToServer();
    });

    // у вигляді таблиці
    $('.glyphicon-th-list').parent().click(function () {
        settings.view = 2;
        tableView();
        saveToServer();
    });

    // зберігаємо на сервер налаштування, вигляд сторінки
    function saveToServer() {
        $.get(dataAjax, {action: "settingsView", view: settings.view})
            .done(function (data) {
                l(data);
            });
    }

    // сортуємо масив за вказаним полем
    function sotrArray(fild, direction) {

        function compare(a, b) {
            if (direction == '0') {
                if (a[fild] < b[fild])
                    return -1;
                if (a[fild] > b[fild])
                    return 1;
                return 0;
            }
            if (direction == '1') {
                if (a[fild] > b[fild])
                    return -1;
                if (a[fild] < b[fild])
                    return 1;
                return 0;
            }
        }

        listGT.sort(compare);
    }

    // сортуємо по вказаному полю
    $('button[data-sort]').click(function () {
        sotrArray($(this).attr('data-sort'), $(this).attr('data-direction'));
        if ($(this).attr('data-direction') == '0') $(this).attr('data-direction', '1');
        else $(this).attr('data-direction', '0');
        if (settings.view == 1) {
            blockView();
        }
        else tableView();
    });

}

/** Робота з навантаженням викладача =========================================== */
if( adminPage == 'working-load' ) {
    var teacher = {
        action: '',
        teacherId: '',
        subjectId: '',
        groupId: ''
    };
    var obTeacherList;

    // відправляємо дані на сервер
    function sendToServer() {
        $.get(dataUrl, teacher)
            .done(function (data) {
                data = JSON.parse(data);
                if (data.error == 0) {
                    $('#teacher-working-load').html(data.text);
                    // встановлюємо "кліки" в таблиці на кнопки для видалення
                    removeTeacherLoad();
                } else {
                    alert(data.text);
                }
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
    function setActiveTeacher() {
        teacher.subjectId = '';
        teacher.groupId = '';
        teacher.teacherId = $('#teacher-current-choice').attr('data-teacher-id'); // можна так: l($(this).val()); // можна так: l($('option:checked', this).text());
        teacher.action = 'teacherWorkingLoad';
        // очистити текстове поле
        $('#subject-current-choice').html('');
        $('#group-current-choice').html('');

        // зберігаємо
        sendToServer();
    };
    setActiveTeacher();

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

    // додати "предмет-група" по викладачу
    $('#button-add').click(function () {
        teacher.action = 'teacherWorkingWrite';
        if (teacher.teacherId != '' && teacher.subjectId != '' && teacher.groupId != '') {
            $("#save-choice").show(0).delay(1000).hide(0);
            sendToServer()
        }
    });

} // END TEACHER