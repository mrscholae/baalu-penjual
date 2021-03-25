// when tombol simpan click in modal add produksi 
$("#btnAddProduksi").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan menambahkan produksi?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let tgl_produksi = $("#tgl_produksi_add").val();
            let tipe_produksi = $("#tipe_produksi_add").val();
            
            let eror = required("#formAddProduksi");
            
            if( eror == 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'lengkapi isi form terlebih dahulu'
                })
            } else {
                data = {tgl_produksi: tgl_produksi, tipe_produksi:tipe_produksi}
                let result = ajax(url_base+"produksi/add_produksi", "POST", data);

                if(result == 1){
                    loadPagination(0)
                    $("#addProduksi").modal("hide");

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil menambahkan produksi',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, ulangi proses input'
                    })
                }
            }
        }
    })
})

// bahan produksi 
    // when click button green tambah bahan produksi
    $(document).on("click", ".addBahanProduksi", function(){
        $("#formAddBahanProduksi").hide();
        $("#btnFormAddPembelian").hide();
        $("#listAllBahan").show();

        let id_produksi = $(this).data("id");
        $("#id_bahan_produksi").val(id_produksi);

        let result = ajax(url_base+"bahan/get_all_bahan");

        let html = "";

        result.forEach(data => {
            html += `
                <div class="form-group text-gray-900">
                    <div class="custom-control custom-checkbox small">
                        <input type="checkbox" name="bahan" value="`+data.id_bahan+`|`+data.nama_bahan+`|`+data.satuan+`|`+data.harga_satuan+`" class="custom-control-input" id="addBahanProduksi`+data.id_bahan+`">
                        <label class="custom-control-label" for="addBahanProduksi`+data.id_bahan+`">`+data.nama_bahan+`</label>
                    </div>
                </div>
            `
        });

        $(".listBahan").html(html);

        $("#footerAddBahanProduksi").removeClass('justify-content-between')
        $("#footerAddBahanProduksi").html(
            `<form action="" class="user">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-success btn-user" id="btnGunakan">Next <i class="fa fa-arrow-right ml-1"></i></button>
                </div>
            </form>`
        );
    })

    // menekan tombol next -> pada modal bahan
    $(document).on("click", "#btnGunakan", function(){
        var atLeastOneIsChecked = $('input[name="bahan"]:checked').length;
        if(atLeastOneIsChecked == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'pilih bahan yang akan digunakan terlebih dahulu'
            })
        } else {
            let i = 1;
            html = "";
            $.each($("input[name='bahan']:checked"), function(){
                data = $(this).val();
                data = data.split("|");
                id_bahan = data[0];
                nama_bahan = data[1];
                satuan = data[2];
                harga_satuan = data[3];
                
                html += `
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+i+`. `+nama_bahan+`</span>
                    </div>
                    <input type="hidden" name="id_bahan_produksi" value="`+id_bahan+`">
                    <input type="number" name="qty_bahan_produksi" class="form-control" aria-label="Amount (to the nearest dollar)">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+satuan+`</span>
                    </div>
                </div>
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Harga Satuan</span>
                    </div>
                    <input type="text" name="harga_satuan_bahan_produksi" class="form-control rupiah" aria-label="Amount (to the nearest dollar)" value="`+formatRupiah(harga_satuan, "Rp. ")+`">
                </div>`;

                i++;
            });

            $(".listBahanPenggunaan").html(html);
            
            $("#btnFormKirim").hide();
            $("#formAddBahanProduksi").show();
            $("#btnFormAddPembelian").show();
            $("#listAllBahan").hide();

            $("#footerAddBahanProduksi").addClass('justify-content-between')
            $("#footerAddBahanProduksi").html(`
                <form action="" class="user">
                    <span>
                        <button type="button" class="btn btn-success btn-user" id="btnBahan"><i class="fa fa-arrow-left mr-1"></i> back</button>
                    </span>
                </form>
                <form action="" class="user">
                    <span>
                        <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary btn-user" id="btnAddBahanProduksi">Simpan</button>
                    </span>
                </form>`);
        }
    })

    // menekan tombol back pada modal bahan
    $(document).on("click", "#btnBahan", function(){
        $("#formAddBahanProduksi").hide();
        $("#listAllBahan").show();

        $("#footerAddBahanProduksi").removeClass('justify-content-between')
        $("#footerAddBahanProduksi").html(
            `<form action="" class="user">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-success btn-user" id="btnGunakan">Next <i class="fa fa-arrow-right ml-1"></i></button>
                </div>
            </form>`
        );
    })

    // menekan tombol simpan pada modal bahan produksi 
    $(document).on("click", "#btnAddBahanProduksi", function(){
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menggunakan bahan untuk produksi?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                let id_produksi = $("#id_bahan_produksi").val();

                id_bahan = new Array();
                $.each($("input[name='id_bahan_produksi']"), function(){
                    id_bahan.push($(this).val());
                });
                
                // untuk cek jik ada field yang tak diisi atau bernilai tidak sesuai
                let eror = 0;

                qty = new Array();
                $.each($("input[name='qty_bahan_produksi']"), function(){
                    qty.push($(this).val());

                    if($(this).val() == 0 || $(this).val() == ""){
                        eror = 1;
                    }

                });

                harga_satuan = new Array();
                $.each($("input[name='harga_satuan_bahan_produksi']"), function(){
                    harga_satuan.push($(this).val());

                    if($(this).val() == "Rp. 0" || $(this).val() == ""){
                        eror = 1;
                    }

                });

                if(eror == 0){
                    data = {id_produksi: id_produksi, id_bahan:id_bahan, qty:qty, harga_satuan:harga_satuan}
                    let result = ajax(url_base+"produksi/add_bahan_produksi", "POST", data);

                    if(result == 1){
                        loadPagination(page)
                        $("#addBahanProduksi").modal("hide");

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil menambahkan bahan untuk produksi',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'terjadi kesalahan, ulangi proses input'
                        })
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'inputkan jumlah bahan, jumlah bahan tidak boleh 0 atau kosong'
                    })
                }
                
            }
        })
    })
