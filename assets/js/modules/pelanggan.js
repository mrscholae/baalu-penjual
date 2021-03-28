    // when tombol add pelanggan click
    $("#btnPlusPelanggan").click(function(){
        
        $("#kecamatan_lainnya_add").prop("disabled", true);
        $("#kecamatan_lainnya_add").prop("required", false);

        list_kecamatan();

    })

    // jika opsi kecamatan berubah 
    $("#addPelanggan select[name='kecamatan']").change(function(){
        let form = "#addPelanggan";
        let sumber = $(this).val();

        if(sumber == "Lainnya"){
            $(form+" input[name='kecamatan_lainnya']").prop("disabled", false);
            $(form+" input[name='kecamatan_lainnya']").prop("required", true);
            $(form+" input[name='kecamatan_lainnya']").addClass("required");
        } else {
            $(form+" input[name='kecamatan_lainnya']").val("");
            $(form+" input[name='kecamatan_lainnya']").prop("disabled", true);
            $(form+" input[name='kecamatan_lainnya']").prop("required", false);
            $(form+" input[name='kecamatan_lainnya']").removeClass("required");
        }
    })
    
    // jika opsi kecamatan berubah pada menu edit 
    $("#editPelanggan select[name='kecamatan']").change(function(){
        let form = "#editPelanggan";
        let sumber = $(this).val();
        
        if(sumber == "Lainnya"){
            $(form+" input[name='kecamatan_lainnya']").prop("disabled", false);
            $(form+" input[name='kecamatan_lainnya']").prop("required", true);
            $(form+" input[name='kecamatan_lainnya']").addClass("required");
        } else {
            $(form+" input[name='kecamatan_lainnya']").val("");
            $(form+" input[name='kecamatan_lainnya']").prop("disabled", true);
            $(form+" input[name='kecamatan_lainnya']").prop("required", false);
            $(form+" input[name='kecamatan_lainnya']").removeClass("required");
        }
    })

    // tekan tombol simpan pada modal tambah pelanggan 
    $("#addPelanggan .btnSimpan").click(function(){
        let form = "#addPelanggan";

        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menambahkan pelanggan?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                let tgl_bergabung = $(form+" input[name='tgl_bergabung']").val();
                let nama_pelanggan = $(form+" input[name='nama_pelanggan']").val();
                let alamat = $(form+" textarea[name='alamat']").val();
                let no_hp = $(form+" input[name='no_hp']").val();
                let kecamatan = $(form+" select[name='kecamatan']").val();
                let kecamatan_lainnya = $(form+" input[name='kecamatan_lainnya']").val();

                if(kecamatan != "Lainnya"){
                    kecamatan = kecamatan;
                } else {
                    kecamatan = kecamatan_lainnya
                }
                
                let eror = required(form);
        
                if( eror == 1){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'lengkapi isi form terlebih dahulu'
                    })
                } else {
                    data = {tgl_bergabung: tgl_bergabung, nama_pelanggan: nama_pelanggan, alamat: alamat, no_hp: no_hp, kecamatan: kecamatan}
                    let result = ajax(url_base+"pelanggan/add_pelanggan", "POST", data);

                    if(result == 1){
                        let nama = $("#searchNavbar").val();
                        let search = {nama: nama}
                        reload_data(search);

                        $("#formAddPelanggan").trigger("reset");

                        list_kecamatan();

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil menambahkan data pelanggan',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'terjadi kesalahan, ulangi input pelanggan'
                        })
                    }
                }
            }
        })
    })

    // when tombol edit pelanggan click 
    $(document).on("click",".editPelanggan", function(){
        let form = "#editPelanggan";
        let id_pelanggan = $(this).data("id");
        let data = {id_pelanggan: id_pelanggan};
        let result = ajax(url_base+"pelanggan/get_pelanggan", "POST", data);
        
        list_kecamatan();

        $(form+" input[name='kecamatan_lainnya']").prop("disabled", true);
        $(form+" input[name='kecamatan_lainnya']").prop("required", false);

        $(form+" input[name='id_pelanggan']").val(result.id_pelanggan);
        $(form+" input[name='tgl_bergabung']").val(result.tgl_bergabung);
        $(form+" input[name='nama_pelanggan']").val(result.nama_pelanggan);
        $(form+" textarea[name='alamat']").val(result.alamat);
        $(form+" select[name='kecamatan']").val(result.kecamatan);
        $(form+" input[name='no_hp']").val(result.no_hp);
    })

    // when tombol simpan click in modal edit pelanggan 
    $("#editPelanggan .btnSimpan").click(function(){
        Swal.fire({
            icon: 'question',
            text: 'Yakin akan merubah data pelanggan?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                let form = "#editPelanggan";

                let id_pelanggan = $(form+" input[name='id_pelanggan']").val();
                let tgl_bergabung = $(form+" input[name='tgl_bergabung']").val();
                let nama_pelanggan = $(form+" input[name='nama_pelanggan']").val();
                let alamat = $(form+" textarea[name='alamat']").val();
                let no_hp = $(form+" input[name='no_hp']").val();
                let kecamatan = $(form+" select[name='kecamatan']").val();
                let kecamatan_lainnya = $(form+" input[name='kecamatan_lainnya']").val();

                if(kecamatan != "Lainnya"){
                    kecamatan = kecamatan;
                } else {
                    kecamatan = kecamatan_lainnya
                }
                
                let eror = required(form);
        
                if( eror == 1){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'lengkapi isi form terlebih dahulu'
                    })
                } else {
                    data = {id_pelanggan: id_pelanggan, tgl_bergabung: tgl_bergabung, nama_pelanggan: nama_pelanggan, alamat: alamat, no_hp: no_hp, kecamatan: kecamatan}
                    let result = ajax(url_base+"pelanggan/edit_pelanggan", "POST", data);

                    if(result == 1){
                        let nama = $("#searchNavbar").val();
                        let search = {nama: nama}
                        reload_data(search);

                        list_kecamatan();

                        $(form+" select[name='kecamatan']").val(kecamatan);
                        $(form+" input[name='kecamatan_lainnya']").prop("disabled", true);
                        $(form+" input[name='kecamatan_lainnya']").prop("required", false);
                        $(form+" input[name='kecamatan_lainnya']").val("");

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil merubah data pelanggan',
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

    // when tombol delete pelanggan click 
    $(document).on("click", ".hapusPelanggan", function(){
        let data = $(this).data("id");
        data = data.split("|");
        let id_pelanggan = data[0];
        let nama_pelanggan = data[1];

        Swal.fire({
            icon: 'question',
            text: 'Yakin akan menghapus data pelanggan '+nama_pelanggan+'?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (result.value) {
                data = {id_pelanggan: id_pelanggan}
                let result = ajax(url_base+"pelanggan/hapus_pelanggan", "POST", data);

                if(result == 1){
                    let nama = $("#searchNavbar").val();
                    let search = {nama: nama}
                    reload_data(search);

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil menghapus data pelanggan',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, gagal menghapus data pelanggan'
                    })
                }
            }
        })
    })

    $(document).on("click", ".rekapPembelian", function(){
        let form = "#rekapPembelian";
        let id_pelanggan = $(this).data("id");

        let data = {id_pelanggan:id_pelanggan};

        let result = ajax(url_base+"pelanggan/get_rekap_pembelian", "POST", data);

        html = "";

        html += `
            <ul class="list-group text-gray-900">
                <li class="list-group-item list-group-item-info"><i class="fa fa-mail mr-1"></i>Data Pelanggan</li>
                <li class="list-group-item">
                    <p><i class="fa fa-store mr-3"></i>`+result.pelanggan.nama_pelanggan+`</p>
                    <p><i class="fa fa-map-marker-alt mr-4"></i>`+result.pelanggan.alamat+`</p>
                    <p><i class="fa fa-map-signs mr-3"></i>`+result.pelanggan.kecamatan+`</p>
                    <p><i class="fa fa-shopping-bag mr-3"></i>`+result.pelanggan.pembelian+` pembelian</p>
                </li>
            </ul>`;

        $(form+" .listData").html(html)

        html = "";
        if(result.barang.length != 0){
            i = 1;
            result.barang.forEach(data => {
                html += `
                    <li class="list-group-item list-group-item-primary d-flex justify-content-between">
                        <span>`+i+`. `+data.nama_barang+`</span>
                        <span>
                            <i class="fa fa-shopping-bag mr-2"></i>`+data.total_qty+`
                        </span>
                    </li>`
                    
                i++;

            });
        } else {
            html += ``
        }

        $(form+" .listItem").html(html)
    })

    $(document).on("click", "#btnSearchNavbar", function(){
        let nama = $("#searchNavbar").val();
        let data = {nama: nama}
        
        reload_data(data);
    })

    $(document).on("click", "#btnSearchNavbarSmall", function(){
        let nama = $("#searchNavbarSmall").val();
        let data = {nama: nama}

        reload_data(data);
    })

    $("#searchNavbarSmall").change(function() {
        $("#searchNavbar").val($(this).val())
    })

    $("#searchNavbar").change(function() {
        $("#searchNavbarSmall").val($(this).val())
    })
