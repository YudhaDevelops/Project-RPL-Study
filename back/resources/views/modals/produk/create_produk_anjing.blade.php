<div class="modal fade bs-example-modal-lg" id="create_modal_produk_anjing" tabindex="-1"
    role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Tambah Produk Anjing
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <form action="{{ route('anjing.simpan') }}" method="POST" id="form_create_anjing" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" value="{{ $idGenerate }}" name="kode_produk">
                            <div class="form-group  @error('nama_produk') has-danger @enderror">
                                <label for="nama_produk">Nama Produk</label>
                                <input value="{{ old('nama_produk') }}" type="text" name="nama_produk" id="nama_produk" 
                                    class="form-control 
                                         @error('nama_produk') form-control-danger @enderror" 
                                         @error('nama_produk') placeholder="{{ $message }}"@enderror >
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group @error('harga') has-danger @enderror ">
                                <label for="harga">Harga Jual</label>
                                <input value="{{ old('harga') }}" type="number" name="harga" id="harga"
                                    class="form-control
                                    @error('harga') form-control-danger @enderror" 
                                    @error('harga') placeholder="{{$errors->first('harga')}}"@enderror>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group @error('bobot')) has-danger @enderror ">
                                <label for="bobot">Bobot</label>
                                <input value="{{ old('bobot') }}" type="number" name="bobot" id="bobot"
                                    class="form-control
                                    @error('bobot') form-control-danger @enderror" 
                                    @error('bobot') placeholder="{{$errors->first('bobot')}}"@enderror>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group @error('stok')) has-danger @enderror">
                                <label for="stok">Stok</label>
                                <input value="{{ old('stok') }}" id="stok" type="text" value="0" name="stok"
                                    class="form-control
                                    @error('stok') form-control-danger @enderror" 
                                    @error('stok') placeholder="{{$errors->first('stok')}}"@enderror>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group @error('gambar_produk')) has-danger @enderror">
                                <label for="gambar_produk">Gambar Produk</label>
                                <input type="file" name="gambar_produk" id="gambar_produk" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit button" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
