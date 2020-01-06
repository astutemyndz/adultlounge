<?php 
if (isset($_SESSION['curr_user']) && isset($user)) {
    $current_user = get_login_user();
} else {
    return;
}
?>
<div class="gift-bg">
    <div class="gift-container">
        <div class="gift-hed">
            <h3>Gift <span>You currently have <span class="credit-total"> <?= $current_user['credit'] ?> <?= $current_user['credit'] < 2 ? singular('Credit') : plural('Credit') ?></span></span></h3>
            <span class="giftClose">&times;</span>
        </div>
        <div class="gift-body gift-area">
            <h2>SEND TO <?= strtoupper( $user[0]['name'] ) ?></h2>            
            <?php if (isset($gifts)) : ?>
            <ul>
                <?php foreach($gifts as $gift) : ?>
            	    <li>
                        <a href="javascript:void(0);" data-id="<?= encrypt_id( $gift->id ) ?>" data-uid="<?= encrypt_id( $user[0]['id'] ) ?>" class="gift-send">
                            <img src="<?= uploads_url($gift->gift_image_path) ?>" alt="<?= $gift->gift_name ?>" />
                            <span><?= $gift->gift_point ?> <?= $gift->gift_point < 2 ? singular('Credit') : plural('Credit') ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <a href="javascript:void(0);">LEGAL DISCLAIMER: </a>
        </div>
    </div>
</div>