// bahan produksi 

// produksi barang 
    // modal produksi barang
    $(document).on("click", ".addProduksiBarang", function(){
        $("#formAddProduksiBarang").hide();
        $("#listAllBarang").show();

        let id_produksi = $(this).data("id");
        $("#id_produksi_barang").val(id_produksi);

        let result = ajax(url_base+"barang/get_all_barang");

        let html = `<div class="alert alert-info"><i class="fa fa-info-circle text-info mr-1"></i>pilih barang yang diproduksi</div>`;

        result.forEach(data => {
            html += `
                <div class="form-group text-gray-900">
                    <div class="custom-control custom-checkbox small">
                        <input type="checkbox" name="barang" value="`+data.id_barang+`|`+data.kode_barang+`|`+data.nama_barang+`" class="custom-control-input" id="addProduksiBarang`+data.id_barang+`">
                        <label class="custom-control-label" for="addProduksiBarang`+data.id_barang+`">`+data.nama_barang+`</label>
                    </div>
                </div>
            `
        });

        $(".listAllBarang").html(html);

        $("#footerAddProduksiBarang").removeClass('justify-content-between')
        $("#footerAddProduksiBarang").html(
            `<form action="" class="user">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-success btn-user" id="btnProduksi">Next <i class="fa fa-arrow-right ml-1"></i></button>
                </div>
            </form>`
        );
    })

    // btn next modal produksi barang
    $(document).on("click", "#btnProduksi", function(){
        var atLeastOneIsChecked = $('input[name="barang"]:checked').length;
        if(atLeastOneIsChecked == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'pilih barang yang akan diproduksi terlebih dahulu'
            })
        } else {
            let i = 1;
            html = "";
            $.each($("input[name='barang']:checked"), function(){
                data = $(this).val();
                data = data.split("|");
                id_barang = data[0];
                kode_barang = data[1];
                nama_barang = data[2];
                
                html += `
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span>`+i+`. `+nama_barang+`</span>
                    </div>
                    <input type="hidden" name="id_barang_produksi" value="`+id_barang+`">
                </div>
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text list-group-item-success"><i class="fa fa-check"></i></span>
                    </div>
                    <input type="number" name="berhasil_produksi" class="form-control" aria-label="Amount (to the nearest dollar)" value="">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text list-group-item-danger"><i class="fa fa-times"></i></span>
                    </div>
                    <input type="number" name="gagal_produksi" class="form-control" aria-label="Amount (to the nearest dollar)" value="">
                </div>
                
                `;

                i++;
            });

            $(".listProduksiBarang").html(html);
            
            $("#formAddProduksiBarang").show();
            $("#listAllBarang").hide();

            $("#footerAddProduksiBarang").addClass('justify-content-between')
            $("#footerAddProduksiBarang").html(`
                <form action="" class="user">
                    <span>
                        <button type="button" class="btn btn-success btn-user" id="btnBarang"><i class="fa fa-arrow-left mr-1"></i> back</button>
                    </span>
                </form>
                <form action="" class="user">
                    <span>
                        <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary btn-user" id="btnAddProduksiBarang">Simpan</button>
                    </span>
                </form>`);
        }
    })

    // menekan tombol back pada modal produksi barang
    $(document).on("click", "#btnBarang", function(){
        $("#formAddProduksiBarang").hide();
        $("#listAllBarang").show();

        $("#footerAddProduksiBarang").removeClass('justify-content-between')
        $("#footerAddProduksiBarang").html(
            `<form action="" class="user">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-success btn-user" id="btnProduksi">Next <i class="fa fa-arrow-right ml-1"></i></button>
                </div>
            </form>`
        );
    })

    // menekan tombol simpan pada modal produksi barang 
    $(document).on("click", "#btnAddProduksiBarang", function(){
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menambahkan produksi barang?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                let id_produksi = $("#id_produksi_barang").val();

                id_barang = new Array();
                $.each($("input[name='id_barang_produksi']"), function(){
                    id_barang.push($(this).val());
                });
                
                // untuk cek jik ada field yang tak diisi atau bernilai tidak sesuai
                let eror = 0;

                berhasil = new Array();
                $.each($("input[name='berhasil_produksi']"), function(){
                    berhasil.push($(this).val());

                    if($(this).val() == 0 || $(this).val() == ""){
                        eror = 1;
                    }

                });

                gagal = new Array();
                $.each($("input[name='gagal_produksi']"), function(){
                    gagal.push($(this).val());

                    if($(this).val() == "Rp. 0" || $(this).val() == ""){
                        eror = 1;
                    }

                });

                if(eror == 0){
                    data = {id_produksi: id_produksi, id_barang:id_barang, berhasil:berhasil, gagal:gagal}
                    let result = ajax(url_base+"produksi/add_barang_produksi", "POST", data);

                    if(result == 1){
                        loadPagination(page)
                        $("#addProduksiBarang").modal("hide");

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil menambahkan produksi barang',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'terjadi kesalahan, ulangi proses input'
                        })
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'inputkan jumlah barang, jumlah barang tidak boleh 0 atau kosong'
                    })
                }
                
            }
        })
    })
// produksi barang 

