$(document).ready(function() {
    if ($('#table-pengeluaran tbody').children().length == 0) {
        $('#table-pengeluaran tbody').append('<tr><td colspan=7 class="text-center">Data masih kosong</td></tr>');
    }

    if($('#list-action').children().length == 0) {
        $('#list-action').detach();
    }

    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const startDate = urlParams.get('start');
    const endDate = urlParams.get('end');
    const searchQuery = urlParams.get('search');

    // Set input values from URL parameters if they exist
    if (startDate) $('#input-tanggal-awal').val(startDate);
    if (endDate) $('#input-tanggal-akhir').val(endDate);
    if (searchQuery) $('#input-search').val(searchQuery);

    // Apply filter function
    function applyFilter() {
        const startDate = $('#input-tanggal-awal').val();
        const endDate = $('#input-tanggal-akhir').val();
        const searchQuery = $('#input-search').val();

        let url = window.location.pathname + '?';
        if (startDate) url += `start=${startDate}&`;
        if (endDate) url += `end=${endDate}&`;
        if (searchQuery) url += `search=${searchQuery}`;

        window.location.href = url;
    }

    // Apply filter on button click
    $('#btn-apply-filter').on('click', function() {
        applyFilter();
    });

    // Apply filter on enter key in search input
    $('#input-search').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            applyFilter();
        }
    });

    // Handle export button click
    $('#btn-export').on('click', function() {
        const startDate = $('#input-tanggal-awal').val();
        const endDate = $('#input-tanggal-akhir').val();
        const searchQuery = $('#input-search').val();

        let url = '/laporan/pengeluaran/export?';
        if (startDate) url += `start=${startDate}&`;
        if (endDate) url += `end=${endDate}&`;
        if (searchQuery) url += `search=${searchQuery}`;

        window.location.href = url;
    });

    var btnIndex = -1, btnId = 0;
    $('#table-pengeluaran .btn').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });
});
