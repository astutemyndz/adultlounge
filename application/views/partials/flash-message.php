<?php if ($this->session->flashdata('success_msg')) { ?>
    <div class="alert alert-success fade in">
        <a href="#" class="close" data-dismiss="alert">×</a>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        <?= $this->session->flashdata('success_msg') ?>
    </div>
<?php } ?>
<?php if ($this->session->flashdata('error_msg')) { ?>
    <div class="alert alert-danger fade in">
        <a href="#" class="close" data-dismiss="alert">×</a>
        <h4><i class="icon fa fa-close"></i> Error!</h4>
        <?= $this->session->flashdata('error_msg') ?>
    </div>
<?php } ?>