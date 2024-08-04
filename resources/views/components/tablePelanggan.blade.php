<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Membership</th>
                <th>Nama Lengkap</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Telphone</th>
                <th>E-mail</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pelanggans as $pelanggan)
            <tr id="pelanggan-{{ $pelanggan->id }}">
                @if ($pelanggan->member)
                    <td class="text-center">Member</td>
                @else
                    <td class="text-center">Bukan member</td>
                @endif
                <td>{{ $pelanggan->nama }}</td>
                <td class="text-center">{{ date("d F Y", strtotime($pelanggan->tanggal_lahir)) }}</td>
                @if ($pelanggan->gender == 'pria')
                    <td class="text-center">Pria</td>
                @elseif ($pelanggan->gender == 'wanita')
                    <td class="text-center">Wanita</td>
                @else
                <td class="text-center">{{ $pelanggan->gender }}</td>
                @endif
                <td>{{ $pelanggan->alamat }}</td>
                <td>{{ $pelanggan->telephone }}</td>
                <td>{{ $pelanggan->email }}</td>
                <td class="cell-action">
                    <button id="btn-{{ $pelanggan->id }}" class="btn btn-primary btn-sm btn-show-action" type="button">
                        <i class="fas fa-bars"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $pelanggans->links() }}
