@if (isset($kasir) && $kasir != null)
    @foreach ($kasir as $modalKasir)
        <div class="modal fade bs-example-modal-xl" id="edit_modal_kasir_{{ $modalKasir->id }}" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            Edit Data Kasir
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                    </div>
                    <form action="{{route('update.update-account-kasir',['id'=>$modalKasir->id])}}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <div class=" height-100-p">
                                        <div class="profile-tab height-100-p">
                                            <div class="tab height-100-p">
                                                <div class="tab-content">
                                                    <!-- personal Setting Tab start -->
                                                    <div class="tab-pane fade show active height-100-p" id="setting" role="tabpanel">
                                                        <div class="profile-setting">
                                                            <ul class="profile-edit-list row">
                                                                <li class="weight-500 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Nama Lengkap</label>
                                                                        <input class="form-control form-control-lg" 
                                                                        value="{{ old('nama_lengkap',$modalKasir->nama_lengkap) }}" type="text" name="nama_lengkap" />
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input class="form-control form-control-lg"
                                                                            type="email" name="email"value="{{ old('email',$modalKasir->email) }}"/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Gender</label>
                                                                        <div class="d-flex">
                                                                            <div class="custom-control custom-radio mb-5 mr-20">
                                                                                <input type="radio" id="pria_{{ $modalKasir->id }}"
                                                                                    name="gender" value="Laki-Laki"
                                                                                    class="custom-control-input" @if($modalKasir->gender == "Laki-Laki") checked="checked" @endif/>
                                                                                <label class="custom-control-label weight-400"
                                                                                    for="pria_{{ $modalKasir->id }}">Laki-Laki</label>
                                                                            </div>
                                                                            <div class="custom-control custom-radio mb-5">
                                                                                <input type="radio" id="wanita_{{ $modalKasir->id }}"
                                                                                name="gender" value="Perempuan"
                                                                                class="custom-control-input" @if($modalKasir->gender == "Perempuan") checked="checked" @endif/>
                                                                                <label class="custom-control-label weight-400"
                                                                                for="wanita_{{ $modalKasir->id }}">Perempuan</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Phone Number</label>
                                                                        <input class="form-control form-control-lg"
                                                                            type="text" value="{{ old('no_telepon',$modalKasir->no_telepon) }}" name="no_telepon"/>
                                                                    </div>
                                                                </li>
                                                                {{-- edit alamat --}}
                                                                <li class="weight-500 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Provinsi</label>
                                                                        <select class="form-control form-control-lg" name="provinsi">
                                                                            <option value="">Pilih Provinsi</option>
                                                                            @if (isset($prov) && $prov != null)
                                                                                <option value="{{ $prov->id }}" {{isset($modalKasir->provinsi) ? 'selected' : ''}}>
                                                                                    {{ $prov->nama }}
                                                                                </option>
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Kabupaten</label>
                                                                        <select class=" form-control form-control-lg" name="kabupaten">
                                                                            <option value="" selected>{{isset($modalKasir->kabupaten) ? $modalKasir->kabupaten : 'Kabupaten'}}</option>
                                                                            @if (isset($kabupaten) && $kabupaten != null)
                                                                                @foreach ($kabupaten as $item)
                                                                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Kecamatan</label>
                                                                        <select class=" form-control form-control-lg" name="kecamatan">
                                                                            <option value="" selected>{{isset($modalKasir->kecamatan) ? $modalKasir->kecamatan : 'Kecamatan'}}</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Kelurahan</label>
                                                                        <select class=" form-control form-control-lg" name="kelurahan">
                                                                            <option value="" selected>{{isset($modalKasir->kelurahan) ? $modalKasir->kelurahan : 'Kelurahan'}}</option>
                                                                        </select>
                                                                    </div>
                                                                </li>
                                                                <li class="weight-500 col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Detail Alamat</label>
                                                                        <textarea class="form-control" name="detail_alamat">{{isset($modalKasir->detail_alamat) ? $modalKasir->detail_alamat : ''}}</textarea>
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
                                Update data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endif
