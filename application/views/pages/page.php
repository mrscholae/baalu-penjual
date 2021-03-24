<?php $this->load->view("_partials/header");?>
        
        
    <div class="row" id="dataAjax">
    
    </div>

    <!-- Paginate -->
    <div class="row">
        <div class="col-12">
            <div class="mt-3" id='pagination'></div>
        </div>
    </div>

    <?php 
        if(isset($modal)){
            foreach ($modal as $i => $modal) {
                $this->load->view("_partials/modal/".$modal);
            }
        }
    ?>

    <?php 
        if(isset($js)) :
            foreach ($js as $i => $js) : ?>
                <script src="<?= base_url()?>assets/js/<?= $js?>"></script>
    <?php 
            endforeach;
        endif;
    ?>
    
<?php $this->load->view("_partials/footer");?>