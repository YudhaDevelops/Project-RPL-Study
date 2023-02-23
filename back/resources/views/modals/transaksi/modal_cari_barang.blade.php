<div class="modal fade bs-example-modal-lg" id="modal_cari_barang" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Cari Produk
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="data-table table stripe hover nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Stok</th>
                                    <th class="datatable-nosort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($produk) && $produk != null)
                                <?php $i = 1 ?>
                                    @foreach ($produk as $item)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $item->kode_produk }}</td>
                                            <td>{{ $item->nama_produk }}</td>
                                            <td>{{ $item->stok }}</td>
                                            <td>
                                                <a href="{{route('kasir.tambah_keranjang',['id'=>$item->kode_produk])}}" class="btn btn btn-success btn-small-success">
                                                    <i class="icon-copy dw dw-shopping-cart2"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
