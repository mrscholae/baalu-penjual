// modal add pembelian
    // when tombol add pembelian click (tombol plus)
    $(document).on("click", "#btnPlusPembelian", function(){
        $("#formAddPembelian").hide();
        $("#btnFormAddPembelian").hide();
        $("#btnFormKirim").show();
        $("#listAllBahan").show();

        let result = ajax(url_base+"bahan/get_all_bahan");

        let html = "";

        result.forEach(data => {
            html += `
                <div class="form-group text-gray-900">
                    <div class="custom-control custom-checkbox small">
                        <input type="checkbox" name="bahan" value="`+data.id_bahan+`|`+data.nama_bahan+`|`+data.satuan+`" class="custom-control-input" id="`+data.id_bahan+`">
                        <label class="custom-control-label" for="`+data.id_bahan+`">`+data.nama_bahan+`</label>
                    </div>
                </div>
            `
        });

        $(".listBahan").html(html);
    })

    // when tombol beli click in modal add pembelian
    $("#btnBeli").click(function(){
        var atLeastOneIsChecked = $('input[name="bahan"]:checked').length;
        if(atLeastOneIsChecked == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'pilih bahan yang akan dibeli terlebih dahulu'
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
                
                html += `
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+i+`. `+nama_bahan+`</span>
                    </div>
                    <input type="hidden" name="id_bahan_pembelian" value="`+id_bahan+`">
                    <input type="number" name="qty" class="form-control" aria-label="Amount (to the nearest dollar)">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+satuan+`</span>
                    </div>
                </div>
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Total Harga</span>
                    </div>
                    <input type="text" name="harga_total" class="form-control rupiah" aria-label="Amount (to the nearest dollar)" value="">
                </div>`;

                i++;
            });

            $(".listBahanPembelian").html(html);
            
            $("#btnFormKirim").hide();
            $("#formAddPembelian").show();
            $("#btnFormAddPembelian").show();
            $("#listAllBahan").hide();
        }
    })

    // when tombol bahan click in modal add pembelian 
    $("#btnBahan").click(function(){
        $("#btnFormKirim").show();
        $("#formAddPembelian").hide();
        $("#btnFormAddPembelian").hide();
        $("#listAllBahan").show();
    })

    // when tombol simpan click in modal add pembelian 
    $("#btnAddPembelian").click(function(){
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menambahkan pembelian?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                let tgl_pembelian = $("#tgl_pembelian_add").val();

                if(tgl_pembelian == ""){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'lengkapi isi form terlebih dahulu'
                    })
                } else {
                    id_bahan = new Array();
                    $.each($("input[name='id_bahan_pembelian']"), function(){
                        id_bahan.push($(this).val());
                    });
                    
                    // untuk cek jik ada field yang tak diisi atau bernilai tidak sesuai
                    let eror = 0;

                    qty = new Array();
                    $.each($("input[name='qty']"), function(){
                        qty.push($(this).val());

                        if($(this).val() == 0 || $(this).val() == ""){
                            eror = 1;
                        }

                    });

                    harga_total = new Array();
                    $.each($("input[name='harga_total']"), function(){
                        harga_total.push($(this).val());

                        if($(this).val() == "Rp. 0" || $(this).val() == ""){
                            eror = 1;
                        }

                    });

                    if(eror == 0){
                        data = {tgl_pembelian: tgl_pembelian, id_bahan:id_bahan, qty:qty, harga_total:harga_total}
                        let result = ajax(url_base+"pembelian/add_pembelian", "POST", data);

                        if(result == 1){
                            loadPagination(0)
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
                            text: 'inputkan jumlah bahan, jumlah bahan tidak boleh 0 atau kosong'
                        })
                    }
                }
            }
        })
    })

    // get data detail pembelian 
    $(document).on("click", ".btnDetailPembelian", function(){
        let id_pembelian = $(this).data("id");
        let data = {id_pembelian:id_pembelian};

        let result = ajax(url_base+"pembelian/get_detail_pembelian", "POST", data);

        html = "";
        
        html += `
            <li class="list-group-item list-group-item-info"><i class="fa fa-mail mr-1"></i>Data Pembelian</li>
            <li class="list-group-item">
                <p><i class="fa fa-calendar mr-3"></i>`+result.pembelian.tgl_pembelian+`</p>
                <p><i class="fa fa-dollar-sign mr-4"></i>`+formatRupiah(result.total, "Rp. ")+`</p>
            </li>`

        $(".detailPembelianData").html(html);
        
        html = "";
        if(result.detail_pembelian.length != 0){
            i = 1;
            result.detail_pembelian.forEach(data => {
                html += `
                    <li class="list-group-item list-group-item-primary d-flex justify-content-between">
                        <span>`+i+`. `+data.nama_bahan+`</span>
                        <span><i class="fa fa-dollar-sign mr-1"></i>`+formatRupiah(data.harga_total, "Rp. ")+`</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><i class="fa fa-shopping-bag mr-1"></i>`+data.qty+` `+data.satuan+`</span>
                        <span><i class="fa fa-box mr-1"></i>`+formatRupiah(data.harga_satuan, "Rp. ")+`</span>
                    </li>`
                    
                i++;

            });
        } else {
            html += `
            `
        }

        $(".detailPembelianListBahan").html(html);

    })

    // delete data pembelian 
    $(document).on("click", ".bthHapusPembelian", function(){
        let id_pembelian = $(this).data("id");

        Swal.fire({
                icon: 'question',
                text: 'Yakin akan menghapus data pembelian ini?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                data = {id_pembelian: id_pembelian}
                let result = ajax(url_base+"pembelian/hapus_pembelian", "POST", data);

                if(result == 1){
                    loadPagination(page)

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

    // edit pembelian 
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

    // when tombol kirim click in modal edit pembelian
    $(document).on("click", "#btnEditPembelianTambah", function(){
        var atLeastOneIsChecked = $('input[name="bahan"]:checked').length;
        if(atLeastOneIsChecked == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'pilih bahan yang akan ditambahkan terlebih dahulu'
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
                
                html += `<div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+i+`. `+nama_bahan+`</span>
                    </div>
                    <input type="hidden" name="id_bahan_pembelian_tambah" value="`+id_bahan+`">
                    <input type="number" name="qty_tambah" class="form-control" aria-label="Amount (to the nearest dollar)" value="">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+satuan+`</span>
                    </div>
                </div>
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Total Harga</span>
                    </div>
                    <input type="text" name="harga_total_tambah" class="form-control rupiah" aria-label="Amount (to the nearest dollar)" value="">
                </div>`;

                i++;
            });

            $("#editPembelianTambahBahan").html(html);
            
            $("#editPembelianTambahList").hide();
            $("#editPembelianTambahBahan").show();
            
            $("#btnEditPembelianTambah").hide();
            $(".footer-3").html(`
                <div class="modal-footer justify-content-between">
                    <form action="" class="user">
                        <span>
                            <button type="button" class="btn btn-success btn-user" id="btnBahanEditPembelian"><i class="fa fa-arrow-left mr-1"></i> bahan</button>
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

    // when tombol bahan clicked in modal edit
    $(document).on("click", "#btnBahanEditPembelian", function(){
        $("#editPembelianTambahList").show();
        $("#editPembelianTambahBahan").hide();

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

                if(tgl_pembelian == ""){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'lengkapi isi form terlebih dahulu'
                    })
                } else {

                    data = {id_pembelian: id_pembelian, tgl_pembelian: tgl_pembelian}
                    let result = ajax(url_base+"pembelian/edit_pembelian", "POST", data);

                    if(result == 1){
                        loadPagination(page)

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

    // when tombol trash click in modal edit pembelian bahan 
    $(document).on("click",".btnDeleteDetailPembelian",function(){
        let data = $(this).data("id");
        data = data.split("|");

        let id = data[0];
        let id_pembelian = data[1];
        let nama_bahan = data[2]
        
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menghapus '+nama_bahan+' dari pembelian?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                data = {id: id}

                let result = ajax(url_base+"pembelian/delete_detail_pembelian", "POST", data);

                if(result == 1){
                    
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil menghapus bahan dari pembelian',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    data_edit_pembelian(id_pembelian);

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, gagal menghapus bahan dari pembelian'
                    })
                }
            }
        })
    })

    // when tombol simpan edit bahan click
    $("#btnEditPembelianBahan").click(function(){
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan mengubah detail bahan pembelian?',
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
                $.each($("input[name='harga_total_edit']"), function(){
                    harga.push($(this).val());

                    if($(this).val() == "Rp. 0" || $(this).val() == ""){
                        eror = 1;
                    }

                });

                if(eror == 0){
                    data = {id_detail:id_detail, qty:qty, harga_total:harga}
                    let result = ajax(url_base+"pembelian/edit_bahan_pembelian", "POST", data);

                    if(result == 1){
                        loadPagination(page);

                        data_edit_pembelian(id_pembelian);
                        $("#addPembelian").modal("hide");

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil mengubah detail pembelian bahan',
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
    
    // when tombol simpan click in modal edit pembelian tambah bahan
    $(document).on("click", "#editPembelianTambahSimpan", function(){
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menambahkan bahan pada pembelian ini?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {

                let id_pembelian = $("#id_pembelian_edit").val();

                id_bahan = new Array();
                $.each($("input[name='id_bahan_pembelian_tambah']"), function(){
                    id_bahan.push($(this).val());
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
                $.each($("input[name='harga_total_tambah']"), function(){
                    harga.push($(this).val());

                    if($(this).val() == 0 || $(this).val() == ""){
                        eror = 1;
                    }
                });
                
                if(eror == 0){
                    data = {id_pembelian:id_pembelian, id_bahan:id_bahan, qty:qty, harga_total:harga}
                    let result = ajax(url_base+"pembelian/add_bahan_pembelian", "POST", data);

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
                            text: 'Berhasil menambahkan bahan pembelian',
                            showConfirmButton: false,
                            timer: 1500
                        })

                        loadPagination(page);
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

    function data_edit_pembelian(id_pembelian){
                
        let data = {id_pembelian:id_pembelian};

        let result = ajax(url_base+"pembelian/get_detail_pembelian", "POST", data);

        $("#id_pembelian_edit").val(result.pembelian.id_pembelian);
        $("#tgl_pembelian_edit").val(result.pembelian.tgl_pembelian_format);

        html = "";
        i = 1;

        if(result.detail_pembelian.length != 0){
            
            result.detail_pembelian.forEach(data => {
                
                html += `
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+i+`. `+data.nama_bahan+`</span>
                    </div>
                    <input type="hidden" name="id_detail_edit" value="`+data.id+`">
                    <input type="number" name="qty_edit" class="form-control" aria-label="Amount (to the nearest dollar)" value="`+data.qty+`">
                    <div class="input-group-prepend">
                        <span class="input-group-text">`+data.satuan+`</span>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><a href="javascript:void(0)" class="btnDeleteDetailPembelian" data-id="`+data.id+`|`+data.id_pembelian+`|`+data.nama_bahan+`"><i class="fa fa-trash-alt text-danger"></i></a></span>
                    </div>
                </div>
                
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Harga</span>
                    </div>
                    <input type="text" name="harga_total_edit" class="form-control rupiah" aria-label="Amount (to the nearest dollar)" value="`+formatRupiah(data.harga_total, 'Rp. ')+`">
                </div>`;

                i++;
            });

        } else {
            html += `<div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning"></i>list bahan kosong</div>`
        }

        $("#editPembelianBahan").html(html);

        result = ajax(url_base+"pembelian/get_all_bahan_belum_dikirim", "POST", data);

        html = "";
        if(result.length != 0){
            result.forEach(data => {
                html += `
                    <div class="form-group text-gray-900">
                        <div class="custom-control custom-checkbox small">
                        <input type="checkbox" name="bahan" value="`+data.id_bahan+`|`+data.nama_bahan+`|`+data.satuan+`" class="custom-control-input" id="`+data.id_bahan+`">
                            <label class="custom-control-label" for="`+data.id_bahan+`">`+data.nama_bahan+`</label>
                        </div>
                    </div>`
            });
        } else {
            html += `
                <div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning mr-1"></i>list bahan kosong</div>`
        }

        $("#editPembelianTambahList").html(html)

    }
// modal add pembelian 