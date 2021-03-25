        // when tombol add toko click
        $("#btnPlusToko").click(function(){
            
            $("#kecamatan_lainnya_add").prop("disabled", true);
            $("#kecamatan_lainnya_add").prop("required", false);

            list_kecamatan();

        })

        // jika opsi kecamatan berubah 
        $("#kecamatan_add").change(function(){
            let sumber = $(this).val();
            if(sumber == "Lainnya"){
                $("#kecamatan_lainnya_add").prop("disabled", false);
                $("#kecamatan_lainnya_add").prop("required", true);
                $("#kecamatan_lainnya_add").addClass("required");
            } else {
                $("#kecamatan_lainnya_add").val("");
                $("#kecamatan_lainnya_add").prop("disabled", true);
                $("#kecamatan_lainnya_add").prop("required", false);
                $("#kecamatan_lainnya_add").removeClass("required");
            }
        })
        
        // tekan tombol simpan pada modal tambah toko 
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
                    let jam_buka = $("#jam_buka_add").val();
                    let jam_tutup = $("#jam_tutup_add").val();
                    let jam_operasional = jam_buka + " s.d " + jam_tutup;

                    if(kecamatan != "Lainnya"){
                        kecamatan = kecamatan;
                    } else {
                        kecamatan = kecamatan_lainnya
                    }
                    
                    let eror = required("#formAddToko");
            
                    if( eror == 1){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'lengkapi isi form terlebih dahulu'
                        })
                    } else {
                        data = {tgl_bergabung: tgl_bergabung, nama_toko: nama_toko, alamat: alamat, pj: pj, no_hp: no_hp, kecamatan: kecamatan, jam_operasional: jam_operasional}
                        let result = ajax(url_base+"toko/add_toko", "POST", data);

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

        // jika opsi kecamatan berubah pada menu edit 
        $("#kecamatan_edit").change(function(){
            let sumber = $(this).val();
            if(sumber == "Lainnya"){
                $("#kecamatan_lainnya_edit").prop("disabled", false);
                $("#kecamatan_lainnya_edit").prop("required", true);
                $("#kecamatan_lainnya_edit").addClass("required");
            } else {
                $("#kecamatan_lainnya_edit").val("");
                $("#kecamatan_lainnya_edit").prop("disabled", true);
                $("#kecamatan_lainnya_edit").prop("required", false);
                $("#kecamatan_lainnya_edit").removeClass("required");
            }
        })

        // when tombol edit toko click 
        $(document).on("click",".btnEditToko", function(){
            let id_toko = $(this).data("id");
            let data = {id_toko: id_toko};
            let result = ajax(url_base+"toko/get_toko", "POST", data);
            
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
            
            let jam = result.jam_operasional;
            jam = jam.split(" s.d ");

            $("#jam_buka_edit").val(jam[0]);
            $("#jam_tutup_edit").val(jam[1]);
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
                    let jam_buka = $("#jam_buka_edit").val();
                    let jam_tutup = $("#jam_tutup_edit").val();
                    let jam_operasional = jam_buka + " s.d " + jam_tutup;

                    let kecamatan = $("#kecamatan_edit").val();
                    let kecamatan_lainnya = $("#kecamatan_lainnya_edit").val();

                    if(kecamatan != "Lainnya"){
                        kecamatan = kecamatan;
                    } else {
                        kecamatan = kecamatan_lainnya
                    }
                    
                    let eror = required("#formEditToko");
            
                    if( eror == 1){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'lengkapi isi form terlebih dahulu'
                        })
                    } else {
                        data = {id_toko: id_toko, tgl_bergabung: tgl_bergabung, nama_toko: nama_toko, alamat: alamat, pj: pj, no_hp: no_hp, kecamatan: kecamatan, jam_operasional: jam_operasional}
                        let result = ajax(url_base+"toko/edit_toko", "POST", data);

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
                    let result = ajax(url_base+"toko/hapus_toko", "POST", data);

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

        $(document).on("click", ".rekapPenjualan", function(){
            let form = "#rekapPenjualan";
            let id_toko = $(this).data("id");

            let data = {id_toko:id_toko};

            let result = ajax(url_base+"toko/get_rekap_penjualan", "POST", data);

            console.log(result);

            html = "";

            html += `
                <ul class="list-group text-gray-900">
                    <li class="list-group-item list-group-item-info"><i class="fa fa-mail mr-1"></i>Data Toko</li>
                    <li class="list-group-item">
                        <p><i class="fa fa-store mr-3"></i>`+result.toko.nama_toko+`</p>
                        <p><i class="fa fa-map-marker-alt mr-4"></i>`+result.toko.alamat+`</p>
                        <p><i class="fa fa-map-signs mr-3"></i>`+result.toko.kecamatan+`</p>
                        <p><i class="fa fa-truck mr-3"></i>`+result.toko.pengiriman+` pengiriman (selesai)</p>
                    </li>
                </ul>`;

            $(form+" .dataToko").html(html)

            html = "";
            if(result.barang.length != 0){
                i = 1;
                result.barang.forEach(data => {
                    html += `
                        <li class="list-group-item list-group-item-primary d-flex justify-content-between">
                            <span>`+i+`. `+data.nama_barang+`</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-center">
                            <span class="mr-3">
                                <i class="fa fa-truck mr-2"></i>`+data.total_kirim+`
                            </span>
                            <span>
                                <i class="fa fa-truck-pickup fa-flip-horizontal mr-2"></i>`+data.total_retur+`
                            </span>
                        </li>`
                        
                    i++;

                });
            } else {
                html += ``
            }

            $(form+" .dataPenjualan").html(html)
        })
