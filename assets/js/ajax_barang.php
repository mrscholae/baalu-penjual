<script>

    $(function(){
        
        reload_data();

        function reload_data(){
            let result = ajax("<?= base_url()?>barang/ajax_list_barang", "POST", "");
            
            html = "";

            if(result.length != 0){
                result.forEach(data => {
                    html += `
                    <div class="col-12 col-md-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">`+data.nama_barang+`</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Data Barang</div>
                                        <a class="dropdown-item btnEditBarang" href="#editBarang" data-toggle="modal" data-id="`+data.id_barang+`">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item btnHapusBarang" href="javascript:void(0)" data-id="`+data.id_barang+`|`+data.nama_barang+`">Hapus</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-gray-900">
                                <p><i class="fa fa-id-card mr-3"></i> `+data.kode_barang+`</p>
                                <p><i class="fa fa-calendar-alt mr-3"></i> `+data.tgl_rilis+`</p>
                                <p><i class="fa fa-dollar-sign mr-4"></i> `+data.harga+`</p>
                                <p><i class="fa fa-handshake mr-3"></i> `+data.bagi_hasil+`</p>
                            </div>
                        </div>
                    </div>`
                });
            } else {
                html += `
                    <div class="col-12">
                        <div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning mr-1"></i>data barang kosong</div>
                    </div>`
                
            }

            $("#dataAjax").html(html);
        }

        $("#btnAddBarang").click(function(){
            Swal.fire({
                icon: 'question',
                text: 'Yakin akan menambahkan barang?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then(function (result) {
                if (result.value) {
                    let tgl_rilis = $("#tgl_rilis_add").val();
                    let nama_barang = $("#nama_barang_add").val();
                    let kode_barang = $("#kode_barang_add").val();
                    let harga = $("#harga_add").val();
                    let bagi_hasil = $("#bagi_hasil_add").val();
                    
                    if(tgl_rilis == "" || nama_barang == "" || kode_barang == "" || harga == "" || bagi_hasil == ""){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal menambahkan data barang, lengkapi isi form terlebih dahulu'
                        })
                    } else {
                        data = {tgl_rilis: tgl_rilis, nama_barang: nama_barang, kode_barang: kode_barang, harga: harga, bagi_hasil: bagi_hasil}
                        let result = ajax("<?= base_url()?>barang/add_barang", "POST", data);

                        if(result == 1){
                            reload_data();
                            $("#formAddBarang").trigger("reset");

                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                text: 'Berhasil menambahkan data barang',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'terjadi kesalahan, ulangi input barang'
                            })
                        }
                    }
                }
            })
        })

        $(document).on("click",".btnEditBarang", function(){
            let id_barang = $(this).data("id");
            let data = {id_barang: id_barang};
            let result = ajax("<?= base_url()?>barang/get_barang", "POST", data);
            // console.log(result);
            $("#nama_barang_edit").val(result.nama_barang);
            $("#kode_barang_edit").val(result.kode_barang);
            $("#tgl_rilis_edit").val(result.tgl_rilis);
            $("#harga_edit").val(formatRupiah(result.harga, 'Rp. '));
            $("#bagi_hasil_edit").val(formatRupiah(result.bagi_hasil, 'Rp. '));
            $("#id_barang_edit").val(result.id_barang);
        })

        $("#btnEditBarang").click(function(){
            Swal.fire({
                icon: 'question',
                text: 'Yakin akan merubah data barang?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then(function (result) {
                if (result.value) {
                    let id_barang = $("#id_barang_edit").val();
                    let tgl_rilis = $("#tgl_rilis_edit").val();
                    let nama_barang = $("#nama_barang_edit").val();
                    let kode_barang = $("#kode_barang_edit").val();
                    let harga = $("#harga_edit").val();
                    let bagi_hasil = $("#bagi_hasil_edit").val();
                    
                    if(tgl_rilis == "" || nama_barang == "" || kode_barang == "" || harga == "" || bagi_hasil == ""){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal merubah data barang, lengkapi isi form terlebih dahulu'
                        })
                    } else {
                        data = {id_barang: id_barang, tgl_rilis: tgl_rilis, nama_barang: nama_barang, kode_barang: kode_barang, harga: harga, bagi_hasil: bagi_hasil}
                        let result = ajax("<?= base_url()?>barang/edit_barang", "POST", data);

                        if(result == 1){
                            reload_data();
                            $("#formAddBarang").trigger("reset");

                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                text: 'Berhasil merubah data barang',
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

        $(document).on("click", ".btnHapusBarang", function(){
            let data = $(this).data("id");
            data = data.split("|");
            let id_barang = data[0];
            let nama_barang = data[1];

            Swal.fire({
                icon: 'question',
                text: 'Yakin akan menghapus data barang '+nama_barang+'?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then(function (result) {
                if (result.value) {
                    data = {id_barang: id_barang}
                    let result = ajax("<?= base_url()?>barang/hapus_barang", "POST", data);

                    if(result == 1){
                        reload_data();

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil menghapus data barang',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'terjadi kesalahan, gagal menghapus data barang'
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

        $("input[name=harga]").keyup(function(){
            $(this).val(formatRupiah(this.value, 'Rp. '))
        })
        
        $("input[name=bagi_hasil]").keyup(function(){
            $(this).val(formatRupiah(this.value, 'Rp. '))
        })
        
    })

</script>