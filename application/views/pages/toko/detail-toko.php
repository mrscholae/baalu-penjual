<?php $this->load->view("_partials/header");?>
        
    <!-- Content Row -->
    <div class="row" id="dataAjax">
    </div>

    <?php 
        if(isset($modal)){
            foreach ($modal as $i => $modal) {
                $this->load->view("_partials/modal/".$modal);
            }
        }
    ?>
    
    <script>
        var id_toko = "<?= $id_toko?>";
    </script>

    <?php 
        if(isset($js)) :
            foreach ($js as $i => $js) : ?>
                <script src="<?= base_url()?>assets/js/<?= $js?>"></script>
    <?php 
            endforeach;
        endif;
    ?>


<?php $this->load->view("_partials/footer");?>