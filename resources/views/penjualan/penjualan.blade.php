@extends('layout.index')
@section('title-page', 'Penjualan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Penjualan</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Data Penjualan</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 180px;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl">
                        Tambah Penjualan
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
                        <th>PENANGGUNG JAWAB</th>
                        <th>PELANGGAN</th>
                        <th>TANGGAL PESAN</th>
                        <th>TANGGAL TERIMA</th>
                        <th>TOTAL</th>
                        <th>AKDI</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($penjualans as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>{{ $item->pelanggan->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pesan)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_terima)->format('d-m-Y') }}</td>
                            <td>Rp{{ number_format($item->total, 2, ',', '.') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <button class="btn bg-gradient-info btn-sm mr-1" data-toggle="modal"
                                        data-target="#modal-detail-{{ $item->id }}">Detail</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data penjualan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- modal detail -->
            @foreach ($penjualans as $item)
                <div class="modal fade" id="modal-detail-{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Penjualan</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h5>Info Penjualan</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Pelanggan:</strong> {{ $item->pelanggan->nama ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Penanggung Jawab:</strong> {{ $item->user->name ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Tanggal Pesan:</strong>
                                            {{ \Carbon\Carbon::parse($item->tanggal_pesan)->format('d-m-Y') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Tanggal Terima:</strong>
                                            {{ \Carbon\Carbon::parse($item->tanggal_terima)->format('d-m-Y') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Total Harga:</strong>
                                            Rp{{ number_format($item->total, 2, ',', '.') }}</p>
                                    </div>
                                </div>

                                <h5 class="mt-4">Detail Obat</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>Nama Obat</th>
                                                <th>Jenis</th>
                                                <th>Kategori</th>
                                                <th>Jumlah</th>
                                                <th>Harga Jual</th>
                                                <th>Expired</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item->detailPenjualans as $detail)
                                                <tr>
                                                    <td>{{ $detail->Obat->dataObat->nama ?? '-' }}</td>
                                                    <td>{{ $detail->Obat->dataObat->jenis ?? '-' }}</td>
                                                    <td>{{ $detail->Obat->dataObat->kategori ?? '-' }}</td>
                                                    <td>{{ $detail->jumlah_beli }}</td>
                                                    <td>Rp{{ number_format($detail->Obat->harga, 2, ',', '.') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($detail->expired)->format('d-m-Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Modal Tambah Penjualan -->
            <div class="modal fade" id="modal-xl" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <form id="form-penjualan" method="POST" action="{{ route('penjualans.store') }}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Penjualan</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">

                                <!-- Data Utama -->
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                <div class="form-group">
                                    <label>Pelanggan</label>
                                    <select name="pelanggan_id" class="form-control selectpicker my-select"
                                        data-live-search="true" required>
                                        <option value="">-- Pilih Pelanggan --</option>
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Pesan</label>
                                    <input type="date" name="tanggal_pesan" class="form-control" required>
                                </div>

                                {{--  <div class="form-group">
                                    <label>Tanggal Terima</label>
                                    <input type="date" name="tanggal_terima" class="form-control" required>
                                </div>  --}}
                                <input type="hidden" name="tanggal_terima"
                                    value="{{ \Carbon\Carbon::now()->toDateString() }}">

                                <div class="form-group">
                                    <label>Total Harga</label>
                                    <input type="number" name="total" id="total_harga" class="form-control" readonly>
                                </div>

                                <hr>

                                <!-- Detail Obat -->
                                <h5>Detail Penjualan</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Nama Obat | Stok | Harga</label>
                                        <select id="obat_id" class="form-control selectpicker my-select"
                                            data-live-search="true">
                                            <option value="">-- Pilih Obat --</option>
                                            @foreach ($obats as $obat)
                                                <option value="{{ $obat['id'] }}" data-harga="{{ $obat['harga'] }}"
                                                    data-nama="{{ $obat['nama'] }}" data-stok="{{ $obat['stok'] }}">
                                                    {{ $obat['nama'] }} | Stok: {{ $obat['stok'] }} |
                                                    Rp{{ number_format($obat['harga'], 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Jumlah Beli</label>
                                        <input type="number" id="jumlah_beli" class="form-control">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" id="btnTambahObat"
                                            class="btn btn-success w-100">Tambah</button>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th>Nama Obat</th>
                                                    <th>Jumlah</th>
                                                    <th>Harga</th>
                                                    <th>Subtotal</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabel-detail-obat"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Script JavaScript -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                let detailPenjualan = [];

                document.getElementById('btnTambahObat').addEventListener('click', function() {
                    const select = document.getElementById('obat_id');
                    const jumlah = parseInt(document.getElementById('jumlah_beli').value);
                    const option = select.options[select.selectedIndex];

                    const id = select.value;
                    const nama = option?.getAttribute('data-nama') || '';
                    const harga = parseInt(option?.getAttribute('data-harga') || 0);
                    const stok = parseInt(option?.getAttribute('data-stok') || 0);

                    if (!id || isNaN(jumlah) || jumlah < 1) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Input Tidak Valid',
                            text: 'Pilih obat dan masukkan jumlah beli yang benar.',
                        });
                        return;
                    }

                    if (jumlah > stok) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Stok Tidak Cukup',
                            text: `Stok tersedia hanya ${stok}`,
                        });
                        return;
                    }

                    const subtotal = harga * jumlah;
                    detailPenjualan.push({
                        obat_id: id,
                        nama,
                        harga,
                        jumlah,
                        subtotal
                    });

                    renderTabel();
                    hitungTotal();

                    // Reset input
                    document.getElementById('jumlah_beli').value = '';
                    select.value = '';
                });

                function renderTabel() {
                    const tbody = document.getElementById('tabel-detail-obat');
                    tbody.innerHTML = '';

                    detailPenjualan.forEach((item, index) => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${item.nama}</td>
                                <td>${item.jumlah}</td>
                                <td>Rp${item.harga.toLocaleString('id-ID')}</td>
                                <td>Rp${item.subtotal.toLocaleString('id-ID')}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusItem(${index})">Hapus</button>
                                </td>
                            </tr>
                        `;
                    });
                }

                function hapusItem(index) {
                    detailPenjualan.splice(index, 1);
                    renderTabel();
                    hitungTotal();
                }

                function hitungTotal() {
                    const total = detailPenjualan.reduce((sum, item) => sum + item.subtotal, 0);
                    document.getElementById('total_harga').value = total;
                }

                document.getElementById('form-penjualan').addEventListener('submit', function(e) {
                    e.preventDefault(); // prevent default submit

                    const pelanggan = document.querySelector('[name="pelanggan_id"]').value;
                    const tanggalPesan = document.querySelector('[name="tanggal_pesan"]').value;
                    const tanggalTerima = document.querySelector('[name="tanggal_terima"]').value;
                    const total = document.querySelector('#total_harga').value;

                    if (!pelanggan || !tanggalPesan || !tanggalTerima || detailPenjualan.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Belum Lengkap',
                            text: 'Harap isi semua data termasuk minimal satu item obat.',
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Yakin ingin menyimpan?',
                        text: "Data penjualan akan dikirim!",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Simpan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.getElementById('form-penjualan');

                            // Tambahkan input hidden untuk detail
                            detailPenjualan.forEach((item, index) => {
                                form.insertAdjacentHTML('beforeend', `
                                    <input type="hidden" name="detail[${index}][obat_id]" value="${item.obat_id}">
                                    <input type="hidden" name="detail[${index}][jumlah]" value="${item.jumlah}">
                                    <input type="hidden" name="detail[${index}][harga]" value="${item.harga}">
                                `);
                            });

                            form.submit();
                        }
                    });
                });
            </script>


        </div>
        <!-- /.card-body -->
    </div>
@endsection
