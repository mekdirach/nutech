<div class="card">
    <div class="card-header">
        <!-- Gambar Profil Bulat -->
        <div class="profile-image">
            <img src="{{ asset('CMS/Frame 98700.png') }}" alt="Foto Profil" class="rounded-circle"
                style="width: 100px; height: 100px;">
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <label for="nama_kandidat">Nama Kandidat</label>
                <input id="nama_kandidat" type="text" class="form-control white-bg"
                    value="{{ ucwords(Session::get('user')['nama']) }}">
            </div>
            <div class="col-md-4">
                <label>Posisi Kandidat</label>
                <input id="nama_kandidat" type="text" class="form-control white-bg"
                    value="{{ ucwords(Session::get('user')['posisi']) }}">
            </div>
        </div>

    </div>
</div>

<style>
    .card-header {
        background-color: #f8f9fa;
        padding: 20px;
    }

    .card-header img {
        border: 2px solid #ffffff;
    }


    .profile-image {
        margin: 0 auto;
    }

    .card-body {
        margin-top: 20px;
    }

    .card-header h3 {
        margin-bottom: 10px;
    }

    .card-header p {
        margin: 0;
    }
</style>
