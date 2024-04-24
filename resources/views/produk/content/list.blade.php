<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <form class="row g-3" id="form-cari">
                    <div class="col-md-6">
                        <label for="col-form-label" class="form-label">Nama Produk</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="inputProduk" name="inputProduk"
                                placeholder="Masukkan Nama Produk...." style="width: 300px;">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="col-form-label" class="form-label">Kategori Produk</label>
                        <div class="input-group">
                            <select class="form-select" name="kategori" id="kategori">
                                <option selected value="">- Pilih -</option>
                                <option value="alat olahraga">alat olahraga</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 text-md-end">
                        <div class="row justify-content-center">
                            <div class="col-sm-6 text-right">
                                <button class="btn btn-sm btn-primary" id="btnSearch"><i class="ion ion-ios-search"></i>
                                    Cari</button>
                            </div>
                            <div class="col-sm-1 text-left">
                                <button class="btn btn-sm btn-warning" id="btnReset">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-4 text-md-end">
                <button class="btn btn-success" type="button" id="btnExport"><i class="fas fa-share-square"></i>
                    Export</button>
                <button class="btn btn-primary" type="button" onclick="modalTambah()">
                    <i class="ion ion-md-add-circle-outline"></i> Tambah Data
                </button>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="datatables-demos table table-striped table-bordered">
        </table>
    </div>
</div>



