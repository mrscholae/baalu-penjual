reload_data();


function reload_data(){
    let result = ajax(url_base+"pelanggan/ajax_pelanggan/"+id_pelanggan, "POST", "");

    html = "";
    
    if(result.pelanggan.hapus == 0){
        
        if(result.pelanggan.pembelian == 0){
            best_seller = "";
        } else {
            best_seller = `<a href="#rekapPembelian" data-toggle="modal" class="btn btn-circle btn-warning mr-1 rekapPembelian" data-id="`+result.pelanggan.id_pelanggan+`|`+result.pelanggan.nama_pelanggan+`"><i class="fa fa-star"></i></a>`;
        }

        html += `
                <div class="col-12 col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-building mr-1"></i>Profil Pelanggan</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated-fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Data Pelanggan</div>
                                    <a class="dropdown-item editPelanggan" href="#editPelanggan" data-toggle="modal" data-id="`+result.pelanggan.id_pelanggan+`">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item hapusPelanggan" href="javascript:void(0)" data-id="`+result.pelanggan.id_pelanggan+`|`+result.pelanggan.nama_pelanggan+`">Hapus</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-gray-900">
                            <p><i class="fa fa-user-circle mr-4"></i>`+result.pelanggan.nama_pelanggan+`</p>
                            <p><i class="fa fa-phone mr-4"></i>`+result.pelanggan.no_hp+`</p>
                            <p><i class="fa fa-map-marker-alt mr-4"></i>`+result.pelanggan.alamat+`</p>
                            <p><i class="fa fa-map-signs mr-3"></i>`+result.pelanggan.kecamatan+`</p>
                            <p><i class="fa fa-calendar-alt mr-4"></i>`+result.pelanggan.tgl_bergabung+`</p>
                            <p><i class="fa fa-shopping-bag mr-3"></i>`+result.pelanggan.pembelian+` pembelian </p>
                            <div class="d-flex justify-content-center mt-1">
                                <a href="#addPembelian" data-toggle="modal" class="btn btn-circle btn-success mr-1 addPembelian" data-id="`+result.pelanggan.id_pelanggan+`|`+result.pelanggan.nama_pelanggan+`"><i class="fa fa-shopping-bag"></i></a>
                                `+best_seller+`
                            </div>
                        </div>
                    </div>
                </div>`;

        html += `<div class="col-12 mb-4">
            <h5 class="mb-0 text-gray-800">List Pembelian</h5>
        </div>`;

        if(result.pembelian.length != 0){
            result.pembelian.forEach(data => {                
                html += `<div class="col-12 col-md-4">
                    <div class="card shadow mb-4">
                        <div class="list-group-item-success card-header py-3 d-flex flex-row align-items-center justify-content-between">    
                            <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-check-circle text-success mr-1"></i>Selesai</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Pembelian</div>
                                    <a class="dropdown-item detailPembelian" href="#detailPembelian" data-id="`+data.id_pembelian+`" data-toggle="modal">Detail</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-gray-900">
                            <p><i class="fa fa-map-marker-alt mr-4"></i>`+data.alamat+` </p>
                            <p><i class="fa fa-map-signs mr-3"></i>`+data.kecamatan+`</p>
                            <p><i class="fa fa-calendar mr-3"></i>`+data.tgl_pembelian+`</p>
                            <p><i class="fa fa-hand-holding-usd mr-3 text-success"></i>`+data.total+`</p>
                        </div>
                    </div>
                </div>`;
            });
        } else {
            html += `<div class="col-12"><div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning mr-1"></i>Data pembelian kosong</div></div>`
        }
    } else {
        html += `<div class="col-12"><div class="alert alert-danger"><i class="fa fa-times-circle text-danger mr-1"></i>Data pelanggan ini telah dihapus</div></div>`
    }

    $("#dataAjax").html(html);
}