<script>

    $(function(){
        reload_data();

        function reload_data(){
            let result = ajax("<?= base_url()?>pengambilan/ajax_pengambilan", "POST", "");
        
            html = "";
            if(result.pengiriman.length != 0){
                result.pengiriman.forEach(data => {
                    if(data.status == "Selesai"){
                        status = `
                        <div class="list-group-item-success card-header py-3 d-flex flex-row align-items-center justify-content-between">    
                            <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-check-circle text-success mr-1"></i>Selesai</h6>`

                        pengambilan = ``;
                    } else {
                        status = `
                        <div class="list-group-item-warning card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-exclamation-circle text-warning mr-1"></i>Proses</h6>`
                        
                        // button pengambilan 
                        pengambilan = `<div class="d-flex justify-content-center mt-1">
                            <a href="#addPengambilan" data-toggle="modal" data-id="`+data.id_pengiriman+`" class="btn btn-circle btn-warning mr-1 btnAddPengambilan"><i class="fa fa-hand-holding-usd"></i></a>
                        </div>`;
                    }
                    html += `<div class="col-12 col-md-4">
                        <div class="card shadow mb-4">
                            
                                `+status+`
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Pengiriman</div>
                                        <a class="dropdown-item btnDetailPengiriman" href="#detailPengiriman" data-id="`+data.id_pengiriman+`" data-toggle="modal">Detail</a>
                                        <a class="dropdown-item" href="#">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Hapus</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-gray-900">
                                <p><i class="fa fa-store mr-3"></i>`+data.nama_toko+` </p>
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
            

            $("#dataAjax").html(html);
        }

        // when detail pengiriman click
        $(document).on("click", ".btnDetailPengiriman", function(){
            let id_pengiriman = $(this).data("id");
            // console.log(id_pengiriman)
            let data = {id_pengiriman:id_pengiriman};

            let result = ajax("<?= base_url()?>toko/get_detail_pengiriman", "POST", data);
            // console.log(result);
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

        // $("#btnAddPengambilan").click(function(){

        // })

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