// produksi bahan 
    // modal produksi bahan
    $(document).on("click", ".addProduksiBahan", function(){
        let form = "#addProduksiBahan";
        // $("#formAddProduksiBahan").hide();
        // $("#listAllProduksiBahan").show();
        $(form+" .listItem").show();
        $(form+" .formItem").hide();

        let id_produksi = $(this).data("id");
        $(form+" .id_produksi").val(id_produksi);

        let result = ajax(url_base+"bahan/get_all_bahan_produksi");

        let html = `<div class="alert alert-info"><i class="fa fa-info-circle text-info mr-1"></i>pilih bahan yang diproduksi</div>`;

        result.forEach(data => {
            html += `
                <div class="form-group text-gray-900">
                    <div class="custom-control custom-checkbox small">
                        <input type="checkbox" name="produksi_bahan" value="`+data.id_bahan+`|`+data.nama_bahan+`|`+data.satuan+`" class="custom-control-input" id="addProduksiBahan`+data.id_bahan+`">
                        <label class="custom-control-label" for="addProduksiBahan`+data.id_bahan+`">`+data.nama_bahan+`</label>
                    </div>
                </div>`
        });

        $(form+" .listItem").html(html);

        $(form+" .modal-footer").removeClass('justify-content-between')
        $(form+" .modal-footer").html(
            `<form action="" class="user">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-success btn-user btnNext">Next <i class="fa fa-arrow-right ml-1"></i></button>
                </div>
            </form>`
        );
    })

    $(document).on("click", "#addProduksiBahan .btnNext", function(){
        let form = "#addProduksiBahan";

        var atLeastOneIsChecked = $(form+' input[name="produksi_bahan"]:checked').length;
        if(atLeastOneIsChecked == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'pilih bahan yang akan diproduksi terlebih dahulu'
            })
        } else {
            $(form+" .listItem").hide();
            $(form+" .formItem").show();

            let i = 1;
            html = "";
            $.each($(form+" input[name='produksi_bahan']:checked"), function(){
                data = $(this).val();
                data = data.split("|");
                id_bahan = data[0];
                nama_bahan = data[1];
                satuan = data[2];
                
                html += `
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+i+`. `+nama_bahan+`</span>
                    </div>
                    <input type="hidden" name="id_produksi_bahan" value="`+id_bahan+`">
                    <input type="number" name="qty_produksi_bahan" class="form-control" aria-label="Amount (to the nearest dollar)">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+satuan+`</span>
                    </div>
                </div>
                `;

                i++;
            });

            $(form+" .listItemGenerate").html(html);

            $(form+" .modal-footer").addClass('justify-content-between')
            $(form+" .modal-footer").html(`
                <form action="" class="user">
                    <span>
                        <button type="button" class="btn btn-success btn-user" id="btnBarang"><i class="fa fa-arrow-left mr-1"></i> back</button>
                    </span>
                </form>
                <form action="" class="user">
                    <span>
                        <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary btn-user btnSimpan">Simpan</button>
                    </span>
                </form>`);
        }
    })

    // menekan tombol simpan pada modal produksi barang 
    $(document).on("click", "#addProduksiBahan .btnSimpan", function(){
        let form = "#addProduksiBahan";

        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menambahkan produksi bahan?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                let id_produksi = $(form+" input[name='id_produksi']").val();

                id_bahan = new Array();
                $.each($(form+" input[name='id_produksi_bahan']"), function(){
                    id_bahan.push($(this).val());
                });
                
                // untuk cek jik ada field yang tak diisi atau bernilai tidak sesuai
                let eror = 0;

                qty = new Array();
                $.each($(form+" input[name='qty_produksi_bahan']"), function(){
                    qty.push($(this).val());

                    if($(this).val() == 0 || $(this).val() == ""){
                        eror = 1;
                    }

                });

                if(eror == 0){
                    data = {id_produksi: id_produksi, id_bahan:id_bahan, qty:qty}
                    let result = ajax(url_base+"produksi/add_produksi_bahan", "POST", data);

                    if(result == 1){
                        loadPagination(page)
                        $(form).modal("hide");

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil menambahkan produksi bahan',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'terjadi kesalahan, ulangi proses input'
                        })
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'inputkan jumlah bahan, jumlah bahan tidak boleh 0 atau kosong'
                    })
                }
                
            }
        })
    })
// produksi bahan 

// detail produksi 
    $(document).on("click", ".btnDetailProduksi", function(){
        let id_produksi = $(this).data("id");
        let data = {id_produksi:id_produksi}

        let result = ajax(url_base+"produksi/get_detail_produksi", "POST", data)

        html = "";
        
        html += `
            <li class="list-group-item list-group-item-info"><i class="fa fa-mail mr-1"></i>Data Produksi</li>
            <li class="list-group-item">
                <p><i class="fa fa-calendar mr-3"></i>`+result.produksi.tgl_produksi+`</p>
                <p><i class="fa fa-dollar-sign mr-4"></i>`+formatRupiah(result.total, "Rp. ")+`</p>
            </li>`

        $(".detailProduksiData").html(html)

        
        html = "";
        if(result.bahan_produksi.length != 0){
            i = 1;
            result.bahan_produksi.forEach(data => {
                html += `
                    <li class="list-group-item list-group-item-primary d-flex justify-content-between">
                        <span>`+i+`. `+data.nama_bahan+`</span>
                        <span><i class="fa fa-dollar-sign mr-1"></i>`+formatRupiah(data.harga_total, "Rp. ")+`</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><i class="fa fa-weight-hanging mr-1"></i>`+data.qty+` `+data.satuan+`</span>
                        <span><i class="fa fa-box mr-1"></i>`+formatRupiah(data.harga_satuan, "Rp. ")+`</span>
                    </li>`

                i++;

            });
        } else {
            html += ``
        }

        $(".detailProduksiListBahan").html(html);

        html = "";
        
        if(result.produksi.tipe_produksi == "Produksi Barang") {
            if(result.produksi_barang.length != 0){
                i = 1;
                html = `<li class="list-group-item list-group-item-success">List Produksi Barang</li>`;
                result.produksi_barang.forEach(data => {
                    html += `
                        <li class="list-group-item list-group-item-primary d-flex justify-content-between">
                            <span>`+i+`. `+data.nama_barang+`</span>
                            <span><i class="fa fa-boxes mr-1"></i>`+data.total+`</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-center">
                            <span class="mr-3"><i class="fa fa-check text-success mr-"></i>`+data.berhasil+`</span>
                            <span><i class="fa fa-times text-danger mr-1"></i>`+data.gagal+`</span>
                        </li>`
    
                    i++;
    
                });
            } else {
                html += ``
            }
        } else {
            if(result.produksi_bahan.length != 0){
                i = 1;
                html = `<li class="list-group-item list-group-item-success">List Produksi Bahan</li>`;
                result.produksi_bahan.forEach(data => {
                    html += `
                        <li class="list-group-item list-group-item-primary d-flex justify-content-between">
                            <span>`+i+`. `+data.nama_bahan+`</span>
                            <span><i class="fa fa-boxes mr-1"></i>`+data.qty+` `+data.satuan+`</span>
                        </li>`
                    i++;
    
                });
            } else {
                html += ``
            }
        }

        $(".detailProduksiListBarang").html(html);
    })
