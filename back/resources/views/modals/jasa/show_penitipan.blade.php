@if ($penitipanAll != null)
    @foreach ($penitipanAll as $modalData)
        <div class="modal fade bs-example-modal-lg" id="show_penitipan_{{$modalData->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Show Data Jasa Penitipan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="data_id">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="nama_hewan">Nama Hewan</label>
                                    <input value="{{$modalData->nama_hewan}}" disabled type="text" name="nama_hewan" id="nama_hewan_show" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="nama_pemilik">Nama Pemilik</label>
                                    <input value="{{$modalData->nama_lengkap}}" disabled type="text" name="nama_pemilik" id=""class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="nomor_kandang">Nomor Kandang</label>
                                    <input value="{{$modalData->no_kandang}}" disabled type="text" name="nomor_kandang" id="bobot_show"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="durasi">Durasi</label>
                                    <input value="{{$modalData->durasi}}" disabled type="text" name="durasi" id="bobot_show"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="tanggal_masuk">Tanggal Masuk</label>
                                    <input value="{{$modalData->tanggal_masuk}}" disabled id="tanggal_masuk" type="text" name="stok" class="form-control form-control-lg datetimepicker">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="tanggal_keluar">Tanggal Pengambilan</label>
                                    <input value="{{$modalData->tanggal_keluar}}" disabled id="tanggal_keluar" type="text" name="stok" class="form-control form-control-lg datetimepicker">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="harga">Harga Total</label>
                                    <input value="{{$modalData->hargaPenitipanTotal}}" disabled type="text" name="harga" id="bobot_show"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif