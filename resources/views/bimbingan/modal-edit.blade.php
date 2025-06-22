@if (auth()->user()->role_id == 3)
    <div class="modal fade" id="editModal{{ $bim->id }}" tabindex="-1"
        aria-labelledby="editModalLabel{{ $bim->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $bim->id }}">
                        Edit Bimbingan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('bimbingan.update', $bim->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control"
                                id="tanggal" name="tanggal"
                                value="{{ $bim->tanggal }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="topik_bimbingan" class="form-label">Topik
                                Bimbingan</label>
                            <textarea class="form-control" id="topik_bimbingan" name="topik_bimbingan" rows="5" required>{{ $bim->topik_bimbingan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="dospem1" class="form-label">Dosen
                                Pembimbing</label>
                            <select class="form-select" id="dospem1"
                                name="dospem1" required>
                                <option hidden value="">Pilih Dosen Pembimbing</option>
                                @foreach ($dospem as $dos)
                                    <option value="{{ $dos->id }}"
                                        {{ $bim->dospem1 == $dos->id ? 'selected' : '' }}>
                                        {{ $dos->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">File</label>
                            <input type="file" class="form-control"
                                id="file" name="file"
                                accept=".pdf,.doc,.docx">
                            <small class="text-muted">
                                Unggah file bimbingan (.pdf, .doc, .docx), maksimal
                                10MB. Biarkan kosong jika tidak ingin mengubah file.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@else
    {{-- Modal Edit untuk Dosen Pembimbing --}}
    <div class="modal fade" id="editModal{{ $bim->id }}" tabindex="-1"
        aria-labelledby="editModalLabel{{ $bim->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="editModalLabel{{ $bim->id }}">
                        Edit Bimbingan
                    </h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('bimbingan.updateStatus', $bim->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status"
                                class="form-label">Status</label>
                            <select class="form-select" id="status"
                                name="status" required>
                                <option value="Maju Sempro"
                                    {{ $bim->status == 'Maju Sempro' ? 'selected' : '' }}>
                                    Maju Sempro</option>
                                <option value="Bimbingan Ulang"
                                    {{ $bim->status == 'Bimbingan Ulang' ? 'selected' : '' }}>
                                    Bimbingan Ulang</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="review"
                                class="form-label">Review</label>
                            <textarea class="form-control" id="review" name="review" rows="5">{{ $bim->review }}</textarea>
                            <small class="text-muted">Isi review jika ada.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
