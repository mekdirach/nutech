@extends('layouts.app')
@section('content')
    <div class="container-fluid">

        <h4 class="font-weight-bold py-3 mb-4">
            <span class="text-muted font-weight-light">Data /</span> Produk
        </h4>
        <h4 class="media align-items-center font-weight-bold py-3 mb-4">
            @include('produk.content.list')

        </h4>
    </div>
@endsection
