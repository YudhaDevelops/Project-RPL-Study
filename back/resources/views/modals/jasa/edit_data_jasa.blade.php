@if ($data != null)
    @foreach ($data as $modalUpdate)
    <div class="modal fade bs-example-modal-lg" id="edit_modal_jasa{{$modalUpdate->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Edit Data Jasa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="{{route('owner.update-jasa',['id'=>$modalUpdate->id])}}" method="POST" id="form_edit_jasa" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group  @error('nama_jasa') has-danger @enderror">
                                    <label for="nama_jasa">Nama Produk</label>
                                    <input value="{{$modalUpdate->nama_jasa}}" type="text" name="nama_jasa" id="nama_jasa" 
                                        class="form-control 
                                            @error('nama_jasa') form-control-danger @enderror" 
                                            @error('nama_jasa') placeholder="{{ $message }}"@enderror >
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('harga_jasa') has-danger @enderror ">
                                    <label for="harga_jasa">Harga Jasa</label>
                                    <input value="{{$modalUpdate->harga_jasa}}" type="number" name="harga_jasa" id="harga_jasa"
                                        class="form-control
                                        @error('harga_jasa') form-control-danger @enderror" 
                                        @error('harga_jasa') placeholder="{{$errors->first('harga_jasa')}}"@enderror>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group" >
                                    <img alt="" width="100px" src="{{isset($modalUpdate->gambar_jasa) ? $modalUpdate->gambar_jasa : 'https://blue.kumparan.com/image/upload/fl_progressive,fl_lossy,c_fill,q_auto:best,w_640/v1634025439/345904dd98766f700f6c92f61bc6a08b13a5b1f39d4b7c33ba4f789814cff17c.jpg'}}">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('gambar_jasa_update')) has-danger @enderror">
                                    <label for="gambar_jasa_update">Gambar Produk</label>
                                    <input type="hidden" id="id_jasa_modal_edit" >
                                    <input type="file"  name="gambar_jasa_update" id="gambar_jasa_update" data-id="{{$modalUpdate->id}}" class="form-control">
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