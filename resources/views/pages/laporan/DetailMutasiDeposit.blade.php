@extends('layouts.users')

@section('content')
@include('includes.library.datatables')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);">
        <a>Laporan</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Mutasi Deposit</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>{{ $pelanggan->nama }}</a>
    </header>
    <section id="data-laporan">
        <div class="card">
            <div class="card-body">
                <h4>Laporan Mutasi Deposit {{ $pelanggan->nama }}</h4>
                <hr>

                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <h4>Filter</h4>
                        <input id="filter-bulan" class="form-control ms-3" type="month" style="width: 200px;">
                        <input id="filter-tahun" class="form-control ms-3" type="number" style="width: 200px;" min=2000 step=1 placeholder="Tahun">
                    </div>
                    <i id="loading-icon" class="fa-solid fa-spinner fa-spin-pulse fs-4" style="display: none;"></i>
                </div>

                <div id="container-history-saldo" class="mt-3"></div>
                <input id="pelanggan-id" type="hidden" value="{{ $pelanggan->id }}">
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        var searchData;
        $('#filter-bulan').on('change', function() {
            clearTimeout(searchData);
            $('#loading-icon').show();
            $('#filter-tahun').val('');
            searchData = setTimeout(searchByMonth, 2000);
        });

        $('#filter-tahun').on('change', function() {
            clearTimeout(searchData);
            $('#loading-icon').show();
            $('#filter-bulan').val('');
            searchData = setTimeout(searchByYear, 2000);
        });

        function searchByMonth() {
            let date = $('#filter-bulan').val().split('-');
            let year = date[0];
            let month = date[1];

            $('#container-history-saldo').load(window.location.origin + '/pelanggan/' + $('#pelanggan-id').val() + '/history/saldo?month=' + month + '&year=' + year + '&order=asc', function() {
                $('#loading-icon').hide();
                $("#table-history-saldo").dataTable({
                    columnDefs: [
                        {
                            targets: [0],
                            type: 'date-custom'
                        }
                    ]
                });

                jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                    'date-custom-pre': function (a) {
                        var dateParts = a.split('-');
                        return Date.UTC(parseInt(dateParts[0], 10), parseInt(dateParts[1], 10) - 1, parseInt(dateParts[2], 10));
                    },
                    'date-custom-asc': function (a, b) {
                        return a - b;
                    },
                    'date-custom-desc': function (a, b) {
                        return b - a;
                    }
                });
            });
        };

        function searchByYear() {
            let year = $('#filter-tahun').val();

            $('#container-history-saldo').load(window.location.origin + '/pelanggan/' + $('#pelanggan-id').val() + '/history/saldo?year=' + year + '&order=asc', function() {
                $('#loading-icon').hide();
                $("#table-history-saldo").dataTable({
                    columnDefs: [
                        {
                            targets: [0],
                            type: 'date-custom'
                        }
                    ]
                });

                jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                    'date-custom-pre': function (a) {
                        var dateParts = a.split('-');
                        return Date.UTC(parseInt(dateParts[0], 10), parseInt(dateParts[1], 10) - 1, parseInt(dateParts[2], 10));
                    },
                    'date-custom-asc': function (a, b) {
                        return a - b;
                    },
                    'date-custom-desc': function (a, b) {
                        return b - a;
                    }
                });
            });
        };
    });
</script>
@endsection
