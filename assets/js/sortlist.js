function filterText() {
    var rex = new RegExp($('#filterText').val());
    if (rex == "/all/") {
        clearFilter()
    } else {
        $('.content').hide();
        $('.content').filter(
            function() {
                return rex.test($(this).text());
            }
        ).show();
    }
}

function clearFilter() {
    $('.filterText').val('');
    $('.content').show();
}

function refreshTable() {
    var urlactive = '/admin/getTable.php?sort=' + sort + '&sortdirection=' + sortdirection;
    var urlinactive = '/admin/getTable2.php?sort=' + sort + '&sortdirection=' + sortdirection;

    $('#holderTable').load(urlactive,
        function() {
            filterText();
            doScroll(0);
        }
    );

    $('#holderTable2').load('/admin/getTable2.php', function() { setTimeout(refreshTable, 10000); });
    $('#holderTable2').load('/admin/getTable2.php', function() { /*setTimeout(refreshTable, 10000);*/ });
}