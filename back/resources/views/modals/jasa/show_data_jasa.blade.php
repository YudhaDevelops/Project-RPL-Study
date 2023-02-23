@if (isset($data) && $data != null)
    @foreach ($data as $item)
        <div class="modal fade bs-example-modal-lg" id="show_modal_jasa{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Show Data Jasa</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="data_id">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nama_produk">Nama Jasa</label>
                                    <input value="{{$item->nama_jasa}}" readonly type="text" name="nama_jasa" id="nama_jasa_show" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="harga_jasa">Harga Jasa</label>
                                    <input value="{{$item->harga_jasa}}" readonly type="number" name="harga_jasa" id=""class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="form-group" id="bungkus_gambar_show">
                                        <img id="show_produk_show" alt="" width="100px" src="@if ($item->gambar_produk != null)
                                            {{$item->gambar_produk}}
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