// detail produksi 

// delete data produksi
$(document).on("click", ".bthHapusProduksi", function(){
    let id_produksi = $(this).data("id");

    Swal.fire({
            icon: 'question',
            text: 'Yakin akan menghapus data produksi ini?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            data = {id_produksi: id_produksi}
            let result = ajax(url_base+"produksi/hapus_produksi", "POST", data);

            if(result == 1){
                loadPagination(page)

                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    text: 'Berhasil menghapus data produksi',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'terjadi kesalahan, gagal menghapus data produksi'
                })
            }
        }
    })
})

// edit produksi
    $(document).on("click", ".btnEditProduksi", function(){
        let form = "#editProduksi";

        let id_produksi = $(this).data("id");
        let data = {id_produksi:id_produksi};

        let result = ajax(url_base+"produksi/get_produksi", "POST", data);

        $(form+" input[name='tgl_produksi']").val(result['tgl_produksi_format']);
        $(form+" input[name='id_produksi']").val(result['id_produksi']);
    })

    $(document).on("click", "#editProduksi .btnSimpan", function(){
        let form = "#editProduksi";
        let tgl_produksi = $(form+" input[name='tgl_produksi']").val();
        let id_produksi = $(form+" input[name='id_produksi']").val();

        Swal.fire({
            icon: 'question',
            text: 'Yakin akan merubah data produksi?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                let eror = required(form);
            
                if( eror == 1){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'lengkapi isi form terlebih dahulu'
                    })
                } else {
                    data = {tgl_produksi: tgl_produksi, id_produksi: id_produksi}
                    let result = ajax(url_base+"produksi/edit_produksi", "POST", data);

                    if(result == 1){
                        loadPagination(page)

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil merubah data produksi',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'terjadi kesalahan, ulangi proses input'
                        })
                    }
                }
            }
        })
    })
// edit produksi 

