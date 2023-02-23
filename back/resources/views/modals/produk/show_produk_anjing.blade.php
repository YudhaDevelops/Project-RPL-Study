@if ($data != null)
    @foreach ($data as $modalData)
        <div class="modal fade bs-example-modal-lg" id="show_modal_produk_anjing_{{$modalData->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Show Data Produk Anjing</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="data_id">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nama_produk">Nama Produk</label>
                                    <input value="{{$modalData->nama_produk}}" disabled type="text" name="nama_produk" id="nama_produk_show" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="harga">Harga Jual</label>
                                    <input value="{{$modalData->harga}}" disabled type="number" name="harga" id=""class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="bobot">Bobot</label>
                                    <input value="{{$modalData->bobot}}" disabled type="number" name="bobot" id="bobot_show"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="demo3">Stok</label>
                                    <input value="{{$modalData->stok}}" disabled id="demo3" type="text" name="stok" class="form-control stok_show">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="form-group" id="bungkus_gambar_show">
                                        <img id="show_produk_show" alt="" width="100px" src="@if ($modalData->gambar_produk != null)
                                            {{$modalData->gambar_produk}}
                                        @endif">
                                    </div>
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