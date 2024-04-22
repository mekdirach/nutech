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

                    <div class="col-md-6">
                        <label class="col-form-label">Kategori Produk</label>
                        <div class="input-group">
                            <select class="custom-select" name="kategori" id="kategori">
                                <option selected value="ALL">- Pilih -</option>
                                <option value="alat olahraga">alat olahraga</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mt-4">
                        <div class="row justify-content-center">
                            <div class="col-sm-6 text-right">
                                <button class="btn btn-sm btn-primary" id="btnSearch"><i class="ion ion-ios-search"></i>
                                    Cari</button>
                            </div>
                            <div class="col-sm-6 text-left">
                                <button class="btn btn-sm btn-warning" id="btnReset">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-4 text-md-end">
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
                <h5 class="modal-title custom-title">
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="account_id" id="account_id">
                <div class="form-row">
                    <div class="form-group col">
                        <label class="form-label">Account Type</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" id="deskripsi" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label class="form-label">Status</label>
                        <div id="status"></div>
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
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            loadData();

            $('#btnSearch').on('click', function() {
                $('.datatables-demos').DataTable().clear().destroy();
                console.log("masukkk");
                loadData();
            });

            $('#btnReset').on('click', function() {
                $("#inputProduk").val('ALL');
                $('#kategori').val('');
                $('.datatables-demos').DataTable().clear().destroy();
                loadData();
            });

            // Sisipkan perintah untuk tombol ekspor di sini

            $('#saveBtn').click(function() {
                var formData = $('#form-modal').serialize();
                var url = edit ? "{{ route('produk.create') }}";

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.rc == '0000') {
                            $('#modals-top').modal('hide');
                            swal("Sukses", response.message, "success");
                        } else {
                            $('#modals-top').modal('hide');
                            swal("Gagal", response.message, "warning");
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
                destroy: true, // Gunakan "destroy" bukan "bDestroy"
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
                        data: 'harga_barang',
                    },
                    {
                        title: "Harga Jual",
                        width: "5%",
                        data: 'harga_jual',
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
                            var html
                            html =
                                `<a href="javascript:void(0)" title="Edit" type="button" class="btn btn-sm btn-outline-secondary" onclick="modalEdit('${row.id}')"><i class="ion ion-ios-create"></i></a>`
                            return html
                        }
                    },
                ]
            });
        }


        function modalTambah() {
            edit = false;
            $('#modals-top').modal('show');
            $('.custom-title').html('Tambah Account Type');
            $('#name').val('');
            $('#deskripsi').val('');
            $('#status').html(`<select class="custom-select" name="isactive">
        <option value="1" selected>Aktif</option>
        <option value="0">Nonaktif</option>
    </select>`);
        }

        function modalEdit(id) {
            $('#modals-top').modal('show');
            $('#status').attr('disabled', false);
            edit = true;

            $.ajax({
                url: "{{ route('produk.create') }}",
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('.custom-title').html('Edit Account Type');
                    $('#account_id').val(data.account_type);
                    $('#name').val(data.account_type);
                    $('#deskripsi').val(data.account_type_name);
                    $('#status').html(`<select class="custom-select" name="isactive" value="${data.status_aktif}">
                <option value="1" ${data.status_aktif == 1 ? 'selected' : ''}>Aktif</option>
                <option value="0" ${data.status_aktif == 0 ? 'selected' : ''}>Nonaktif</option>
                </select>`);
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    </script>
@endpush
