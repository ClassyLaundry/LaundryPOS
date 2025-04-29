<div class="table-responsive mb-2">
    <table class="table table-striped" id="table-list-trans">
        <thead class="text-center">
            <tr>
                <th>Kode</th>
                <th class="d-none d-lg-table-cell">Tanggal Transaksi</th>
                <th>Nama Pelanggan</th>
                <th colspan="2">Harga Total</th>
                {{-- <th></th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $trans)
            <tr id={{ $trans->id }}>
                <td class="text-center">{{ $trans->kode }}</td>
                <td class="d-none d-lg-table-cell text-center">{{ $trans->created_at }}</td>
                <td>{{ $trans->pelanggan->nama }}</td>
                <td>Rp</td>
                <td class="text-end thousand-separator">{{ $trans->grand_total }}</td>
                {{-- <td class='text-end p-1' style='width: 46.25px;'>
                    <button id='btn-{{ $trans->id }}' class='btn btn-primary btn-sm btn-show-action' type='button' style="cursor: pointer">
                        <i class='fas fa-bars' aria-hidden='true'></i>
                    </button>
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $transaksis->links() }}
