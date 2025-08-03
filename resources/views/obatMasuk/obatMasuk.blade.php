@extends('layout.index')
@section('title-page', 'Obat Masuk')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Obat Masuk</li>
@endsection

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Data Obat Masuk</h3>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                    <tr>
                        <th>NO</th>
                        <th>PENANGGUNG JAWAB</th>
                        <th>SUPPLIER</th>
                        <th>TANGGAL PESAN</th>
                        <th>TANGGAL TERIMA</th>
                        <th>TOTAL HARGA</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($obatMasuks as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->pemesanan->user->name ?? '-' }}</td>
                            <td>{{ $item->pemesanan->supplier->nama ?? '-' }}</td>
                            <td>{{ $item->pemesanan->tanggal_pesan ? \Carbon\Carbon::parse($item->pemesanan->tanggal_pesan)->format('d-m-Y') : '-' }}
                            </td>
                            <td>{{ $item->tanggal_terima ? \Carbon\Carbon::parse($item->tanggal_terima)->format('d-m-Y') : '-' }}
                            </td>
                            <td>Rp{{ number_format($item->total_harga, 2, ',', '.') }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <button class="btn bg-gradient-info btn-sm mr-1" data-toggle="modal"
                                        data-target="#modal-detail-{{ $item->id }}">Detail</button>
                                    <button class="btn bg-gradient-warning btn-sm mr-1" data-toggle="modal"
                                        data-target="#modal-edit-{{ $item->id }}">Edit</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Semua modal dipindahkan ke luar tabel --}}
    @foreach ($obatMasuks as $item)
        <!-- Modal Detail -->
        <div class="modal fade" id="modal-detail-{{ $item->id }}" tabindex="-1" aria-labelledby="modal-detail-label"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Data Obat Masuk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <h5 class="mb-3">Data Sumber Obat</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Supplier:</strong> {{ $item->pemesanan->supplier->nama ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Tanggal Pesan:</strong>
                                        {{ $item->pemesanan->tanggal_pesan ? \Carbon\Carbon::parse($item->pemesanan->tanggal_pesan)->format('d-m-Y') : '-' }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Tanggal Terima:</strong>
                                        {{ $item->tanggal_terima ? \Carbon\Carbon::parse($item->tanggal_terima)->format('d-m-Y') : '-' }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Total Harga:</strong>
                                        Rp{{ number_format($item->total_harga, 2, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h5 class="mb-3">Detail Data Obat</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Nama Obat</th>
                                            <th>Jenis</th>
                                            <th>Kategori</th>
                                            <th>No. Batch</th>
                                            <th>Jumlah</th>
                                            <th>Harga Beli</th>
                                            <th>Harga Jual</th>
                                            <th>Expired</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($item->detailObatMasuks as $detail)
                                            <tr>
                                                <td>{{ $detail->dataObat->nama ?? '-' }}</td>
                                                <td>{{ $detail->dataObat->jenis ?? '-' }}</td>
                                                <td>{{ $detail->dataObat->kategori ?? '-' }}</td>
                                                <td>{{ $detail->no_batch ?? '-' }}</td>
                                                <td>{{ $detail->jumlah_beli }}</td>
                                                <td>Rp{{ number_format($detail->harga_beli, 2, ',', '.') }}</td>
                                                <td>Rp{{ number_format($detail->harga_jual, 2, ',', '.') }}</td>
                                                <td>{{ $detail->expired ? \Carbon\Carbon::parse($detail->expired)->format('d-m-Y') : '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Obat Masuk -->
        <div class="modal fade" id="modal-edit-{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <form method="POST" action="{{ route('obatMasuk.update', $item->id) }}"
                    id="form-edit-{{ $item->id }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Obat Masuk</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Supplier</label>
                                    <input type="text" class="form-control"
                                        value="{{ $item->pemesanan->supplier->nama ?? '-' }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Tanggal Pesan</label>
                                    <input type="date" class="form-control"
                                        value="{{ $item->pemesanan->tanggal_pesan }}" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Terima</label>
                                <input type="date" name="tanggal_terima" class="form-control"
                                    value="{{ $item->tanggal_terima }}" required>
                            </div>

                            <div class="form-group">
                                <label>Total Harga</label>
                                <input type="number" id="total_harga_edit_{{ $item->id }}" name="total_harga"
                                    class="form-control" readonly>
                            </div>

                            <hr>
                            <h5>Detail Obat</h5>

                            <!-- Input Tambah -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div>
                                        <label>Nama Obat</label>
                                        <select class="form-control obat-select selectpicker my-select"
                                            data-target="{{ $item->id }}" data-live-search="true">
                                            <option value="">-- Pilih Obat --</option>
                                            @foreach ($obats as $obat)
                                                <option value="{{ $obat->id }}" data-nama="{{ $obat->nama }}">
                                                    {{ $obat->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label>Nomor Batch</label>
                                        <input type="text" class="form-control nomor_batch"
                                            data-target="{{ $item->id }}">
                                    </div>
                                    <div>
                                        <label>Jumlah Beli</label>
                                        <input type="number" class="form-control jumlah-beli"
                                            data-target="{{ $item->id }}" min="1">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div>
                                        <label>Harga Beli</label>
                                        <input type="number" class="form-control harga-beli"
                                            data-target="{{ $item->id }}" min="0" step="0.01">
                                    </div>
                                    <div>
                                        <label>Harga Jual</label>
                                        <input type="number" class="form-control harga-jual"
                                            data-target="{{ $item->id }}" min="0" step="0.01">
                                    </div>
                                    <div>
                                        <label>Tanggal Expired</label>
                                        <input type="date" class="form-control expired-date"
                                            data-target="{{ $item->id }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 d-flex align-items-end">
                                    <button type="button" class="btn btn-success w-100 btn-tambah-detail"
                                        data-target="{{ $item->id }}">
                                        Tambah Detail
                                    </button>
                                </div>
                            </div>

                            <!-- Tabel Detail -->
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Nama Obat</th>
                                            <th>No. Batch</th>
                                            <th>Jumlah</th>
                                            <th>Harga Beli</th>
                                            <th>Harga Jual</th>
                                            <th>Expired</th>
                                            <th>Subtotal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="edit-detail-body-{{ $item->id }}">
                                        @foreach ($item->detailObatMasuks as $i => $detail)
                                            @php
                                                $subtotal = $detail->jumlah_beli * $detail->harga_beli;
                                            @endphp
                                            <tr data-row-id="{{ $i }}">
                                                <td>
                                                    {{ $detail->dataObat->nama }}
                                                    <input type="hidden" name="detail[{{ $i }}][id]"
                                                        value="{{ $detail->id }}">
                                                    <input type="hidden" name="detail[{{ $i }}][obat_id]"
                                                        value="{{ $detail->dataObat->id }}">
                                                    <input type="hidden" name="detail[{{ $i }}][nama]"
                                                        value="{{ $detail->dataObat->nama }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="detail[{{ $i }}][no_batch]"
                                                        class="form-control" value="{{ $detail->no_batch }}"
                                                        placeholder="Batch">
                                                </td>
                                                <td>
                                                    <input type="number" name="detail[{{ $i }}][jumlah_beli]"
                                                        class="form-control quantity-input"
                                                        value="{{ $detail->jumlah_beli }}" min="1"
                                                        data-target="{{ $item->id }}"
                                                        data-row="{{ $i }}">
                                                </td>
                                                <td>
                                                    <input type="number" name="detail[{{ $i }}][harga_beli]"
                                                        class="form-control price-input"
                                                        value="{{ $detail->harga_beli }}" min="0" step="0.01"
                                                        data-target="{{ $item->id }}"
                                                        data-row="{{ $i }}">
                                                </td>
                                                <td>
                                                    <input type="number" name="detail[{{ $i }}][harga_jual]"
                                                        class="form-control" value="{{ $detail->harga_jual }}"
                                                        min="0" step="0.01">
                                                </td>
                                                <td>
                                                    <input type="date" name="detail[{{ $i }}][expired]"
                                                        class="form-control" value="{{ $detail->expired }}">
                                                </td>
                                                <td class="subtotal-cell" data-row="{{ $i }}">
                                                    <span
                                                        class="subtotal-display">Rp{{ number_format($subtotal, 2, ',', '.') }}</span>
                                                    <input type="hidden" name="detail[{{ $i }}][subtotal]"
                                                        class="subtotal-value" value="{{ $subtotal }}">
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm btn-delete-detail-db"
                                                        data-detail-id="{{ $detail->id }}"
                                                        data-obat-id="{{ $detail->dataObat->id }}"
                                                        data-obat-masuk-id="{{ $item->id }}"
                                                        data-row="{{ $i }}">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!-- SweetAlert2 CDN (jika belum ada) -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inisialisasi total harga setiap modal edit
                @foreach ($obatMasuks as $item)
                    updateTotalHargaEdit({{ $item->id }});
                    initializeDynamicCalculation({{ $item->id }});
                @endforeach

                // Fungsi untuk menginisialisasi perhitungan dinamis
                function initializeDynamicCalculation(target) {
                    // Event listener untuk perubahan quantity dan price
                    document.addEventListener('input', function(e) {
                        if (e.target.classList.contains('quantity-input') || e.target.classList.contains(
                                'price-input')) {
                            const targetId = e.target.dataset.target;
                            const rowId = e.target.dataset.row;

                            if (targetId == target) {
                                updateRowSubtotal(targetId, rowId);
                                updateTotalHargaEdit(targetId);
                            }
                        }
                    });
                }

                // Fungsi untuk update subtotal per baris
                function updateRowSubtotal(target, rowId) {
                    const row = document.querySelector(`tr[data-row-id="${rowId}"]`);
                    if (!row) return;

                    const quantityInput = row.querySelector(`[name*="[jumlah_beli]"]`);
                    const priceInput = row.querySelector(`[name*="[harga_beli]"]`);
                    const subtotalCell = row.querySelector('.subtotal-cell');
                    const subtotalValue = row.querySelector('.subtotal-value');
                    const subtotalDisplay = row.querySelector('.subtotal-display');

                    if (quantityInput && priceInput && subtotalCell) {
                        const quantity = parseFloat(quantityInput.value) || 0;
                        const price = parseFloat(priceInput.value) || 0;
                        const subtotal = quantity * price;

                        // Update display
                        subtotalDisplay.textContent =
                            `Rp${subtotal.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

                        // Update hidden value
                        if (subtotalValue) {
                            subtotalValue.value = subtotal;
                        }
                    }
                }

                // Tambah baris baru (dimodifikasi)
                document.querySelectorAll('.btn-tambah-detail').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const target = this.dataset.target;
                        const select = document.querySelector(`.obat-select[data-target="${target}"]`);
                        const nama = select.options[select.selectedIndex].text;
                        const obatId = select.value.trim();
                        const noBatch = document.querySelector(`.nomor_batch[data-target="${target}"]`)
                            .value.trim();
                        const jumlah = document.querySelector(`.jumlah-beli[data-target="${target}"]`)
                            .value.trim();
                        const hargaBeli = document.querySelector(`.harga-beli[data-target="${target}"]`)
                            .value.trim();
                        const hargaJual = document.querySelector(`.harga-jual[data-target="${target}"]`)
                            .value.trim();
                        const expired = document.querySelector(`.expired-date[data-target="${target}"]`)
                            .value.trim();
                        const tbody = document.getElementById(`edit-detail-body-${target}`);
                        const index = tbody.querySelectorAll('tr').length;

                        // Validasi input
                        if (!obatId || !jumlah || !hargaBeli || !hargaJual || !expired) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Lengkapi Data!',
                                text: 'Pastikan semua inputan sudah diisi lengkap.'
                            });
                            return;
                        }

                        const subtotal = parseFloat(jumlah) * parseFloat(hargaBeli);

                        const row = `
                            <tr data-row-id="${index}">
                                <td>
                                    ${nama}
                                    <input type="hidden" name="detail[${index}][obat_id]" value="${obatId}">
                                    <input type="hidden" name="detail[${index}][nama]" value="${nama}">
                                </td>
                                <td>
                                    <input type="text" name="detail[${index}][no_batch]" class="form-control" value="${noBatch}" placeholder="Batch">
                                </td>
                                <td>
                                    <input type="number" name="detail[${index}][jumlah_beli]"
                                        class="form-control quantity-input"
                                        value="${jumlah}"
                                        min="1"
                                        data-target="${target}"
                                        data-row="${index}" required>
                                </td>
                                <td>
                                    <input type="number" name="detail[${index}][harga_beli]"
                                        class="form-control price-input"
                                        value="${hargaBeli}"
                                        min="0"
                                        step="0.01"
                                        data-target="${target}"
                                        data-row="${index}" required>
                                </td>
                                <td>
                                    <input type="number" name="detail[${index}][harga_jual]"
                                        class="form-control"
                                        value="${hargaJual}"
                                        min="0"
                                        step="0.01" required>
                                </td>
                                <td>
                                    <input type="date" name="detail[${index}][expired]"
                                        class="form-control"
                                        value="${expired}" required>
                                </td>
                                <td class="subtotal-cell" data-row="${index}">
                                    <span class="subtotal-display">Rp${subtotal.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                                    <input type="hidden" name="detail[${index}][subtotal]"
                                        class="subtotal-value"
                                        value="${subtotal}">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete-row"
                                            data-target="${target}"
                                            data-row="${index}">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        `;

                        tbody.insertAdjacentHTML('beforeend', row);

                        // Reset input
                        select.selectedIndex = 0;
                        document.querySelector(`.nomor_batch[data-target="${target}"]`).value = '';
                        document.querySelector(`.jumlah-beli[data-target="${target}"]`).value = '';
                        document.querySelector(`.harga-beli[data-target="${target}"]`).value = '';
                        document.querySelector(`.harga-jual[data-target="${target}"]`).value = '';
                        document.querySelector(`.expired-date[data-target="${target}"]`).value = '';

                        // Update total
                        updateTotalHargaEdit(target);
                    });
                });

                // Event listener untuk hapus baris baru
                /*
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('btn-delete-row')) {
                        const target = e.target.dataset.target;
                        e.target.closest('tr').remove();
                        updateTotalHargaEdit(target);
                    }
                });
                */
                // Event listener untuk hapus baris baru (data sementara)
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('btn-delete-row')) {
                        e.preventDefault();

                        const target = e.target.dataset.target;
                        const row = e.target.closest('tr');

                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Data ini akan dihapus dari tabel!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                row.remove();
                                updateTotalHargaEdit(target);
                            }
                        });
                    }
                });


                // Validasi sebelum submit
                document.querySelectorAll('[id^="form-edit-"]').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(this);
                        const rows = this.querySelectorAll('tbody tr');

                        if (rows.length === 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Detail Obat Kosong!',
                                text: 'Silakan tambahkan minimal satu data obat.'
                            });
                            return;
                        }

                        // Konfirmasi sebelum submit
                        Swal.fire({
                            title: 'Yakin simpan perubahan?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Simpan!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                });
            });

            // Fungsi update total harga (dimodifikasi)
            function updateTotalHargaEdit(target) {
                const rows = document.querySelectorAll(`#edit-detail-body-${target} tr`);
                let total = 0;

                rows.forEach(row => {
                    const jumlah = row.querySelector('[name*="[jumlah_beli]"]')?.value || 0;
                    const harga = row.querySelector('[name*="[harga_beli]"]')?.value || 0;
                    const subtotal = parseFloat(jumlah) * parseFloat(harga);
                    total += subtotal;
                });

                // Update input total harga
                const totalInput = document.getElementById(`total_harga_edit_${target}`);
                if (totalInput) {
                    totalInput.value = total.toFixed(2);
                }

                // Update display total
                const totalDisplay = document.getElementById(`total-display-${target}`);
                if (totalDisplay) {
                    totalDisplay.textContent =
                        `Rp${total.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                }
            }
        </script>

        <script>
            document.querySelectorAll('.btn-delete-detail-db').forEach(button => {
                button.addEventListener('click', function() {
                    const detailId = this.dataset.detailId;
                    const obatId = this.dataset.obatId;
                    const obatMasukId = this.dataset.obatMasukId;

                    Swal.fire({
                        title: 'Yakin ingin menghapus detail ini?',
                        text: 'anda tidak dapat mengembalikan data ini setelah dihapus',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/obat/detail/${detailId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        obat_id: obatId,
                                        obat_masuk_id: obatMasukId
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Berhasil!', data.message, 'success');
                                        // Hapus baris dari tabel
                                        button.closest('tr').remove();
                                        // Update total harga
                                        updateTotalHargaEdit(obatMasukId);
                                    } else {
                                        Swal.fire('Gagal', data.message, 'error');
                                    }
                                })
                                .catch(error => {
                                    console.error(error);
                                    Swal.fire('Gagal', 'Terjadi kesalahan.', 'error');
                                });
                        }
                    });
                });
            });
        </script>

        <script>
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-delete-row')) {
                    e.preventDefault(); // Jangan langsung hapus

                    const button = e.target;
                    const target = button.dataset.target;
                    const row = button.closest('tr');

                    Swal.fire({
                        title: 'Yakin ingin menghapus data ini?',
                        text: 'Data ini belum tersimpan ke database dan akan dihapus dari tabel.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            row.remove();
                            updateTotalHargaEdit(target);
                        }
                    });
                }
            });
        </script>
    @endforeach

@endsection
