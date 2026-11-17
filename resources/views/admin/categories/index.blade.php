
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - Tani-Segar</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f5f8f4;
            color: #26352b;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #38734a;
            text-decoration: none;
            font-weight: bold;
        }

        h1 { margin-bottom: 8px; }

        .description {
            color: #68756b;
            margin-bottom: 25px;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 11px 17px;
            border: none;
            border-radius: 7px;
            background: #34784b;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-edit { background: #d69b24; }
        .btn-delete { background: #c0392b; }

        .alert {
            padding: 13px;
            margin-bottom: 15px;
            border-radius: 7px;
            background: #e2f4e6;
            color: #256137;
        }

        .alert.error {
            background: #fde8e7;
            color: #a52b23;
        }

        .table-wrapper {
            background: white;
            border-radius: 10px;
            overflow-x: auto;
            box-shadow: 0 3px 12px #0000000d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 750px;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #edf0ed;
        }

        th {
            background: #eaf2e9;
            color: #345d3d;
        }

        .category-image {
            width: 55px;
            height: 45px;
            object-fit: cover;
            border-radius: 6px;
        }

        .status {
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            background: #e0f3e4;
            color: #26713b;
        }

        .inactive {
            background: #fce5e3;
            color: #a52b23;
        }

        .actions {
            display: flex;
            gap: 7px;
            align-items: center;
        }

        .actions form { margin: 0; }

        .empty {
            text-align: center;
            color: #888;
            padding: 30px;
        }

        @media(max-width: 600px) {
            body { padding: 15px; }
        }
    </style>
</head>
<body>

<div class="container">

    <a href="{{ route('dashboard') }}" class="back">
        ← Kembali ke Dashboard
    </a>

    <h1>Kelola Kategori</h1>
    <p class="description">
        Tambah, ubah, dan kelola kategori produk Tani-Segar.
    </p>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="top">
        <strong>Total Kategori: {{ $categories->total() }}</strong>

        <a href="{{ route('admin.categories.create') }}" class="btn">
            + Tambah Kategori
        </a>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Gambar</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $index => $category)
                    <tr>
                        <td>{{ $categories->firstItem() + $index }}</td>

                        <td>
                            @if($category->gambar)
                                <img
                                    src="{{ asset('storage/' . $category->gambar) }}"
                                    class="category-image"
                                    alt="{{ $category->nama_kategori }}"
                                >
                            @else
                                -
                            @endif
                        </td>

                        <td>{{ $category->nama_kategori }}</td>
                        <td>{{ $category->slug }}</td>

                        <td>
                            @if($category->status)
                                <span class="status">Aktif</span>
                            @else
                                <span class="status inactive">Nonaktif</span>
                            @endif
                        </td>

                        <td>
                            <div class="actions">
                                <a
                                    href="{{ route('admin.categories.edit', $category->id) }}"
                                    class="btn btn-edit"
                                >Edit</a>

                                <form
                                    action="{{ route('admin.categories.destroy', $category->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-delete">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">
                            Belum ada kategori.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $categories->links() }}
    </div>

</div>

</body>
</html>
