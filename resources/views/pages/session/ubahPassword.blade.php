@extends('layouts.guest')

@section('content')
<section class="bg-clean vh-100 d-flex align-items-center">
    <form method="post">
        <div class="px-2 mb-3 d-flex justify-content-between align-items-center form-container">
            <input class="form-control px-2 me-2" type="password" name="oldpass" placeholder="Password lama">
            <i class="fas fa-eye-slash"></i>
        </div>
        <div class="px-2 mb-3 d-flex justify-content-between align-items-center form-container">
            <input class="form-control px-2 me-2" type="password" name="newpass" placeholder="Password baru">
            <i class="fas fa-eye-slash"></i>
        </div>
        <div class="px-2 mb-4 d-flex justify-content-between align-items-center form-container">
            <input class="form-control px-2 me-2" type="password" name="confpass" placeholder="Ulangi password baru">
            <i class="fas fa-eye-slash"></i>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary d-block w-100" type="submit">Simpan</button>
        </div>
    </form>
</section>
@endsection
