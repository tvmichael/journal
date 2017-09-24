function l(s) { console.log(s)} l('Inspector start!');

// Пошук викладача за прізвищем
$('#input-search-teacher').keyup(function () {
    var filter, table, tbody, tr, td, i;
    filter = $(this).val();
    table = document.getElementsByTagName('table')[0];
    tbody = table.getElementsByTagName('tbody')[0];
    tr = tbody.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            if (td.innerHTML.toLowerCase().indexOf(filter.toLowerCase()) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
});

/*
// Відкрити викладача
$('table tbody tr').click(function () {
    //var main = document.getElementById('inspector-main');
    //document.location.assign(main.getAttribute('data-url')+'teacher?action=openTeacher&id='+$(this).attr('data-id'));
    //document.location.href = main.getAttribute('data-url')+'teacher?action=openTeacher&id='+$(this).attr('data-id');
})
*/