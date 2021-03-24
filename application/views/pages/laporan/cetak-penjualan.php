<?php
    function rupiah($angka){           
        $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h3><?= $title?></h3>

    <table border=1>
        
        <thead>
            <tr>
                <th>No.</th>
                <th>Tgl. Pengiriman</th>
                <th>Tgl. Pengambilan</th>
                <th>Lokasi (Kecamatan)</th>
                <th>Mitra</th>
                <th>Barang</th>
                <!-- g  -->
                <th>QTY</th>
                <!-- h  -->
                <th>Return</th>
                <!-- i  -->
                <th>Harga Jual</th>
                <!-- j  -->
                <th>Bagi Hasil</th>
                <th>Jumlah</th>
            </tr>
        </thead>

        <tbody>
            <?php 
                foreach ($pengiriman as $i => $pengiriman) :
            ?>
                
                <?php if($pengiriman['row'] != 0) :?>
                <tr>
                    <td rowspan="<?= $pengiriman['row']?>"><center><?= $i+1?></center></td>
                    <td rowspan="<?= $pengiriman['row']?>"><center><?= date('d-M-y', strtotime($pengiriman['tgl_pengiriman']))?></center></td>
                    <td rowspan="<?= $pengiriman['row']?>"><center><?= date('d-M-y', strtotime($pengiriman['tgl_pengambilan']))?></center></td>
                    <td rowspan="<?= $pengiriman['row']?>"><?= $pengiriman['kecamatan']?></td>
                    <td rowspan="<?= $pengiriman['row']?>"><?= $pengiriman['nama_toko']?></td>
                    <?php foreach ($pengiriman['detail'] as $j => $detail) :?>
                            <?php if($j == 0):?>
                                <td><?= $j+1 . ". " . $detail['barang']['nama_barang']?></td>
                                <td><center><?= $detail['kirim']?></center></td>
                                <td><center><?= $detail['kembali']?></center></td>
                                <td><?= rupiah($detail['harga'])?></td>
                                <td><?= rupiah($detail['bagi_hasil'])?></td>
                                <td rowspan="<?= $pengiriman['row']?>"><?= rupiah($pengiriman['jumlah'])?></td>
                            <?php else :?>
                                <tr>
                                    <td><?= $j+1 . ". " . $detail['barang']['nama_barang']?></td>
                                    <td><center><?= $detail['kirim']?></center></td>
                                    <td><center><?= $detail['kembali']?></center></td>
                                    <td><?= rupiah($detail['harga'])?></td>
                                    <td><?= rupiah($detail['bagi_hasil'])?></td>
                                </tr>
                            <?php endif;?>
                        <?php endforeach;?>
                </tr>
                <?php else :?>
                    <tr>
                        <td><center><?= $i+1?></center></td>
                        <td><?= $pengiriman['nama_toko']?></td>
                        <td><?= $pengiriman['alamat']?></td>
                        <td><center><?= date('d-M-y', strtotime($pengiriman['tgl_pengiriman']))?></center></td>
                        <td><center><?= date('d-M-y', strtotime($pengiriman['tgl_pengambilan']))?></center></td>
                        <td><center>-</center></td>
                        <td><center>-</center></td>
                        <td><center>-</center></td>
                    </tr>
                <?php 
                    $g ++;
                endif;?>
            
            <?php endforeach;?>

            <tr>
                <td colspan="10"><center><b>Omset</b></center></td>
                <td><b><?= rupiah($omset)?></b></td>
            </tr>
        </tbody>

    </table>

</body>
</html>