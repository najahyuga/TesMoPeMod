<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Perangkat Modem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Monitoring Perangkat Modem</h1>

        <!-- Button Tambah Data -->
        <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>

        <!-- Search Form -->
        <form action="{{ route('modem.search') }}" method="GET" class="mb-3">
            {{-- <p>Action URL: {{ route('modem.search') }}</p> --}}
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Cari berdasarkan nama atau lokasi..." value="{{ request('query') }}">
                <button type="submit" class="btn btn-secondary">Cari</button>
            </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Perangkat</th>
                        <th>Lokasi Pemasangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($modems as $modem)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $modem->nama_perangkat }}</td>
                        <td>{{ $modem->lokasi_pemasangan }}</td>
                        <td>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $modem->id }}">Lihat</button>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $modem->id }}">Edit</button>
                            <form action="{{ route('modem.destroy', $modem->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Lihat -->
                    <div class="modal fade" id="viewModal{{ $modem->id }}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Perangkat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Nama Perangkat:</strong> {{ $modem->nama_perangkat }}</p>
                                    <p><strong>Lokasi Pemasangan:</strong> {{ $modem->lokasi_pemasangan }}</p>
                                    <p><strong>Lokasi Pemasangan:</strong> {{ $modem->tipe_modem }}</p>
                                    <p><strong>Lokasi Pemasangan:</strong> {{ $modem->status }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal{{ $modem->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Perangkat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('modem.update', $modem->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nama_perangkat" class="form-label">Nama Perangkat</label>
                                            <input type="text" class="form-control" name="nama_perangkat" value="{{ $modem->nama_perangkat }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="lokasi" class="form-label">Lokasi Pemasangan</label>
                                            <input type="text" class="form-control" name="lokasi_pemasangan" value="{{ $modem->lokasi_pemasangan }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="lokasi" class="form-label">Tipe Modem</label>
                                            <input type="text" class="form-control" name="tipe_modem" value="{{ $modem->tipe_modem }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="lokasi" class="form-label">Status Modem</label>
                                            <select class="form-select @error('status') is-invalid @enderror" name="status" aria-label="Default select example">
                                                <option value="aktif" {{ $modem->status == 'aktif' ? 'selected' : '' }}>aktif</option>
                                                <option value="nonaktif" {{ $modem->status == 'nonaktif' ? 'selected' : '' }}>nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $modems->links('pagination::bootstrap-5') }}
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Perangkat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('modem.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_perangkat" class="form-label">Nama Perangkat</label>
                            <input type="text" class="form-control" name="nama_perangkat" required>
                        </div>
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi Pemasangan</label>
                            <input type="text" class="form-control" name="lokasi_pemasangan" required>
                        </div>
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Tipe Modem</label>
                            <input type="text" class="form-control" name="tipe_modem" required>
                        </div>
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" aria-label="Default select example">
                                <option selected>Pilih Status</option>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>aktif</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>
