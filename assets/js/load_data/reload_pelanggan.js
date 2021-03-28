reload_data();


$(document).tooltip({selector : '[data-toggle="tooltip"]'})

// load data pelanggan 
function reload_data(data = ""){

    let result = "";
    
    if(data){
        result = ajax(url_base+"pelanggan/ajax_list_pelanggan", "POST", data);
    } else {
        result = ajax(url_base+"pelanggan/ajax_list_pelanggan", "POST", "");
    }
    
    html = "";

    if(result.length != 0){
        result.forEach(data => {
            if(data.pengiriman == 0){
                best_seller = "";
            } else {
                best_seller = `<a href="#rekapPembelian" data-toggle="modal" class="btn btn-circle btn-warning mr-1 rekapPembelian" data-id="`+data.id_pelanggan+`|`+data.nama_pelanggan+`"><i class="fa fa-star"></i></a>`;
            }

            html += `
                <div class="col-12 col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">`+data.nama_pelanggan+`</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated-fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Data Pelanggan</div>
                                    <a class="dropdown-item editPelanggan" href="#editPelanggan" data-toggle="modal" data-id="`+data.id_pelanggan+`">Edit</a>
                                    <a class="dropdown-item hapusPelanggan" href="javascript:void(0)" data-id="`+data.id_pelanggan+`|`+data.nama_pelanggan+`">Hapus</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-gray-900">
                            <p><i class="fa fa-phone mr-3"></i>`+data.no_hp+`</p>
                            <p><i class="fa fa-map-marker-alt mr-3"></i>`+data.alamat+`</p>
                            <p><i class="fa fa-map-signs mr-3"></i>`+data.kecamatan+`</p>
                            <p><i class="fa fa-shopping-bag mr-3"></i>`+data.pembelian+` pembelian </p>
                            <div class="d-flex justify-content-center mt-1">
                                <a href="#addPembelian" data-toggle="modal" class="btn btn-circle btn-success mr-1 addPembelian" data-id="`+data.id_pelanggan+`|`+data.nama_pelanggan+`"><i class="fa fa-shopping-bag"></i></a>
                                <a href="`+url_base+`pelanggan/detail/`+data.link_pelanggan+`" class="btn btn-circle btn-info mr-1"><i class="fa fa-info"></i></a>
                                `+best_seller+`
                            </div>
                        </div>
                    </div>
                </div>`;
        });
    } else {
        html += `
            <div class="col-12">
                <div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning mr-1"></i>data pelanggan kosong</div>
            </div>`
        
    }

    $("#dataAjax").html(html);
}