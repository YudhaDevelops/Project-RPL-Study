@if (isset($grooming) && $grooming != null)
    @foreach ($grooming as $mGrooming)
        <div class="modal fade bs-example-modal-xl" id="edit_modal_grooming_{{ $mGrooming->id_grooming }}" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            Edit Data Grooming
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                    </div>
                    <form action="{{route('jasa.update.grooming',['id'=> $mGrooming->id_grooming])}}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-5">
                                    <div class="height-100-p overflow-hidden">
                                        <div class="profile-tab height-100-p">
                                            <div class="tab height-100-p">
                                                <div class="tab-content">
                                                    <!-- Setting Tab start -->
                                                    <div class="tab-pane fade show active height-100-p" id="grooming"
                                                        role="tabpanel">
                                                        <div class="profile-setting">
                                                            <ul class="profile-edit-list row">
                                                                <li class="weight-500 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Nama Hewan</label>
                                                                        <input type="text" name="nama_hewan"
                                                                            class="form-control" value="{{isset($mGrooming->nama_hewan) ? $mGrooming->nama_hewan : ''}}" readonly
                                                                            id="">
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-6">
                                                                            <label>Tanggal</label>
                                                                            <input class="form-control form-control-lg" readonly
                                                                                type="" name="tanggal" value="{{isset($mGrooming->tanggal_grooming) ? $mGrooming->tanggal_grooming : ''}}">
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <label>Tahapan</label>
                                                                            <select class="form-control" name="tahapan" id="tahapan">
                                                                                <option value="" selected disabled>Pilih Tahapan</option>
                                                                                <option value="Pendataan" {{ $mGrooming->tahapan == "Pendataan" ? 'selected' : '' }}>Pendataan</option>
                                                                                <option value="Proses" {{ $mGrooming->tahapan == "Proses" ? 'selected' : '' }}>Proses</option>
                                                                            </select>
                                                                            {{-- <input class="form-control form-control-lg"
                                                                                type="" name="tanggal" value="{{isset($mGrooming->tahapan) ? $mGrooming->tahapan : ''}}"> --}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Jenis Grooming</label>
                                                                        <select name="jenis_grooming" disabled id="" class="form-control">
                                                                            <option value="" id="">Pilih Jenis Grooming</option>
                                                                            @if (isset($jasa) && $jasa != null)
                                                                                @foreach ($jasa as $item)
                                                                                    <option value="{{ $item->id }}" {{ $mGrooming->id_jasa == $item->id ? 'selected' : ''}}>
                                                                                        {{ $item->nama_jasa }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </li>
                                                                <li class="weight-500 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Nama Customer</label>
                                                                        <input id="nama_customer"
                                                                            class="form-control form-control-lg"
                                                                            name="nama_lengkap" readonly type="text"
                                                                            value="{{isset($mGrooming->nama_lengkap) ? $mGrooming->nama_lengkap : ''}}" />
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-6">
                                                                            <label>Waktu Masuk</label>
                                                                            <input value="{{isset($mGrooming->waktu_masuk) ? $mGrooming->waktu_masuk : ''}}"
                                                                                class="form-control form-control-lg time-picker-default"
                                                                                name="waktu_masuk" disabled>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <label>Waktu Keluar</label>
                                                                            <input value="{{isset($mGrooming->waktu_keluar) ? $mGrooming->waktu_keluar : ''}}"
                                                                                class="form-control form-control-lg time-picker-default"
                                                                                name="waktu_keluar">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Harga Jasa</label>
                                                                        <input id="harga_grooming" value="@currency($mGrooming->harga_jasa)"
                                                                            class="form-control form-control-lg" readonly
                                                                            type="text" value="" />
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- Setting Tab End -->
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
