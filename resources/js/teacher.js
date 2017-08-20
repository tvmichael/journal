;(function () {
    function l(s){ console.log(s);}
    l('START-TEACHER-JOURNAL')

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
    var markTable = document.getElementById('table-mark');

    var listJournalLesson = Array(); // список номерів пар і їхніх дат в таблиці

    var tableCellPosition = {
        currentRow: 1,
        currentCell: 0,
        nRow: markTable.rows.length,
        nCell: markTable.rows[0].cells.length,
        editCell: false,
        mark: '',
        td: '',
        input: ''
    };



/** ============================================================================================ */
    // змінюємо розмір таблиці оцінок відповідно до розмірів вікна
    function tableMarkWidth() {
        $('#table-student-mark').width($(window).width()-340);
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
                // додати новий стовпець
                if ( task == 'addNewColumnToTable') addNewColumnToTable();

                $('#table-headline-message').html(data);
                $("#table-headline-message").show(0).delay(5000).hide(0);
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

        // встановити поточну дату в поле вибору дат
        var d = new Date();
        $('#add-new-date-input').val(yyyymmdd(d));
    });

    // відмінити і закрити вікно додавання дати
    $("#add-new-date-cancel").click(function(){
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
                idS = table_student.rows[i].cells[0].getAttribute('data-id-student');
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
            markTable.rows[i].cells[n_cells-1].setAttribute("data-mark", "");
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
        var tSelect = document.getElementById("add-new-lesson-input");

        $('#box-add-new-date').hide(100);
        var newDateInTable = $('#add-new-date-input').val(),
            newLessonNumber = 1,
            newLessonType = $('#add-new-lesson-input').val();

        if( newDateInTable == '' ) return;
        if(!confirm("Ви дійсно бажаєте дотати '"+ tSelect.options[ tSelect.selectedIndex ].innerHTML + "', дата: " + newDateInTable)) return;

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



/** Занесення оцінок =========================================================================== */

    // редагування клітинки
    function toEditCurrentCell() {
        var r = tableCellPosition.currentRow,
            c = tableCellPosition.currentCell;

        // включаємо режим редагування клітинки
        tableCellPosition.editCell = true;
        // запамятовуєм поточну клітинку 'тд' і елемент 'інпут'
        tableCellPosition.td = markTable.rows[r].cells[c];
        tableCellPosition.input = document.createElement("input");
        // змінюємо стиль поточної клітинки
        tableCellPosition.td.style.padding = '0px';
        tableCellPosition.td.style.position = 'relative';

        // додаємо елемент "інпут" до клітинки
        tableCellPosition.mark = tableCellPosition.td.innerHTML;
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

    // пізіціонування клітинки мишкою
    $('#table-mark tbody').on('click', '[data-mark]', function (e) {
        selectActiveCell('mouse', {c: e.target.cellIndex, r: this.parentNode.rowIndex});
    });

    // видаляємо 'інпут' і зберігаємо інформацію в таблиці і БД
    function exitEditCurrentCell(){
        function find(value) {
            var array = ['0','1','2','3','4','5','6','7','8','9','10','11','12','н'];
            value = value.toLowerCase();
            for (var i = 0; i < array.length; i++) {
                if (array[i] == value) return i;
            }
            return -1;
        }

        // відключаємо режим редагування
        tableCellPosition.editCell = false;

        // перевіряємо чи правильно введена оцінка
        if (find(tableCellPosition.input.value) > 0)
            tableCellPosition.mark = tableCellPosition.input.value.toLowerCase();

        // видалити 'інпут'
        $('#' + tableCellPosition.input.id).unbind('focusout', exitEditCurrentCell);
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
        tableCellPosition.td.innerHTML = journal.mark;

        // зберігаємо інформацію в базі даних
        sendDataToServer('addNewMark');
        l(journal);
    };

    // змінюємо поточну позицію курсора на таблиці
    function selectActiveCell(direction, step) {
        if (!tableCellPosition.editCell) {
            markTable.rows[tableCellPosition.currentRow].cells[tableCellPosition.currentCell].className = '';
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
            markTable.rows[tableCellPosition.currentRow].cells[tableCellPosition.currentCell].className = 'm-table-active-cell';
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
            if( !tableCellPosition.editCell ){
                toEditCurrentCell();
                return;
            }
            if( tableCellPosition.editCell ){
                exitEditCurrentCell();
                return;
            }
        };
    });
    
    
    






})();