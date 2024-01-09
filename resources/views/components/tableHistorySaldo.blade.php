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
                <td>{{ date('d/m/Y', strtotime($saldo->created_at)) }}</td>
                <td class="text-center">{{ $saldo->jenis_input }}</td>
                <td>{{ number_format($saldo->nominal, 0, ',', '.') }}</td>
                <td>{{ number_format($saldo->saldo_akhir, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
