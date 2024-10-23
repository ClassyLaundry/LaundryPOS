<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama Item</th>
                <th>Note</th>
                <th>Tipe Kemas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->item_transaksi as $item)
                @if ($item->jenis_item->unit != "MTR")
                    @for($i = 0; $i < $item->qty; $i++)
                    <tr>
                        <td class="text-start">{{ $item->nama }}</td>
                        @if (isset($item->item_notes[$i]) && $item->item_notes[$i]->catatan)
                            <td class="text-start">{{ $item->item_notes[$i]->catatan }}</td>
                        @else
                            <td class="text-center">-</td>
                        @endif
                        <td class="py-1">
                            <select class="form-select form-select-sm input-inventory">
                                <option hidden value="">-</option>
                                @foreach ($inventories as $inventory)
                                    <option value="{{ $inventory->id }}">{{ $inventory->nama }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endfor
                @else
                <tr>
                    <td class="text-start">{{ $item->nama }}</td>
                    @if (isset($item->item_notes) && $item->item_notes[0]->catatan)
                        <td class="text-start">{{ $item->item_notes[0]->catatan }}</td>
                    @else
                        <td class="text-center">-</td>
                    @endif
                    <td class="py-1">
                        <select class="form-select form-select-sm input-inventory">
                            <option hidden value="">-</option>
                            @foreach ($inventories as $inventory)
                                <option value="{{ $inventory->id }}">{{ $inventory->nama }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
