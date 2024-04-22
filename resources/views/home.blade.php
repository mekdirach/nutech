@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="my-3">
            <h1 class="display-4 fw-bold">Selamat Datang</h1>
            <p class="lead fw-normal mb-0">Terima kasih telah mengunjungi halaman utama kami. Silakan
                jelajahi aplikasi kami dan temukan fitur-fiturnya!</p>
        </div>
        <h4 class="media align-items-center font-weight-bold py-3 mb-4">
            <div class="media-body ml-3">
                Welcome, {{ ucwords(Session::get('user')['nama']) }}
                <br>
                Nama Cabang {{ ucwords(Session::get('user')['namaCabang']) }}
            </div>

        </h4>
    </div>
@endsection
