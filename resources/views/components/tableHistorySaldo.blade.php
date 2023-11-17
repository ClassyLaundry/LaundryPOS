<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis Input</th>
                <th colspan="2">Nominal</th>
                <th colspan="2">Saldo Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($saldos as $saldo)
            <tr>
                <td>{{ date('d-M-Y', strtotime($saldo->created_at)) }}</td>
                <td class="text-center">{{ $saldo->jenis_input }}</td>
                <td>Rp</td>
                <td class="text-end">{{ number_format($saldo->nominal, 0, ',', '.') }}</td>
                <td>Rp</td>
                <td class="text-end">{{ number_format($saldo->saldo_akhir, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $saldos->links() }}
