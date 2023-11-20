@extends('layouts.users')

@section('content')
<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);">
        <a>Laporan</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Omset</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>{{ $tahun }}</a>
    </header>
    <section id="laporan-omset">
        <div class="card">
            <div class="card-body">
                <h4>Laporan Omset {{ $tahun }}</h4>
                <hr>
                <div id="chartContainer" class="w-100" style="height: 300px;"></div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        var laporan = @json($laporan);
        var laporanData = laporan.map(element => element[0]);
        for (let index = 0; index < laporanData.length; index++) {
            if (typeof laporanData[index] === "undefined") {
                laporanData[index] = {};
                laporanData[index].Deposit = 0;
                laporanData[index].Tunai = 0;
                laporanData[index].Qris = 0;
                laporanData[index].Debit = 0;
                laporanData[index].Transfer = 0;
            } else {
                let temp = {};
                temp.Deposit = laporanData[index].deposit != null ? parseInt(laporanData[index].deposit) : 0;
                temp.Tunai = laporanData[index].tunai != null ? parseInt(laporanData[index].tunai) : 0;
                temp.Qris = laporanData[index].debit != null ? parseInt(laporanData[index].debit) : 0;
                temp.Debit = laporanData[index].debit != null ? parseInt(laporanData[index].debit) : 0;
                temp.Transfer = laporanData[index].transfer != null ? parseInt(laporanData[index].transfer) : 0;
                laporanData[index] = temp;
            }
        }

        var seriesNames = ['Deposit', 'Tunai', 'Qris', 'Debit', 'Transfer'];
        var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        var seriesData = seriesNames.map(seriesName => {
            let i = 0;
            return {
                type: "stackedColumn",
                name: seriesName,
                showInLegend: true,
                yValueFormatString: "#,##0",
                dataPoints: laporanData.map(element => ({
                    y: element[seriesName],
                    label: monthNames[i++]
                }))
            };
        });

        var options = {
            animationEnabled: true,
            title: {
                text: "2023"
            },
            toolTip: {
                shared: true,
                reversed: true
            },
            data: seriesData
        };

        $('#chartContainer').CanvasJSChart(options);
    });
</script>
@endsection
