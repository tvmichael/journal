;(function () {
    function l(s){ console.log(s);}
    l('START-TEACHER-JOURNAL');

    var markTable = document.getElementById('table-mark');  // таблиця оцінок студентів

    var listJournalLesson = Array(); // список номерів пар і їхніх дат в таблиці

    var changeDate; // при заміні - нова дата

    var tableCellPosition = { // позиція активної клітинки в таблиці
        currentRow: 1,
        currentCell: 0,
        nRow: markTable.rows.length,
        nCell: markTable.rows[0].cells.length,
        editCell: false,
        mark: '',
        oldMark: '',
        td: '',
        input: ''
    };

    var journal = { // обєкт - оцінка в журналі
        action: '',
        teacher: '',
        group: '',
        subject: '',
        student: '',
        type: '',
        number: '',
        date: '',
        mark: '',
        count: tableCellPosition.nRow - 1 // кількість студентів
    };


    var sW = 330; // зменьшуємо ширину таблиці Mark, щоб не виходила за праву межу екрана


/** Додаткові функції ========================================================================== */

    // змінюємо розмір таблиці оцінок відповідно до розмірів вікна
    function tableMarkWidth() {
        $('#table-student-mark').width($(window).width()-sW);
    };

    // змінюємо розміри таблиці при зміні розмірів вікна
    $(window).resize(function(){
        tableMarkWidth();
    });

    // відправляємо дані на сервер
    function sendDataToServer(task) {
        //відправляємо запит на серевер
        $.get($('#main-journal').attr('data-url'), journal)
            .done(function (data) {
                myObj = JSON.parse(data);
                // додати новий стовпець
                if( task == 'addNewColumnToTable' && (myObj.error == 0  || myObj.count == journal.count) )
                    addNewColumnToTable();
                // показуємо повідомлення що надійшло з серевера
                $('#table-headline-message').html(myObj.text);
                $("#table-headline-message").show(0).delay(3000).hide(0);
            })
            .fail(function() {
                $('#table-headline-message').html("<span style='color: red;'>ПОМИЛКА!</span>");
                $("#table-headline-message").show(0).delay(5000).hide(0);
            });
    };

    // перетворюємо дату в потрібний формат
    function yyyymmdd(d) {
        var mm = d.getMonth() + 1; // getMonth() is zero-based
        var dd = d.getDate();

        return [d.getFullYear(),
            (mm > 9 ? '' : '0') + mm,
            (dd > 9 ? '' : '0') + dd
        ].join('-');
    };


    // отримати список наявних дат (присутніх в таблиці)
    function createListJournalDate() {
        var i = 0;
        listJournalLesson.length = 0;
        $("#table-mark thead th").each(function() {
            listJournalLesson[i] = Array();
            listJournalLesson[i][0] = $(this).attr('data-date');
            listJournalLesson[i][1] = $(this).attr('data-lesson-type');
            listJournalLesson[i][2] = $(this).attr('data-lesson-number');
            i++;
        });
    };

    // вкорочуємо прізвиша студентів для маленького екрану
    function shortStudentList() {
        $('#table-student-list td').each(function () {
            var s;
            s = $(this).text();
            s = s.split(' ');
            try { $(this).text( s[0] + ' '+ s[1][0] +'.'); }
            catch(err) { $(this).text(s[0]); }
        });
        sW = 230;
        $('#table-student-list').width(200);
        $('#table-student-mark').css('left', 200);
        $('#table-student-mark').width($(window).width()-sW);
    };

    // середній бал для кожного студента
    function averadgeStudentMark() {
        $('#table-student-mark tbody tr').each(function () {
            var i,
                tr = $(this),
                lastTd,
                averadge = [],
                sum = 0,
                n = 0;

            $('td', tr).each(function () {
                averadge.push($(this).text());
                lastTd = $(this);
            });
            averadge.pop();
            for (i = 0; i < averadge.length; i++){
                if ( parseInt(averadge[i]) ){
                    sum += parseInt(averadge[i]);
                    n++;
                }
            }
            if(n != 0)
                sum = Math.round((sum/n) * 10) / 10;
            else
                sum ='.';
            lastTd.html('<strong>' + sum + '</strong>');
        });
    };


/** Загрузка документа ========================================================================= */

    // загрузка документа
    $(document).ready(function() {
        //змінюємо позицію 'footer' (роблю так бо незнаю як краще ...)
        $('#main-journal').height($('#table-student-list').height()+60);
        //змінюємо ширину таблиці при загрузці
        tableMarkWidth();
        //заносимо основін дані до обєкта - journal
        journal['teacher'] =$('#table-mark').attr('data-id-teacher');
        journal['group'] =$('#table-mark').attr('data-id-group');
        journal['subject'] =$('#table-mark').attr('data-id-subject');

        // список дат на момент загрузки
        createListJournalDate();

        // визначаємо тип браузера
        var isMobile = {
            Android: function() {return navigator.userAgent.match(/Android/i);},
            BlackBerry: function() {return navigator.userAgent.match(/BlackBerry/i);},
            iOS: function() {return navigator.userAgent.match(/iPhone|iPad|iPod/i);},
            Opera: function() {return navigator.userAgent.match(/Opera Mini/i);},
            Windows: function() {return navigator.userAgent.match(/IEMobile/i);},
            any: function() {
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
            }
        };
        if(isMobile.any()){
            shortStudentList();
        };
        // середня оцінка для кожного студента
        averadgeStudentMark();

        // виділяємо стилями різні типи оцінок, якщо "1, 2" або "н"
        $('#table-mark tbody td').each(function () {
            if (this.getAttribute('data-id-teacher')) {
                if ($(this).text() == 'н') this.className = 'm-table-nb';
                if ( (parseInt($(this).text()) < 3) || (this.getAttribute('data-remark') == '2') ) this.className = 'm-table-mark2';
                if (this.getAttribute('data-remark') == '1') this.className = 'm-table-nb-n';
            }
        });

    });



/** Додати нову дату до таблиці ================================================================ */

    // відкриваємо вікно додавання нової дати
    $('#add-new-date').click(function () {
        $('#box-add-new-date').show(100);

        // встановити поточну дату в поле вибору дат
        var d = new Date();
        $('#add-new-date-input').val(yyyymmdd(d));
    });

    // відмінити і закрити вікно додавання дати
    $("#add-new-date-cancel").click(function(){
        $('#box-add-new-date').hide(100);
    });
    $('#add-new-date-cancel-attention').click(function () {
        $('#box-add-new-date').hide(100);
    });

    //додати новий стовбчик до таблиці
    function addNewColumnToTable() {
        var n_rows = markTable.rows.length,
            n_cells = markTable.rows[0].cells.length;
        var table_student = document.getElementById('table-list');
        var idS;

        var i = journal.date.split('-');
        var tSelect = document.getElementById("add-new-lesson-input");

        // добавляємо нову дату в заголовок з відповідними атрибутами
        markTable.rows[0].insertCell(n_cells-1);
        markTable.rows[0].cells[n_cells-1].outerHTML =
            "<th class='text-center m-table-type-"+ journal.type +"' " +
            "data-lesson-type='" + journal.type +
            "' data-date='" + journal.date +
            "' data-lesson-number='" + journal.number +
            "' title='" + tSelect.options[ tSelect.selectedIndex ].innerHTML + "' >" +
            "<span class='m-table-h-day'>" + i[2] + "</span><br>"+
            "<span class='m-table-h-month'>" + i[1] + "</span><br>"+
            "<span class='m-table-stud-count'>" + n_cells + "</span></th>";

        // додати стовбчики до таблиці
        for(i = 1; i < n_rows; i++){
            if( n_cells <= 1 )
                // якщо стовбчиків ще немає то беремо дані з таблиці "список студентів"
                idS = table_student.rows[i].cells[1].getAttribute('data-id-student');
            else
                idS = markTable.rows[i].cells[n_cells-2].getAttribute('data-id-student');

            markTable.rows[i].insertCell(n_cells-1);
            markTable.rows[i].cells[n_cells-1].innerHTML = '';
            markTable.rows[i].cells[n_cells-1].setAttribute("data-id-teacher", journal.teacher);
            markTable.rows[i].cells[n_cells-1].setAttribute("data-id-subject", journal.subject);
            markTable.rows[i].cells[n_cells-1].setAttribute("data-id-group", journal.group);
            markTable.rows[i].cells[n_cells-1].setAttribute("data-id-student", idS);
            markTable.rows[i].cells[n_cells-1].setAttribute("data-id-lesson-type", journal.type);
            markTable.rows[i].cells[n_cells-1].setAttribute("data-lesson-number", journal.number);
            markTable.rows[i].cells[n_cells-1].setAttribute("data-mark", '');
            markTable.rows[i].cells[n_cells-1].setAttribute("data-date", journal.date);
        };
        // обновляємо список присутніх дат в таблиці
        createListJournalDate();
        // обновляємо кількість стовбців в таблиці
        tableCellPosition.nCell = markTable.rows[0].cells.length;
    };

    // додавання нової дати до таблиці журналу
    $('#add-new-date-ok').click(function () {
        var i;
        //var tSelect = document.getElementById("add-new-lesson-input");


        $('#box-add-new-date').hide(100);
        var newDateInTable = $('#add-new-date-input').val(),
            newLessonNumber = 1,
            newLessonType = $('#add-new-lesson-input').val();

        if( newDateInTable == '' ) return;
        //if(!confirm("Ви дійсно бажаєте дотати '"+ tSelect.options[ tSelect.selectedIndex ].innerHTML + "', дата: " + newDateInTable)) return;

        // первіряємо які дати присутні, якщо прара є то збільшуємо кількість на "1"
        for (i = 0; i < listJournalLesson.length; i++) {
            if( newDateInTable == listJournalLesson[i][0] && newLessonType == listJournalLesson[i][1] ){
                newLessonNumber = Number(listJournalLesson[i][2]) + Number(1);
            }
        };

        journal.type = newLessonType;
        journal.number = newLessonNumber;
        journal.date = newDateInTable;
        journal.action = 'addColumnToTable';

        // зберігаємо інформацію в базі даних
        sendDataToServer('addNewColumnToTable');
    });

    // показати дату (що додається до журналу)
    $('#add-new-date-attendion').click(function () {
        var d = new Date($('#add-new-date-input').val()),
        month =['01','02','03','04','05','06','07','08','09','10','11','12'];

        // якщо дата неправильна то зупиняємо введення
        if ( isNaN(d.getTime()) ) $(this).attr('data-toggle', '');
            else $(this).attr('data-toggle', 'modal');

        var tSelect = document.getElementById("add-new-lesson-input");
        $('#add-new-lesson-display').html(tSelect.options[ tSelect.selectedIndex ].innerHTML);
        $('#add-new-date-display').html(d.getDate() +'-'+ month[d.getMonth()] +'-'+ d.getFullYear());
    });



    // змінити дату
    $('#table-mark thead th').dblclick(function () {
        $('#change-date-setup').val($(this).attr('data-date'));
        changeDate = {
            'oldDate': $(this).attr('data-date'),
            'newDate': '',
            'lessonType': $(this).attr('data-lesson-type'),
            'lessonNumber': $(this).attr('data-lesson-number'),
            'lessonNumberNew': 1,
            'th': this
        };
        var d = changeDate.oldDate.split('-');
        $('#change-date-display').html(d[2]+'-'+d[1]+'-'+d[0]);
        $('#change-date').modal('show');
    });
    $('#change-date-ok').click(function () {
        // нове значення дати
        changeDate.newDate = $('#change-date-setup').val();
        if (changeDate.newDate == '')
            $('#change-date-error').html(' Введіть дату.');
        else if (changeDate.oldDate != changeDate.newDate && changeDate.newDate.indexOf('-') > 0) {
            var d = new Date(changeDate.newDate);
            if ( Object.prototype.toString.call(d) === "[object Date]" ) {
                // it is a date
                if ( isNaN( d.getTime() ) ) {  // d.valueOf() could also work
                    // date is not valid
                    $('#change-date-error').html(' Дата не коректна.');
                }
                else {
                    // date is valid
                    var n = 0;
                    for (var i=0; i < listJournalLesson.length; i++){
                        if (changeDate.newDate == listJournalLesson[i][0]
                            && changeDate.lessonType == listJournalLesson[i][1]) {
                            n++;
                        }
                    }
                    if (n > 0 ) changeDate.lessonNumberNew = n + 1;
                    else changeDate.lessonNumberNew = 1;

                    //відправляємо запит на сервер
                    var obj = {
                        'action': 'changeDate',
                        'teacher': journal.teacher,
                        'group': journal.group,
                        'subject': journal.subject,
                        'date': changeDate.oldDate,
                        'dateNew': changeDate.newDate,
                        'type': changeDate.lessonType,
                        'number': changeDate.lessonNumber,
                        'numberNew': changeDate.lessonNumberNew
                    };

                    $.get($('#main-journal').attr('data-url'), obj)
                        .done(function (data) {
                            // міняємо дані в заголовку
                            $(changeDate.th).attr('data-date', changeDate.newDate);
                            $(changeDate.th).attr('data-lesson-number', changeDate.lessonNumberNew);
                            var d = changeDate.newDate.split('-');
                            $('.m-table-h-day', changeDate.th).html(d[2]);
                            $('.m-table-h-month', changeDate.th).html(d[1]);
                            // міняємо дані по таблиці
                            var table = document.getElementById('table-mark'),
                                tbody = table.getElementsByTagName('tbody')[0],
                                tr = tbody.getElementsByTagName('tr');
                            for (var i =0; i < tr.length; i++ ){
                                tr[i].getElementsByTagName('td')[changeDate.th.cellIndex].setAttribute('data-date', changeDate.newDate);
                                tr[i].getElementsByTagName('td')[changeDate.th.cellIndex].setAttribute('data-lesson-number', changeDate.lessonNumberNew);
                            }
                            //
                            $('#change-date').modal('hide');
                            // показуємо повідомлення що надійшло з серевера
                            $('#table-headline-message').html(data);
                            $("#table-headline-message").show(0).delay(3000).hide(0);
                            createListJournalDate();
                        })
                        .fail(function() {
                            $('#table-headline-message').html("<span style='color: red;'>ПОМИЛКА!</span>");
                            $("#table-headline-message").show(0).delay(5000).hide(0);
                        });
                    /**/
                }
            }
            else {
                $('#change-date-error').html(' Дата не коректна.');
            }
        }
    });


/** Занесення оцінок =========================================================================== */

    // редагування клітинки
    function toEditCurrentCell() {
        var r = tableCellPosition.currentRow,  // поточний рядок
            c = tableCellPosition.currentCell; // поточна клітинка

        // включаємо режим редагування клітинки
        tableCellPosition.editCell = true;
        // запамятовуєм поточну клітинку 'тд' і елемент 'інпут'
        tableCellPosition.td = markTable.rows[r].cells[c];
        tableCellPosition.input = document.createElement("input");
        // змінюємо стиль поточної клітинки
        tableCellPosition.td.style.padding = '0px';
        tableCellPosition.td.style.position = 'relative';

        // запамятовуємо оцінку в клікинці
        tableCellPosition.mark = tableCellPosition.td.innerHTML;

        // додаємо елемент "інпут" до клітинки
        tableCellPosition.input.id = 'i-' + r +'-' + c;
        tableCellPosition.input.value = tableCellPosition.mark;
        tableCellPosition.input.style.position ='absolute';
        tableCellPosition.input.style.width = $(tableCellPosition.td).width()+'px';
        tableCellPosition.input.style.height = $(tableCellPosition.td).height()+'px';
        tableCellPosition.td.innerHTML ='';
        tableCellPosition.td.appendChild(tableCellPosition.input);
        tableCellPosition.input.focus();

        // назначаємо обробник подій на "інпут" при втраті фокуса
        $('#' + tableCellPosition.input.id).bind('focusout', exitEditCurrentCell);
        //$('#' + tableCellPosition.input.id).focusout(function(){ exitEditCurrentCell(); });
    };

    // введення оцінки в клітинку подвійним клацанням мишки
    $('#table-mark tbody').on('dblclick', '[data-mark]', function (e) {
        selectActiveCell('mouse', {c: e.target.cellIndex, r: this.parentNode.rowIndex});
        toEditCurrentCell();
    });

    // видаляємо 'інпут' і зберігаємо інформацію в таблиці і БД
    function exitEditCurrentCell(){
        var saveDb = false,
            str = tableCellPosition.input.value;

        // забираємо всі пропуки з рядка
        str = str.replace(/\s/g, '');
        str = str.toLowerCase();

        //
        function find(value) {
            var array = ['0','1','2','3','4','5','6','7','8','9','10','11','12','н', ''];
            value = value.toLowerCase();
            for (var i = 0; i < array.length; i++) {
                if (array[i] == value) return i;
            }
            return -1;
        }

        // відключаємо режим редагування
        tableCellPosition.editCell = false;

        // перевіряємо чи правильно введена оцінка
        if (find(str) > 0) {
            // якщо оцінка змінена то дозволяємо збереження
            if ( tableCellPosition.mark != str )
                saveDb = true;
            // якщо оцінка така сама то залишаємо цю оцінку
            tableCellPosition.mark = str;
        }

        // видалити методи встановлені на елемент 'інпут'
        $('#' + tableCellPosition.input.id).unbind('focusout', exitEditCurrentCell);
        // видалити - input
        tableCellPosition.td.removeChild(tableCellPosition.input);
        tableCellPosition.td.style.padding = '';
        tableCellPosition.td.style.position = '';

        // заносимо змінену оцінку до 'journal'
        journal.mark = tableCellPosition.mark;
        journal.date = tableCellPosition.td.getAttribute('data-date');
        journal.number = tableCellPosition.td.getAttribute('data-lesson-number');
        journal.student = tableCellPosition.td.getAttribute('data-id-student');
        journal.type = tableCellPosition.td.getAttribute('data-id-lesson-type');
        journal.action = 'addNewMark';

            // змінюємо стиль відображення оцінки якщо "1, 2" або "н"
            if ( journal.mark == 'н') tableCellPosition.td.classList.add('m-table-nb');
                else tableCellPosition.td.classList.remove('m-table-nb');
            // якщо "н" виправлено на позитивну оцінку
            if (tableCellPosition.td.getAttribute('data-remark') == '1') tableCellPosition.td.classList.add('m-table-nb-n');
                else tableCellPosition.td.classList.remove('m-table-nb-n');
            if ((parseInt(journal.mark) < 3) || (tableCellPosition.td.getAttribute('data-remark') == '2')) tableCellPosition.td.classList.add('m-table-mark2');
                else tableCellPosition.td.classList.remove('m-table-mark2');

                //l(tableCellPosition.td.getAttribute('data-remark'));

        //заносимо оцінку до таблиці
        tableCellPosition.td.innerHTML = journal.mark;

        //якщо оцінка змінена то збарігаємо
        if(saveDb) {
            // зберігаємо інформацію в базі даних
            sendDataToServer('addNewMark');
            // перераховуємо середні оцінки
            averadgeStudentMark();
        }
    };


/** Рух по таблиці ============================================================================= */

    // пізіціонування клітинки мишкою
    $('#table-mark tbody').on('click', '[data-mark]', function (e) {
        selectActiveCell('mouse', {c: e.target.cellIndex, r: this.parentNode.rowIndex});
    });

    // змінюємо поточну позицію курсора на таблиці
    function selectActiveCell(direction, step) {
        if (!tableCellPosition.editCell) {
            markTable.rows[tableCellPosition.currentRow].cells[tableCellPosition.currentCell].classList.remove('m-table-active-cell');
            switch (direction) {
                case 'ud':
                    if ((tableCellPosition.currentRow + step < tableCellPosition.nRow) &&
                        (tableCellPosition.currentRow + step >= 1)) {
                        tableCellPosition.currentRow += step;
                    }
                    break;
                case 'lr':
                    if ((tableCellPosition.currentCell + step < tableCellPosition.nCell - 1) &&
                        (tableCellPosition.currentCell + step >= 0)) {
                        tableCellPosition.currentCell += step;
                    }
                    break;
                case 'mouse':
                    tableCellPosition.currentRow = step.r;
                    tableCellPosition.currentCell = step.c;
                    break;
            }
            markTable.rows[tableCellPosition.currentRow].cells[tableCellPosition.currentCell].classList.add('m-table-active-cell');
        }
    };

    // переміщення по таблиці за допомогою клавіатури
    $(window).on('keydown', function(ev) {
        if (tableCellPosition.editCell == false) {
            if (ev.keyCode == '37') { //left
                selectActiveCell('lr', -1);
            }
            if (ev.keyCode == '39') { // right
                selectActiveCell('lr', 1);
            }
            if (ev.keyCode == '38') { // up
                selectActiveCell('ud', -1);
            }
            if (ev.keyCode == '40') { // down
                selectActiveCell('ud', 1);
            }
        }
        if (ev.keyCode == '13') { // enter
            if( listJournalLesson.length > 0 ){
                if( !tableCellPosition.editCell ){
                    toEditCurrentCell();
                    return;
                }
                if( tableCellPosition.editCell ){
                    exitEditCurrentCell();
                    return;
                }
            }
        }
    });

})();