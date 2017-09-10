;(function () {
    function l(s) { console.log(s);} l('ADMIN');

    var baseUrl = $('#t-main').attr('data-url'),
        adminPage = $('#t-main').attr('data-admin');

/** Сторінка роботи з навантаженням викладача =========================================== */

if( adminPage == 'working-load' ) {
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

    // додати "предмет-група" по викладачу
    $('#button-add').click(function () {
        teacher.action = 'teacherWorkingWrite';
        if (teacher.teacherId != '' && teacher.subjectId != '' && teacher.groupId != '') {
            $("#save-choice").show(0).delay(1000).hide(0);
            sendToServer()
        }
    });

} // END TEACHER


/** Сторінка роботи зі студентами ======================================================= */

// списки груп студентів
if( adminPage == 'student' ) {

    var sGroup = {
        action: '',
        groupId: '',
        studentId: ''
    }

    var sNewStudent = {
        action:'',
        course: '',
        group: '',
        subgroup: '',
        student: []
    }

    // відправляємо дані на сервер
    function sSendToServer() {
        $.get(baseUrl, sGroup)
            .done(function (data) {
                if (sGroup.action == 'readGroupIdStudent'){
                    $('#sel-s-student-list tbody').html(data);
                    editStudentId();
                    $('#sel-s-count-student').html(
                        $('#sel-s-student-list tbody tr').length + '  ' +
                        "<label class='label label-default'>" +
                        $("#sel-s-group-list option:selected").text() + "</label>"
                    );
                }
                if (sGroup.action == 'editStudentId'){
                    $('#modal-edit-student-data').html(data);
                }
            });
    }

    // завантажуємо вибрану групу
    $('#sel-s-group-list').click(function () {
        sGroup.groupId = this.value;
        sGroup.action = 'readGroupIdStudent';
        sSendToServer();
    });
    $('#sel-s-group-list').keyup(function () {
        sGroup.groupId = this.value;
        sGroup.action = 'readGroupIdStudent';
        sSendToServer();
    });

    // редагуємо студента
    function editStudentId() {
        $('#sel-s-student-list button').on('click', function (e) {
            sGroup.action = 'editStudentId';
            sGroup.studentId = $(this).attr('data-student-id');
            sSendToServer();
            l(sGroup);
        })
    }
    editStudentId();
} // END STUDENT


// додати список (групу) студентів
if( adminPage == 'add-new-student' ) {

    var studentList = Array();

    // беремо список студентів з текстової області
    $('#textarea-button').click(function () {
        var student = $('#s-textarea').val().split('\n');
        var temp = [];
        for (var i=0; i<student.length; i++){
            studentList[i]= {
                surname: '',
                name: '',
                patronymic: '',
                group: []
            };
            student[i] = student[i].trim();
            temp = student[i].split(' ');
            studentList[i].surname = temp[0];
            studentList[i].name = temp[1];
            studentList[i].patronymic = temp[2];
            studentList[i].group = [];
        }
        //На основі списку студентів створюємо таблицю
        sMakeStudentTable();
        $('#textarea-container').hide();
        $('#student-div').show();
    });

    // таблиця налаштування студентів - встановлення груп
    function sMakeStudentTable() {
        var tbody = '';
        for(var i=0; i<studentList.length; i++){
            tbody = tbody
                + '<tr>'
                + '<td>'+ (i+1) + '</td>'
                + '<td>'+ studentList[i].surname + '</td>'
                + '<td>'+ studentList[i].name + '</td>'
                + '<td>'+ studentList[i].patronymic + '</td>'
                + '<td>'+ "<input type='checkbox' style='transform: scale(1.2);'>" + '</td>'
                + '<td>' + '</td>'
                + '</tr>';
        }
        $('#edit-student-table tbody').html(tbody);
    }

    // встановлюємо звязки груп зі студентами
    $('#button-add-group').click(function () {
        var table = document.getElementById('edit-student-table'),
            tbody = table.getElementsByTagName('tbody')[0],
            tr = tbody.getElementsByTagName('tr');
        // якщо не вибрано групу то виходимо
        if( $('#group-selected').val() == -1) return;

        // перебір рядків таблиці і занесення інформації
        for(var i=0; i<tr.length; i++){ // і - номер студента в таблиці і в "обєкті"
            var td = tr[i].getElementsByTagName('td');
            // якщо студент відмічений то додаємо групу
            if(td[4].getElementsByTagName('input')[0].checked){
                var s = td[5].innerHTML;
                var s = s
                    + "<div class='s-student-added-group'>"
                    + "<span class='label label-default'>"
                    + $('#group-selected option:selected').text().trim()
                    + " <button data-n-student='" + i + "' data-id-group='" + $('#group-selected').val() + "'"
                    + " type='button' class='btn btn-warning btn-xs'> X </button>"
                    + '</span>'
                    + '</div>';
                td[5].innerHTML = s;
                studentList[i].group.push($('#group-selected').val());
            };
        }

        // видаляємо записану групу
        $('#edit-student-table tbody button').on('click', function () {
            var n = $(this).attr('data-n-student');
            for (var i=0; i<studentList[n].group.length; i++) {
                if ( studentList[n].group[i] == $(this).attr('data-id-group') ) {
                 studentList[n].group.splice(i, 1);
                }
            }
            //l( studentList[n]);
            $(this).parent().parent().remove();
        })
    });

    //
    $('#save-student-group').click(function () {
        l(baseUrl);
        l(studentList);
        var data = {
            action:'saveStudentGroup',
            student: studentList
        }

        $.get(baseUrl, data)
            .done(function (data) {
                $('#student-div').html(data);
            });
    });


} //






})(); // * END * //