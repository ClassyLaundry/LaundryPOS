$(document).ready(function () {
    const elements = {
        btn_customer: $('#button-customer'),
        btn_cuci: $('#button-cuci'),
        btn_omset: $('#button-omset'),
        btn_saldo: $('#button-saldo'),
        table_customer: $("#table-laporan-customer"),
        table_omset: $("#table-laporan-omset"),
        table_cuci: $("#table-laporan-cuci"),
        table_saldo: $("#table-laporan-saldo"),
        bef_harga: $('.before-harga'),
        jdl_lap: $('#judul-laporan'),
        tgl: $('.tanggal'),
        bln: $('#bulan'),
        btn_aply: $('#btn-apply-filter'),
        btn_excel: $('#btn-export-excel'),
        data_search_page: null,
    };
    elements.btn_customer.hide();
    elements.btn_cuci.hide();
    elements.btn_omset.hide();
    elements.btn_saldo.hide();
    elements.bln.hide();
    elements.tgl.hide();
    elements.btn_aply.hide();
    elements.btn_excel.hide();


    $('.filter-search').on('click', function () {
        elements.data_search_page = $(this).data('search');

        $('.filter-search').removeClass('active');
        $(this).addClass('active');
        fetchData();

        if (elements.data_search_page === 'data-pelanggan') {
            elements.btn_cuci.hide();
            elements.btn_saldo.hide();
            elements.btn_omset.hide();
            elements.btn_customer.show();
            elements.tgl.show();
            elements.bln.hide();
            elements.btn_aply.show();
            elements.btn_excel.show();
            elements.jdl_lap.text('Laporan Pelanggan')
        } else if (elements.data_search_page === 'data-cuci') {
            elements.btn_customer.hide();
            elements.btn_omset.hide();
            elements.btn_saldo.hide();
            elements.btn_cuci.show();
            elements.btn_aply.show();
            elements.tgl.show();
            elements.bln.hide();
            elements.btn_excel.show();
            elements.jdl_lap.text('Laporan Cuci');
        }
        else if (elements.data_search_page === 'data-omset') {
            elements.btn_cuci.hide();
            elements.btn_saldo.hide();
            elements.btn_customer.hide();
            elements.btn_omset.show();
            elements.btn_aply.show();
            elements.bln.show();
            elements.btn_excel.show();
            elements.tgl.hide();
            elements.jdl_lap.text('Laporan Omset');
        }
        else if (elements.data_search_page === 'data-saldo') {
            elements.btn_cuci.hide();
            elements.btn_customer.hide();
            elements.btn_omset.hide();
            elements.btn_saldo.show();
            elements.btn_aply.show();
            elements.bln.show();
            elements.btn_excel.show();
            elements.tgl.hide();
            elements.jdl_lap.text('Laporan Saldo');
        }
    });

    $('#btn-apply-filter').on('click', function () {
        let jenis = '';
        let page = elements.data_search_page;
        let selectedOption = $('input[name="filterOption"]:checked').val();
        if (selectedOption) {
            jenis += selectedOption + ';';
        }
        // if ($('#btn-item').is(':checked')) {
        //     jenis += 'item;';
        // }
        // if ($('#btn-paket').is(':checked')) {
        //     jenis += 'paket;';
        // }
        if ($('#btn-omsetTerbesar').is(':checked')) {
            jenis += 'omsetTerbesar;';
        }
        if ($('#btn-omsetTerkecil').is(':checked')) {
            jenis += 'omsetTerkecil;';
        }
        if ($('#btn-saldoTerbesar').is(':checked')) {
            jenis += 'saldoTerbesar;';
        }
        if (jenis === '') {
            alert('Pilih tipe pembeli');
            return;
        }
        if (elements.data_search_page === 'data-omset' || elements.data_search_page === 'data-saldo') {
            $.get('/component/customer', {
                bulan: $('#bulanomset').val(),
                jenis: jenis,
                page: page
            }, function (data) {
                $('#table-container').html(data);
                if (elements.data_search_page === 'data-omset') {
                    elements.table_customer.hide();
                    elements.table_cuci.hide();
                    elements.table_omset.show();
                    elements.btn_omset.show();
                    elements.btn_cuci.hide();
                    elements.btn_aply.show();
                }
                else if (elements.data_search_page === 'data-saldo') {
                    elements.table_customer.hide();
                    elements.table_cuci.hide();
                    elements.table_saldo.show();
                    elements.btn_saldo.show();
                    elements.btn_aply.show();
                    elements.btn_cuci.hide();
                }
                $('#total-kas_masuk').text('Rp ' + $('#table-laporan').data('total'));
            }).fail(function () {
                alert('Terjadi kesalahan saat memuat data.');
            });
        }
        else {
            $.get('/component/customer', {
                start: $('#input-tanggal-awal').val(),
                end: $('#input-tanggal-akhir').val(),
                jenis: jenis,
                page: page
            }, function (data) {
                $('#table-container').html(data);
                if (page === 'data-cuci') {
                    elements.table_customer.hide();
                    elements.table_omset.hide();
                    elements.table_cuci.show();
                    elements.btn_cuci.show();
                    elements.btn_aply.show();
                }
                else if (page === 'data-pelanggan') {
                    elements.table_cuci.hide();
                    elements.table_omset.hide();
                    elements.table_customer.show();
                    elements.btn_customer.show();
                    elements.btn_aply.show();
                }
                else if (page === 'data-omset') {
                    elements.table_customer.hide();
                    elements.table_cuci.hide();
                    elements.table_omset.show();
                    elements.btn_omset.show();
                    elements.btn_cuci.hide();
                    elements.btn_aply.show();
                }
                else if (page === 'data-saldo') {
                    elements.table_customer.hide();
                    elements.table_cuci.hide();
                    elements.table_omset.hide();
                    elements.table_saldo.show();
                    elements.btn_saldo.show();
                    elements.btn_aply.show();
                    elements.btn_cuci.hide();
                }
                $('#total-kas_masuk').text('Rp ' + $('#table-laporan').data('total'));
            }).fail(function () {
                alert('Terjadi kesalahan saat memuat data.');
            });
        }
    });


    function fetchData() {
        let url;
        switch (elements.data_search_page) {
            case 'data-cuci':
                url = '/component/customer';
                break;
            case 'data-omset':
                url = '/component/customer';
                break;
            case 'data-pelanggan':
                url = '/component/customer';
                break;
            case 'data-saldo':
                url = '/component/customer';
                break;
            default:
                return;
        }

        $.ajax({
            url: url,
            type: 'GET',
            data: { search: elements.data_search_page },
            success: function (data) {
                $('#table-container').html(data);
                if (elements.data_search_page === 'data-pelanggan') {
                    elements.table_customer.show();
                    elements.table_cuci.hide();
                    elements.table_omset.hide();
                }
                else if (elements.data_search_page === 'data-cuci') {
                    elements.table_customer.hide();
                    elements.table_omset.hide();
                    elements.table_cuci.show();
                }
                else if (elements.data_search_page === 'data-omset') {
                    elements.table_customer.hide();
                    elements.table_omset.show();
                    elements.table_cuci.hide();
                }
            },
            error: function () {
                alert('Terjadi kesalahan saat memuat data table.');
            }
        });
    }
    $('#btn-export-excel').on('click', function () {
        let page = $('.filter-search.active').data('search');
        let startDate = $('#input-tanggal-awal').val();
        let endDate = $('#input-tanggal-akhir').val();
        let bulan = $('#bulanomset').val();
        let selectedOption = $('input[name="filterOption"]:checked').val();
        let jenis = '';

        if (selectedOption) {
            jenis += selectedOption + ';';
        }

        if ($('#btn-omsetTerbesar').is(':checked')) {
            jenis += 'omsetTerbesar;';
        }
        if ($('#btn-omsetTerkecil').is(':checked')) {
            jenis += 'omsetTerkecil;';
        }
        if ($('#btn-saldoTerbesar').is(':checked')) {
            jenis += 'saldoTerbesar;';
        }
        if ($('#btn-saldoTerkecil').is(':checked')) {
            jenis += 'saldoTerkecil;';
        }

        if(page === 'data-omset' || page === 'data-saldo')
        {
            window.location.href = `/export-excel?page=${page}&bulan=${bulan}&jenis=${jenis}`;
        }else{
            window.location.href = `/export-excel?page=${page}&start=${startDate}&end=${endDate}&jenis=${jenis}`;
        }
    });
});
