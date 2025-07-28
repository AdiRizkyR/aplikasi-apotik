@extends('layout.index')
@section('title-page', 'Supplier')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Supplier</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Data Supplier</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 180px;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl">
                        Tambah Supplier
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
                    @forelse ($suppliers as $index => $supplier)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $supplier->nama }}</td>
                            <td>{{ $supplier->alamat }}</td>
                            <td>{{ $supplier->nohp }}</td>
                            <td>{{ \Carbon\Carbon::parse($supplier->created_at)->format('d-m-Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    {{--  <button type="button" class="btn bg-gradient-warning btn-sm mr-1">Edit</button>  --}}
                                    <button type="button" class="btn bg-gradient-warning btn-sm mr-1 btn-edit"
                                        data-id="{{ $supplier->id }}" data-nama="{{ $supplier->nama }}"
                                        data-alamat="{{ $supplier->alamat }}" data-nohp="{{ $supplier->nohp }}"
                                        data-toggle="modal" data-target="#modal-edit">
                                        Edit
                                    </button>
                                    <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST"
                                        class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn bg-gradient-danger btn-sm btn-delete"
                                            data-nama="{{ $supplier->nama }}">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data supplier.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

            <!-- Begin::modal add -->
            <div class="modal fade" id="modal-xl">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form action="{{ route('supplier.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah Data Supplier</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Begin::Form Fields -->
                                <div class="form-group">
                                    <label for="nama">Nama Supplier</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Masukkan nama supplier" required>
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
            <!-- End::modal add -->

            <!-- Modal Edit Supplier -->
            <div class="modal fade" id="modal-edit">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form id="editForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Data Supplier</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Begin::Form Fields -->
                                <input type="hidden" id="edit-id" name="id">
                                <div class="form-group">
                                    <label for="edit-nama">Nama Supplier</label>
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
                                <!-- End::Form Fields -->
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
                document.addEventListener('DOMContentLoaded', function() {
                    const editButtons = document.querySelectorAll('.btn-edit');
                    const form = document.getElementById('editForm');

                    editButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const id = this.getAttribute('data-id');
                            const nama = this.getAttribute('data-nama');
                            const alamat = this.getAttribute('data-alamat');
                            const nohp = this.getAttribute('data-nohp');

                            // Set input values
                            document.getElementById('edit-id').value = id;
                            document.getElementById('edit-nama').value = nama;
                            document.getElementById('edit-alamat').value = alamat;
                            document.getElementById('edit-nohp').value = nohp;

                            // Set action URL
                            form.action = `/supplier/${id}`;
                        });
                    });
                });
            </script>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const deleteButtons = document.querySelectorAll('.btn-delete');

                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const form = this.closest('form');
                            const nama = this.getAttribute('data-nama');

                            Swal.fire({
                                title: 'Yakin ingin menghapus?',
                                text: `Supplier "${nama}" akan dihapus secara permanen.`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    form.submit();
                                }
                            });
                        });
                    });
                });
            </script>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
