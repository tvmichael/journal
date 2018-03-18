function l(s){ console.log(s);} l('START-STUDENT-MAIN');

var namePage = document.getElementsByTagName('main')[0].getAttribute("data-name");

if(namePage == 'main-student')
{
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
}


if(namePage == 'main-student-rating')
{
    l(data_journal);

    function dataJournalDraw (divN, studentsList, journalsList)
    {
        var i, j, n, k, count;
        var averageBall = Array();

        n = studentsList.length;
        k = journalsList.length;
        for (i = 0; i < n; i++){
            averageBall[i] = 1;
            count = 1;

            for(j = 0; j < k; j++){

                //l(studentsList[i]['surname'] +': '+ j + ' == ' + journalsList[j]['mark']);

                if (studentsList[i]['id'] == journalsList[j]['id_student']){
                    if ( Number(journalsList[j]['mark']) ){
                        if (Number(journalsList[j]['mark'])) {
                            averageBall[i] = averageBall[i] + Number(journalsList[j]['mark']);
                            count++;
                        }
                    }
                }
            }
            averageBall[i] = averageBall[i]/count;
            averageBall[i] = averageBall[i].toFixed(1);
            //l(studentsList[i]['surname'] + ': ' + averageBall[i]);
        }

        // GOOGLE
        google.charts.load("current", {packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var sb = Array();

            sb[0]  = ["Студент", "Середній бал", { role: "style" } ];
            n = studentsList.length;
            for (i = 0; i < n; i++ ){
                sb[i+1] = [studentsList[i]['surname'] + ' ' + studentsList[i]['name'] , Number(averageBall[i]), "#C3CBC2"];
            }

            var data = google.visualization.arrayToDataTable(sb);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                2]);

            var options = {
                title: "Успішність студентів",
                width: window.innerWidth - 120,
                height: window.innerHeight - 100,
                bar: {groupWidth: "95%"},
                legend: { position: "none" },
            };

            var chart = new google.visualization.ColumnChart(document.getElementById("group-content_"+divN));
            chart.draw(view, options);
        }
    }

    for (var i = 0; i < data_journal.length; i++)
        dataJournalDraw(data_journal[i][0], data_journal[i][1], data_journal[i][2]);

}