<div class="modal modal-top fade" id="modals-top">
    <div class="modal-dialog">
        <form class="modal-content" id="form-modal">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title custom-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="account_id" id="account_id">
                <div class="form-row">
                    <div class="form-group col">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                        <div class="invalid-feedback" id="nameError"></div>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label class="form-label">Kategori Produk</label>
                        <div class="input-group">
                            <select class="form-select" name="kategori" id="kategori">
                                <option selected value="">- Pilih -</option>
                                <option value="alat olahraga">alat olahraga</option>
                            </select>
                            <div class="invalid-feedback" id="kategoriError"></div>
                        </div>

                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label class="form-label">Harga Barang</label>
                        <input type="number" class="form-control" name="harga_barang" id="harga_barang" required>
                        <div class="invalid-feedback" id="hargaBarangError"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label class="form-label">Stok Produk</label>
                        <input type="number" class="form-control" name="stok" id="stok" required>
                        <div class="invalid-feedback" id="stokError"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBtn">Save</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modals-default">
    <div class="modal-dialog">
        <form action="{{ route('produk.export') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title custom-title">Export
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="mProduk" id="mProduk">
                <input type="hidden" name="mKategori" id="mKategori">
                <div class="form-row">
                    <div class="form-group col">
                        <label class="form-label">Tipe</label>
                        <select name="type" class="form-select" id="type">
                            <option value="1">Excel</option>
                            <option value="2">PDF</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="saveBtn">Export</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            loadData();

            $('#btnSearch').on('click', function() {
                $('.datatables-demos').DataTable().clear().destroy();

                loadData();
            });

            $('#btnExport').on('click', function() {
                $('#modals-default').modal('show')
                $('#mProduk').val($('#inputProduk').val())
                $('#mKategori').val($('#kategori').val())
            })

            $('#btnReset').on('click', function() {
                $("#inputProduk").val('');
                $('#kategori').val('');
                $('.datatables-demos').DataTable().clear().destroy();
                loadData();
            });
            $('#saveBtn').click(function() {
                var nama_produk = $('#name').val();
                var harga_barang = $('#harga_barang').val();
                var stok = $('#stok').val();

                $('.invalid-feedback').text('');
                $('input').removeClass('is-invalid');

                if (!nama_produk || !harga_barang || !stok) {
                    if (!nama_produk) {
                        $('#name').addClass('is-invalid'); // Menambah kelas is-invalid ke input
                        $('#nameError').text("Nama produk harus diisi.").addClass('text-danger');
                    }
                    if (!harga_barang) {
                        $('#harga_barang').addClass('is-invalid'); // Menambah kelas is-invalid ke input
                        $('#hargaBarangError').text("Harga barang harus diisi.").addClass('text-danger');
                    }
                    if (!stok) {
                        $('#stok').addClass('is-invalid'); // Menambah kelas is-invalid ke input
                        $('#stokError').text("Stok harus diisi.").addClass('text-danger');
                    }
                    return;
                }

                var formData = $('#form-modal').serialize();
                var edit = ($('#account_id').val() !== '');

                var url = '';
                if (edit) {
                    url = "{{ route('produk.edit') }}";
                } else {
                    url = "{{ route('produk.create') }}";
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.rc == '0000') {
                            $('#modals-top').modal('hide');
                            alert("Sukses: " + response.message);
                        } else {
                            $('#modals-top').modal('hide');
                            alert("Gagal: " + response.message);
                        }
                        loadData();
                    },
                    error: function(error) {
                        console.error('Error saving data:', error);
                    }
                });
            });


            $('#form-cari').submit(function(e) {
                e.preventDefault();
                loadData();
            });
        });


        function loadData() {
            var keyword = $('#inputProduk').val();
            var produk = $('#kategori').val();
            console.log(produk);
            $('.datatables-demos').DataTable({
                serverSide: true,
                paging: true,
                ordering: false,
                searching: false,
                responsive: true,
                processing: true,
                destroy: true,
                buttons: [],
                oLanguage: {
                    oPaginate: {
                        sFirst: "Halaman Pertama",
                        sPrevious: "Sebelumnya",
                        sNext: "Selanjutnya",
                        sLast: "Halaman Terakhir"
                    }
                },
                ajax: {
                    url: "{{ route('produk.list') }}",
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        keyword: keyword,
                        produk: produk
                    }
                },
                columns: [{
                        title: "No",
                        width: "1%",
                        data: 'rownum',
                        mRender: function(data, type, row) {
                            return row.rownum;
                        }
                    },
                    {
                        title: "Nama Produk",
                        width: "5%",
                        data: 'nama_produk',
                    },
                    {
                        title: "Kategori Produk",
                        width: "5%",
                        data: 'kategori_produk',
                    },
                    {
                        title: "harga Barang",
                        width: "5%",
                        data: function(row) {
                            return 'Rp.' + row.harga_barang.toLocaleString('id-ID', {
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    {
                        title: "Harga Jual",
                        width: "5%",
                        data: function(row) {
                            return 'Rp.' + row.harga_jual.toLocaleString('id-ID', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    {
                        title: "Stok",
                        width: "5%",
                        data: 'stok',
                    },
                    {
                        title: "Action",
                        data: 'id',
                        width: "5%",
                        class: "text-center",
                        mRender: function(data, type, row) {
                            var html;
                            html =
                                `<a href="#" title="Edit" class="btn btn-sm btn-outline-secondary me-2" onclick="modalEdit('${row.id}')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                    <path d="M11.293 0.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-10.5 10.5a1 1 0 0 1-.577.288l-3.5 1a1 1 0 0 1-1.29-1.29l1-3.5a1 1 0 0 1 .288-.577l10.5-10.5a1 1 0 0 1 1.414 0zM11 2.414L13.586 5 11 7.586 8.414 5 11 2.414zM13.707 1.707l1.5 1.5-1.293 1.293-1.5-1.5 1.293-1.293zM2 11l-1.585.585a1 1 0 0 0-.293.586L0 14l2 2 2-2-1.829-1.829a1 1 0 0 0-.586-.293L2 11zm-1 4l1 1v-2H0v1z"/>
                </svg>
            </a>`;

                            html +=
                                `<a href="#" title="Delete" class="btn btn-sm btn-outline-danger" onclick="modalDelete('${row.id}')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-.5.5H14l-.83 9.975a2 2 0 0 1-1.997 1.775H4.827a2 2 0 0 1-1.997-1.775L2 4.5H1a.5.5 0 0 1-.5-.5v-.5zm3.879-1a1.5 1.5 0 0 1 2.964 0h3.314a1.5 1.5 0 0 1 2.964 0H12.12a2.5 2.5 0 0 1-4.882 0H4.879z"/>
                </svg>
            </a>`;

                            return html;
                        }
                    },
                ]
            });
        }


        function modalTambah() {
            edit = false;
            $('#modals-top').modal('show');
            $('.custom-title').html('Tambah Produk');
            $('#name').val('');
            $('#kategori').val('');
            $('#harga_barang').val('');
            $('#harga_jual').val('');
            $('#stok').val('');
        }

        function modalEdit(id) {
            $('#modals-top').modal('show');
            edit = true;

            $.ajax({
                url: "{{ route('produk.show') }}",
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('.custom-title').html('Edit Account Type');
                    $('#account_id').val(data.id);
                    $('#name').val(data.nama_produk);
                    $('#kategori').val(data.kategori_produk);
                    $('#harga_barang').val(data.harga_barang);
                    $('#harga_jual').val(data.harga_jual);
                    $('#stok').val(data.stok);
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        function modalDelete(id) {
            $.ajax({
                url: "{{ route('produk.delete', ['id' => ':id']) }}".replace(':id',
                    id),
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.rc == '0000') {
                        alert("Sukses: " + response.message);
                    } else {
                        alert("Gagal: " + response.message);
                    }
                    loadData();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
@endpush
