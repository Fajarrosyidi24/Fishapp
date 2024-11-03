@extends('layouts.app_admin')
@section('title')
    <title>Detail Nelayan Page - Fishapp</title>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm border-0 rounded">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Detail Nelayan</h4>
            </div>
            <div class="card-body">
                <form>
                    <div class="row mb-4">
                        <label for="name" class="col-md-3 col-form-label fw-semibold">Nama</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="name" value="{{ $nelayan->name }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="email" class="col-md-3 col-form-label fw-semibold">Email</label>
                        <div class="col-md-9">
                            <input type="email" class="form-control" id="email" value="{{ $nelayan->email }}"
                                readonly>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="phone" class="col-md-3 col-form-label fw-semibold">Nomor Telepon</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="phone"
                                value="{{ $nelayan->detailprofile->no_telepon ?? 'N/A' }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="status" class="col-md-3 col-form-label fw-semibold">Status</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="status" value="{{ $nelayan->status }}"
                                readonly>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="status" class="col-md-3 col-form-label fw-semibold">Jenis Kelamin</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="status"
                                value="{{ $nelayan->detailProfile->jenis_kelamin }}" readonly>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="alamat" class="fw-semibold">Tempat Dan Tanggal Lahir</label>
                        <div class="row gx-2">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="dusun" name="dusun"
                                    value="{{ $nelayan->detailProfile->tempat_lahir }}," readonly>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="dusun" name="dusun"
                                    value="{{ $nelayan->detailProfile->tanggal_lahir }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="alamat" class="fw-semibold">Alamat Lengkap</label>
                        <div class="row gx-2">
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="dusun" name="dusun"
                                    value="{{ $nelayan->detailProfile->provinsi }}" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="dusun" name="dusun"
                                    value="{{ $nelayan->detailProfile->kabupaten }}" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="dusun" name="dusun"
                                    value="{{ $nelayan->detailProfile->kecamatan }}" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="dusun" name="dusun"
                                    value="{{ $nelayan->detailProfile->desa }}" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="dusun" name="dusun"
                                    value="{{ $nelayan->detailProfile->dusun }}" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="dusun" name="dusun"
                                    value="{{ $nelayan->detailProfile->rt }}" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="dusun" name="dusun"
                                    value="{{ $nelayan->detailProfile->rw }}" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="dusun" name="dusun"
                                    value="{{ $nelayan->detailProfile->code_pos }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <textarea class="form-control" id="address" rows="3" readonly>{{ $nelayan->detailProfile->alamat_lengkap ?? 'N/A' }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="status" class="col-md-3 col-form-label fw-semibold">Nama Kapal</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="status"
                                value="{{ $nelayan->detailProfile->nama_kapal }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="status" class="col-md-3 col-form-label fw-semibold">Jenis Kapal</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="status"
                                value="{{ $nelayan->detailProfile->jenis_kapal }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="status" class="col-md-3 col-form-label fw-semibold">Jenis Kapal</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" id="status"
                                value="{{ $nelayan->detailProfile->jumlah_abk }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="foto" class="col-md-3 col-form-label fw-semibold">Foto</label>
                        <div class="col-md-9">
                            <img src="{{ asset('storage/fotonelayan/' . $nelayan->detailProfile->foto) }}"
                                alt="Foto Nelayan" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                    </div>
                   @if ($nelayan->status === 'pending')
                   <div class="form-group mb-4">
                    <div class="row gx-2">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success w-100" data-bs-toggle="modal"
                                data-bs-target="#confirmModal">Verifikasi Permintaan</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-danger w-100" id="rejectButton">Tolak
                                Permintaan</button>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-md-6">
                    <a href="{{route('admin.dashboard')}}">
                        <button type="button" class="btn btn-secondary w-50">Kembali</button>
                    </a>
                </div>                
                   @endif

                </form>

                <!-- Modal -->
                <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Verifikasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin memverifikasi akun ini menjadi nelayan?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <form action="{{ route('verifikasi.nelayan', $nelayan->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Verifikasi</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="rejectionForm" class="mt-4" style="display: none;" class="mb-3 my-4"
                    action="{{ route('tolakakunnelayan', ['id' => $nelayan->id]) }}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Alasan Penolakan Akun</h5>
                        <button type="button" class="btn-close" aria-label="Close"
                            onclick="hideRejectionForm()"></button>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="reason1"
                            value="Dokumen identitas tidak valid atau tidak lengkap.">
                        <label class="form-check-label" for="reason1">Dokumen identitas tidak valid atau tidak
                            lengkap.</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="reason2"
                            value="Data pribadi yang disediakan tidak sesuai">
                        <label class="form-check-label" for="reason2">Data pribadi yang disediakan tidak sesuai</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="reason3"
                            value="Akun terindikasi melakukan aktivitas yang mencurigakan.">
                        <label class="form-check-label" for="reason3">Akun terindikasi melakukan aktivitas yang
                            mencurigakan.</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="reason4"
                            value="Pengajuan akun tidak memenuhi persyaratan pendaftaran.">
                        <label class="form-check-label" for="reason4">Pengajuan akun tidak memenuhi persyaratan
                            pendaftaran.</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="reasonOther" value="Lainnya">
                        <label class="form-check-label" for="reasonOther">Lainnya</label>
                    </div>
                    <textarea class="form-control mb-2" name="reason5" id="otherReasonInput" rows="3"
                        placeholder="Inputkan alasan lainnya..." style="display: none;"></textarea>

                    <button type="submit" class="btn btn-danger" id="submitButton2" disabled>Tolak Permintaan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('foot')
    <script>
        document.getElementById('rejectButton').addEventListener('click', function() {
            document.getElementById('rejectionForm').style.display = 'block';
        });

        document.getElementById('reasonOther').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('otherReasonInput').style.display = 'block';
            } else {
                document.getElementById('otherReasonInput').style.display = 'none';
            }
        });
    </script>

    <script>
        // JavaScript to enable or disable the submit button based on checkbox selection
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('rejectionForm');
            const checkboxes = form.querySelectorAll('.form-check-input');
            const submitButton = document.getElementById('submitButton2');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Enable the button if at least one checkbox is checked
                    submitButton.disabled = !Array.from(checkboxes).some(cb => cb.checked);
                });
            });
        });
    </script>

    <script>
        function hideRejectionForm() {
            document.getElementById('rejectionForm').style.display = 'none';
        }

        // Optional: Enable/disable the submit button based on checkbox selection
        const checkboxes = document.querySelectorAll('#rejectionForm .form-check-input');
        const submitBtn = document.getElementById('submitBtn');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                submitBtn.disabled = !Array.from(checkboxes).some(cb => cb.checked);
            });
        });
    </script>
@endsection
