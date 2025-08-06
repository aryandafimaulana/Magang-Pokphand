<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Manajemen Gudang</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>


<body class="bg-gray-100 min-h-screen">

    @if (session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <x-navbar />

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Selamat Datang, Admin!</h2>

        <!-- Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold text-gray-700">Total Barang</h3>
                <p class="text-4xl font-bold text-blue-600 mt-4">{{ $totalBarang }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold text-gray-700">Stok Masuk Hari Ini</h3>
                <p class="text-4xl font-bold text-yellow-600 mt-4">{{ $stokMasukHariIni }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold text-gray-700">Stok Keluar Hari Ini</h3>
                <p class="text-4xl font-bold text-red-600 mt-4">{{ $stokKeluarHariIni }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold text-gray-700">Total Stok</h3>
                <p class="text-4xl font-bold text-purple-600 mt-4">{{ $totalStok }}</p>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-lg shadow mt-8">
            <div class="p-4 border-b">
                <h3 class="text-xl font-semibold text-gray-700">Barang Terbaru</h3>
            </div>
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Kode</th>
                        <th class="px-4 py-2 border">Nama Barang</th>
                        <th class="px-4 py-2 border">Stok</th>
                        <th class="px-4 py-2 border">Tanggal Masuk</th>
                        <th class="px-4 py-2 border">Tanggal Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangTerbaru as $barang)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $barang->kode_barang }}</td>
                        <td class="px-4 py-2 border">{{ $barang->nama_barang }}</td>
                        <td class="px-4 py-2 border">{{ $barang->stok }}</td>
                        <td class=" px-4 py-2 border">{{ $barang->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-2 border">{{ $barang->tanggal_keluar ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

</body>


</html>