<div class="p-3 bg-white d-flex justify-content-end align-items-center border-bottom gap-2">
    <button type="button" class="btn btn-sm btn-outline-success" onclick="submitBulkAction('restore', '{{ $modelType }}')">
        <i class="feather-rotate-ccw me-1"></i> Pulihkan Terpilih
    </button>
    <button type="button" class="btn btn-sm btn-outline-danger" onclick="submitBulkAction('force_delete', '{{ $modelType }}')">
        <i class="feather-trash-2 me-1"></i> Hapus Permanen Terpilih
    </button>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th style="width: 40px; text-align: center;">
                    <div class="form-check d-flex justify-content-center">
                        <input class="form-check-input" type="checkbox" onchange="toggleSelectAll(this, '{{ $modelType }}')">
                    </div>
                </th>
                <th style="width: 50px;">No</th>
                <th>Deskripsi / Nama</th>
                <th>Waktu Dihapus</th>
                <th style="width: 150px;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td class="text-center">
                        <div class="form-check d-flex justify-content-center">
                            <input class="form-check-input checkbox-{{ $modelType }}" type="checkbox" value="{{ $item->$idField }}">
                        </div>
                    </td>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-bold text-dark">{{ $item->$nameField ?? '-' }}</div>
                        @if($modelType == 'beritaacara' && isset($item->jenis_kegiatan))
                            <small class="text-muted">{{ $item->jenis_kegiatan }}</small>
                        @elseif(isset($item->tahun))
                            <small class="text-muted">Tahun: {{ $item->tahun }}</small>
                        @endif
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($item->deleted_at)->translatedFormat('d M Y, H:i') }}
                    </td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <form action="{{ route('pemulihan.restore') }}" method="POST" class="d-inline no-swal" data-restore-form>
                                @csrf
                                <input type="hidden" name="model" value="{{ $modelType }}">
                                <input type="hidden" name="ids[]" value="{{ $item->$idField }}">
                                <button type="button" class="btn btn-sm bg-light-success text-success border-0" title="Pulihkan"
                                    onclick="swalRestore(this, '{{ $item->$nameField ?? 'data ini' }}')"
                                >
                                    <i class="feather-rotate-ccw"></i>
                                </button>
                            </form>
                            <form action="{{ route('pemulihan.force_delete') }}" method="POST" class="d-inline no-swal" data-name="{{ $item->$nameField ?? 'data ini' }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="model" value="{{ $modelType }}">
                                <input type="hidden" name="ids[]" value="{{ $item->$idField }}">
                                <button type="submit" class="btn btn-sm bg-light-danger text-danger border-0" title="Hapus Permanen">
                                    <i class="feather-trash-2"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="alert alert-light mb-0" role="alert">
                            <i class="feather-inbox me-2"></i>Tidak ada data terhapus
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
