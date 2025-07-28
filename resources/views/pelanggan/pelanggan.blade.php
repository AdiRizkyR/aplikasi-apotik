@extends('layout.index')
@section('title-page', 'Pelanggan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Pelanggan</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Data Pelanggan</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 180px;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl">
                        Tambah Pelanggan
                    </button>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>NO</th>
                        <th>NAMA</th>
                        <th>ALAMAT</th>
                        <th>NOMOR HANDPHONE</th>
                        <th>JOIN DATE</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($pelanggans as $index => $pelanggan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pelanggan->nama }}</td>
                            <td>{{ $pelanggan->alamat }}</td>
                            <td>{{ $pelanggan->nohp }}</td>
                            <td>{{ \Carbon\Carbon::parse($pelanggan->created_at)->format('d-m-Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn bg-gradient-warning btn-sm mr-1 btn-edit"
                                        data-id="{{ $pelanggan->id }}" data-nama="{{ $pelanggan->nama }}"
                                        data-alamat="{{ $pelanggan->alamat }}" data-nohp="{{ $pelanggan->nohp }}"
                                        data-toggle="modal" data-target="#modal-edit">
                                        Edit
                                    </button>
                                    <form action="{{ route('pelanggans.destroy', $pelanggan->id) }}" method="POST"
                                        class="form-delete d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn bg-gradient-danger btn-sm btn-delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Begin::modal -->
            <div class="modal fade" id="modal-xl">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form action="{{ route('pelanggans.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah Data Pelanggan</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Begin::Form Fields -->
                                <div class="form-group">
                                    <label for="nama">Nama Pelanggan</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Masukkan nama pelanggan" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap"
                                        required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="nohp">Nomor HP</label>
                                    <input type="tel" class="form-control" id="nohp" name="nohp"
                                        placeholder="Contoh: 08123456789" pattern="08[0-9]{8,11}" required>
                                </div>
                                <!-- End::Form Fields -->
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- End::modal -->

            <!-- Modal Edit Pelanggan -->
            <div class="modal fade" id="modal-edit">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form id="form-edit" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Data Pelanggan</h4>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Form Fields -->
                                <input type="hidden" id="edit-id">
                                <div class="form-group">
                                    <label for="edit-nama">Nama Pelanggan</label>
                                    <input type="text" class="form-control" id="edit-nama" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit-alamat">Alamat</label>
                                    <textarea class="form-control" id="edit-alamat" name="alamat" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="edit-nohp">Nomor HP</label>
                                    <input type="tel" class="form-control" id="edit-nohp" name="nohp"
                                        pattern="08[0-9]{8,11}" required>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-warning">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                // Saat tombol edit diklik
                document.querySelectorAll('.btn-edit').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const nama = this.getAttribute('data-nama');
                        const alamat = this.getAttribute('data-alamat');
                        const nohp = this.getAttribute('data-nohp');

                        // Isi field di modal
                        document.getElementById('edit-id').value = id;
                        document.getElementById('edit-nama').value = nama;
                        document.getElementById('edit-alamat').value = alamat;
                        document.getElementById('edit-nohp').value = nohp;

                        // Ubah action form edit
                        document.getElementById('form-edit').setAttribute('action', `/pelanggans/${id}`);
                    });
                });
            </script>

            <!-- SweetAlert2 -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                // Tangani klik pada tombol hapus
                document.querySelectorAll('.form-delete').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault(); // Cegah form submit langsung

                        Swal.fire({
                            title: 'Anda yakin?',
                            text: "Data ini akan dihapus secara permanen!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // Submit form jika dikonfirmasi
                            }
                        });
                    });
                });
            </script>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
