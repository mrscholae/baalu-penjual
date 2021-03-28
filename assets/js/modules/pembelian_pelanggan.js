// modal add pembelian
    // when tombol add pembelian click (tombol gambar truk)
    $(document).on("click", ".addPembelian", function(){
        let form = "#addPembelian";

        $(form+" .form-1").show();
        $(form+" .form-2").hide();

        let data = $(this).data("id");
        data = data.split("|");

        let id_pelanggan = data[0];
        let nama_pelanggan = data[1];

        $(form+" input[name='nama_pelanggan']").val(nama_pelanggan);
        $(form+" input[name='id_pelanggan']").val(id_pelanggan);

        let result = ajax(url_base+"barang/get_all_barang");

        let html = "";

        result.forEach(data => {
            html += `
                <div class="form-group text-gray-900">
                    <div class="custom-control custom-checkbox small">
                        <input type="checkbox" name="barang" value="`+data.id_barang+`|`+data.kode_barang+`|`+formatRupiah(data.bagi_hasil, 'Rp. ')+`|`+formatRupiah(data.harga, 'Rp. ')+`|`+data.stok+`" class="custom-control-input" id="addPembelian`+data.id_barang+`">
                        <label class="custom-control-label" for="addPembelian`+data.id_barang+`">`+data.nama_barang+` (`+data.stok+`)</label>
                    </div>
                </div>
            `
        });

        $(form+" .listItem").html(html);

        $(form+" .modal-footer").removeClass("justify-content-between");
        $(form+" .modal-footer").html(`<form action="" class="user">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-success btn-user btnNext">Next <i class="fa fa-arrow-right ml-1"></i></button>
            </div>
        </form>`);
    })

    // when tombol next click in modal add pembelian
    $(document).on("click","#addPembelian .btnNext", function(){
        form = "#addPembelian"
        var atLeastOneIsChecked = $(form+' input[name="barang"]:checked').length;
        if(atLeastOneIsChecked == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'pilih barang yang akan dikirim terlebih dahulu'
            })
        } else {
            $(form+" .form-1").hide();
            $(form+" .form-2").show();

            let i = 1;
            html = "";
            $.each($(form+" input[name='barang']:checked"), function(){
                data = $(this).val();
                data = data.split("|");
                id_barang = data[0];
                kode_barang = data[1];
                bagi_hasil = data[2];
                harga = data[3];
                stok = data[4];
                
                html += `
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+i+`. `+kode_barang+` (`+stok+`)</span>
                    </div>
                    <input type="hidden" name="id_barang" value="`+id_barang+`">
                    <input type="number" name="qty" class="form-control" aria-label="Amount (to the nearest dollar)" value="">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Harga</span>
                    </div>
                    <input type="text" name="harga" class="form-control rupiah" aria-label="Amount (to the nearest dollar)" value="`+harga+`">
                </div>`;

                i++;
            });

            $(form+" .listItem2").html(html);
            
            $(form+" .modal-footer").addClass("justify-content-between");
            $(form+" .modal-footer").html(`<form action="" class="user">
                <span>
                    <button type="button" class="btn btn-success btn-user btnBack"><i class="fa fa-arrow-left mr-1"></i> back</button>
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

    // when tombol barang click in modal add pembelian 
    $(document).on("click", "#addPembelian .btnBack", function(){
        form = "#addPembelian";

        $(form+" .form-1").show();
        $(form+" .form-2").hide();
        
        $(form+" .modal-footer").removeClass("justify-content-between");
        $(form+" .modal-footer").html(`<form action="" class="user">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-success btn-user btnNext">Next <i class="fa fa-arrow-right ml-1"></i></button>
            </div>
        </form>`);
    })

    // when tombol simpan click in modal add pembelian 
    $(document).on("click", "#addPembelian .btnSimpan", function(){
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menambahkan pembelian pelanggan?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                let form = "#addPembelian";

                let id_pelanggan = $(form+" input[name='id_pelanggan']").val();
                let tgl_pembelian = $(form+" input[name='tgl_pembelian']").val();

                let eror = required(form);
        
                if( eror == 1){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'lengkapi isi form terlebih dahulu'
                    })
                } else {
                    id_barang = new Array();
                    $.each($(form+" input[name='id_barang']"), function(){
                        id_barang.push($(this).val());
                    });
                    
                    // untuk cek jik ada field yang tak diisi atau bernilai tidak sesuai
                    eror = 0;

                    qty = new Array();
                    $.each($(form+" input[name='qty']"), function(){
                        qty.push($(this).val());

                        if($(this).val() == 0 || $(this).val() == ""){
                            eror = 1;
                        }

                    });

                    harga = new Array();
                    $.each($(form+" input[name='harga']"), function(){
                        harga.push($(this).val());

                        if($(this).val() == "Rp. 0" || $(this).val() == ""){
                            eror = 1;
                        }

                    });

                    if(eror == 0){
                        data = {id_pelanggan: id_pelanggan, tgl_pembelian: tgl_pembelian, id_barang:id_barang, qty:qty, harga:harga}
                        let result = ajax(url_base+"pelanggan/add_pembelian", "POST", data);

                        if(result == 1){
                            reload_data();
                            $("#addPembelian").modal("hide");

                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                text: 'Berhasil menambahkan pembelian',
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
                            text: 'lengkapi isi form'
                        })
                    }
                }
            }
        })
    })
