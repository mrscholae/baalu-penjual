reload_data();


$(document).tooltip({selector : '[data-toggle="tooltip"]'})

// load data toko 
function reload_data(data = ""){

    let result = "";
    
    if(data){
        result = ajax(url_base+"toko/ajax_list_toko", "POST", data);
    } else {
        result = ajax(url_base+"toko/ajax_list_toko", "POST", "");
    }
    
    html = "";

    if(result.length != 0){
        result.forEach(data => {
            if(data.pengiriman == 0){
                reload = "";
                best_seller = "";
            } else {
                reload = `<a href="#addPengiriman" data-toggle="modal" class="btn btn-circle btn-success mr-1 addPengirimanUlang" data-id="`+data.id_toko+`|`+data.nama_toko+`"><i class="fa fa-redo-alt"></i></a>`;
                best_seller = `<a href="#rekapPenjualan" data-toggle="modal" class="btn btn-circle btn-warning mr-1 rekapPenjualan" data-id="`+data.id_toko+`|`+data.nama_toko+`"><i class="fa fa-star"></i></a>`;
            }

            if(data.prioritas != null){
                if(data.prioritas.jarak == 1) jarak = `<a class="btn btn-sm btn-circle btn-danger mr-1" data-toggle="tooltip" data-placement="top" title="Jarak Sesuai">
                    <i class="fa fa-people-arrows"></i>
                </a>`
                else jarak = ""

                if(data.prioritas.pelayanan == 1) pelayanan = `<a class="btn btn-sm btn-circle btn-success mr-1" data-toggle="tooltip" data-placement="top" title="Pelayanan Mitra Bagus">
                    <i class="fa fa-handshake"></i>
                </a>`
                else pelayanan = ""

                if(data.prioritas.repeat_order == 1) repeat_order = `<a class="btn btn-sm btn-circle btn-info mr-1" data-toggle="tooltip" data-placement="top" title="Repeat Order Cepat">
                    <i class="fa fa-redo"></i>
                </a>`
                else repeat_order = ""

                if(data.prioritas.retur == 1) retur = `<a class="btn btn-sm btn-circle btn-dark mr-1" data-toggle="tooltip" data-placement="top" title="Tidak Ada Retur">
                    <i class="fa fa-truck-pickup fa-flip-horizontal"></i>
                </a>`
                else retur = ""

                if(data.prioritas.pengunjung == 1) pengunjung = `<a class="btn btn-sm btn-circle btn-primary mr-1" data-toggle="tooltip" data-placement="top" title="Traffic Pelanggan Baik">
                    <i class="fa fa-users"></i>
                </a>`
                else pengunjung = ""

                if(data.prioritas.min_order == 1) min_order = `<a class="btn btn-sm btn-circle btn-warning mr-1" data-toggle="tooltip" data-placement="top" title="Minimal Order 24 pcs">
                    <i class="fa fa-boxes"></i>
                </a>`
                else min_order = ""
            } else {
                jarak = "";
                pelayanan = "";
                repeat_order = "";
                retur = "";
                pengunjung = "";
                min_order = "";
            }

            html += `
                <div class="col-12 col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">`+data.nama_toko+`</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated-fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Data Toko</div>
                                    <a class="dropdown-item btnEditToko" href="#editToko" data-toggle="modal" data-id="`+data.id_toko+`">Edit</a>
                                    <a class="dropdown-item prioritasToko" href="#prioritasToko" data-toggle="modal" data-id="`+data.id_toko+`">Prioritas</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item btnHapusToko" href="javascript:void(0)" data-id="`+data.id_toko+`|`+data.nama_toko+`">Hapus</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-gray-900">
                            <div class="d-flex justify-content-center mb-3">
                                `+jarak+`
                                `+pelayanan+`
                                `+repeat_order+`
                                `+retur+`
                                `+pengunjung+`
                                `+min_order+`
                            </div>
                            <p><i class="fa fa-map-marker-alt mr-4"></i>`+data.alamat+`</p>
                            <p><i class="fa fa-map-signs mr-3"></i>`+data.kecamatan+`</p>
                            <p><i class="fa fa-truck mr-3"></i>`+data.pengiriman+` pengiriman </p>
                            <p><i class="fa fa-clock mr-3"></i>`+data.jam_operasional+`</p>
                            <div class="d-flex justify-content-center mt-1">
                                <a href="#addPengiriman" data-toggle="modal" class="btn btn-circle btn-success mr-1 addPengiriman" data-id="`+data.id_toko+`|`+data.nama_toko+`"><i class="fa fa-truck"></i></a>
                                `+reload+`
                                <a href="`+url_base+`toko/detail/`+data.link_toko+`" class="btn btn-circle btn-info mr-1"><i class="fa fa-info"></i></a>
                                `+best_seller+`
                            </div>
                        </div>
                    </div>
                </div>`;
        });
    } else {
        html += `
            <div class="col-12">
                <div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning mr-1"></i>data toko kosong</div>
            </div>`
        
    }

    $("#dataAjax").html(html);
}