// edit bahan produksi 
    $(document).on("click", ".btnEditBahan", function(){

        let form = "#editBahanProduksi";

        // button form
        $(".btn-form-1").addClass("active");
        $(".btn-form-2").removeClass("active");
        $(".btn-form-3").removeClass("active");

        // form
        $(".form-1").show();
        $(".form-2").hide();
        $(".form-3").hide();

        // footer
        $(".footer-1").show();
        $(".footer-2").hide();
        $(".footer-3").hide();
        
        let id_produksi = $(this).data("id");

        data_edit_bahan_produksi(id_produksi);
    })

    function data_edit_bahan_produksi(id_produksi){
        let form = "#editBahanProduksi";

        $(form+" .listItem2").show();
        $(form+" .listItem3").hide();

        let data = {id_produksi:id_produksi};

        let result = ajax(url_base+"produksi/get_bahan_produksi", "POST", data);

        $(form+" input[name='id_produksi']").val(id_produksi);

        html = "";
        i = 1;

        if(result.length != 0){
            
            result.forEach(data => {
                
                html += `
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+i+`. `+data.nama_bahan+`</span>
                    </div>
                    <input type="hidden" name="id" value="`+data.id+`">
                    <input type="number" name="qty" class="form-control" aria-label="Amount (to the nearest dollar)" value="`+data.qty+`">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+data.satuan+`</span>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><a href="javascript:void(0)" class="btnDelete" data-id="`+data.id+`|`+data.id_produksi+`|`+data.nama_bahan+`"><i class="fa fa-trash-alt text-danger"></i></a></span>
                    </div>
                </div>
                
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Harga Satuan</span>
                    </div>
                    <input type="text" name="harga_satuan" class="form-control rupiah" aria-label="Amount (to the nearest dollar)" value="`+formatRupiah(data.harga_satuan, 'Rp. ')+`">
                </div>`;

                i++;
            });

        } else {
            html += `<div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning"></i>list bahan kosong</div>`
        }

        $(form+" .listItem").html(html);

        result = ajax(url_base+"produksi/get_not_bahan_produksi", "POST", data);

        html = "";
        if(result.length != 0){
            result.forEach(data => {
                html += `
                    <div class="form-group text-gray-900">
                        <div class="custom-control custom-checkbox small">
                        <input type="checkbox" name="bahan" value="`+data.id_bahan+`|`+data.nama_bahan+`|`+data.satuan+`|`+data.harga_satuan+`" class="custom-control-input" id="editBahanProduksi`+data.id_bahan+`">
                            <label class="custom-control-label" for="editBahanProduksi`+data.id_bahan+`">`+data.nama_bahan+`</label>
                        </div>
                    </div>`
            });
        } else {
            html += `
                <div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning mr-1"></i>list bahan kosong</div>`
        }

        $(form+" .listItem2").html(html)

        $(form+" .footer-2").removeClass('justify-content-between')
        $(form+" .footer-2").html(`
            <div class="modal-footer">
                <form action="" class="user">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success btn-user btnNext">next <i class="fa fa-arrow-right ml-1"></i></button>
                    </div>
                </form>
            </div>
        `);

    }

    $(document).on("click", "#editBahanProduksi .btnDelete", function(){
        let data = $(this).data("id");
        data = data.split("|");

        let id = data[0];
        let id_produksi = data[1];
        let nama_bahan = data[2]
        
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menghapus '+nama_bahan+' dari bahan produksi?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                data = {id: id}

                let result = ajax(url_base+"produksi/delete_bahan_produksi", "POST", data);

                if(result == 1){
                    
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil menghapus bahan dari produksi',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    data_edit_bahan_produksi(id_produksi);
                    loadPagination(page)

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, gagal menghapus bahan dari produksi'
                    })
                }
            }
        })
    })

    $(document).on("click", "#editBahanProduksi .btnSimpan1", function(){
        let form = "#editBahanProduksi"

        Swal.fire({
            icon: 'question',
            text: 'Yakin akan mengubah detail penggunaan bahan produksi?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                let id_produksi = $(form+" input[name='id_produksi']").val();

                id_detail = new Array();
                $.each($(form+" input[name='id']"), function(){
                    id_detail.push($(this).val());
                });
                
                // untuk cek jik ada qty yang 0
                let eror = 0;

                qty = new Array();
                $.each($("input[name='qty']"), function(){
                    qty.push($(this).val());

                    if($(this).val() == 0 || $(this).val() == ""){
                        eror = 1;
                    }

                });

                harga_satuan = new Array();
                $.each($("input[name='harga_satuan']"), function(){
                    harga_satuan.push($(this).val());

                    if($(this).val() == "Rp. 0" || $(this).val() == ""){
                        eror = 1;
                    }

                });

                if(eror == 0){
                    data = {id_detail:id_detail, qty:qty, harga_satuan:harga_satuan}
                    let result = ajax(url_base+"produksi/edit_bahan_produksi", "POST", data);

                    if(result == 1){
                        loadPagination(page);

                        data_edit_bahan_produksi(id_produksi)

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil mengubah detail penggunaan bahan produksi',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'terjadi kesalahan, ulangi proses input'
                        })
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'inputkan jumlah bahan, jumlah bahan tidak boleh 0 atau kosong'
                    })
                }
                
            }
        })
    })

    $(document).on("click", "#editBahanProduksi .btnNext", function(){
        let form = "#editBahanProduksi";

        var atLeastOneIsChecked = $(form+' input[name="bahan"]:checked').length;
        if(atLeastOneIsChecked == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'pilih bahan yang akan digunakan terlebih dahulu'
            })
        } else {
            let i = 1;
            html = "";
            $.each($(form+" input[name='bahan']:checked"), function(){
                data = $(this).val();
                data = data.split("|");
                id_bahan = data[0];
                nama_bahan = data[1];
                satuan = data[2];
                harga_satuan = data[3];
                
                html += `
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+i+`. `+nama_bahan+`</span>
                    </div>
                    <input type="hidden" name="id_bahan_2" value="`+id_bahan+`">
                    <input type="number" name="qty_2" class="form-control" aria-label="Amount (to the nearest dollar)">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+satuan+`</span>
                    </div>
                </div>
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Harga Satuan</span>
                    </div>
                    <input type="text" name="harga_satuan_2" class="form-control rupiah" aria-label="Amount (to the nearest dollar)" value="`+formatRupiah(harga_satuan, "Rp. ")+`">
                </div>`;

                i++;
            });

            $(form+" .listItem2").hide();
            $(form+" .listItem3").show();
            $(form+" .listItem3").html(html);

            $(form+" .footer-2").html(`
                <div class="modal-footer justify-content-between">
                    <form action="" class="user">
                        <span>
                            <button type="button" class="btn btn-success btn-user btnBack"><i class="fa fa-arrow-left mr-1"></i> back</button>
                        </span>
                    </form>
                    <form action="" class="user">
                        <span>
                            <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary btn-user btnSimpan2">Simpan</button>
                        </span>
                    </form>
                </div>
            `);
        }
    })

    $(document).on("click", "#editBahanProduksi .btnBack", function(){
        let form = "#editBahanProduksi";

        // console.log("cek")

        $(form+" .listItem2").show();
        $(form+" .listItem3").hide();
        
        $(form+" .footer-2").html(`
            <div class="modal-footer">
                <form action="" class="user">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success btn-user btnNext">next <i class="fa fa-arrow-right ml-1"></i></button>
                    </div>
                </form>
            </div>
        `);
    })

    $(document).on("click", "#editBahanProduksi .btnSimpan2", function(){
        let form = "#editBahanProduksi"

        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menggunakan bahan untuk produksi?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                let id_produksi = $(form+" input[name='id_produksi']").val();

                id_bahan = new Array();
                $.each($(form+" input[name='id_bahan_2']"), function(){
                    id_bahan.push($(this).val());
                });
                
                // untuk cek jik ada field yang tak diisi atau bernilai tidak sesuai
                let eror = 0;

                qty = new Array();
                $.each($(form+" input[name='qty_2']"), function(){
                    qty.push($(this).val());

                    if($(this).val() == 0 || $(this).val() == ""){
                        eror = 1;
                    }

                });

                harga_satuan = new Array();
                $.each($(form+" input[name='harga_satuan_2']"), function(){
                    harga_satuan.push($(this).val());

                    if($(this).val() == "Rp. 0" || $(this).val() == ""){
                        eror = 1;
                    }

                });

                if(eror == 0){
                    data = {id_produksi: id_produksi, id_bahan:id_bahan, qty:qty, harga_satuan:harga_satuan}
                    let result = ajax(url_base+"produksi/add_bahan_produksi", "POST", data);

                    if(result == 1){
                        loadPagination(page)
                        data_edit_bahan_produksi(id_produksi)
                        btn_1();

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil menambahkan bahan untuk produksi',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'terjadi kesalahan, ulangi proses input'
                        })
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'inputkan jumlah bahan, jumlah bahan tidak boleh 0 atau kosong'
                    })
                }
                
            }
        })
    })
