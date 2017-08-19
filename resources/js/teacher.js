;(function () {
    function c(s){ console.log(s);}
    c('START-TEACHER-JOURNAL')

    var journal = {
        action:'',
        teacher:'',
        group:'',
        subject:'',
        student:'',
        type:'',
        number:'',
        date:'',
        mark:''
    };
    var listJournalLesson = Array(); // список номерів пар і їхніх дат в таблиці


    // змінюємо розмір таблиці оцінок відповідно до розмірів вікна
    function tableMarkWidth() {
        $('#table-student-mark').width($(window).width()-340);
    };

    // змінюємо розміри таблиці при зміні розмірів вікна
    $(window).resize(function(){
        tableMarkWidth();
    });

    // відправляємо дані на сервер
    function sendDataToServer() {
        //відправляємо запит на серевер
        $.get($('#main-journal').attr('data-url'), journal)
            .done(function (data) {
                $('#table-headline-message').html(data);
                $("#table-headline-message").show(0).delay(5000).hide(0);
            })
            .fail(function() {
                $('#table-headline-message').html("error");
            });
    };

/** Загрузка документа ========================================================================= */

    // отримати список наявних дат (присутніх в таблиці)
    function createListJournalDate() {
        var i = 0;
        $("#table-mark thead th").each(function() {
            listJournalLesson[i] = Array();
            listJournalLesson[i][0] = $(this).attr('data-date');
            listJournalLesson[i][1] = $(this).attr('data-lesson-type');
            listJournalLesson[i][2] = $(this).attr('data-lesson-number');
            i++;
        });
    };

    // загрузка документа
    $(document).ready(function() {
        tableMarkWidth();
        //заносимо основін дані до обєкта - journal
        journal['teacher'] =$('#table-mark').attr('data-id-teacher');
        journal['group'] =$('#table-mark').attr('data-id-group');
        journal['subject'] =$('#table-mark').attr('data-id-subject');
        // список дат на момент загрузки
        createListJournalDate();
    });


/** Додати нову дату до таблиці ================================================================ */

    // відкриваємо вікно додавання нової дати
    $('#add-new-date').click(function () {
        $('#box-add-new-date').show(100);
    });

    // відмінити і закрити вікно додавання дати
    $("#add-new-date-cancel").click(function(){
        $('#box-add-new-date').hide(100);
        $('#add-new-date-input').val('');
    });

    //додати новий стовбчик до таблиці
    function addNewColumnToTable() {
        var table = document.getElementById('table-mark'),
            n_rows = table.rows.length,
            n_cells = table.rows[0].cells.length;
        var table_student = document.getElementById('table-list');
        var idS;

        var i = journal.date.split('-');
        var tSelect = document.getElementById("add-new-lesson-input");

        // добавляємо нову дату в заголовок з відповідними атрибутами
        table.rows[0].insertCell(n_cells-1);
        table.rows[0].cells[n_cells-1].outerHTML =
            "<th class='text-center m-table-type-"+ journal.type +"' " +
            "data-lesson-type='" + journal.type +
            "' data-date='" + journal.date +
            "' data-lesson-number='" + journal.number +
            "' title='" + tSelect.options[ tSelect.selectedIndex ].innerHTML + "' >" +
            "<span class='m-table-h-day'>" + i[2] + "</span><br>"+
            "<span class='m-table-h-month'>" + i[1] + "</span></th>";

        // додати стовбчики до таблиці
        for(i = 1; i < n_rows; i++){
            if( n_cells <= 1 )
                idS = table_student.rows[i].cells[0].getAttribute('data-id-student');
            else
                idS = table.rows[i].cells[n_cells-2].getAttribute('data-id-student');

            table.rows[i].insertCell(n_cells-1);
            table.rows[i].cells[n_cells-1].innerHTML = '';
            table.rows[i].cells[n_cells-1].setAttribute("data-id-teacher", journal.teacher);
            table.rows[i].cells[n_cells-1].setAttribute("data-id-subject", journal.subject);
            table.rows[i].cells[n_cells-1].setAttribute("data-id-group", journal.group);
            table.rows[i].cells[n_cells-1].setAttribute("data-id-student", idS);
            table.rows[i].cells[n_cells-1].setAttribute("data-id-lesson-type", journal.type);
            table.rows[i].cells[n_cells-1].setAttribute("data-lesson-number", journal.number);
            table.rows[i].cells[n_cells-1].setAttribute("data-mark", "");
            table.rows[i].cells[n_cells-1].setAttribute("data-date", journal.date);
        };

        createListJournalDate()
    };

    // додавання нової дати до таблиці журналу
    $('#add-new-date-ok').click(function () {
        var i;
        var tSelect = document.getElementById("add-new-lesson-input");

        $('#box-add-new-date').hide(100);
        var newDateInTable = $('#add-new-date-input').val(),
            newLessonNumber = 1,
            newLessonType = $('#add-new-lesson-input').val();

        if( newDateInTable == '' ) return;
        if(!confirm("Ви дійсно бажаєте дотати '"+ tSelect.options[ tSelect.selectedIndex ].innerHTML + "', дата: " + newDateInTable)) return;

        // первіряємо які дати присутні, якщо прара є то збільшуємо кількість на 1
        for (i = 0; i < listJournalLesson.length; i++) {
            if( newDateInTable == listJournalLesson[i][0] && newLessonType == listJournalLesson[i][1] ){
                newLessonNumber = Number(listJournalLesson[i][2]) + Number(1);
            }
        };

        journal.type = newLessonType;
        journal.number = newLessonNumber;
        journal.date = newDateInTable;
        journal.action = 'addColumnToTable';

        // додати новий стовпець
        addNewColumnToTable();

        // зберігаємо інформацію в базі даних
        sendDataToServer();
    });









})();