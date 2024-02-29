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
        columnDefs : [{
            targets: [1, 2],
            render: function (data, type, row) {
                if ((type === 'display' || type === 'filter') && data != '-') {
                    return new Date(data).toLocaleDateString('en-GB');
                }
                return data;
            }
        }],
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
