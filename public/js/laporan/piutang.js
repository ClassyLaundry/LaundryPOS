$(document).ready(function() {
    var btnIndex = -1, btnId = 0;
    $('#data-piutang').on('click', '.btn-show-action', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    // $('#table-piutang').load(window.location.origin + '/component/laporan/piutang');

    // function search() {
    //     $('#table-piutang').load(window.location.origin + '/component/jenis-item?key=' + encodeURIComponent($('#input-search').val()) +'&paginate=' + paginateCount, function() {
    //         setThousandSeparator();
    //     });
    // }

});
