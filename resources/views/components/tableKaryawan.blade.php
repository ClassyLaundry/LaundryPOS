<div class="table-responsive">
    <table class="table" id="table-pengaturan-karyawan">
        <thead>
            <tr>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Telepon</th>
                <th>E-mail</th>
                <th>Outlet</th>
                <th>Role</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($karyawans as $karyawan)
                <tr>
                    <td>{{ $karyawan->username }}</td>
                    <td>{{ $karyawan->name }}</td>
                    <td class="text-center">{{ $karyawan->phone }}</td>
                    <td>{{ $karyawan->email }}</td>
                    @if ($karyawan->outlet)
                        <td class="text-center">{{ $karyawan->outlet->nama }}</td>
                    @else
                        <td class="text-center">-</td>
                    @endif
                    <td class="text-center">{{ $karyawan->role }}</td>
                    @if ($karyawan->status)
                        <td class="text-center">Aktif</td>
                    @else
                        <td class="text-center">Tidak aktif</td>
                    @endif
                    <td class="cell-action">
                        <button id="btn-{{ $karyawan->id }}"  class="btn btn-primary btn-sm btn-show-action" type="button"><i class="fas fa-bars"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $karyawans->links() }}
