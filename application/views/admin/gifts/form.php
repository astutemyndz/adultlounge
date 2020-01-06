<?php
$this->load->view('admin/layout/header');
$this->load->view('admin/layout/sidemenu');
?>
<div class="content">
    <div class="content-header">
        <div class="leftside-content-header">
            <ul class="breadcrumbs">
                <li><i class="fa fa-home" aria-hidden="true"></i><a href="<?=base_url('admin/dashboard')?>">Dashboard</a></li>
                <li><a><?= isset($gift) ? 'Edit' : 'Add' ?> Gift</a></li>
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
                            
                            <form action="<?= isset($gift) ? base_url('admin/gifts/edit/' . encrypt_id($gift->id) ) : base_url('admin/gifts/add') ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                                
                                <div class="form-group">
                                    <label for="email2" class="col-sm-4 control-label">Gift Name *</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="gift_name" class="form-control commonRequired" value="<?php if(isset($gift)){ print $gift->gift_name; }?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email2" class="col-sm-4 control-label">Gift Point *</label>
                                    <div class="col-sm-4">
                                        <input type="number" name="gift_point" class="form-control commonRequired" value="<?php if(isset($gift)){ print $gift->gift_point; }?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email2" class="col-sm-4 control-label">Gift Image *</label>
                                    <div class="col-sm-4">
                                        <img src="<?= isset($gift) ? uploads_url( $gift->gift_image_path ) : '' ?>" id="imageElem" class="pb-3" style="<?= isset($gift) ? '' : 'display:none' ?>">
                                        <input type="file" name="gift_image" id="form-control" accept="image/jpeg, image/png, image/gif" onchange="onImageChange(this)">
                                        <?php if(isset($gift)) : ?>
                                            <input type="hidden" name="saved_gift_image" value="<?= $gift->gift_image_path ?>">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email2" class="col-sm-4 control-label">Is Active? *</label>
                                    <div class="col-sm-4">
                                        <label class="checkbox-inline">
                                            <input type="radio" name="is_active" value="1" <?= ( isset($gift) && $gift->is_active == 1 ) ? 'checked': 'checked' ?>> Yes
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="radio" name="is_active" value="0" <?= ( isset($gift) && $gift->is_active == 0 ) ? 'checked': '' ?>> No
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
