@if (isset($keranjang) && $keranjang != null)
    @foreach ($keranjang as $modal_keranjang)
        <div class="modal fade" id="update_jumlah_barang_{{ $modal_keranjang->kode_produk }}" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="myLargeModalLabel">
                            Tambah Jumlah Barang
                        </h6>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                    </div>
                    <form action="{{route('update.updateKeranjang',['kode_produk'=>$modal_keranjang->kode_produk])}}" method="post">
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        @csrf
                                        <label for="jumlah_barang">Tambah Jumlah Barang?</label>
                                        <input type="text" id="jumlah_barang" name="jumlah_barang" value="1" placeholder="Mau Tambah Brapa Jumlah Nya?">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Close
                            </button>
                            <button type="button submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endif
