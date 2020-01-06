<?php
$this->load->view('admin/layout/header');
$this->load->view('admin/layout/sidemenu');
?>
<div class="content">
    <div class="content-header">
        <div class="leftside-content-header">
            <ul class="breadcrumbs">
                <li><i class="fa fa-home" aria-hidden="true"></i><a href="<?=base_url('admin/dashboard')?>">Dashboard</a></li>
                <li><a>Loyalty Plans</a></li>
            </ul>
        </div>
    </div>
    <div class="row animated fadeInUp">
        <div class="col-sm-12 col-md-12">
            <?php $this->load->view('partials/flash-message'); ?>
            
            <div class="panel">
                <div class="panel-content">
                    <div class="table-responsive">
                        <table id="basic-table" class="data-table table table-striped nowrap table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Title</th>
                                    <th>Credit Point</th>
                                    <th>Spent Total</th>
                                    <th>Is Active?</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if ( count( $loyalty_plans ) ) {
                                        foreach ($loyalty_plans as $index => $loyalty_plan) {
                                ?>
                                <tr>
                                    <td><?=$index + 1?>.</td>                                    
                                    <td><?= $loyalty_plan['title'] ?></td>
                                    <td><?= $loyalty_plan['credit'] ?></td>
                                    <td><?= $loyalty_plan['sell_price'] ?></td>
                                    <td><?= $loyalty_plan['status'] ? 'Yes' : 'No' ?></td>
                                    <td><a href="<?= base_url('admin/loyalty/edit/'. encrypt_id( $loyalty_plan['id'] ) ) ?>" title="edit"><i class="fa fa-fw fa-edit"></i></a>
                                    </td>
                                </tr>
                                <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/layout/footer'); ?>

<script src="<?=base_url()?>backend/vendor/data-table/media/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>backend/vendor/data-table/media/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    $("#basic-table").one("preInit.dt", function () {
        $button = $("<a class='btn btn-primary ml-3 mt-3' href='<?= base_url('admin/loyalty/add') ?>'>Add New</a>");
        $("#basic-table_filter label").append($button);
        $button.button();
    });
});
</script>
<script src="<?=base_url()?>backend/javascripts/examples/tables/data-tables.js"></script>