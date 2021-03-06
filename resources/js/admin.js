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
                data = JSON.parse(data);
                if (data.error == 0) {
                    $('#teacher-working-load').html(data.text);
                    // встановлюємо "кліки" в таблиці на кнопки для видалення
                    removeTeacherLoad();
                } else {
                    alert('ERRROR');
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
                + '<td>'+ "<label>Відмітити <input type='checkbox' style='transform: scale(1.2);'></label>" + '</td>'
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

        var sGroupName = $('#group-selected option:selected').text().trim(),

        // виділяємо різними кольорами частини підгруп
        sStyle = 'label-default';
        if (sGroupName.indexOf('1/2') !== -1 ) sStyle = 'label-primary';
        if (sGroupName.indexOf('1/3') !== -1 ) sStyle = 'label-success';
        if (sGroupName.indexOf('1/4') !== -1 ) sStyle = 'label-info';
        if (sGroupName.indexOf('Іноземна') !== -1 ) sStyle = 'label-warning';


        // перебір рядків таблиці і занесення інформації
        for(var i = 0; i<tr.length; i++){ // і - номер студента в таблиці і в "обєкті"
            var td = tr[i].getElementsByTagName('td');
            // якщо студент відмічений то додаємо групу
            if(td[4].getElementsByTagName('input')[0].checked){
                var s = td[5].innerHTML;
                var s = s
                    + "<div class='s-student-added-group'>"
                    + "<span class='label " + sStyle + "'>"
                    + sGroupName
                    + " <button data-n-student='" + i + "' data-id-group='" + $('#group-selected').val() + "'"
                    + " type='button' class='btn btn-warning btn-xs'> X </button>"
                    + '</span>'
                    + '</div>';
                td[5].innerHTML = s;
                //заносимо новий 'ID' групи до якої належить студент
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

    // зберігаємо список студентів до БД (відправляємо запит з обєктом)
    $('#save-student-group').click(function () {
        l(studentList);
        var data = {
            action:'saveStudentGroup',
            student: studentList
        };
        $.get(baseUrl, data)
            .done(function (data) {
                $('#student-div').html(data);
            });
    });
} //


// редагувати студента
if( adminPage == 'student_edit' ) {

    // додаємо нову групу до студента
    $('#add-new-group').click(function () {
        var idS = $(this).attr('data-id-student');
        if ($('#group-selected').val() > 0 )
        $.get(baseUrl, {'action':'editStudentAddGroup',
            'id_student':$(this).attr('data-id-student'),
            'id_group':$('#group-selected').val()
        }).done(function (error) {
                var js = JSON.parse(error);
                l(error);
                $('#respond').html(js[1]);

                // якщо немає помилок  error = 0, то додаємо рядок таблиці
                if (js[0] == '0') {
                    $('table > tbody').append('<tr><td>' + ($('table >tbody tr').length + 1)
                        + '</td><td>'
                        + $('#group-selected option:selected').text().trim()
                        + "</td><td><button data-delete-group='0' data-id-student='" + idS
                        + "' data-id-group='" + $('#group-selected').val()
                        + "' class='btn btn-default'>"
                        + "<span class='glyphicon glyphicon-trash'></span></button></td>"
                        + '</td></tr>');
                    $('[data-delete-group]').click(removeStudetnGroup);
                }
                else { alert('Помилка збереження даних')}
            });
    });

    // видаляємо належність студента до даної групи
    function removeStudetnGroup () {
        var self = $(this).parent().parent();
        l(self);
        $.get(baseUrl, {'action':'deleteStudentGroup',
            'id_student':$(this).attr('data-id-student'),
            'id_group':$(this).attr('data-id-group')
        }).done(function (error) {
            if (error == '0')
                self.remove();
        });
    }
    // видаляємо належність студента до даної групи
    $('[data-delete-group]').click(removeStudetnGroup);
    //$('[data-delete-group]').on('click', removeStudetnGroup);

    // зберігаємо зміни внесені до (прізвища, імя, побітькові) студента
    $('#save-student').click(function () {
        l('save-student');
        var surname = $('#student-surname').val();
        var name = $('#student-name').val();
        var patronymic = $('#student-patronymic').val();
        var obj = {
            'action':'saveStudent',
            'id_student' : $(this).attr('data-id-student'),
            'surname':surname,
            'name':name,
            'patronymic':patronymic
        };
        l(obj);
        $.get(baseUrl, obj).done(function (data) {
            $('#respond').html('<span class="label label-primary">' + data + '</span>');
        });
    });

    // видаляємо студента з бізи даних
    $('#delete-student').click(function (e) {
        $.get(baseUrl, {'action':'deleteStudent',
            'id_student':$(this).attr('data-id-student')
        }).done(function (error) {
            if (error == '0'){
                window.history.back();
            }
        });
    });

} // end - student_edit


// налаштування ... студентів
if( adminPage == 'student-setting' ) {

    var registrationData = Array();
    $('#read-list-student-registration').click(function () {
        $.get(baseUrl, {'action':'listStudentRegistration'}).done(function (d) {
            //l(JSON.parse(d));
            var listStudent = JSON.parse(d),
                uniqueGroup = Array(),
                uniqueCourse = Array(),
                i, g, k, n,
                str = '';

            l(listStudent);
            $('#write-list-student-registration').attr('data-hash', listStudent.hash);
            listStudent = listStudent.students;

            for (i = 0; i < listStudent.length; i++){
                uniqueGroup.push(listStudent[i].groupe);
                uniqueCourse.push(listStudent[i].course);
            }

            uniqueGroup = Array.from(new Set(uniqueGroup));
            uniqueCourse =Array.from(new Set(uniqueCourse));
            //l(uniqueCourse);
            //l(uniqueGroup);

            n = 0;
            for(k=0; k<uniqueCourse.length; k++){
                str = str + '<h3>' + uniqueCourse[k]+ "</h3>";
                for(g=0; g<uniqueGroup.length; g++){
                    str = str +'<b>' + uniqueGroup[g] + '</b><br>';
                    for (i = 0; i < listStudent.length; i++){
                        if(uniqueCourse[k] == listStudent[i].course && uniqueGroup[g] == listStudent[i].groupe ){
                            n = n + 1;
                            var pass = Math.random().toString(36).slice(-6);
                            str = str
                                + n + '. '
                                + '[ ' + 'student'
                                + listStudent[i]['id'] + ' - ' + pass + ' ] &nbsp;&nbsp;'
                                + ' ' + listStudent[i]['name'] + ' ' + listStudent[i]['surname']
                                + '<br>';
                            registrationData.push({
                                login:'student'+listStudent[i]['id'],
                                password:pass,
                                surname:listStudent[i]['surname'],
                                name:listStudent[i]['name'],
                                patronymic:listStudent[i]['patronymic'],
                                settings: {
                                    course:listStudent[i]['course'],
                                    groupe:listStudent[i]['groupe'],
                                    group_id:listStudent[i]['group_id']
                                }
                            });
                        }
                    }
                }
            }

            //l(registrationData);
            $('#data-list-student-registration').html(str);
        });
    });
    $('#write-list-student-registration').click(function () {
        var self = this;
        var objectData ={
            action: 'writeListStudentRegistration',
            writeData: registrationData.slice(0, 110)
        };
        var nameCsrf = $(self).attr('data-name');
        objectData[nameCsrf] = $(self).attr('data-hash');

        l(objectData);
        $.post(baseUrl, objectData).done(function (d) {
            l(d);
            var jd = JSON.parse(d);
            $(self).attr('data-hash', jd.hash);
            $('#data-list-student-registration').html(d);
        });
    });


    // реєстраційні дані студентів
    $('#list-student-registration').click(function () {
        $.get(baseUrl, {'action':'listStudentRegistration'}).done(function (d) {
            var listStudent = JSON.parse(d),
                uniqueGroup = Array(),
                uniqueCourse = Array(),
                i, g, k, n,
                str = '';

            for (i = 0; i < listStudent.length; i++){
                uniqueGroup.push(listStudent[i].groupe);
                uniqueCourse.push(listStudent[i].course);
            }
            uniqueGroup = Array.from(new Set(uniqueGroup));
            uniqueCourse =Array.from(new Set(uniqueCourse));
            //l(uniqueCourse);
            //l(uniqueGroup);
            n = 0;
            for(k=0; k<uniqueCourse.length; k++){
                str = str + '<h2>' + uniqueCourse[k]+ "</h2>";
                for(g=0; g<uniqueGroup.length; g++){
                    str = str +'<h4>' + uniqueGroup[g] + '</h4>';
                    for (i = 0; i < listStudent.length; i++){
                        if(uniqueCourse[k] == listStudent[i].course && uniqueGroup[g] == listStudent[i].groupe ){
                            n = n + 1;
                            str = str
                                + n + '. '
                                + listStudent[i]['login']
                                + ' ' + listStudent[i]['password']
                                + ' <b> . ' + listStudent[i]['name'] + ' _ ' + listStudent[i]['surname']
                                + '</b><br>';
                        }
                    }
                }
            }
            $('#data-list-student-registration').html(str);
        });
    });

} // end - student-setting



})(); // * END * //