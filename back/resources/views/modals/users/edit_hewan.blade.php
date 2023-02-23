@if (isset($customer) && $customer != null)
    @foreach ($customer as $mHewan)
        <div class="modal fade bs-example-modal-xl" id="update_hewan_{{ $mHewan->id_hewan }}" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            Edit Data Hewan
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                    </div>
                    <form action="{{ route('update.update-hewan', ['id' => $mHewan->id_hewan]) }}" method="post"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <div class=" height-100-p overflow-hidden">
                                        <div class="profile-tab height-100-p">
                                            <div class="tab height-100-p">
                                                <div class="tab-content">
                                                    <!-- personal Setting Tab start -->
                                                    <div class="tab-pane fade show active height-100-p" id="setting"
                                                        role="tabpanel">
                                                        <div class="profile-setting">
                                                            <ul class="profile-edit-list row">
                                                                <li class="weight-500 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Nama Hewan</label>
                                                                        <input type="text" name="nama_hewan"
                                                                            value="{{ isset($mHewan->nama_hewan) ? $mHewan->nama_hewan : '' }}"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Jenis Hewan</label>
                                                                        <div class="d-flex">
                                                                            <div
                                                                                class="custom-control custom-radio mb-5 mr-20">
                                                                                <input type="radio" id="anjing_edit"
                                                                                    name="jenis_hewan" value="Anjing"
                                                                                    {{ $mHewan->tipe_hewan == 'Anjing' ? 'checked' : '' }}
                                                                                    class="custom-control-input" />
                                                                                <label
                                                                                    class="custom-control-label weight-400"
                                                                                    for="anjing_edit">Anjing</label>
                                                                            </div>
                                                                            <div
                                                                                class="custom-control custom-radio mb-5">
                                                                                <input type="radio" id="kucing_edit"
                                                                                    name="jenis_hewan" value="Kucing"
                                                                                    {{ $mHewan->tipe_hewan == 'Kucing' ? 'checked' : '' }}
                                                                                    class="custom-control-input" />
                                                                                <label
                                                                                    class="custom-control-label weight-400"
                                                                                    for="kucing_edit">Kucing</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="weight-500 col-md-6">
                                                                    <div class="form-group row">
                                                                        <div class="col-6">
                                                                            <label for="umur_hewan">Umur Hewan</label>
                                                                            <input type="number" name="umur_hewan"
                                                                                value="{{ isset($mHewan->umur_hewan) ? $mHewan->umur_hewan : '' }}"
                                                                                class="form-control">
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <label>Gambar Hewan</label>
                                                                            <input type="file" class="form-control"
                                                                                name="gambar_hewan" id="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="pemilik">Nama Pemilik</label>
                                                                        <select name="nama_pemilik"
                                                                            class="custom-select2 form-control"
                                                                            id="nama_pemilik"
                                                                            style="width: 100%; height: 38px">
                                                                            <option value="" selected disabled>
                                                                                Pilih Pemilik</option>
                                                                            <option value="" selected disabled>
                                                                                {{ isset($mHewan->nama_lengkap) ? $mHewan->nama_lengkap : '' }}
                                                                            </option>
                                                                            @if (isset($user) && $user != null)
                                                                                @foreach ($user as $item)
                                                                                    <option value="{{ $item->id }}">
                                                                                        {{ $item->nama_lengkap }}
                                                                                    </option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Close
                            </button>
                            <button type="button submit" class="btn btn-primary">
                                Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endif
