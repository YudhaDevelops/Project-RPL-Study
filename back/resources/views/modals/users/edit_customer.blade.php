@if (isset($customer) && $customer != null)
    @foreach ($customer as $modalCustomer)
        <div class="modal fade bs-example-modal-xl" id="update_modal_customer_{{ $modalCustomer->id_user }}" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            Edit Data Customer
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                    </div>
                    <form action="{{ route('kasir.update.customer', ['id' => $modalCustomer->id_user]) }}" method="post">
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
                                                                        <label>Nama Lengkap</label>
                                                                        <input class="form-control form-control-lg"
                                                                            name="nama_lengkap"
                                                                            value="{{ $modalCustomer->nama_lengkap }}"
                                                                            type="text" />
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input
                                                                            class="form-control form-control-lg"type="email"
                                                                            name="email"
                                                                            value="{{ $modalCustomer->email ? $modalCustomer->email : '' }}" />
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Gender</label>
                                                                        <div class="d-flex">
                                                                            <div
                                                                                class="custom-control custom-radio mb-5 mr-20">
                                                                                <input type="radio"
                                                                                    id="pria_edit_customer" value="Laki-Laki"
                                                                                    name="gender"{{ $modalCustomer->gender == 'Laki-Laki' ? 'checked' : '' }}
                                                                                    class="custom-control-input" />
                                                                                <label
                                                                                    class="custom-control-label weight-400"
                                                                                    for="pria_edit_customer">Laki-Laki</label>
                                                                            </div>
                                                                            <div
                                                                                class="custom-control custom-radio mb-5">
                                                                                <input type="radio"
                                                                                    id="perempuan_edit_customer"
                                                                                    value="Perempuan"
                                                                                    name="gender"{{ $modalCustomer->gender == 'Perempuan' ? 'checked' : '' }}
                                                                                    class="custom-control-input" />
                                                                                <label
                                                                                    class="custom-control-label weight-400"
                                                                                    for="perempuan_edit_customer">Perempuan</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Phone Number</label>
                                                                        <input class="form-control form-control-lg"
                                                                            name="no_telpon"
                                                                            value="{{ $modalCustomer->no_telepon ? $modalCustomer->no_telepon : '' }}"
                                                                            type="text" />
                                                                    </div>
                                                                </li>
                                                                {{-- edit alamat --}}
                                                                <li class="weight-500 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Provinsi</label>
                                                                        <select
                                                                            class="custom-select2 form-control"id="provinsi"
                                                                            name="provinsi"
                                                                            style="width: 100%; height: 38px">
                                                                            <option value="#" selected disabled>
                                                                                Provinsi</option>
                                                                            @if (isset($data) && $data != null)
                                                                                <option value="{{ $data->id }}"
                                                                                    {{ isset($modalCustomer->provinsi) ? 'selected' : '' }}>
                                                                                    {{ $data->nama }}
                                                                                </option>
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Kabupaten</label>
                                                                        <select id="kabupaten" name="kabupaten"
                                                                            class="custom-select2 form-control"
                                                                            style="width: 100%; height: 38px">
                                                                            <option value="" selected>
                                                                                {{ isset($modalCustomer->kabupaten) ? $modalCustomer->kabupaten : 'Kabupaten' }}
                                                                            </option>
                                                                            @foreach ($kabupaten as $item)
                                                                                <option value="{{ $item->id }}">
                                                                                    {{ $item->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Kecamatan</label>
                                                                        <select id="kecamatan" name="kecamatan"
                                                                            class="custom-select2 form-control"
                                                                            style="width: 100%; height: 38px">
                                                                            <option value="" selected>
                                                                                {{ isset($modalCustomer->kecamatan) ? $modalCustomer->kecamatan : 'Kecamatan' }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Kelurahan</label>
                                                                        <select id="kelurahan" name="kelurahan"
                                                                            class="custom-select2 form-control"
                                                                            style="width: 100%; height: 38px">
                                                                            <option value="" selected>
                                                                                {{ isset($modalCustomer->kelurahan) ? $modalCustomer->kelurahan : 'Kelurahan' }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </li>
                                                                <li class="weight-500 col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Detail Alamat</label>
                                                                        <textarea name="detail_alamat" class="form-control">{{ isset($modalCustomer->detail_alamat) ? $modalCustomer->detail_alamat : '' }}</textarea>
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
