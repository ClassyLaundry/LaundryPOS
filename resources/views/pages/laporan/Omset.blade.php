@extends('layouts.users')

@section('content')
<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);">
        <a>Laporan</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Omset</a>
    </header>
    <section id="laporan-omset">
        <div class="card">
            <div class="card-body">
                <h4>Laporan Omset</h4>
                <hr>

                <div class="row">
                    @foreach ($laporan as $data)
                        <div class="col-xl-4 col-lg-6 col-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="w-100 chartContainer" style="height: 300px;"></div>
                                    <button class="btn btn-outline-primary w-100 text-center btn-sm mt-2 btn-detail" type="button" data-year="{{ $data->tahun }}">Detail</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        var laporan = @json($laporan);
        $('.chartContainer').each(function(index, element) {
            let options = {
                animationEnabled: true,
                title: {
                    text: laporan[index].tahun
                },
                data: [{
                    type: "doughnut",
                    innerRadius: "50%",
                    showInLegend: true,
                    legendText: "{label}",
                    indexLabel: "{label}: #percent%",
                    dataPoints: [
                        { label: "Deposit", y: laporan[index].deposit != null ? parseInt(laporan[index].deposit) : 0 },
                        { label: "Tunai", y: laporan[index].tunai != null ? parseInt(laporan[index].tunai) : 0 },
                        { label: "Qris", y: laporan[index].qris != null ? parseInt(laporan[index].qris) : 0 },
                        { label: "Debit", y: laporan[index].debit != null ? parseInt(laporan[index].debit) : 0 },
                        { label: "Transfer", y: laporan[index].transfer != null ? parseInt(laporan[index].transfer) : 0 }
                    ]
                }]
            };
            $(element).CanvasJSChart(options);
        });

        $('.btn-detail').on('click', function() {
            window.location = window.location + '/' + $(this).data('year');
        });
    });
</script>
@endsection
