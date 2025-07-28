@extends('layout.index')
@section('title-page', 'User')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">User</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Data User</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl">
                        Tambah User
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
                        <th>USERNAME</th>
                        <th>JOIN DATE</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                        class="d-inline form-delete-user">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="btn bg-gradient-danger btn-sm btn-delete-user">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Begin::modal add -->
            <div class="modal fade" id="modal-xl">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form action="{{ route('user.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah Data User</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Begin::Form Fields -->
                                <div class="form-group">
                                    <label for="name">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Masukkan nama lengkap" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Masukkan username" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Kata Sandi</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Masukkan kata sandi" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Konfirmasi Kata Sandi</label>
                                    <input type="password" class="form-control" id="confirm_password"
                                        name="password_confirmation" placeholder="Ulangi kata sandi" required>
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

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                document.querySelectorAll('.btn-delete-user').forEach(button => {
                    button.addEventListener('click', function() {
                        const form = this.closest('form');

                        Swal.fire({
                            title: 'Yakin ingin menghapus?',
                            text: "Data yang dihapus tidak bisa dikembalikan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            </script>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
