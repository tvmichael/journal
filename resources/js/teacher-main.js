function l(s){ console.log(s);} l('START-TEACHER-MAIN');

var mainJournal = document.getElementById('main-journal'),
    dataUrl = mainJournal.getAttribute('data-url'),
    dataAjax = mainJournal.getAttribute('data-ajax');

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
            +"</tr>"
            + "</thead>";
            + "<body>";
    var tr = '';
    for (var i=0; i < listGT.length; i++){
        // course fullname groupe id_group id_subject id_teacher shortname subgroup
        tr = tr
            + "<tr>"
            + "<td>" + (i+1) + "</td>"
            + "<td>" + listGT[i]['course'] + "</td>"
            + "<td>"+ listGT[i]['groupe'] +"</td>"
            + "<td>"+ listGT[i]['subgroup'] +"</td>"
            + "<td>"+ listGT[i]['fullname'] +"</td>"
            + "<td>"
            + "<a href='" + dataUrl
            +"?teacher=" + listGT[i]['id_teacher'] + "&group=" + listGT[i]['id_group'] + "&subject=" + listGT[i]['id_subject']
            +"'>" + "Відкрити сторніку журнала" + "</a>"
            +"</td>"
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
    for (var i=0; i < listGT.length; i++){
        block = block
            +"<div class='col-sm-6 col-lg-4'>"
                + "<a href='" + dataUrl
                +"?teacher=" + listGT[i]['id_teacher'] + "&group=" + listGT[i]['id_group'] + "&subject=" + listGT[i]['id_subject']
                +"' style='text-decoration: none;'>"
                +"<div id='list-group-teacher'>"
                    +"<h5 class='m-course-name"
                    +" list-group-teacher-" + sb1234(listGT[i]['subgroup'])
                    +"'>" + listGT[i]['course']
                    +"</h5>"
                    +"<h3 class='m-group-name'>" + listGT[i]['groupe'] + "</h3>"
                    +"<p class='m-subgroup-name'>" + listGT[i]['subgroup'] + "</p>"
                    +"<p class='m-fullname-name'>" + listGT[i]['fullname'] + "</p>"
                +"</div>"
                +"</a>"
            +"</div>";
    }
    container.innerHTML = block;
}

// відобразити таблицю
if (settings.view == 1) { blockView(); }
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
    $.get( dataAjax, { action: "settingsView", view: settings.view } )
        .done(function( data ) {
            l(data);
        });
}


// сортуємо масив за вказаним полем
function sotrArray(fild, direction) {
    function compare(a,b) {
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

//
$('button[data-sort]').click(function () {
    sotrArray($(this).attr('data-sort'), $(this).attr('data-direction'));
    if ($(this).attr('data-direction') == '0' ) $(this).attr('data-direction', '1');
        else $(this).attr('data-direction', '0');
    if (settings.view == 1) { blockView(); }
        else tableView();
});