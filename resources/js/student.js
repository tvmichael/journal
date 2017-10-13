function l(s){ console.log(s);} l('START-STUDENT-MAIN');

var i, j, tr, td, th, table = '',
    fullname ='', name ='', surname ='',
    d, sBal, nb, k,
    subject = [],
    studentData = document.getElementById('student-data');

// сортуємо масив за датами
journal.sort(function (a, b) {
    return a['date'] < b['date'] ? -1 : a['date'] > b['date'] ? 1 : 0;
});

// виділяємо унікальні предмети з масиву
function uniqueArray(arr, key) {
    var a = [];
    for (var i=0, l=arr.length; i < l; i++)
        if (a.indexOf(arr[i][key]) === -1 && arr[i][key] !== '')
            a.push(arr[i][key]);
    return a;
}
subject = uniqueArray(journal, 'id_subject');

// таблиця для кожного предмету
for (i = 0; i < subject.length; i++){
    th = '';
    td = '';
    nb = 0;     // кількість 'н'
    sBal = 0;   // середній бал по предмету
    k = 0;      // кількість оцінок
    for (j=0; j < journal.length; j++){
        if(subject[i] == journal[j]['id_subject']){

            d = journal[j].date.split('-');
            if (journal[j].mark == 'н') nb++;
                else if (journal[j].mark != "") {
                    sBal = sBal + parseInt(journal[j].mark);
                    k++;
                }
            th = th
                + "<th class='text-center'>"
                + "<span>" + d[2] + "</span><br><span class='m-month'>" + d[1] + '</span>'
                + "</th>";
            td = td
                + "<td class='text-center'>"
                + journal[j].mark
                + "</td>";
            //l(journal[j]);
            fullname = journal[j].fullname;
            name = journal[j].name != null ? journal[j].name : '';
            surname = journal[j].surname;
        }
    }
    if (nb == 0) nb = '';
    if (sBal == 0) sBal = '';
    if (k != 0) {
        sBal =  sBal/k;
        sBal = sBal.toFixed(1);
    };
    th ="<th class='m-data-column'>Дата</th>"
        +"<th class='m-data-column'>с.б.</th>"
        +"<th class='m-data-column'>н</th>" + th;
    td ="<td>Оцінка</td><td><b>"+ sBal +"</b></td><td><b>"+ nb +"</b></td>" + td;

    table = table
        + "<h4>"
        + "<span class='label label-primary'>" + fullname + "</span> "
        + "<span class='label label-default'>" + surname + ' '+ name + "</span>"
        + "</h4>"
        +"<div class='m-journal-table'><table class='table table-bordered'>"
        +"<thead><tr class='m-th-bg'>" + th + '</tr></thead>'
        +'<tbody><tr>' + td + '</tr></tbody>'
        +'</table></div><br>';
    l('----------------------------------------------');
} //
studentData.innerHTML = table;


//l(subject);
//l(journal);