// edit bahan produksi 

// edit barang produksi 
    $(document).on("click", ".btnEditBarang", function(){

        let form = "#editBarangProduksi";

        // button form
        $(".btn-form-1").addClass("active");
        $(".btn-form-2").removeClass("active");
        $(".btn-form-3").removeClass("active");

        // form
        $(".form-1").show();
        $(".form-2").hide();
        $(".form-3").hide();

        // footer
        $(".footer-1").show();
        $(".footer-2").hide();
        $(".footer-3").hide();
        
        let id_produksi = $(this).data("id");

        data_edit_barang_produksi(id_produksi);
    })

    function data_edit_barang_produksi(id_produksi){
        let form = "#editBarangProduksi";

        $(form+" .listItem2").show();
        $(form+" .listItem3").hide();

        let data = {id_produksi:id_produksi};

        let result = ajax(url_base+"produksi/get_barang_produksi", "POST", data);

        $(form+" input[name='id_produksi']").val(id_produksi);

        html = "";
        i = 1;

        if(result.length != 0){
            
            result.forEach(data => {
                
                html += `
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+i+`. `+data.nama_barang+`</span>
                        <span class="input-group-text"><a href="javascript:void(0)" class="btnDelete" data-id="`+data.id+`|`+data.id_produksi+`|`+data.nama_barang+`"><i class="fa fa-trash-alt text-danger"></i></a></span>
                    </div>
                    <input type="hidden" name="id" value="`+data.id+`">
                </div>
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text list-group-item-success"><i class="fa fa-check"></i></span>
                    </div>
                    <input type="number" name="berhasil" class="form-control" aria-label="Amount (to the nearest dollar)" value="`+data.berhasil+`">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text list-group-item-danger"><i class="fa fa-times"></i></span>
                    </div>
                    <input type="number" name="gagal" class="form-control" aria-label="Amount (to the nearest dollar)" value="`+data.gagal+`">
                </div>`;

                i++;
            });

        } else {
            html += `<div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning"></i>list barang kosong</div>`
        }

        $(form+" .listItem").html(html);

        result = ajax(url_base+"produksi/get_not_barang_produksi", "POST", data);

        html = "";
        if(result.length != 0){
            result.forEach(data => {
                html += `
                <div class="form-group text-gray-900">
                    <div class="custom-control custom-checkbox small">
                        <input type="checkbox" name="barang" value="`+data.id_barang+`|`+data.kode_barang+`|`+data.nama_barang+`" class="custom-control-input" id="editBarangProduksi`+data.id_barang+`">
                        <label class="custom-control-label" for="editBarangProduksi`+data.id_barang+`">`+data.nama_barang+`</label>
                    </div>
                </div>`
            });
        } else {
            html += `
                <div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning mr-1"></i>list barang kosong</div>`
        }

        $(form+" .listItem2").html(html)

        $(form+" .footer-2").removeClass('justify-content-between')
        $(form+" .footer-2").html(`
            <div class="modal-footer">
                <form action="" class="user">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success btn-user btnNext">next <i class="fa fa-arrow-right ml-1"></i></button>
                    </div>
                </form>
            </div>
        `);

    }

    $(document).on("click", "#editBarangProduksi .btnDelete", function(){
        let data = $(this).data("id");
        data = data.split("|");

        let id = data[0];
        let id_produksi = data[1];
        let nama_barang = data[2]
        
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menghapus '+nama_barang+' dari produksi barang?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                data = {id: id}

                let result = ajax(url_base+"produksi/delete_produksi_barang", "POST", data);

                if(result == 1){
                    
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil menghapus barang dari produksi',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    data_edit_barang_produksi(id_produksi);
                    loadPagination(page)

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, gagal menghapus barang dari produksi'
                    })
                }
            }
        })
    })

    $(document).on("click", "#editBarangProduksi .btnSimpan1", function(){
        let form = "#editBarangProduksi"

        Swal.fire({
            icon: 'question',
            text: 'Yakin akan mengubah detail produksi barang?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                let id_produksi = $(form+" input[name='id_produksi']").val();

                id_detail = new Array();
                $.each($(form+" input[name='id']"), function(){
                    id_detail.push($(this).val());
                });
                
                // untuk cek jik ada qty yang 0
                let eror = 0;

                berhasil = new Array();
                $.each($(form+" input[name='berhasil']"), function(){
                    berhasil.push($(this).val());

                    if($(this).val() == ""){
                        eror = 1;
                    }

                });

                gagal = new Array();
                $.each($(form+" input[name='gagal']"), function(){
                    gagal.push($(this).val());

                    if($(this).val() == ""){
                        eror = 1;
                    }

                });

                if(eror == 0){
                    data = {id_detail:id_detail, berhasil:berhasil, gagal:gagal}
                    let result = ajax(url_base+"produksi/edit_barang_produksi", "POST", data);

                    if(result == 1){
                        loadPagination(page);

                        data_edit_barang_produksi(id_produksi)

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil mengubah detail produksi barang',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'terjadi kesalahan, ulangi proses input'
                        })
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'inputkan jumlah bahan, jumlah bahan tidak boleh 0 atau kosong'
                    })
                }
                
            }
        })
    })

    $(document).on("click", "#editBarangProduksi .btnNext", function(){
        let form = "#editBarangProduksi";

        var atLeastOneIsChecked = $(form+' input[name="barang"]:checked').length;
        if(atLeastOneIsChecked == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'pilih barang yang akan diproduksi terlebih dahulu'
            })
        } else {
            let i = 1;
            html = "";
            $.each($(form+" input[name='barang']:checked"), function(){
                data = $(this).val();
                data = data.split("|");
                id_barang = data[0];
                kode_barang = data[1];
                nama_barang = data[2];
                
                html += `
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span>`+i+`. `+nama_barang+`</span>
                    </div>
                    <input type="hidden" name="id_barang_2" value="`+id_barang+`">
                </div>
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text list-group-item-success"><i class="fa fa-check"></i></span>
                    </div>
                    <input type="number" name="berhasil_2" class="form-control" aria-label="Amount (to the nearest dollar)" value="">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text list-group-item-danger"><i class="fa fa-times"></i></span>
                    </div>
                    <input type="number" name="gagal_2" class="form-control" aria-label="Amount (to the nearest dollar)" value="">
                </div>
                
                `;

                i++;
            });

            $(form+" .listItem2").hide();
            $(form+" .listItem3").show();
            $(form+" .listItem3").html(html);

            $(form+" .footer-2").html(`
                <div class="modal-footer justify-content-between">
                    <form action="" class="user">
                        <span>
                            <button type="button" class="btn btn-success btn-user btnBack"><i class="fa fa-arrow-left mr-1"></i> back</button>
                        </span>
                    </form>
                    <form action="" class="user">
                        <span>
                            <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary btn-user btnSimpan2">Simpan</button>
                        </span>
                    </form>
                </div>
            `);
        }
    })

    $(document).on("click", "#editBarangProduksi .btnBack", function(){
        let form = "#editBarangProduksi";

        $(form+" .listItem2").show();
        $(form+" .listItem3").hide();
        
        $(form+" .footer-2").html(`
            <div class="modal-footer">
                <form action="" class="user">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success btn-user btnNext">next <i class="fa fa-arrow-right ml-1"></i></button>
                    </div>
                </form>
            </div>
        `);
    })

    $(document).on("click", "#editBarangProduksi .btnSimpan2", function(){
        let form = "#editBarangProduksi"

        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menambahkan produksi barang?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                let id_produksi = $(form+" input[name='id_produksi']").val();

                id_barang = new Array();
                $.each($(form+" input[name='id_barang_2']"), function(){
                    id_barang.push($(this).val());
                });
                
                // untuk cek jik ada field yang tak diisi atau bernilai tidak sesuai
                let eror = 0;

                berhasil = new Array();
                $.each($(form+" input[name='berhasil_2']"), function(){
                    berhasil.push($(this).val());

                    if($(this).val() == ""){
                        eror = 1;
                    }

                });

                gagal = new Array();
                $.each($(form+" input[name='gagal_2']"), function(){
                    gagal.push($(this).val());

                    if($(this).val() == ""){
                        eror = 1;
                    }

                });

                if(eror == 0){
                    data = {id_produksi: id_produksi, id_barang:id_barang, berhasil:berhasil, gagal:gagal}
                    let result = ajax(url_base+"produksi/add_barang_produksi", "POST", data);

                    if(result == 1){
                        loadPagination(page)
                        data_edit_barang_produksi(id_produksi)
                        btn_1();

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil menambahkan produksi barang',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'terjadi kesalahan, ulangi proses input'
                        })
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'inputkan jumlah barang, jumlah barang tidak boleh kosong'
                    })
                }
                
            }
        })
    })
