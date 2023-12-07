$(document).ready(function() {
    var btnIndex = -1, btnId = 0;
    $('.btn-show-action').on('click', '', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    $('#action-detail').on('click', function() {
        window.location = window.location + '/' + btnId + '/detail';
    });

    $('#table-laporan').dataTable({
        order: [[0, 'asc']],
        columns: [
            null,
            null,
            null,
            null,
            { orderable: false }
        ]
    });
});
