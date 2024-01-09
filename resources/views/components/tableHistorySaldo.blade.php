<div class="table-responsive">
    <table class="table table-striped" id="table-history-saldo">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis Input</th>
                <th>Nominal</th>
                <th>Saldo Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($saldos as $saldo)
            <tr>
                <td>{{ date('d-M-Y', strtotime($saldo->created_at)) }}</td>
                <td class="text-center">{{ $saldo->jenis_input }}</td>
                <td>
                    <div class="d-flex justify-content-between">
                        <span>Rp</span>
                        <span>{{ number_format($saldo->nominal, 0, ',', '.') }}</span>
                    </div>
                </td>
                <td>
                    <div class="d-flex justify-content-between">
                        <span>Rp</span>
                        <span>{{ number_format($saldo->saldo_akhir, 0, ',', '.') }}</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
