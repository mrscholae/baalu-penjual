var page = "";
        
// Detect pagination click
$('#pagination').on('click','a',function(e){
    e.preventDefault(); 
    var pageno = $(this).attr('data-ci-pagination-page');
    loadPagination(pageno);

    page = pageno;
});

loadPagination(0);

// Load pagination
function loadPagination(pagno){
    let result = ajax(url_base+"produksi/loadRecord/"+pagno, "POST", "");

    if(result.total_rows != 0) {

        if(result.total_rows_perpage != 0){
            
            $('#pagination').html(result.pagination);
            createTable(result.result,result.row);

        } else {
            pageback = pagno - 1;
            let result = ajax(url_base+"produksi/loadRecord/"+pageback, "POST", "");

            $('#pagination').html(result.pagination);
            createTable(result.result,result.row);
        }

    } else {
        html = `<div class="col-12"><div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning mr-1"></i>Data produksi kosong</div></div>`
        $("#dataAjax").html(html);

    }
    
}

// Create table list
function createTable(data,sno){

    sno = Number(sno);

    html = "";

    for(index in data){

        if(data[index].bahan_produksi == 0){
            bahan = `<a href="#addBahanProduksi" data-toggle="modal" class="btn btn-circle btn-success mr-1 addBahanProduksi" data-id="`+data[index].id_produksi+`"><i class="fa fa-prescription-bottle"></i></a>`;
        } else {
            bahan = '';
        }
        
        if(data[index].tipe_produksi == "Produksi Barang") {
            color = "list-group-item-success";
            edit_hasil = `<a class="dropdown-item btnEditBarang" href="#editBarangProduksi" data-toggle="modal" data-id="`+data[index].id_produksi+`">Edit Hasil</a>`;
            if(data[index].produksi_barang == 0){
                barang = `<a href="#addProduksiBarang" data-toggle="modal" class="btn btn-circle btn-info addProduksiBarang" data-id="`+data[index].id_produksi+`"><i class="fa fa-box"></i></a>`;
            } else {
                barang = '';
            }
        } else if(data[index].tipe_produksi == "Produksi Bahan") {
            color = "list-group-item-warning";
            edit_hasil = `<a class="dropdown-item btnEditProduksiBahan" href="#editProduksiBahan" data-toggle="modal" data-id="`+data[index].id_produksi+`">Edit Hasil</a>`;
            if(data[index].produksi_bahan == 0){
                barang = `<a href="#addProduksiBahan" data-toggle="modal" class="btn btn-circle btn-info addProduksiBahan" data-id="`+data[index].id_produksi+`"><i class="fa fa-box"></i></a>`;
            } else {
                barang = '';
            }

        }

        html += `
        <div class="col-12 col-md-4">
            <div class="card shadow mb-4">
                <div class="`+color+` card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-calendar mr-1"></i>`+data[index].tgl_produksi+`</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Produksi</div>
                            <a class="dropdown-item btnDetailProduksi" href="#detailProduksi" data-id="`+data[index].id_produksi+`" data-toggle="modal">Detail</a>
                            <a class="dropdown-item btnEditProduksi" href="#editProduksi" data-toggle="modal" data-id="`+data[index].id_produksi+`">Edit Data</a>
                            <a class="dropdown-item btnEditBahan" href="#editBahanProduksi" data-toggle="modal" data-id="`+data[index].id_produksi+`">Edit Bahan</a>
                            `+edit_hasil+`
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item bthHapusProduksi" href="javascript:void(0)" data-id="`+data[index].id_produksi+`">Hapus</a>
                        </div>
                    </div>
                </div>
                <div class="card-body text-gray-900">
                    <p><i class="fa fa-info-circle mr-2"></i>`+data[index].tipe_produksi+`</p>
                    <p><i class="fa fa-dollar-sign mr-3"></i>`+data[index].harga_total+`</p>
                    <div class="d-flex justify-content-center mt-1">
                        `+bahan+`
                        `+barang+`
                    </div>
                </div>
            </div>
        </div>`;
    }

    $("#dataAjax").html(html);

};