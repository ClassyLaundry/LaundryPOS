<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th style="width: 10%;">ID</th>
                <th style="width: 30%;">Penerima</th>
                <th style="width: 20%;">Outlet</th>
                <th>Tanggal Ambil</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($diOutlets as $ambil_di_outlet)
                <tr>
                    <td>{{ $ambil_di_outlet->id }}</td>
                    <td>{{ $ambil_di_outlet->penerima }}</td>
                    <td>{{ $ambil_di_outlet->outlet->nama }}</td>
                    <td>{{ $ambil_di_outlet->tanggal_penerimaan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $diOutlets->links() }}
