<!-- Navbar -->
<nav class="bg-blue-600 text-white shadow">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
        <h1 class="text-2xl font-bold">Manajemen Gudang</h1>
        <ul class="flex space-x-6">
            <li><a href="/dashboard" class="hover:text-yellow-300">Dashboard</a></li>
            <li><a href="/barang" class="hover:text-yellow-300">Barang</a></li>
        </ul>
        <div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>