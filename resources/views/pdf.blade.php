<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Gudang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header img {
            width: 80px;
            float: left;
            margin-right: 15px;
        }
        .company-info {
            text-align: left;
        }
        h2 {
            margin: 0;
            font-size: 16px;
        }
        .report-title {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #f0f0f0;
            text-align: center;
        }
        th, td {
            padding: 6px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #000;
            padding-top: 5px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="report-title">
        LAPORAN DATA GUDANG<br>
        {{ now()->format('d F Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $index => $item)
                <tr>
                    <td style="text-align:center;">{{ $index + 1 }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td style="text-align:center;">{{ $item->stok }}</td>
                    <td>{{$item->tanggal_masuk}}</td>
                    <td>{{$item->tanggal_keluar}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada {{ now()->format('d-m-Y H:i') }} | Sistem Manajemen Gudang PT Charoen Pokphand Indonesia
    </div>

</body>
</html>