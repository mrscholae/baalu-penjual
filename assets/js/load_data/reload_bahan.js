reload_data();

// untuk meload data bahan
function reload_data(){
    let result = ajax(url_base+"bahan/ajax_list_bahan", "POST", "");
    
    html = "";

    if(result.length != 0){
        result.forEach(data => {
            html += `
            <div class="col-12 col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">`+data.nama_bahan+`</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Data Bahan</div>
                                <a class="dropdown-item btnEditBahan" href="#editBahan" data-toggle="modal" data-id="`+data.id_bahan+`">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item btnHapusBahan" href="javascript:void(0)" data-id="`+data.id_bahan+`|`+data.nama_bahan+`">Hapus</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-gray-900">
                        <p><i class="fa fa-info-circle mr-3"></i> `+data.jenis+`</p>
                        <p><i class="fa fa-weight-hanging mr-3"></i> `+data.satuan+`</p>
                        <p><i class="fa fa-dollar-sign mr-4"></i> `+data.harga_satuan+` / `+data.satuan+`</p>
                        <p><i class="fa fa-minus-circle text-danger mr-3"></i> `+data.min_stok+`</p>
                        <p><i class="fa fa-cubes mr-3"></i> `+data.stok+` `+data.satuan+`</p>
                    </div>
                </div>
            </div>`
        });
    } else {
        html += `
            <div class="col-12">
                <div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning mr-1"></i>data bahan kosong</div>
            </div>`
        
    }

    $("#dataAjax").html(html);
}