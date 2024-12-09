@extends('layouts.users')

@section('content')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);">
        <a>Diskon History</a>
    </header>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Diskon History</h4>
            <hr>
            <div class="table-responsive mb-2">
                <table class="table table-striped" id="table-diskon">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Transaksi</th>
                            <th>Nama Pelanggan</th>
                            <th>Kode Diskon</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($diskonHistories as $diskonHistory)
                            <th>{{ $loop->index + 1 }}</th>
                            <td>{{ $diskonHistory->transaksi->kode }}</td>
                            <td>{{ $diskonHistory->pelanggan->nama }}</td>
                            <td>{{ $diskonHistory->diskon->code }}</td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