// modal add pembelian 

// edit pembelian 
    function data_edit_pembelian(id_pembelian){
                
        let data = {id_pembelian:id_pembelian};

        let result = ajax(url_base+"pelanggan/get_detail_pembelian", "POST", data);

        // console.log(result);

        $("#id_pembelian_edit").val(result.pembelian.id_pembelian);
        $(".nama_pelanggan_edit_pembelian").val(result.pembelian.nama_pelanggan);
        $("#tgl_pembelian_edit").val(result.pembelian.tgl_pembelian_format);
        $("#tgl_pengambilan_edit").val(result.pembelian.tgl_pengambilan_format);

        html = "";
        i = 1;

        if(result.detail_pembelian.length != 0){
            
            result.detail_pembelian.forEach(data => {
                
                html += `
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+i+`. `+data.kode_barang+` (`+data.stok+`)</span>
                    </div>
                    <input type="hidden" name="id_detail_edit" value="`+data.id+`">
                    <input type="number" name="qty_edit" class="form-control" value="`+data.kirim+`" aria-label="Amount (to the nearest dollar)">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><a href="javascript:void(0)" class="btnDeleteDetailPembelian" data-id="`+data.id+`|`+data.id_pembelian+`|`+data.nama_barang+`"><i class="fa fa-trash-alt text-danger"></i></a></span>
                    </div>
                </div>
                
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Harga</span>
                    </div>
                    <input type="text" name="harga_jual_edit" class="form-control rupiah" aria-label="Amount (to the nearest dollar)" value="`+formatRupiah(data.harga, 'Rp. ')+`">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">BH</span>
                    </div>
                    <input type="text" name="bh_edit" class="form-control rupiah" aria-label="Amount (to the nearest dollar)" value="`+formatRupiah(data.bagi_hasil, 'Rp. ')+`">
                </div>`;

                i++;
            });

        } else {
            html += `<div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning"></i>list barang kosong</div>`
        }

        $("#editPembelianBarang").html(html);

        result = ajax(url_base+"pelanggan/get_all_barang_belum_dikirim", "POST", data);

        html = "";
        if(result.length != 0){
            result.forEach(data => {
                html += `
                    <div class="form-group text-gray-900">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" name="barang" value="`+data.id_barang+`|`+data.kode_barang+`|`+data.harga+`|`+data.bagi_hasil+`|`+data.stok+`" class="custom-control-input" id="edit`+data.id_barang+`">
                            <label class="custom-control-label" for="edit`+data.id_barang+`">`+data.nama_barang+` (`+data.stok+`)</label>
                        </div>
                    </div>`
            });
        } else {
            html += `
                <div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning mr-1"></i>list barang kosong</div>`
        }

        $("#editPembelianTambahList").html(html)

    }

    // when detail pembelian click
    $(document).on("click", ".detailPembelian", function(){
        let form = "#detailPembelian";

        let id_pembelian = $(this).data("id");
        // console.log(id_pembelian)
        let data = {id_pembelian:id_pembelian};

        let result = ajax(url_base+"pelanggan/get_detail_pembelian", "POST", data);
        
        html = "";
        
        html += `
            <li class="list-group-item list-group-item-info"><i class="fa fa-mail mr-1"></i>Data Pembelian</li>
            <li class="list-group-item">
                <p><i class="fa fa-store mr-3"></i>`+result.pembelian.nama_pelanggan+`</p>
                <p><i class="fa fa-truck mr-3"></i>`+result.pembelian.tgl_pembelian+`</p>
                <p><i class="fa fa-dollar-sign mr-4"></i>`+formatRupiah(result.pembelian.total, "Rp. ")+`</p>
            </li>`

        $(form+" .listData").html(html);

        
        html = "";
        if(result.detail_pembelian.length != 0){
            i = 1;
            result.detail_pembelian.forEach(data => {
                html += `
                    <li class="list-group-item list-group-item-primary d-flex justify-content-between">
                        <span>`+i+`. `+data.nama_barang+`</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>
                            <i class="fa fa-shopping-bag mr-3"></i>`+data.qty+`
                        </span>
                        <span><i class="fa fa-dollar-sign mr-1"></i>`+formatRupiah(data.harga, "Rp. ")+`</span>
                    </li>`
                    
                i++;

            });
        } else {
            html += `
            `
        }

        $(form+" .listItem").html(html);
    })
    
    // when edit pembelian click
    $(document).on("click", ".btnEditPembelian", function(){
        
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

        $(".footer-3-1").hide();
        
        let id_pembelian = $(this).data("id");

        data_edit_pembelian(id_pembelian);

    })
    
    // when tombol simpan click in modal edit pembelian 
    $("#btnEditPembelian").click(function(){
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan mengubah data pembelian?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                let id_pembelian = $("#id_pembelian_edit").val();
                let tgl_pembelian = $("#tgl_pembelian_edit").val();
                let tgl_pengambilan = $("#tgl_pengambilan_edit").val();

                if(tgl_pembelian == "" || tgl_pengambilan == ""){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'lengkapi isi form terlebih dahulu'
                    })
                } else {

                    data = {id_pembelian: id_pembelian, tgl_pembelian: tgl_pembelian, tgl_pengambilan: tgl_pengambilan}
                    let result = ajax(url_base+"pelanggan/edit_pembelian", "POST", data);

                    if(result == 1){
                        reload_data();

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil mengubah data pembelian',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'terjadi kesalahan'
                        })
                    }
                }
            }
        })
    })
    
    // when tombol trash click in modal edit pembelian barang 
    $(document).on("click",".btnDeleteDetailPembelian",function(){
        let data = $(this).data("id");
        data = data.split("|");

        let id = data[0];
        let id_pembelian = data[1];
        let kode_barang = data[2]
        
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menghapus '+kode_barang+' dari pembelian?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                data = {id: id}

                let result = ajax(url_base+"pelanggan/delete_detail_pembelian", "POST", data);

                if(result == 1){
                    
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil menghapus barang dari pembelian',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    data_edit_pembelian(id_pembelian);

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, gagal menghapus barang dari pembelian'
                    })
                }
            }
        })
    })
    
    // when tombol simpan edit barang click
    $("#btnEditPembelianBarang").click(function(){
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan mengubah detail barang pembelian?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                id_pembelian = $("#id_pembelian_edit").val();

                id_detail = new Array();
                $.each($("input[name='id_detail_edit']"), function(){
                    id_detail.push($(this).val());
                });
                
                // untuk cek jik ada qty yang 0
                let eror = 0;

                qty = new Array();
                $.each($("input[name='qty_edit']"), function(){
                    qty.push($(this).val());

                    if($(this).val() == 0 || $(this).val() == ""){
                        eror = 1;
                    }

                });

                harga = new Array();
                $.each($("input[name='harga_jual_edit']"), function(){
                    harga.push($(this).val());

                    if($(this).val() == "Rp. 0" || $(this).val() == ""){
                        eror = 1;
                    }

                });

                bh = new Array();
                $.each($("input[name='bh_edit']"), function(){
                    bh.push($(this).val());

                    if($(this).val() == ""){
                        eror = 1;
                    }

                });

                if(eror == 0){
                    data = {id_detail:id_detail, qty:qty, harga:harga, bh:bh}
                    let result = ajax(url_base+"pelanggan/edit_barang_pembelian", "POST", data);

                    if(result == 1){
                        data_edit_pembelian(id_pembelian);
                        $("#addPembelian").modal("hide");

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil mengubah detail pembelian barang',
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
    
    // when tombol delete pembelian click 
    $(document).on("click", ".bthHapusPembelian", function(){
        let id_pembelian = $(this).data("id");

        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menghapus data pembelian?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                data = {id_pembelian: id_pembelian}
                let result = ajax(url_base+"pelanggan/hapus_pembelian", "POST", data);

                if(result == 1){
                    reload_data();

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil menghapus data pembelian',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, gagal menghapus data pembelian'
                    })
                }
            }
        })
    })
    
    // when button circle bg warning clicked
    $(document).on("click", ".btnAddPengambilan", function(){
        let id_pembelian = $(this).data("id");
        // console.log(id_pembelian)
        let data = {id_pembelian:id_pembelian};

        let result = ajax(url_base+"pelanggan/get_detail_pembelian", "POST", data);

        // console.log(result);
        
        $("#id_pembelian_pengambilan").val(result.pembelian.id_pembelian)
        $("#nama_pelanggan_pengambilan").val(result.pembelian.nama_pelanggan)
        $("#tgl_pembelian_pengambilan").val(result.pembelian.tgl_pembelian)
        $("#tgl_pengambilan_pengambilan").val(result.pembelian.tgl_pengambilan)
        
        i = 1;
        html = "";
        result.detail_pembelian.forEach(data => {
            
            html += `<div class="input-group input-group-sm mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text">`+i+`. `+data.kode_barang+` (`+data.kirim+`)</span>
                </div>
                <input type="hidden" name="id_detail" value="`+data.id+`">
                <input type="number" name="qty_kembali" class="form-control" value="0" aria-label="Amount (to the nearest dollar)">
            </div>`

            i++;
        });
        
        $(".addPengambilanListBarang").html(html);
    })
    
    // when tombol simpan click in modal add pengambilan 
    $("#btnAddPengambilan").click(function(){
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menginputkan data pengambilan?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                id_pembelian = $("#id_pembelian_pengambilan").val();

                id_detail = new Array();
                $.each($("input[name='id_detail']"), function(){
                    id_detail.push($(this).val());
                });
                
                // untuk cek jik ada qty yang 0
                let eror = 0;

                qty = new Array();
                $.each($("input[name='qty_kembali']"), function(){
                    qty.push($(this).val());

                    if($(this).val() == ""){
                        eror = 1;
                    }

                });

                if(eror == 0){
                    data = {id_pembelian:id_pembelian, id_detail:id_detail, qty:qty}
                    let result = ajax(url_base+"pelanggan/add_pengambilan", "POST", data);

                    if(result == 1){
                        reload_data();
                        $("#addPengambilan").modal("hide");

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil menginputkan pengambilan',
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
    
    // when tombol kirim click in modal edit pembelian
    $(document).on("click", "#btnEditPembelianTambah", function(){
        var atLeastOneIsChecked = $('input[name="barang"]:checked').length;
        if(atLeastOneIsChecked == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'pilih barang yang akan ditambahkan terlebih dahulu'
            })
        } else {
            let i = 1;
            html = "";
            $.each($("input[name='barang']:checked"), function(){
                data = $(this).val();
                data = data.split("|");
                id_barang = data[0];
                kode_barang = data[1];
                harga = data[2];
                bagi_hasil = data[3];
                stok = data[4];
                
                html += `<div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+i+`. `+kode_barang+` (`+stok+`)</span>
                    </div>
                    <input type="hidden" name="id_barang_pembelian_tambah" value="`+id_barang+`">
                    <input type="number" name="qty_tambah" class="form-control" aria-label="Amount (to the nearest dollar)" value="0">
                </div>
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Harga</span>
                    </div>
                    <input type="text" name="harga_jual_tambah" class="form-control rupiah" aria-label="Amount (to the nearest dollar)" value="`+formatRupiah(harga, "Rp. ")+`">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">BH</span>
                    </div>
                    <input type="text" name="bh_tambah" class="form-control rupiah" aria-label="Amount (to the nearest dollar)" value="`+formatRupiah(bagi_hasil, "Rp. ")+`">
                </div>`;

                i++;
            });

            $("#editPembelianTambahBarang").html(html);
            
            $("#editPembelianTambahList").hide();
            $("#editPembelianTambahBarang").show();
            
            $("#btnEditPembelianTambah").hide();
            $(".footer-3").html(`
                <div class="modal-footer justify-content-between">
                    <form action="" class="user">
                        <span>
                            <button type="button" class="btn btn-success btn-user" id="btnBarangEditPembelian"><i class="fa fa-arrow-left mr-1"></i> barang</button>
                        </span>
                    </form>
                    <form action="" class="user">
                        <span>
                            <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary btn-user" id="editPembelianTambahSimpan">Simpan</button>
                        </span>
                    </form>
                </div>
            `);
        }
    })
    
    // when tombol barang clicked 
    $(document).on("click", "#btnBarangEditPembelian", function(){
        $("#editPembelianTambahList").show();
        $("#editPembelianTambahBarang").hide();

        $(".footer-3").html(`
            <div class="modal-footer">
                <form action="" class="user">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success btn-user" id="btnEditPembelianTambah"><i class="fa fa-plus mr-1"></i> Tambah</button>
                    </div>
                </form>
            </div>
        `);
    })
    
    // when tombol simpan click in modal edit pembelian tambah barang
    $(document).on("click", "#editPembelianTambahSimpan", function(){
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menambahkan barang pada pembelian ini?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {

                let id_pembelian = $("#id_pembelian_edit").val();

                id_barang = new Array();
                $.each($("input[name='id_barang_pembelian_tambah']"), function(){
                    id_barang.push($(this).val());
                });
                
                // untuk cek jik ada qty yang 0
                let eror = 0;

                qty = new Array();
                $.each($("input[name='qty_tambah']"), function(){
                    qty.push($(this).val());

                    if($(this).val() == 0 || $(this).val() == ""){
                        eror = 1;
                    }
                });

                harga = new Array();
                $.each($("input[name='harga_jual_tambah']"), function(){
                    harga.push($(this).val());

                    if($(this).val() == 0 || $(this).val() == ""){
                        eror = 1;
                    }
                });
                
                bh = new Array();
                $.each($("input[name='bh_tambah']"), function(){
                    bh.push($(this).val());

                    if($(this).val() == 0 || $(this).val() == ""){
                        eror = 1;
                    }
                });

                if(eror == 0){
                    data = {id_pembelian:id_pembelian, id_barang:id_barang, qty:qty, harga:harga, bh:bh}
                    let result = ajax(url_base+"pelanggan/add_barang_pembelian", "POST", data);

                    if(result == 1){
            
                        // button form
                        $(".btn-form-1").removeClass("active");
                        $(".btn-form-2").addClass("active");
                        $(".btn-form-3").removeClass("active");

                        // form
                        $(".form-1").hide();
                        $(".form-2").show();
                        $(".form-3").hide();
                        
                        // footer
                        $(".footer-1").hide();
                        $(".footer-2").show();
                        $(".footer-3").hide();

                        data_edit_pembelian(id_pembelian);

                        
                        $("#editPembelianTambahList").show()
                        $("#editPembelianTambahBarang").hide()

                        $(".footer-3").html(`
                            <div class="modal-footer">
                                <form action="" class="user">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-success btn-user" id="btnEditPembelianTambah"><i class="fa fa-plus mr-1"></i> Tambah</button>
                                    </div>
                                </form>
                            </div>
                        `);
                        

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil menambahkan barang pembelian',
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
// edit pembelian 

// tambah 3 hari dari tanggal pengambilan 
    $("#tgl_pembelian_add").change(function(){
        let tgl = new Date($(this).val());
        tgl = tgl.addDays(3);

        $("#tgl_pengambilan_add").val(tgl.toISOString().split('T')[0]+"T"+tgl.getHours()+":"+tgl.getMinutes());
    })

    Date.prototype.addDays = function (days) {
        let date = new Date(this.valueOf());
        date.setDate(date.getDate() + days);
        return date;
    }
// tambah 3 hari dari tanggal pengambilan 
