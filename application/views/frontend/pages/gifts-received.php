<main class="content-wrapper">
    <section class="content-sec">
        <div class="manage-user-heading">
            <h3>MY NETWORK</h3>
            <ul>
                <li>
                    <img src="<?= base_url('assets/profile_image/' . $current_user['image']) ?>" alt="<?= $current_user['name'] ?>">
                    <h5>PERFORMER NAME</h5>
                    <a href="<?= base_url('profile') ?>">EDIT PROFILE</a>
                </li>
                <li>
                    <h5>CURRENT RANKING</h5>
                    <h2>1,110</h2>
                </li>
            </ul>
        </div>
        <div class="manage-area">
            <div class="ad-row">
                <div class="col-6 pr-20">
                    <div class="dash_box">
                        <?php if (count($gifts)) : ?>
                            <div class="dash_box_hed">
                                <p>YOUR GIFTS</p>
                            </div>
                            <div class="manage-list">
                                <ul style="list-style:none">
                                    <?php foreach ($gifts as $gift) : ?>
                                        <li>
                                            <h4>
                                                <img src="<?= base_url('assets/profile_image/' . $gift->image) ?>" width="80" class="img-circle"> <?= $gift->username ?>
                                            </h4>
                                            <img src="<?= uploads_url($gift->gift_image_path) ?>" alt="<?= $gift->gift_name ?>">
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php else : ?>
                            <h3>No gift found!!!</h3>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-6 pl-20">
                    <h2 class="overview">FINANCIAL OVERVIEW</h2>
                    <div class="dash_box network-area">
                        <div class="dash_box_hed">
                            <p>NETWORK EARNINGS TOTALS</p>
                        </div>
                        <div class="dash_box_body grid_2">
                            <ul>
                                <li>
                                    <span class="lft_txt">SHOWS: £0.00</span>
                                </li>
                                <li>
                                    <span class="lft_txt">GIFTS: <?= currency_format($current_month_gift_totals) ?></span>
                                </li>
                                <li>
                                    <span class="lft_txt">CHAT: £0.00</span>
                                </li>
                            </ul>
                            <div class="bg_txt">
                                <span>THIS MONTH</span>
                                <p><?= currency_format($current_month_gift_totals) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="dash_box network-area loyalty">
                        <div class="dash_box_hed">
                            <p>LOYALTY</p>
                        </div>
                        <div class="dash_box_body grid_2">
                            <div class="bg_txt bg_txt1">
                                <span>MONTHLY POINTS EARNED</span>
                                <p><?= number_format($gift_points); ?></p>
                            </div>
                            <div class="bg_txt">
                                <span>TOTAL EARNED</span>
                                <p><?= currency_format($gift_points); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>