<?php $this->load->view("_partials/header");?>

    <!-- Content Row -->
    <div class="row" id="dataAjax">
    </div>

<!-- load modal -->
<?php 
    if(isset($modal)) :
        foreach ($modal as $i => $modal) {
            $this->load->view("_partials/modal/".$modal);
        }
    endif;
?>

<!-- load javascript -->
<?php  
    if(isset($js)) :
        foreach ($js as $i => $js) :?>
            <script src="<?= base_url()?>assets/js/<?= $js?>"></script>
            <?php 
        endforeach;
    endif;    
?>

<!-- $this->load->view("_partials/modal");?> -->
<?php $this->load->view("_partials/footer");?>