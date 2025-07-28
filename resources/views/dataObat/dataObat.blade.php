@extends('layout.index')
@section('title-page', 'Data Obat')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Data Obat</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Data Obat</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 180px;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah-obat">
                        Tambah Data Obat
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
                        <th>NAMA OBAT</th>
                        <th>JENIS OBAT</th>
                        <th>KATEGORI</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($dataObat as $index => $obat)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $obat->nama }}</td>
                            <td>{{ $obat->jenis }}</td>
                            <td>{{ $obat->kategori }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn bg-gradient-warning btn-sm mr-1"
                                        onclick="openEditModal({{ $obat->id }}, '{{ $obat->nama }}', '{{ $obat->jenis }}', '{{ $obat->kategori }}')">
                                        Edit
                                    </button>
                                    <button type="button" class="btn bg-gradient-danger btn-sm btn-delete"
                                        onclick="hapusObat({{ $obat->id }})">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data obat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Modal Tambah Obat -->
            <div class="modal fade" id="modal-tambah-obat" tabindex="-1" aria-labelledby="modalTambahObatLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Data Obat</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Obat</label>
                                <input type="text" class="form-control" id="nama_obat">
                            </div>
                            <div class="form-group">
                                <label>Jenis</label>
                                <input type="text" class="form-control" id="jenis_obat">
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <input type="text" class="form-control" id="kategori_obat">
                            </div>
                            <button type="button" class="btn btn-success btn-sm mb-3" id="tambahSementara">Tambah Data
                                Obat</button>

                            <table class="table table-bordered" id="tabel-obat-sementara">
                                <thead class="text-center">
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>Jenis</th>
                                        <th>Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center"></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" id="simpanObat">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Obat -->
            <div class="modal fade" id="modal-edit-obat" tabindex="-1" aria-labelledby="modalEditObatLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Data Obat</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="edit_id">
                            <div class="form-group">
                                <label>Nama Obat</label>
                                <input type="text" class="form-control" id="edit_nama">
                            </div>
                            <div class="form-group">
                                <label>Jenis</label>
                                <input type="text" class="form-control" id="edit_jenis">
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <input type="text" class="form-control" id="edit_kategori">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" id="simpanEditObat">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                let dataObatSementara = [];

                // Utility function
                function resetForm(...fields) {
                    fields.forEach(id => document.getElementById(id).value = '');
                }

                function renderTabelSementara() {
                    const tbody = document.querySelector('#tabel-obat-sementara tbody');
                    tbody.innerHTML = '';

                    dataObatSementara.forEach((obat, index) => {
                        tbody.innerHTML += `
                        <tr>
                            <td>${obat.nama}</td>
                            <td>${obat.jenis}</td>
                            <td>${obat.kategori}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="hapusSementara(${index})">Hapus</button>
                            </td>
                        </tr>
                    `;
                    });
                }

                function hapusSementara(index) {
                    dataObatSementara.splice(index, 1);
                    renderTabelSementara();
                }

                function fetchWithSwal({
                    url,
                    method = 'POST',
                    data = {},
                    successMessage,
                    errorMessage,
                    reload = true
                }) {
                    fetch(url, {
                            method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (res.success) {
                                Swal.fire('Berhasil', successMessage || res.message, 'success').then(() => {
                                    if (reload) window.location.reload();
                                });
                            } else {
                                Swal.fire('Gagal', errorMessage || res.message, 'error');
                            }
                        })
                        .catch(err => {
                            Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
                            console.error(err);
                        });
                }

                // Tambah data sementara
                document.getElementById('tambahSementara').addEventListener('click', () => {
                    const nama = document.getElementById('nama_obat').value.trim();
                    const jenis = document.getElementById('jenis_obat').value.trim();
                    const kategori = document.getElementById('kategori_obat').value.trim();

                    if (!nama || !jenis || !kategori) {
                        Swal.fire('Gagal', 'Semua kolom harus diisi', 'error');
                        return;
                    }

                    dataObatSementara.push({
                        nama,
                        jenis,
                        kategori
                    });
                    renderTabelSementara();
                    resetForm('nama_obat', 'jenis_obat', 'kategori_obat');
                });

                // Simpan semua data sementara
                document.getElementById('simpanObat').addEventListener('click', () => {
                    if (dataObatSementara.length === 0) {
                        $('#modal-tambah-obat').modal('hide');
                        return;
                    }

                    Swal.fire({
                        title: 'Yakin menyimpan data obat?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Simpan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetchWithSwal({
                                url: '{{ route('data-obat.store') }}',
                                data: {
                                    data: dataObatSementara
                                }
                            });
                        }
                    });
                });

                // Buka modal edit
                function openEditModal(id, nama, jenis, kategori) {
                    document.getElementById('edit_id').value = id;
                    document.getElementById('edit_nama').value = nama;
                    document.getElementById('edit_jenis').value = jenis;
                    document.getElementById('edit_kategori').value = kategori;
                    $('#modal-edit-obat').modal('show');
                }

                // Simpan perubahan edit
                document.getElementById('simpanEditObat').addEventListener('click', () => {
                    const id = document.getElementById('edit_id').value;
                    const nama = document.getElementById('edit_nama').value.trim();
                    const jenis = document.getElementById('edit_jenis').value.trim();
                    const kategori = document.getElementById('edit_kategori').value.trim();

                    if (!nama || !jenis || !kategori) {
                        Swal.fire('Gagal', 'Semua kolom harus diisi!', 'error');
                        return;
                    }

                    Swal.fire({
                        title: 'Yakin simpan perubahan?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Simpan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetchWithSwal({
                                url: `/data-obat/update/${id}`,
                                method: 'PUT',
                                data: {
                                    nama,
                                    jenis,
                                    kategori
                                }
                            });
                        }
                    });
                });

                // Hapus obat dari database
                function hapusObat(id) {
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: 'Data obat yang dihapus tidak bisa dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetchWithSwal({
                                url: `/data-obat/delete/${id}`,
                                method: 'DELETE'
                            });
                        }
                    });
                }
            </script>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
