@if ($data != null)
    @foreach ($data as $modalUpdate)
    <div class="modal fade bs-example-modal-lg" id="edit_modal_produk_kucing_{{$modalUpdate->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Edit Data Produk Kucing</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="{{route('kucing.update',['id'=>$modalUpdate->id])}}" method="POST" id="form_edit_anjing" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <input type="hidden" value="{{ $idGenerate }}" name="kode_produk">
                                <div class="form-group  @error('nama_produk') has-danger @enderror">
                                    <label for="nama_produk">Nama Produk</label>
                                    <input value="{{$modalUpdate->nama_produk}}" type="text" name="nama_produk" id="nama_produk" 
                                        class="form-control 
                                            @error('nama_produk') form-control-danger @enderror" 
                                            @error('nama_produk') placeholder="{{ $message }}"@enderror >
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('harga') has-danger @enderror ">
                                    <label for="harga">Harga Jual</label>
                                    <input value="{{$modalUpdate->harga}}" type="number" name="harga" id="harga"
                                        class="form-control
                                        @error('harga') form-control-danger @enderror" 
                                        @error('harga') placeholder="{{$errors->first('harga')}}"@enderror>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('bobot')) has-danger @enderror ">
                                    <label for="bobot">Bobot</label>
                                    <input value="{{$modalUpdate->bobot}}" type="number" name="bobot" id="bobot"
                                        class="form-control
                                        @error('bobot') form-control-danger @enderror" 
                                        @error('bobot') placeholder="{{$errors->first('bobot')}}"@enderror>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('stok')) has-danger @enderror">
                                    <label for="stok">Stok</label>
                                    <input value="{{$modalUpdate->stok}}" id="stok" type="text" value="0" name="stok"
                                        class="form-control
                                        @error('stok') form-control-danger @enderror" 
                                        @error('stok') placeholder="{{$errors->first('stok')}}"@enderror>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group" >
                                    <img alt="" width="100px" src="@if ($modalUpdate->gambar_produk != null)
                                            {{$modalUpdate->gambar_produk}}
                                        @endif">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('gambar_produk_update')) has-danger @enderror">
                                    <label for="gambar_produk_update">Gambar Produk</label>
                                    <input type="file" name="gambar_produk_update" id="gambar_produk_update" class="form-control">
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
    @endforeach
@endif