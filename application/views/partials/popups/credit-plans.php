<?php
if (isset($_SESSION['curr_user'])) {
    $current_user = get_login_user();
} else {
    return;
}

$plans = get_credit_plans();
?>
<div id="buy-modal" class="modal buy_modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <h2>Buy Credits</h2>
            <p>You currently have <span class="credit-total"><?= $current_user['credit'] ?> <?= $current_user['credit'] < 2 ? singular('Credit') : plural('Credit') ?></span></p>
            <span class="close">&times;</span>
        </div>
        <div class="creadit-test-area">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rutrum lorem nisl. Aliquam erat volutpat. Proin vulputate enim ac hendrerit sagittis. Morbi metus ex, convallis nec semper quis, tincidunt non est. </p>
            <a href="javascript:;"><img src="<?= base_url('assets/images/assistent.png') ?>" alt="assistance" /> NEED ASSISTANCE</a>
        </div>
        <div class="modal-body">

            <div class="clearfix"></div>
            <div class="credit-slider">
                <div class="owl-carousel owl-theme buy-credit-slider">
                    <?php
                    if (!empty($plans)) {
                        foreach ($plans as $plan) {
                            ?>
                            <div class="item">
                                <div class="credit-list">
                                    <?php if (!empty($plan['tag'])) { ?>
                                        <h4 class="best-value"><?php echo $plan['tag']; ?></h4>
                                    <?php } ?>
                                    <h3><img src="<?= base_url('assets/images/credit.png') ?>" alt="assistance" /> <?php echo $plan['credit']; ?> Credits</h3>
                                    <h2>£<?php echo $plan['sell_price']; ?></h2>
                                    <p>EX VAT</p>
                                    <a href="<?= base_url( 'process-payment/' . encrypt_id( $plan['id'] ) ) ?>" class="btn">BUY CREDITS</a>
                                </div>
                            </div>
                    <?php }
                    } ?>

                </div>
                <p class="credit-terms"><span>LEGAL DISCLAIMER: </span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rutrum lorem nisl. Aliquam erat volutpat. Proin vulputate enim ac hendrerit sagittis. </p>
            </div>
        </div>

    </div>

</div>