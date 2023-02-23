<div class="modal fade bs-example-modal-xl" id="bayar_grooming_modal" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Pembayaran
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-30">
                    <div class="pd-5">
                        <div class="row my-3">
                            <div id="pemilik_judul" class="col-sm-4">
                                <h4 class="text-black h4">Pemilik : </h4>
                            </div>
                        </div>
                    </div>
                    <div class="pb-20">
                        <div class="container-fluid">
                            <table class="table table-hover">
                                <thead>
                                    <tr class=" text-center">
                                        <th>nama Hewan</th>
                                        <th>Jasa Terpakai</th>
                                        <th>Harga Per-Jasa</th>
                                    </tr>
                                </thead>
                                <tbody id="table-bayar">
                                </tbody>
                            </table>

                            {{-- total semua --}}
                            <hr>
                            <form action="{{ route('jasa.pembayaran-jasa') }}" method="POST">
                                @csrf
                                <div class="row mt-5">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group ml-3 float-left row">
                                            <label class="my-2">Total Semua : </label>
                                            <input type="hidden" name="pemilik" value="" id="pemilik">
                                            <div class="col-md-8">
                                                <input type="hidden" name="total_bayar" id="total_bayar_cs"
                                                    value="">
                                                <input class="form-control" id="total_bayar_lihat" style="width: 250px"
                                                    type="text" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group  row float-right pr-3">
                                            <label class="my-2">Bayar : </label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="user_membayar" id="user_membayar_jasa"
                                                    style="width: 250px" type="text" value="">
                                            </div>
                                            <button href="#" id="btn_bayar" disabled class="btn btn-outline-primary"
                                                type="button submit">
                                                <i class="icon-copy dw dw-shopping-cart1"></i>
                                                Bayar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mt-1">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group ml-3 float-left row">
                                            <label class="my-2">Kembali : </label>
                                            <div class="col-md-8">
                                                <input type="hidden" name="kembalian" id="kembalian2">
                                                <input class="form-control" id="kembalian" style="width: 250px"
                                                    type="text" value="Rp. " readonly>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6 col-sm-12">
                                        <div class="form-group  row float-right pr-3">
                                            <div class="co-md-12">
                                                <a href="" target="_blank" class="btn btn-outline-info"
                                                    type="button">Print Untuk Bukti Pebayaran</a>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                {{-- <input type="hidden submit" name=""> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
