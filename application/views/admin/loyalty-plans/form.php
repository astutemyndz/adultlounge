<?php
$this->load->view('admin/layout/header');
$this->load->view('admin/layout/sidemenu');
?>
<div class="content">
    <div class="content-header">
        <div class="leftside-content-header">
            <ul class="breadcrumbs">
                <li><i class="fa fa-home" aria-hidden="true"></i><a href="<?=base_url('admin/dashboard')?>">Dashboard</a></li>
                <li><a><?= isset($loyalty_plan) ? 'Edit' : 'Add' ?> Loyalty Plan</a></li>
            </ul>
        </div>
    </div>
    <div class="row animated fadeInUp">
        <div class="col-sm-12 col-md-12">
            <?php $this->load->view('partials/flash-message'); ?>
            
            <div class="panel">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form action="<?= isset($loyalty_plan) ? base_url('admin/loyalty/edit/' . encrypt_id($loyalty_plan->id) ) : base_url('admin/loyalty/add') ?>" class="form-horizontal" method="post">
                                
                                <div class="form-group">
                                    <label for="email2" class="col-sm-4 control-label">Title *</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="title" class="form-control commonRequired" value="<?php if(isset($loyalty_plan)){ print $loyalty_plan->title; }?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email2" class="col-sm-4 control-label">Description *</label>
                                    <div class="col-sm-4">
                                        <textarea name="description" class="form-control" rows="4"><?php if(isset($loyalty_plan)){ print $loyalty_plan->description; }?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email2" class="col-sm-4 control-label">Point *</label>
                                    <div class="col-sm-4">
                                        <input type="number" name="credit" class="form-control commonRequired" value="<?php if(isset($loyalty_plan)){ print $loyalty_plan->credit; }?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email2" class="col-sm-4 control-label">Spent Amount On *</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="sell_price" class="form-control commonRequired" value="<?php if(isset($loyalty_plan)){ print $loyalty_plan->sell_price; }?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email2" class="col-sm-4 control-label">Is Active? *</label>
                                    <div class="col-sm-4">
                                        <label class="checkbox-inline">
                                            <input type="radio" name="is_active" value="1" <?= ( isset($loyalty_plan) && $loyalty_plan->status == 1 ) ? 'checked': 'checked' ?>> Yes
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="radio" name="is_active" value="0" <?= ( isset($loyalty_plan) && $loyalty_plan->status == 0 ) ? 'checked': '' ?>> No
                                        </label>                                        
                                    </div>           
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-8">
                                        <button type="submit" class="btn btn-wide btn-primary form-submit-button">Save</button>                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/layout/footer'); ?>
