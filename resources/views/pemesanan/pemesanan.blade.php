{{--  @extends('layout.index')
@section('title-page', 'Pemesanan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Pemesanan</li>
@endsection

@if (session('success'))
    <script>
        Swal.fire('Berhasil!', '{{ session('success') }}', 'success');
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire('Gagal!', '{{ session('error') }}', 'error');
    </script>
@endif

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Data Pemesanan</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl">
                    Tambah Pemesanan
                </button>
            </div>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>PENANGGUNG JAWAB</th>
                        <th>SUPPLIER</th>
                        <th>TANGGAL PESAN</th>
                        <th>TOTAL HARGA</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemesanans as $index => $pemesanan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pemesanan->user->name ?? '-' }}</td>
                            <td>{{ $pemesanan->supplier->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pemesanan->tanggal_pesan)->format('d-m-Y') }}</td>
                            <td>Rp{{ number_format($pemesanan->total, 2, ',', '.') }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <button class="btn bg-gradient-info btn-sm" data-toggle="modal"
                                        data-target="#modal-detail-{{ $pemesanan->id }}">Detail</button>
                                    <form action="{{ route('pemesanan.destroy', $pemesanan->id) }}" method="POST"
                                        onsubmit="return confirmDelete(event)" class="ml-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Belum ada data pemesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @foreach ($pemesanans as $pemesanan)
                <div class="modal fade" id="modal-detail-{{ $pemesanan->id }}" tabindex="-1"
                    aria-labelledby="modal-detail-label" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Pemesanan Obat</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-4">
                                    <h5 class="mb-3">Informasi Pemesanan</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Penanggung Jawab:</strong> {{ $pemesanan->user->name ?? '-' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Supplier:</strong> {{ $pemesanan->supplier->nama ?? '-' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Tanggal Pesan:</strong>
                                                {{ $pemesanan->tanggal_pesan ? \Carbon\Carbon::parse($pemesanan->tanggal_pesan)->format('d-m-Y') : '-' }}
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Total Harga:</strong>
                                                Rp{{ number_format($pemesanan->total, 2, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h5 class="mb-3">Detail Obat yang Dipesan</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Nama Obat</th>
                                                    <th>Jumlah Beli</th>
                                                    <th>Harga Beli</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pemesanan->detailPemesanans as $detail)
                                                    <tr>
                                                        <td>{{ $detail->dataObat->nama ?? '-' }}</td>
                                                        <td>{{ $detail->jumlah_beli }}</td>
                                                        <td>Rp{{ number_format($detail->harga_beli, 2, ',', '.') }}</td>
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
            @endforeach

            <!-- Modal -->
            <div class="modal fade" id="modal-xl" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <form id="form-pemesanan" method="POST" action="{{ route('pemesanans.store') }}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Pemesanan</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <!-- Bagian 1 -->
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                <div class="form-group">
                                    <label>Supplier</label>
                                    <select name="supplier_id" class="form-control" required>
                                        <option value="">-- Pilih Supplier --</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Pesan</label>
                                    <input type="date" name="tanggal_pesan" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Total Harga</label>
                                    <input type="number" name="total" id="total_harga" class="form-control" readonly>
                                </div>

                                <hr>

                                <!-- Bagian 2 -->
                                <h5>Detail Pemesanan</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Nama Obat</label>
                                        <select id="obat_id" class="form-control">
                                            <option value="">-- Pilih Obat --</option>
                                            @foreach ($obats as $obat)
                                                <option value="{{ $obat->id }}" data-jenis="{{ $obat->jenis }}"
                                                    data-kategori="{{ $obat->kategori }}">
                                                    {{ $obat->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Jumlah Beli</label>
                                        <input type="number" id="jumlah_beli" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Harga Beli</label>
                                        <input type="number" id="harga_beli" class="form-control">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" id="btnTambahObat"
                                            class="btn btn-success w-100">Tambah</button>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Nama Obat</th>
                                                    <th>Jenis</th>
                                                    <th>Kategori</th>
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

            <script>
                let detailObats = [];

                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('form-pemesanan');

                    document.getElementById('btnTambahObat').addEventListener('click', function() {
                        const obatSelect = document.getElementById('obat_id');
                        const obatId = obatSelect.value;
                        const obatText = obatSelect.options[obatSelect.selectedIndex].text;
                        const jenis = obatSelect.options[obatSelect.selectedIndex].getAttribute('data-jenis');
                        const kategori = obatSelect.options[obatSelect.selectedIndex].getAttribute('data-kategori');
                        const jumlah = document.getElementById('jumlah_beli').value;
                        const harga = document.getElementById('harga_beli').value;

                        if (!obatId || !jumlah || !harga) {
                            Swal.fire('Oops!', 'Semua field wajib diisi!', 'warning');
                            return;
                        }

                        detailObats.push({
                            obat_id: obatId,
                            nama: obatText,
                            jenis: jenis,
                            kategori: kategori,
                            jumlah_beli: parseInt(jumlah),
                            harga_beli: parseFloat(harga)
                        });

                        renderTable();
                        updateTotalHarga();

                        // Reset input
                        document.getElementById('jumlah_beli').value = '';
                        document.getElementById('harga_beli').value = '';
                        obatSelect.selectedIndex = 0;
                    });

                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const supplier = form.querySelector('[name="supplier_id"]').value;
                        const tanggal = form.querySelector('[name="tanggal_pesan"]').value;

                        if (!supplier && !tanggal && detailObats.length === 0) {
                            Swal.fire('Oops!', 'Anda belum menginputkan apa pun.', 'warning');
                            return;
                        }

                        if ((supplier || tanggal) && detailObats.length === 0) {
                            Swal.fire('Oops!',
                                'Inputan belum lengkap. Minimal harus ada 1 data pada detail pemesanan.',
                                'warning');
                            return;
                        }

                        Swal.fire({
                            title: 'Simpan Pemesanan?',
                            text: 'Data yang sudah disimpan tidak dapat diubah kembali, Pastikan data yang anda inputkan sudah benar',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Simpan',
                            cancelButtonText: 'Batal'
                        }).then(result => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                });

                function renderTable() {
                    const tbody = document.getElementById('tabel-detail-obat');
                    tbody.innerHTML = '';
                    detailObats.forEach((item, index) => {
                        const subTotal = item.jumlah_beli * item.harga_beli;
                        tbody.innerHTML += `
                            <tr>
                                <td>
                                    ${item.nama}
                                    <input type="hidden" name="detail_obats[${index}][obat_id]" value="${item.obat_id}">
                                </td>
                                <td>
                                    ${item.jenis}
                                    <input type="hidden" name="detail_obats[${index}][jenis]" value="${item.jenis}">
                                </td>
                                <td>
                                    ${item.kategori}
                                    <input type="hidden" name="detail_obats[${index}][kategori]" value="${item.kategori}">
                                </td>
                                <td>
                                    ${item.jumlah_beli}
                                    <input type="hidden" name="detail_obats[${index}][jumlah_beli]" value="${item.jumlah_beli}">
                                </td>
                                <td>
                                    Rp${item.harga_beli.toLocaleString('id-ID')}
                                    <input type="hidden" name="detail_obats[${index}][harga_beli]" value="${item.harga_beli}">
                                </td>
                                <td>
                                    Rp${subTotal.toLocaleString('id-ID')}
                                    <input type="hidden" name="detail_obats[${index}][subtotal]" value="${subTotal}">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusItem(${index})">Hapus</button>
                                </td>
                            </tr>
                        `;
                    });
                }

                function hapusItem(index) {
                    detailObats.splice(index, 1);
                    renderTable();
                    updateTotalHarga();
                }

                function updateTotalHarga() {
                    let total = 0;
                    detailObats.forEach(item => {
                        total += item.jumlah_beli * item.harga_beli;
                    });
                    document.getElementById('total_harga').value = total.toFixed(2);
                }
            </script>

            <script>
                function confirmDelete(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Hapus Pemesanan?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            e.target.submit();
                        }
                    });

                    return false;
                }
            </script>

        </div>
    </div>
@endsection  --}}



@extends('layout.index')
@section('title-page', 'Pemesanan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Pemesanan</li>
@endsection

@if (session('success'))
    <script>
        Swal.fire('Berhasil!', '{{ session('success') }}', 'success');
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire('Gagal!', '{{ session('error') }}', 'error');
    </script>
@endif

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Data Pemesanan</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl">
                    Tambah Pemesanan
                </button>
            </div>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>PENANGGUNG JAWAB</th>
                        <th>SUPPLIER</th>
                        <th>TANGGAL PESAN</th>
                        {{--  <th>TOTAL HARGA</th>  --}}
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemesanans as $index => $pemesanan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pemesanan->user->name ?? '-' }}</td>
                            <td>{{ $pemesanan->supplier->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pemesanan->tanggal_pesan)->format('d-m-Y') }}</td>
                            {{--  <td>Rp{{ number_format($pemesanan->total, 2, ',', '.') }}</td>  --}}
                            <td>
                                <div class="d-flex justify-content-center">
                                    <button class="btn bg-gradient-info btn-sm" data-toggle="modal"
                                        data-target="#modal-detail-{{ $pemesanan->id }}">Detail</button>
                                    <a href="{{ route('pemesanan.cetak', $pemesanan->id) }}"
                                        class="btn btn-warning btn-sm ml-1" target="_blank">
                                        Cetak
                                    </a>
                                    <form action="{{ route('pemesanan.destroy', $pemesanan->id) }}" method="POST"
                                        onsubmit="return confirmDelete(event)" class="ml-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Belum ada data pemesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @foreach ($pemesanans as $pemesanan)
                <div class="modal fade" id="modal-detail-{{ $pemesanan->id }}" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Pemesanan Obat</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h5 class="mb-3">Informasi Pemesanan</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Penanggung Jawab:</strong> {{ $pemesanan->user->name ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Supplier:</strong> {{ $pemesanan->supplier->nama ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Tanggal Pesan:</strong>
                                            {{ \Carbon\Carbon::parse($pemesanan->tanggal_pesan)->format('d-m-Y') }}
                                        </p>
                                    </div>
                                    {{--  <div class="col-md-6">
                                        <p><strong>Total Harga:</strong>
                                            Rp{{ number_format($pemesanan->total, 2, ',', '.') }}
                                        </p>
                                    </div>  --}}
                                </div>

                                <h5 class="mt-4 mb-3">Detail Obat yang Dipesan</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>Nama Obat</th>
                                                <th>Jumlah Beli</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pemesanan->detailPemesanans as $detail)
                                                <tr>
                                                    <td>{{ $detail->dataObat->nama ?? '-' }}</td>
                                                    <td>{{ $detail->jumlah_beli }}</td>
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

            <!-- Modal Tambah Pemesanan -->
            <div class="modal fade" id="modal-xl" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <form id="form-pemesanan" method="POST" action="{{ route('pemesanans.store') }}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Pemesanan</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="total" id="total_harga" value="0">

                                <div class="form-group">
                                    <label>Supplier</label>
                                    <select name="supplier_id" class="form-control selectpicker my-select"
                                        data-live-search="true" required>
                                        <option value="">-- Pilih Supplier --</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Pesan</label>
                                    <input type="date" name="tanggal_pesan" class="form-control" required>
                                </div>

                                <hr>
                                <h5>Detail Pemesanan</h5>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <label>Nama Obat</label>
                                        <select id="obat_id" class="form-control selectpicker my-select"
                                            data-live-search="true">
                                            <option value="">-- Pilih Obat --</option>
                                            @foreach ($obats as $obat)
                                                <option value="{{ $obat->id }}" data-jenis="{{ $obat->jenis }}"
                                                    data-kategori="{{ $obat->kategori }}">
                                                    {{ $obat->nama }}
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
                                                    <th>Jenis</th>
                                                    <th>Kategori</th>
                                                    <th>Jumlah</th>
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

            <!-- SCRIPT -->
            <script>
                let detailObats = [];

                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('form-pemesanan');

                    document.getElementById('btnTambahObat').addEventListener('click', function() {
                        const obatSelect = document.getElementById('obat_id');
                        const obatId = obatSelect.value;
                        const obatText = obatSelect.options[obatSelect.selectedIndex].text;
                        const jenis = obatSelect.options[obatSelect.selectedIndex].getAttribute('data-jenis');
                        const kategori = obatSelect.options[obatSelect.selectedIndex].getAttribute('data-kategori');
                        const jumlah = document.getElementById('jumlah_beli').value;

                        if (!obatId || !jumlah) {
                            Swal.fire('Oops!', 'Semua field wajib diisi!', 'warning');
                            return;
                        }

                        detailObats.push({
                            obat_id: obatId,
                            nama: obatText,
                            jenis: jenis,
                            kategori: kategori,
                            jumlah_beli: parseInt(jumlah),
                            harga_beli: 0 // harga 0
                        });

                        renderTable();
                        document.getElementById('jumlah_beli').value = '';
                        obatSelect.selectedIndex = 0;
                    });

                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const supplier = form.querySelector('[name="supplier_id"]').value;
                        const tanggal = form.querySelector('[name="tanggal_pesan"]').value;

                        if (!supplier || !tanggal || detailObats.length === 0) {
                            Swal.fire('Oops!', 'Lengkapi data terlebih dahulu.', 'warning');
                            return;
                        }

                        Swal.fire({
                            title: 'Simpan Pemesanan?',
                            text: 'Pastikan data yang Anda input sudah benar.',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Simpan',
                            cancelButtonText: 'Batal'
                        }).then(result => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                });

                function renderTable() {
                    const tbody = document.getElementById('tabel-detail-obat');
                    tbody.innerHTML = '';
                    detailObats.forEach((item, index) => {
                        tbody.innerHTML += `
                        <tr>
                            <td>
                                ${item.nama}
                                <input type="hidden" name="detail_obats[${index}][obat_id]" value="${item.obat_id}">
                            </td>
                            <td>${item.jenis}<input type="hidden" name="detail_obats[${index}][jenis]" value="${item.jenis}"></td>
                            <td>${item.kategori}<input type="hidden" name="detail_obats[${index}][kategori]" value="${item.kategori}"></td>
                            <td>${item.jumlah_beli}<input type="hidden" name="detail_obats[${index}][jumlah_beli]" value="${item.jumlah_beli}"></td>
                            <input type="hidden" name="detail_obats[${index}][harga_beli]" value="0">
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm" onclick="hapusItem(${index})">Hapus</button>
                            </td>
                        </tr>
                    `;
                    });
                }

                function hapusItem(index) {
                    detailObats.splice(index, 1);
                    renderTable();
                }

                function confirmDelete(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Hapus Pemesanan?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            e.target.submit();
                        }
                    });
                    return false;
                }
            </script>

        </div>
    </div>

@endsection
