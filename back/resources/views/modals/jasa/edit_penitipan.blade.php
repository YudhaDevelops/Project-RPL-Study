@if ($penitipanAll != null)
    @foreach ($penitipanAll as $modalUpdate)
    <div class="modal fade bs-example-modal-lg dragable_modal" id="edit_penitipan_{{$modalUpdate->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Edit Data Jasa Penitipan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="{{route('penitipan.update',['id'=>$modalUpdate->id_penitipan])}}" method="POST" id="form_edit_penitipan" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group  @error('no_kandang') has-danger @enderror">
                                    <label for="no_kandang">Nomor Kandang</label>
                                    <input value="{{$modalUpdate->no_kandang}}" type="text" name="no_kandang" id="no_kandang" 
                                        class="form-control 
                                            @error('no_kandang') form-control-danger @enderror" 
                                            @error('no_kandang') placeholder="{{ $message }}"@enderror >
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                {{--tampilan kosong--}}
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('tanggal_masuk')) has-danger @enderror ">
                                    <label for="tanggal_masuk">Tanggal Masuk</label>
                                    <input value="{{$modalUpdate->tanggal_masuk}}" type="text" name="tanggal_masuk" id="tanggal_masuk"
                                        class="form-control form-control-lg" disabled>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('tanggal_keluar')) has-danger @enderror">
                                    <label for="tanggal_keluar">Tanggal Ambil</label>
                                    <input value="{{$modalUpdate->tanggal_keluar}}" id="tanggal_keluar" type="text" value="0" name="tanggal_keluar"
                                        class="form-control form-control-lg datetimepicker
                                        @error('tanggal_keluar') form-control-danger @enderror" 
                                        @error('tanggal_keluar') placeholder="{{$errors->first('tanggal_keluar')}}"@enderror>
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