<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang | Manajemen Gudang</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen">

    <x-navbar />

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Kelola Barang</h2>

        <!-- Form Input Barang -->
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Input Barang</h3>
            <form action="{{ route('barang.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                <div>
                    <label class="block mb-2 text-gray-700">Kode Barang</label>
                    <input type="text" name="kode_barang" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('kode_barang')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block mb-2 text-gray-700">Nama Barang</label>
                    <input type="text" name="nama_barang" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                </div>
                <div>
                    <label class="block mb-2 text-gray-700">Stok</label>
                    <input type="number" name="stok" min="1" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
                    @error('stok')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block mb-2 text-gray-700">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk"
                        value="{{ now()->format('Y-m-d') }}"
                        readonly
                        class="w-full px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg w-full md:w-auto">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Tabel Daftar Barang -->
        <div class="bg-white rounded-lg shadow">
            <!-- Filter & Search -->
            <div class="p-4 border-b flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-700">Daftar Barang</h3>

                <form action="{{ route('barang.index') }}" method="GET" class="flex gap-2">
                    <!-- Search -->
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau kode barang..."
                        class="px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300">

                    <!-- Filter -->
                    <select name="filter" class="px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                        <option value="">Semua</option>
                        <option value="keluar" {{ request('filter') == 'keluar' ? 'selected' : '' }}>Sudah Keluar</option>
                        <option value="belum" {{ request('filter') == 'belum' ? 'selected' : '' }}>Belum Keluar</option>
                    </select>

                    <!-- Tombol Cari -->
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                        Cari
                    </button>

                    <!-- Tombol Clear -->
                    <a href="{{ route('barang.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-lg">
                        Clear
                    </a>
                </form>

                <!-- Tombol Download PDF -->
                <a href="{{ route('barang.downloadPdf', ['search' => request('search'), 'filter' => request('filter')]) }}"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                    Download PDF
                </a>

            </div>

            <!-- Table -->
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Kode</th>
                        <th class="px-4 py-2 border">Nama Barang</th>
                        <th class="px-4 py-2 border">Stok</th>
                        <th class="px-4 py-2 border">Tanggal Masuk</th>
                        <th class="px-4 py-2 border">Tanggal Keluar</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $barang)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $barang->kode_barang }}</td>
                        <td class="px-4 py-2 border">{{ $barang->nama_barang }}</td>
                        <td class="px-4 py-2 border">{{ $barang->stok }}</td>
                        <td class="px-4 py-2 border">{{ $barang->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-2 border">
                            {{ $barang->tanggal_keluar 
                            ? \Carbon\Carbon::parse($barang->tanggal_keluar)->timezone('Asia/Jakarta')->format('Y-m-d H:i') 
                            : '-' }}
                        </td>
                        <td class="px-4 py-2 border">
                            @if (is_null($barang->tanggal_keluar))
                            <form action="{{ route('barang.keluar', $barang->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                    Barang Keluar
                                </button>
                            </form>
                            <button onclick="openEditModal({{ $barang->id }}, '{{ $barang->kode_barang }}', '{{ $barang->nama_barang }}', '{{ $barang->stok }}', '{{ $barang->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}', '{{ $barang->tanggal_keluar ? \Carbon\Carbon::parse($barang->tanggal_keluar)->timezone('Asia/Jakarta')->format('Y-m-d H:i') : '-' }}')"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">
                                Edit
                            </button>
                            @else
                            <button class="bg-gray-400 text-white px-3 py-1 rounded cursor-not-allowed" disabled>
                                Barang Keluar
                            </button>
                            <button class="bg-gray-400 text-white px-3 py-1 rounded cursor-not-allowed" disabled>
                                Edit
                            </button>
                            @endif

                            <!-- Tombol Hapus -->
                            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>

</body>

<!-- Modal Edit Barang -->
<div id="editModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg rounded-lg p-6 shadow-lg">
        <h2 class="text-2xl font-semibold mb-4">Edit Barang</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Kode Barang</label>
                <input type="text" name="kode_barang" id="editKode" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Nama Barang</label>
                <input type="text" name="nama_barang" id="editNama" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Stok</label>
                <input type="number" name="stok" id="editStok" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Tanggal Masuk</label>
                <input type="text" id="editTanggalMasuk" readonly class="w-full px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Tanggal Keluar</label>
                <input type="text" id="editTanggalKeluar" readonly class="w-full px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed">
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="bg-gray-400 px-4 py-2 rounded text-white">Batal</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, kode, nama, stok, tanggalMasuk, tanggalKeluar) {
        document.getElementById('editForm').action = `/barang/${id}`;
        document.getElementById('editKode').value = kode;
        document.getElementById('editNama').value = nama;
        document.getElementById('editStok').value = stok;
        document.getElementById('editTanggalMasuk').value = tanggalMasuk;
        document.getElementById('editTanggalKeluar').value = tanggalKeluar;

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>


</html>