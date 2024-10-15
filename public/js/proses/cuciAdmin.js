$(document).ready(function() {
    var paginate = 5, page = 1, key = '', searchBy = 'kode', searchData;

    function search() {
        $('#table-cuci-admin').load(window.location.origin + '/component/admin/cuci?search=' + searchBy + '&key=' + encodeURIComponent(key) + '&paginate=' + paginate + '&page=' + page);
    }

    search();

    $('#table-cuci-admin').on('click', '.page-link', function(e) {
        e.preventDefault();
        page = $(this).attr('href').split('page=')[1];
        search();
    });

    $(".filter-search").on('click', function() {
        searchBy = $(this).data('search');
        $(".filter-search").each(function(index, element) {
            $(element).removeClass('active');
        });
        $(this).addClass('active');
        search();
    });

    $(".filter-paginate").on('click', function() {
        paginate = parseInt($(this).data('paginate'));
        $(".filter-paginate").each(function(index, element) {
            $(element).removeClass('active');
        });
        $(this).addClass('active');
        search();
    });

    $('#input-search').on('input', function() {
        key = $(this).val();
        clearTimeout(searchData);
        searchData = setTimeout(search, 1000);
    });
});
