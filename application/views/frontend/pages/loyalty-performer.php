<main class="content-wrapper loyalty-page">
    <section class="content-sec">
    	<div class="loyalty-banner">
        	<img src="<?=base_url('assets/images/loyalty-banner.jpg')?>" alt=""/>
        </div>
        <div class="loyalty-scheme">
        	<h2><strong>LOYALTY SCHEME</strong></h2>
            <div class="spand-heading-area">
            	<h3>YOUR CURRENT EARNING: <span><?= currency_format($user_spent) ?></span></h3>
                <p><i class="fa fa-caret-up" aria-hidden="true"></i> <span><?= $current_user['credit'] ?></span> <?= date('j/m/y') ?></p>
                <h4><img src="<?=base_url('assets/images/chrisblades.png')?>" alt=""/> <?= strtoupper( substr( $current_user['usernm'], 1 ) ) ?></h4>
            </div>
            <div class="reward-slider">
                <?php if( count($loyalty_plans) ) : ?>
            	<div class="owl-carousel owl-theme slider-reward">
                    <?php 
                        $is_active = false;

                        foreach($loyalty_plans as $index => $loyalty_plan) :                            
                            if ( 
                                ( $user_spent >= $loyalty_plan->sell_price ) && 
                                ! ( $user_spent >= $loyalty_plans[$index + 1]->sell_price ) 
                            ) {
                                $is_active = true;
                            }                            
                    ?>
                    <div class="item <?= $user_spent ?>">
                        <div class="credit-list credit-list2 <?= $is_active ? 'your-reward' : '' ?>">
                            <h3><?= $loyalty_plan->title ?></h3>
                            <h2>
                                <img src="<?=base_url('assets/images/credit.png')?>" alt="assistance" /> <?= $loyalty_plan->credit ?>
                            </h2>
                            <p><?= $loyalty_plan->description ?></p>
                            <?php if ($is_active) : ?>
                                <h4>CONGRATULATIONS</h4>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php $is_active = false; ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="work-area">
        	<div class="how-it-work">
            	<h3>HOW IT WORKS</h3>
                <ul>
                	<li>
                    	<div class="step-work">
                        	<p>step</p>
                            <h2>1</h2>
                        </div>
                        <div class="step-description">
                        	<h4>BUY REGULAR CREDITS </h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rutrum lorem nisl. Aliquam erat volutpat. Proin vulputate enim ac hendrerit sagittis. Morbi metus ex, convallis nec semper quis, tincidunt non est. </p>
                        </div>
                    </li>
                    <li>
                    	<div class="step-work">
                        	<p>step</p>
                            <h2>2</h2>
                        </div>
                        <div class="step-description">
                        	<h4>REACH MILESTONES</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rutrum lorem nisl. Aliquam erat volutpat. Proin vulputate enim ac hendrerit sagittis. Morbi metus ex, convallis nec semper quis, tincidunt non est. </p>
                        </div>
                    </li>
                    <li>
                    	<div class="step-work">
                        	<p>step</p>
                            <h2>3</h2>
                        </div>
                        <div class="step-description">
                        	<h4>GET FREE CREDITS</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rutrum lorem nisl. Aliquam erat volutpat. Proin vulputate enim ac hendrerit sagittis. Morbi metus ex, convallis nec semper quis, tincidunt non est. </p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="loyalty-terms">
            	<h3>TERMS & CONDITIONS</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rutrum lorem nisl. Aliquam erat volutpat. Proin vulputate enim ac hendrerit sagittis. Morbi metus ex, convallis nec semper quis, tincidunt non est. </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rutrum lorem nisl. Aliquam erat volutpat. Proin vulputate enim ac hendrerit sagittis. Morbi metus ex, convallis nec semper quis, tincidunt non est. </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rutrum lorem nisl. Aliquam erat volutpat. Proin vulputate enim ac hendrerit sagittis. Morbi metus ex, convallis nec semper quis, tincidunt non est. </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rutrum lorem nisl. Aliquam erat volutpat. Proin vulputate enim ac hendrerit sagittis. Morbi metus ex, convallis nec semper quis, tincidunt non est. </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rutrum lorem nisl. Aliquam erat volutpat. Proin vulputate enim ac hendrerit sagittis. Morbi metus ex, convallis nec semper quis, tincidunt non est. </p>
            </div>
        </div>
    </section>
</main>