// edit barang produksi 

// edit produksi bahan 
    $(document).on("click", ".btnEditProduksiBahan", function(){

        let form = "#editProduksiBahan";

        // button form
        $(".btn-form-1").addClass("active");
        $(".btn-form-2").removeClass("active");
        $(".btn-form-3").removeClass("active");

        // form
        $(".form-1").show();
        $(".form-2").hide();
        $(".form-3").hide();

        // footer
        $(".footer-1").show();
        $(".footer-2").hide();
        $(".footer-3").hide();
        
        let id_produksi = $(this).data("id");

        data_edit_produksi_bahan(id_produksi);
    })

    function data_edit_produksi_bahan(id_produksi){
        let form = "#editProduksiBahan";

        $(form+" .listItem2").show();
        $(form+" .listItem3").hide();

        let data = {id_produksi:id_produksi};

        let result = ajax(url_base+"produksi/get_produksi_bahan", "POST", data);

        $(form+" input[name='id_produksi']").val(id_produksi);

        html = "";
        i = 1;

        if(result.length != 0){
            
            result.forEach(data => {
                html += `
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">`+i+`. `+data.nama_bahan+`</span>
                        </div>
                        <input type="hidden" name="id" value="`+data.id+`">
                        <input type="number" name="qty" class="form-control" aria-label="Amount (to the nearest dollar)" value="`+data.qty+`">
                        <div class="input-group-prepend">
                            <span class="input-group-text">`+data.satuan+`</span>
                            <span class="input-group-text"><a href="javascript:void(0)" class="btnDelete" data-id="`+data.id+`|`+data.id_produksi+`|`+data.nama_bahan+`"><i class="fa fa-trash-alt text-danger"></i></a></span>
                        </div>
                    </div>`;

                i++;
            });

        } else {
            html += `<div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning"></i>list kosong</div>`
        }

        $(form+" .listItem").html(html);

        result = ajax(url_base+"produksi/get_not_produksi_bahan", "POST", data);

        html = "";
        if(result.length != 0){
            result.forEach(data => {
                html += `
                <div class="form-group text-gray-900">
                    <div class="custom-control custom-checkbox small">
                        <input type="checkbox" name="produksi_bahan" value="`+data.id_bahan+`|`+data.nama_bahan+`|`+data.satuan+`" class="custom-control-input" id="editProduksiBahan`+data.id_bahan+`">
                        <label class="custom-control-label" for="editProduksiBahan`+data.id_bahan+`">`+data.nama_bahan+`</label>
                    </div>
                </div>`
            });
        } else {
            html += `
                <div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning mr-1"></i>list kosong</div>`
        }

        $(form+" .listItem2").html(html)

        $(form+" .footer-2").removeClass('justify-content-between')
        $(form+" .footer-2").html(`
            <div class="modal-footer">
                <form action="" class="user">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success btn-user btnNext">next <i class="fa fa-arrow-right ml-1"></i></button>
                    </div>
                </form>
            </div>
        `);

    }

    $(document).on("click", "#editProduksiBahan .btnDelete", function(){
        let data = $(this).data("id");
        data = data.split("|");

        let id = data[0];
        let id_produksi = data[1];
        let nama_bahan = data[2]
        
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menghapus '+nama_bahan+' dari produksi bahan?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                data = {id: id}

                let result = ajax(url_base+"produksi/delete_produksi_bahan", "POST", data);

                if(result == 1){
                    
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil menghapus produksi bahan',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    data_edit_produksi_bahan(id_produksi);
                    loadPagination(page)

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, gagal menghapus produksi bahan'
                    })
                }
            }
        })
    })

    $(document).on("click", "#editProduksiBahan .btnSimpan1", function(){
        let form = "#editProduksiBahan"

        Swal.fire({
            icon: 'question',
            text: 'Yakin akan mengubah detail produksi bahan?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                let id_produksi = $(form+" input[name='id_produksi']").val();

                id_detail = new Array();
                $.each($(form+" input[name='id']"), function(){
                    id_detail.push($(this).val());
                });
                
                // untuk cek jik ada qty yang 0
                let eror = 0;

                qty = new Array();
                $.each($(form+" input[name='qty']"), function(){
                    qty.push($(this).val());

                    if($(this).val() == ""){
                        eror = 1;
                    }

                });

                if(eror == 0){
                    data = {id_detail:id_detail, qty:qty}
                    let result = ajax(url_base+"produksi/edit_produksi_bahan", "POST", data);

                    if(result == 1){
                        loadPagination(page);

                        data_edit_barang_produksi(id_produksi)

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil mengubah detail produksi bahan',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'terjadi kesalahan, ulangi proses input'
                        })
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'inputkan jumlah bahan, jumlah bahan tidak boleh 0 atau kosong'
                    })
                }
                
            }
        })
    })

    $(document).on("click", "#editProduksiBahan .btnNext", function(){
        let form = "#editProduksiBahan";

        var atLeastOneIsChecked = $(form+' input[name="produksi_bahan"]:checked').length;
        if(atLeastOneIsChecked == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'pilih bahan yang akan diproduksi terlebih dahulu'
            })
        } else {
            let i = 1;
            html = "";
            $.each($(form+" input[name='produksi_bahan']:checked"), function(){
                data = $(this).val();
                data = data.split("|");
                id_bahan = data[0];
                nama_bahan = data[1];
                satuan = data[2];
                
                html += `
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+i+`. `+nama_bahan+`</span>
                    </div>
                    <input type="hidden" name="id_produksi_bahan_2" value="`+id_bahan+`">
                    <input type="number" name="qty_produksi_bahan_2" class="form-control" aria-label="Amount (to the nearest dollar)">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+satuan+`</span>
                    </div>
                </div>
                `;

                i++;
            });

            $(form+" .listItem2").hide();
            $(form+" .listItem3").show();
            $(form+" .listItem3").html(html);

            $(form+" .footer-2").html(`
                <div class="modal-footer justify-content-between">
                    <form action="" class="user">
                        <span>
                            <button type="button" class="btn btn-success btn-user btnBack"><i class="fa fa-arrow-left mr-1"></i> back</button>
                        </span>
                    </form>
                    <form action="" class="user">
                        <span>
                            <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary btn-user btnSimpan2">Simpan</button>
                        </span>
                    </form>
                </div>
            `);
        }
    })

    $(document).on("click", "#editProduksiBahan .btnBack", function(){
        let form = "#editProduksiBahan";

        $(form+" .listItem2").show();
        $(form+" .listItem3").hide();
        
        $(form+" .footer-2").html(`
            <div class="modal-footer">
                <form action="" class="user">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success btn-user btnNext">next <i class="fa fa-arrow-right ml-1"></i></button>
                    </div>
                </form>
            </div>
        `);
    })

    $(document).on("click", "#editProduksiBahan .btnSimpan2", function(){
        let form = "#editProduksiBahan"

        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menambahkan produksi bahan?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                let id_produksi = $(form+" input[name='id_produksi']").val();

                id_bahan = new Array();
                $.each($(form+" input[name='id_produksi_bahan_2']"), function(){
                    id_bahan.push($(this).val());
                });
                
                // untuk cek jik ada field yang tak diisi atau bernilai tidak sesuai
                let eror = 0;

                qty = new Array();
                $.each($(form+" input[name='qty_produksi_bahan_2']"), function(){
                    qty.push($(this).val());

                    if($(this).val() == ""){
                        eror = 1;
                    }

                });
                
                if(eror == 0){
                    data = {id_produksi: id_produksi, id_bahan:id_bahan, qty:qty}
                    let result = ajax(url_base+"produksi/add_produksi_bahan", "POST", data);

                    if(result == 1){
                        loadPagination(page)
                        data_edit_produksi_bahan(id_produksi)
                        btn_1();

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil menambahkan produksi bahan',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'terjadi kesalahan, ulangi proses input'
                        })
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'inputkan jumlah bahan, jumlah bahan tidak boleh kosong'
                    })
                }
                
            }
        })
    })
// edit produksi bahan 