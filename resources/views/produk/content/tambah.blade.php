@extends('layouts.app')

@section('content')
    <h4 class="font-weight-bold py-3 mb-4">
        <span class="text-muted font-weight-light">Data</span> > Tambah Produk
    </h4>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">

                <div class="card-body">
                    <form id="addProductForm" method="POST" action="{{ route('produk.create') }}">
                        @csrf
                        <div class="container justify-content-between">
                            <div class="row">
                                <div class="col-6">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Nama Produk</label>
                                    <div class="col-md-10">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name" required
                                            autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="kategori" class="col-md-4 col-form-label text-md-right">Kategori
                                        Produk</label>
                                    <div class="col-md-10">
                                        <select id="kategori" class="form-select @error('kategori') is-invalid @enderror"
                                            name="kategori" required>
                                            <option selected value="">- Pilih -</option>
                                            <option value="alat olahraga">Alat Olahraga</option>
                                            <option value="alat musik">Alat Musik</option>
                                        </select>
                                        @error('kategori')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="harga_barang" class="col-md-4 col-form-label text-md-right">Harga
                                        Barang</label>
                                    <div class="col-md-10">
                                        <input id="harga_barang" type="number" class="form-control" name="harga_barang"
                                            required>
                                        <span id="harga_barang-error" class="invalid-feedback" role="alert">
                                            <strong></strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="stok" class="col-md-4 col-form-label text-md-right">Stok Produk</label>
                                    <div class="col-md-10">
                                        <input id="stok" type="number" class="form-control" name="stok" required>
                                        <span id="stok-error" class="invalid-feedback" role="alert">
                                            <strong></strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="fallback">
                                        <label for="fileInput" class="text-center mt-2">
                                            <img id="previewImage" src="{{ asset('CMS/Image.png') }}" style="width: 200px;"
                                                alt="Upload Gambar Disini">
                                            <br>
                                            <span>Upload Gambar Disini</span>
                                            <input id="fileInput" name="file" type="file" multiple
                                                onchange="validateFileSize(this)" style="display: none;">
                                        </label>
                                    </div>
                                    @error('file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-5">
                        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batalkan</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <br>

                </form>
            </div>
        </div>
    </div>
    </div>
    <style>
        .fallback {
            text-align: center;
        }

        .fallback .text-center {
            margin-top: 10px;
        }

        .fallback .text-center i {
            font-size: 48px;
            color: #888;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('harga_barang').addEventListener('input', function() {
                var hargaBarang = this.value;
                var errorMessage = '';
                if (isNaN(hargaBarang)) {
                    errorMessage = 'Harga barang harus berupa angka.';
                }
                document.getElementById('harga_barang-error').innerText = errorMessage;
            });

            document.getElementById('stok').addEventListener('input', function() {
                var stok = this.value;
                var errorMessage = '';
                if (isNaN(stok)) {
                    errorMessage = 'Stok harus berupa angka.';
                }
                document.getElementById('stok-error').innerText = errorMessage;
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('addProductForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(form);
                fetch(form.action, {
                        method: form.method,
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.rc === '0000') {
                            alert(data.message);
                            window.location.href = "{{ route('produk.index') }}";
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        document.getElementById("fileInput").addEventListener("change", function(event) {
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById("previewImage").setAttribute("src", e.target
                    .result);
            };

            reader.readAsDataURL(file);
        });

        function validateFileSize(input) {
            var files = input.files;
            for (var i = 0; i < files.length; i++) {
                var fileSize = files[i].size;
                var maxSizeInBytes = 100 * 1024;
                var allowedExtensions = ['jpg', 'jpeg', 'png'];
                var fileName = files[i].name;
                var fileExtension = fileName.split('.').pop().toLowerCase();

                if (!allowedExtensions.includes(fileExtension)) {
                    alert('File harus berupa JPG atau PNG.');
                    input.value = '';
                    document.getElementById('previewImage').src =
                        'https://mdbootstrap.com/img/Photos/Others/placeholder.jpg';
                    return;
                }

                if (fileSize > maxSizeInBytes) {
                    alert('Ukuran file melebihi batas maksimum (100 KB)');
                    input.value = '';
                    document.getElementById('previewImage').src =
                        'https://mdbootstrap.com/img/Photos/Others/placeholder.jpg';
                    return;
                }
            }
        }
    </script>
@endsection
