<script>

    $(function(){
        reload_data();

        function reload_data(){
            let result = ajax("<?= base_url()?>toko/ajax_list_toko", "POST", "");
            
            html = "";

            if(result.length != 0){
                result.forEach(data => {
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
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item btnHapusToko" href="javascript:void(0)" data-id="`+data.id_toko+`|`+data.nama_toko+`">Hapus</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-gray-900">
                                    <p><i class="fa fa-map-marker-alt mr-4"></i>`+data.alamat+`</p>
                                    <p><i class="fa fa-map-signs mr-3"></i>`+data.kecamatan+`</p>
                                    <p><i class="fa fa-truck mr-3"></i>`+data.pengiriman+` pengiriman </p>
                                    <div class="d-flex justify-content-center mt-1">
                                        <a href="#addPengiriman" data-toggle="modal" class="btn btn-circle btn-success mr-1 addPengiriman" data-id="`+data.id_toko+`|`+data.nama_toko+`"><i class="fa fa-truck"></i></a>
                                        <a href="<?= base_url()?>toko/detail/`+data.link_toko+`" class="btn btn-circle btn-info"><i class="fa fa-info"></i></a>
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

        // when tombol add toko click
        $("#btnPlusToko").click(function(){
            
            $("#kecamatan_lainnya_add").prop("disabled", true);
            $("#kecamatan_lainnya_add").prop("required", false);

            list_kecamatan();

        })

        // option untuk list kecamatan 
        function list_kecamatan(){
            data = ajax("<?= base_url()?>/toko/get_all_kecamatan", "POST", "");

            html = `<option value="">Pilih Kecamatan</option>`;

            if(data.length != 0){
                data.forEach(data => {
                    html += `<option value="`+data.kecamatan+`">`+data.kecamatan+`</option>`;
                });


            }
            
            html += `<option value="Lainnya">Lainnya</option>`;
            $("#kecamatan_add").html(html);
            $("#kecamatan_edit").html(html);
        }

        // jika opsi kecamatan berubah 
        $("#kecamatan_add").change(function(){
            let sumber = $(this).val();
            if(sumber == "Lainnya"){
                $("#kecamatan_lainnya_add").prop("disabled", false);
                $("#kecamatan_lainnya_add").prop("required", true);
            } else {
                $("#kecamatan_lainnya_add").val("");
                $("#kecamatan_lainnya_add").prop("disabled", true);
                $("#kecamatan_lainnya_add").prop("required", false);
            }
        })

        $("#kecamatan_edit").change(function(){
            let sumber = $(this).val();
            if(sumber == "Lainnya"){
                $("#kecamatan_lainnya_edit").prop("disabled", false);
                $("#kecamatan_lainnya_edit").prop("required", true);
            } else {
                $("#kecamatan_lainnya_edit").val("");
                $("#kecamatan_lainnya_edit").prop("disabled", true);
                $("#kecamatan_lainnya_edit").prop("required", false);
            }
        })

        $("#btnAddToko").click(function(){
            Swal.fire({
                icon: 'question',
                text: 'Yakin akan menambahkan toko?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then(function (result) {
                if (result.value) {
                    let tgl_bergabung = $("#tgl_bergabung_add").val();
                    let nama_toko = $("#nama_toko_add").val();
                    let alamat = $("#alamat_add").val();
                    let pj = $("#pj_add").val();
                    let no_hp = $("#no_hp_add").val();
                    let kecamatan = $("#kecamatan_add").val();
                    let kecamatan_lainnya = $("#kecamatan_lainnya_add").val();

                    if(kecamatan != "Lainnya"){
                        kecamatan = kecamatan;
                    } else {
                        kecamatan = kecamatan_lainnya
                    }
                    
                    if(tgl_bergabung == "" || nama_toko == "" || alamat == "" || pj == "" || no_hp == "" || kecamatan == ""){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal menambahkan data toko, lengkapi isi form terlebih dahulu'
                        })
                    } else {
                        data = {tgl_bergabung: tgl_bergabung, nama_toko: nama_toko, alamat: alamat, pj: pj, no_hp: no_hp, kecamatan: kecamatan}
                        let result = ajax("<?= base_url()?>toko/add_toko", "POST", data);

                        if(result == 1){
                            reload_data();
                            $("#formAddToko").trigger("reset");

                            list_kecamatan();

                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                text: 'Berhasil menambahkan data toko',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'terjadi kesalahan, ulangi input toko'
                            })
                        }
                    }
                }
            })
        })

        // when tombol edit toko click 
        $(document).on("click",".btnEditToko", function(){
            let id_toko = $(this).data("id");
            let data = {id_toko: id_toko};
            let result = ajax("<?= base_url()?>toko/get_toko", "POST", data);
            
            list_kecamatan();

            $("#kecamatan_lainnya_edit").prop("disabled", true);
            $("#kecamatan_lainnya_edit").prop("required", false);

            $("#id_toko_edit").val(result.id_toko);
            $("#tgl_bergabung_edit").val(result.tgl_bergabung);
            $("#nama_toko_edit").val(result.nama_toko);
            $("#alamat_edit").val(result.alamat);
            $("#kecamatan_edit").val(result.kecamatan);
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

                    let kecamatan = $("#kecamatan_edit").val();
                    let kecamatan_lainnya = $("#kecamatan_lainnya_edit").val();

                    if(kecamatan != "Lainnya"){
                        kecamatan = kecamatan;
                    } else {
                        kecamatan = kecamatan_lainnya
                    }
                    
                    if(tgl_bergabung == "" || nama_toko == "" || alamat == "" || pj == ""|| no_hp == "" || kecamatan == ""){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal merubah data toko, lengkapi isi form terlebih dahulu'
                        })
                    } else {
                        data = {id_toko: id_toko, tgl_bergabung: tgl_bergabung, nama_toko: nama_toko, alamat: alamat, pj: pj, no_hp: no_hp, kecamatan: kecamatan}
                        let result = ajax("<?= base_url()?>toko/edit_toko", "POST", data);

                        if(result == 1){
                            reload_data();
                            $("#formAddToko").trigger("reset");

                            list_kecamatan();

                            $("#kecamatan_edit").val(kecamatan);
                            $("#kecamatan_lainnya_edit").prop("disabled", true);
                            $("#kecamatan_lainnya_edit").prop("required", false);
                            $("#kecamatan_lainnya_edit").val("");

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
                                <input type="checkbox" name="barang" value="`+data.id_barang+`|`+data.kode_barang+`|`+formatRupiah(data.bagi_hasil, 'Rp. ')+`|`+formatRupiah(data.harga, 'Rp. ')+`" class="custom-control-input" id="`+data.id_barang+`">
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
                        bagi_hasil = data[2];
                        harga = data[3];
                        
                        html += `
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text">`+i+`. `+kode_barang+`</span>
                            </div>
                            <input type="hidden" name="id_barang_pengiriman" value="`+id_barang+`">
                            <input type="number" name="qty" class="form-control" aria-label="Amount (to the nearest dollar)" value="0">
                        </div>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Harga</span>
                            </div>
                            <input type="text" name="harga_jual" class="form-control rupiah" aria-label="Amount (to the nearest dollar)" value="`+harga+`">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">BH</span>
                            </div>
                            <input type="text" name="bh" class="form-control rupiah" aria-label="Amount (to the nearest dollar)" value="`+bagi_hasil+`">
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
                            
                            // untuk cek jik ada field yang tak diisi atau bernilai tidak sesuai
                            let eror = 0;

                            qty = new Array();
                            $.each($("input[name='qty']"), function(){
                                qty.push($(this).val());

                                if($(this).val() == 0 || $(this).val() == ""){
                                    eror = 1;
                                }

                            });

                            harga = new Array();
                            $.each($("input[name='harga_jual']"), function(){
                                harga.push($(this).val());

                                if($(this).val() == "Rp. 0" || $(this).val() == ""){
                                    eror = 1;
                                }

                            });

                            bh = new Array();
                            $.each($("input[name='bh']"), function(){
                                bh.push($(this).val());

                                if($(this).val() == ""){
                                    eror = 1;
                                }

                            });

                            if(eror == 0){
                                data = {id_toko: id_toko, tgl_pengiriman: tgl_pengiriman, tgl_pengambilan: tgl_pengambilan, id_barang:id_barang, qty:qty, harga:harga, bh:bh}
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
        
        $(document).on("keyup", ".rupiah", function(){
            $(this).val(formatRupiah(this.value, 'Rp. '))
        })
    })

</script>