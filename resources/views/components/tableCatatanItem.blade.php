<div class="table-responsive">
    <table class="table" id="table-list-catatan">
        <thead class="text-center">
            <tr>
                <th>Noted By</th>
                <th>Role</th>
                <th>Catatan</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notes as $note)
            <tr id={{ $note->id }}>
                <td class='text-center'>{{ $note->nama_user }}</td>
                <td class='text-center'>{{ $note->modifier->role }}</td>
                <td>{{ $note->catatan }}</td>
                <td class='text-end p-1' style='width: 46.25px;'>
                    <button id='btn-{{ $note->id }}' class='btn btn-primary btn-sm btn-show-action-2' type='button'>
                        <i class='fas fa-bars' aria-hidden='true'></i>
                    </button>
                </td>
            @endforeach
        </tbody>
        @if(in_array("Membuat Catatan Item", Session::get('permissions')) || Session::get('role') == 'administrator')
            <tfoot>
                <tr>
                    <td class="text-center" colspan="4">
                        <button class="btn btn-primary btn-sm" type="button" id="add-catatan-item"><i class="fas fa-plus"></i></button>
                    </td>
                </tr>
            </tfoot>
        @endif
    </table>
</div>
