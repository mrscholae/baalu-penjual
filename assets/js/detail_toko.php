<script>

    $(function(){
        reload_data();

        function reload_data(){
            let result = ajax("<?= base_url()?>toko/ajax_toko/<?= $id_toko?>", "POST", "");
            
            html = "";
            
            if(result.toko.hapus == 0){
                html += `
                        <div class="col-12 col-md-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-building mr-1"></i>Profil Toko</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated-fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Data Toko</div>
                                            <a class="dropdown-item btnEditToko" href="#editToko" data-toggle="modal" data-id="`+result.toko.id_toko+`">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item btnHapusToko" href="javascript:void(0)" data-id="`+result.toko.id_toko+`|`+result.toko.nama_toko+`">Hapus</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-gray-900">
                                    <p><i class="fa fa-user-circle mr-4"></i>`+result.toko.pj+`</p>
                                    <p><i class="fa fa-phone mr-4"></i>`+result.toko.no_hp+`</p>
                                    <p><i class="fa fa-map-marker-alt mr-4"></i>`+result.toko.alamat+`</p>
                                    <p><i class="fa fa-calendar-alt mr-4"></i>`+result.toko.tgl_bergabung+`</p>
                                    <p><i class="fa fa-truck mr-3"></i>`+result.toko.pengiriman+` pengiriman </p>
                                    <div class="d-flex justify-content-center mt-1">
                                        <a href="#addPengiriman" data-toggle="modal" class="btn btn-circle btn-success mr-1 addPengiriman" data-id="`+result.toko.id_toko+`|`+result.toko.nama_toko+`"><i class="fa fa-truck"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                html += `<div class="col-12 mb-4">
                    <h5 class="mb-0 text-gray-800">List Pengiriman</h5>
                </div>`;

                if(result.pengiriman.length != 0){
                    result.pengiriman.forEach(data => {
                        if(data.status == "Selesai"){
                            status = `
                            <div class="list-group-item-success card-header py-3 d-flex flex-row align-items-center justify-content-between">    
                                <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-check-circle text-success mr-1"></i>Selesai</h6>`

                            pengambilan = ``;

                            dropdown = `<a class="dropdown-item btnDetailPengiriman" href="#detailPengiriman" data-id="`+data.id_pengiriman+`" data-toggle="modal">Detail</a>`;
                        } else {
                            status = `
                            <div class="list-group-item-warning card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-exclamation-circle text-warning mr-1"></i>Proses</h6>`
                            
                            // button pengambilan 
                            pengambilan = `<div class="d-flex justify-content-center mt-1">
                                <a href="#addPengambilan" data-toggle="modal" data-id="`+data.id_pengiriman+`" class="btn btn-circle btn-warning mr-1 btnAddPengambilan"><i class="fa fa-hand-holding-usd"></i></a>
                            </div>`;

                            dropdown = ` <a class="dropdown-item btnDetailPengiriman" href="#detailPengiriman" data-id="`+data.id_pengiriman+`" data-toggle="modal">Detail</a>
                                <a class="dropdown-item" href="javascript:void(0)">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item bthHapusPengiriman" href="javascript:void(0)" data-id="`+data.id_pengiriman+`">Hapus</a>`
                        }
                        html += `<div class="col-12 col-md-4">
                            <div class="card shadow mb-4">
                                
                                    `+status+`
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Pengiriman</div>
                                            `+dropdown+`
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-gray-900">
                                    <p><i class="fa fa-map-marker-alt mr-4"></i>`+data.alamat+` </p>
                                    <p><i class="fa fa-truck mr-3"></i>`+data.tgl_pengiriman+`</p>
                                    <p><i class="fa fa-truck-pickup fa-flip-horizontal mr-3"></i>`+data.tgl_pengambilan+`</p>
                                    `+pengambilan+`
                                </div>
                            </div>
                        </div>`;
                    });
                } else {
                    html += `<div class="col-12"><div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning mr-1"></i>Data pengiriman kosong</div></div>`
                }
            } else {
                html += `<div class="col-12"><div class="alert alert-danger"><i class="fa fa-times-circle text-danger mr-1"></i>Data toko ini telah dihapus</div></div>`
            }

            $("#dataAjax").html(html);
        }

        // when tombol edit toko click 
        $(document).on("click",".btnEditToko", function(){
            let id_toko = $(this).data("id");
            let data = {id_toko: id_toko};
            let result = ajax("<?= base_url()?>toko/get_toko", "POST", data);
            
            $("#id_toko_edit").val(result.id_toko);
            $("#tgl_bergabung_edit").val(result.tgl_bergabung);
            $("#nama_toko_edit").val(result.nama_toko);
            $("#alamat_edit").val(result.alamat);
            $("#pj_edit").val(result.pj);
            $("#no_hp_edit").val(result.no_hp);
        })

        // when tombol simpan click in modal edit toko 
        $("#btnEditToko").click(function(){
            Swal.fire({
                icon: 'question',
                text: 'Yakin akan merubah data toko?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then(function (result) {
                if (result.value) {
                    let id_toko = $("#id_toko_edit").val();
                    let tgl_bergabung = $("#tgl_bergabung_edit").val();
                    let nama_toko = $("#nama_toko_edit").val();
                    let alamat = $("#alamat_edit").val();
                    let pj = $("#pj_edit").val();
                    let no_hp = $("#no_hp_edit").val();
                    
                    if(tgl_bergabung == "" || nama_toko == "" || alamat == "" || pj == ""|| no_hp == ""){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal merubah data toko, lengkapi isi form terlebih dahulu'
                        })
                    } else {
                        data = {id_toko: id_toko, tgl_bergabung: tgl_bergabung, nama_toko: nama_toko, alamat: alamat, pj: pj, no_hp: no_hp}
                        let result = ajax("<?= base_url()?>toko/edit_toko", "POST", data);

                        if(result == 1){
                            reload_data();
                            $("#formAddToko").trigger("reset");

                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                text: 'Berhasil merubah data toko',
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

        // when tombol delete toko click 
        $(document).on("click", ".btnHapusToko", function(){
            let data = $(this).data("id");
            data = data.split("|");
            let id_toko = data[0];
            let nama_toko = data[1];

            Swal.fire({
                icon: 'question',
                text: 'Yakin akan menghapus data toko '+nama_toko+'?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then(function (result) {
                if (result.value) {
                    data = {id_toko: id_toko}
                    let result = ajax("<?= base_url()?>toko/hapus_toko", "POST", data);

                    if(result == 1){
                        reload_data();

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil menghapus data toko',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'terjadi kesalahan, gagal menghapus data toko'
                        })
                    }
                }
            })
        })

        // modal add pengiriman
            // when tombol add pengiriman click (tombol gambar truk)
            $(document).on("click", ".addPengiriman", function(){
                $("#formAddPengiriman").hide();
                $("#btnFormAddPengiriman").hide();
                $("#btnFormKirim").show();
                $("#listAllBarang").show();

                let data = $(this).data("id");
                data = data.split("|");

                let id_toko = data[0];
                let nama_toko = data[1];

                $("#nama_toko_pengiriman").val(nama_toko);
                $("#id_toko_pengiriman").val(id_toko);

                let result = ajax("<?= base_url()?>barang/get_all_barang");

                let html = "";

                result.forEach(data => {
                    html += `
                        <div class="form-group text-gray-900">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" name="barang" value="`+data.id_barang+`|`+data.kode_barang+`" class="custom-control-input" id="`+data.id_barang+`">
                                <label class="custom-control-label" for="`+data.id_barang+`">`+data.nama_barang+`</label>
                            </div>
                        </div>
                    `
                });

                $(".listBarang").html(html);
            })

            // when tombol kirim click in modal add pengiriman
            $("#btnKirim").click(function(){
                var atLeastOneIsChecked = $('input[name="barang"]:checked').length;
                if(atLeastOneIsChecked == 0){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'pilih barang yang akan dikirim terlebih dahulu'
                    })
                } else {
                    let i = 1;
                    html = "";
                    $.each($("input[name='barang']:checked"), function(){
                        data = $(this).val();
                        data = data.split("|");
                        id_barang = data[0];
                        kode_barang = data[1];
                        
                        html += `<div class="input-group input-group-sm mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">`+i+`. `+kode_barang+`</span>
                            </div>
                            <input type="hidden" name="id_barang_pengiriman" value="`+id_barang+`">
                            <input type="number" name="qty" class="form-control" aria-label="Amount (to the nearest dollar)" value="0">
                        </div>`;

                        i++;
                    });

                    $(".listBarangPengiriman").html(html);
                    
                    $("#btnFormKirim").hide();
                    $("#formAddPengiriman").show();
                    $("#btnFormAddPengiriman").show();
                    $("#listAllBarang").hide();
                }
            })

            // when tombol barang click in modal add pengiriman 
            $("#btnBarang").click(function(){
                $("#btnFormKirim").show();
                $("#formAddPengiriman").hide();
                $("#btnFormAddPengiriman").hide();
                $("#listAllBarang").show();
            })

            // when tombol simpan click in modal add pengiriman 
            $("#btnAddPengiriman").click(function(){
                Swal.fire({
                    icon: 'question',
                    text: 'Yakin akan menambahkan pengiriman?',
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then(function (result) {
                    if (result.value) {
                        let id_toko = $("#id_toko_pengiriman").val();
                        let tgl_pengiriman = $("#tgl_pengiriman_add").val();
                        let tgl_pengambilan = $("#tgl_pengambilan_add").val();

                        if(tgl_pengiriman == "" || tgl_pengambilan == ""){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'lengkapi isi form terlebih dahulu'
                            })
                        } else {
                            id_barang = new Array();
                            $.each($("input[name='id_barang_pengiriman']"), function(){
                                id_barang.push($(this).val());
                            });
                            
                            // untuk cek jik ada qty yang 0
                            let errorQty = 0;

                            qty = new Array();
                            $.each($("input[name='qty']"), function(){
                                qty.push($(this).val());

                                if($(this).val() == 0 || $(this).val() == ""){
                                    errorQty = 1;
                                }

                            });

                            if(errorQty == 0){
                                data = {id_toko: id_toko, tgl_pengiriman: tgl_pengiriman, tgl_pengambilan: tgl_pengambilan, id_barang:id_barang, qty:qty}
                                let result = ajax("<?= base_url()?>toko/add_pengiriman", "POST", data);

                                if(result == 1){
                                    reload_data();
                                    $("#addPengiriman").modal("hide");

                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        text: 'Berhasil menambahkan pengiriman',
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
                    }
                })
            })
        // modal add pengiriman 

        // when detail pengiriman click
        $(document).on("click", ".btnDetailPengiriman", function(){
            let id_pengiriman = $(this).data("id");
            // console.log(id_pengiriman)
            let data = {id_pengiriman:id_pengiriman};

            let result = ajax("<?= base_url()?>toko/get_detail_pengiriman", "POST", data);
            
            html = "";
            
            html += `
                <li class="list-group-item list-group-item-info"><i class="fa fa-mail mr-1"></i>Data Pengiriman</li>
                <li class="list-group-item">
                    <p><i class="fa fa-store mr-3"></i>`+result.pengiriman.nama_toko+`</p>
                    <p><i class="fa fa-info-circle mr-3"></i>`+result.pengiriman.status+`</p>
                    <p><i class="fa fa-truck mr-3"></i>`+result.pengiriman.tgl_pengiriman+`</p>
                    <p><i class="fa fa-truck-pickup fa-flip-horizontal mr-3"></i>`+result.pengiriman.tgl_pengambilan+`</p>
                </li>`

            $(".detailPengirimanData").html(html);

            
            html = "";
            if(result.detail_pengiriman.length != 0){
                i = 1;
                result.detail_pengiriman.forEach(data => {
                    if(result.pengiriman.status == "Selesai") {
                        kembali = `<i class="fa fa-truck-pickup fa-flip-horizontal mr-3"></i>`+data.kembali;
                    } else {
                        kembali = `<i class="fa fa-truck-pickup fa-flip-horizontal mr-3"></i>-`;
                    }

                    html += `
                        <li class="list-group-item d-flex justify-content-between">
                            <span>`+i+`. `+data.kode_barang+`</span>
                            <span>
                                <i class="fa fa-truck mr-3"></i>`+data.kirim+`
                            </span>
                            <span>
                                `+kembali+`
                            </span>
                        </li>`

                    i++;

                });
            } else {
                html += `

                `
            }

            $(".detailPengirimanListBarang").html(html);
        })

        // when tombol delete pengiriman click 
        $(document).on("click", ".bthHapusPengiriman", function(){
            let id_pengiriman = $(this).data("id");

            Swal.fire({
                icon: 'question',
                text: 'Yakin akan menghapus data pengiriman?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then(function (result) {
                if (result.value) {
                    data = {id_pengiriman: id_pengiriman}
                    let result = ajax("<?= base_url()?>toko/hapus_pengiriman", "POST", data);

                    if(result == 1){
                        reload_data();

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil menghapus data pengiriman',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'terjadi kesalahan, gagal menghapus data pengiriman'
                        })
                    }
                }
            })
        })

        // when button check bg success clicked
        $(document).on("click", ".btnAddPengambilan", function(){
            let id_pengiriman = $(this).data("id");
            // console.log(id_pengiriman)
            let data = {id_pengiriman:id_pengiriman};

            let result = ajax("<?= base_url()?>toko/get_detail_pengiriman", "POST", data);

            // console.log(result);
            
            $("#id_pengiriman_pengambilan").val(result.pengiriman.id_pengiriman)
            $("#nama_toko_pengambilan").val(result.pengiriman.nama_toko)
            $("#tgl_pengiriman_pengambilan").val(result.pengiriman.tgl_pengiriman)
            $("#tgl_pengambilan_pengambilan").val(result.pengiriman.tgl_pengambilan)
            
            i = 1;
            html = "";
            result.detail_pengiriman.forEach(data => {
                
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
                    id_pengiriman = $("#id_pengiriman_pengambilan").val();

                    id_detail = new Array();
                    $.each($("input[name='id_detail']"), function(){
                        id_detail.push($(this).val());
                    });
                    
                    // untuk cek jik ada qty yang 0
                    let errorQty = 0;

                    qty = new Array();
                    $.each($("input[name='qty_kembali']"), function(){
                        qty.push($(this).val());

                        if($(this).val() == ""){
                            errorQty = 1;
                        }

                    });

                    if(errorQty == 0){
                        data = {id_pengiriman:id_pengiriman, id_detail:id_detail, qty:qty}
                        let result = ajax("<?= base_url()?>toko/add_pengambilan", "POST", data);

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


        function ajax(url, method, data){
            var result = "";
            $.ajax({
                // option nama dan option sumber 
                url: url,
                method: method,
                data: data,
                dataType: "JSON",
                async: false, 
                success: function(data){
                    result = data;
                }
            })

            return result;
        }
    })

</script>