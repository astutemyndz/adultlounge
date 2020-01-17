<?php if ($this->session->userdata('UserType') == 1) { ?>
    <input type="hidden" id="p_receiver_id" value="<?= $user[0]['id'] ?>">
    <input type="hidden" id="p_receiver_type" value="performer">
    <input type="hidden" id="p_sender_id" value="<?= $this->session->userdata('UserId') ?>">
    <input type="hidden" id="p_sender_type" value="user">
<?php  } ?>
<main class="content-wrapper">
    <section class="content-sec">
        <div class="perform-widget perform-top-layout">
            <div class="perform-left-widget">
                <div class="imgbox">
                    <div class="icons-lft">
                        <ul>
                            <li><a href="javascript:void(0)"><img src="<?= base_url('assets/images/icon-001.png') ?>" alt="" /></a></li>
                            <li><a href="javascript:void(0)"><img src="<?= base_url('assets/images/icon-002.png') ?>" alt="" /></a></li>
                            <li><a href="javascript:void(0)"><img src="<?= base_url('assets/images/icon-003.png') ?>" alt="" /></a></li>
                            <li><a href="javascript:void(0)"><img src="<?= base_url('assets/images/icon-004.png') ?>" alt="" /></a></li>
                            <li><a href="javascript:void(0)"><img src="<?= base_url('assets/images/icon-005.png') ?>" alt="" /></a></li>
                            <li><a href="javascript:void(0)"><img src="<?= base_url('assets/images/icon-006.png') ?>" alt="" /></a></li>
                            <li><a href="javascript:void(0)"><img src="<?= base_url('assets/images/icon-007.png') ?>" alt="" /></a></li>
                            <li><a href="javascript:void(0)"><img src="<?= base_url('assets/images/icon-008.png') ?>" alt="" /></a></li>
                            <li><a href="javascript:void(0)"><img src="<?= base_url('assets/images/icon-009.png') ?>" alt="" /></a></li>
                        </ul>
                        <ul>
                            <li><a href="javascript:void(0)"><img src="<?= base_url('assets/images/icon-010.png') ?>" alt="" /></a></li>
                            <li><a href="javascript:void(0)"><img src="<?= base_url('assets/images/icon-011.png') ?>" alt="" /></a></li>
                            <li><a href="javascript:void(0)"><img src="<?= base_url('assets/images/icon-012.png') ?>" alt="" /></a></li>
                        </ul>
                    </div>
                    <div class="box01-rtl">
                        <div class="box-trns-blck">
                            <span>PRIVATE: £6.99 p/m</span>
                            <span>GROUP: £3.99 p/M</span>
                        </div>
                        <!--<div class="drop-show">
    <span>START SHOW</span>
    <ul>
        <li></li>
    </ul>
</div>-->
                    </div>
                    <img src="<?= base_url('assets/images/img-003.jpg') ?>" alt="img" />

                </div>
                <div class="option-box">
                    <a href="javascript:void(0);" class="btn text-center" id="videostartButton" onclick="startVideoChat('<?= $user[0]['id'] ?>', '<?php if ($user[0]['display_name'] != '') {
                                                                                                                                                    print $user[0]['display_name'];
                                                                                                                                                } else {
                                                                                                                                                    print  $user[0]['name'];
                                                                                                                                                } ?>')">START SHOW</a>
                    <?php if (empty($subs)) { ?>
                        <a href="javascript:void(0)" onclick="subscribe('<?= $user[0]['id'] ?>', '<?= $this->session->userdata('UserId') ?>')" class="btn text-center subs_btn">Subscribe</a>
                    <?php } else { ?>
                        <a href="javascript:void(0)" onclick="subscribe('<?= $user[0]['id'] ?>', '<?= $this->session->userdata('UserId') ?>')" class="btn text-center subs_btn">
                            <?php if ($subs[0]->status == 0) {
                                    print 'Subscribe';
                                } else {
                                    print 'Unsubscribe';
                                } ?>
                        </a>
                    <?php } ?>
                    <a href="javascript:void(0)" class="btn text-center" id="myBtn2">Buy Credits</a>
                    <a href="javascript:void(0)" class="btn text-center gift-modal">Send Gifts</a>
                    <a href="javascript:void(0)" class="btn text-center">Concierge Service</a>
                </div>
            </div>
            <div class="perform-right-widget">
                <div class="box001">
                    <h2><?php if ($user[0]['display_name'] != '') {
                            print $user[0]['display_name'];
                        } else {
                            print  $user[0]['name'];
                        } ?></h2>
                    <div class="flex-cont">
                        <ul>
                            <li><img src="<?= base_url('assets/images/icon-xs-love.png') ?>" alt="" /> 320.000</li>
                            <li><img src="<?= base_url('assets/images/icon-xs-trophy.png') ?>" alt="" /> 320.000</li>
                        </ul>
                        <?php if (empty($subs)) { ?>
                            <a href="javascript:void(0)" onclick="subscribe('<?= $user[0]['id'] ?>', '<?= $this->session->userdata('UserId') ?>')" class="btn text-center subs_btn">Subscribe</a>
                        <?php } else { ?>
                            <a href="javascript:void(0)" onclick="subscribe('<?= $user[0]['id'] ?>', '<?= $this->session->userdata('UserId') ?>')" class="btn text-center subs_btn">
                                <?php if ($subs[0]->status == 0) {
                                        print 'Subscribe';
                                    } else {
                                        print 'Unsubscribe';
                                    } ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <div class="box002">
                    <div class="heading-stripe">
                        <h3><?php if ($user[0]['display_name'] != '') {
                                print $user[0]['display_name'];
                            } else {
                                print  $user[0]['name'];
                            } ?> Chat</h3>
                    </div>
                    <div class="list-style">
                        <ul class="chat-ul ovr-scrl-box" id="p_chat_box">
                            <?php
                            $last_chat_id = '';
                            if (!empty($chat)) {
                                for ($i = 0; $i < count($chat); $i++) {
                                    $last_chat_id = $chat[$i]->id;
                                    ?>
                                    <li style="<?php if ($chat[$i]->sender_id == $this->session->userdata('UserId')) {
                                                            print 'text-align: right';
                                                        } ?>"><?= $chat[$i]->msg ?></li>
                            <?php }
                            } ?>
                        </ul>
                    </div>
                </div>
                <input type="hidden" id="last_chat_id" value="<?= $last_chat_id ?>">
                <div class="box003">
                    <div class="btm-form">
                        <input type="text" id="p_chat_msg" />
                        <input type="button" value="Send" id="p_send_chat" />
                        <ul>
                            <li>
                                <img src="<?= base_url('assets/images/icon-giftbox.png') ?>" alt="Send Gift" />
                                <a href="javascript:void(0);" class="gift-modal">Send Gift</a>
                            </li>
                            <li>
                                <?php if (isset($vote)) { ?>
                                    <input type="hidden" id="perf_vote<?= $user[0]['id'] ?>" value="<?= $point; ?>">
                                    <input type="hidden" id="perf_rank<?= $user[0]['id'] ?>" value="<?= $vote['rank'] ?>">
                                <?php } ?>
                                <input type="hidden" id="perf_name<?= $user[0]['id'] ?>" value="<?php if ($user[0]['display_name'] != '') {
                                                                                                    print $user[0]['display_name'];
                                                                                                } else {
                                                                                                    print  $user[0]['name'];
                                                                                                } ?>">
                                <?php if (isset($vote)) { ?>
                                    <img src="<?= base_url('assets/images/icon-trophy.png') ?>" alt="Vote For Me" />
                                    <a href="javascript:void(0);" class="vt" id="<?= $user[0]['id'] ?>">Vote For Me</a>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="perform-widget">
            <div class="perfomer-short-des">
                <div class="short-des-col">
                    <div class="short-des-about">
                        <span class="round-pic"><img src="<?= base_url('assets/profile_image/' . $user[0]['image']) ?>" alt="<?php if ($user[0]['display_name'] != '') {
                                                                                                                                print $user[0]['display_name'];
                                                                                                                            } else {
                                                                                                                                print  $user[0]['name'];
                                                                                                                            } ?>" /></span>
                        <div class="shortcont">
                            <h1><?php if ($user[0]['display_name'] != '') {
                                    print $user[0]['display_name'];
                                } else {
                                    print  $user[0]['name'];
                                } ?></h1>
                            <p><?= $user[0]['description'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="short-des-col">
                    <?php if ($user[0]['willingness'] != '') {
                        $will = explode(',', $user[0]['willingness']); ?>
                        <h5>WILLINGNESS</h5>
                        <ul>
                            <?php foreach ($will as $wll) { ?>
                                <li><a href="javascript:void(0)">#<?= $wll ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
                <div class="short-des-col">
                    <h5>Get involed</h5>
                    <!--<a href="javascript:void(0)" class="btn">Subscribe</a>
<a href="javascript:void(0)" class="btn">Message</a>-->
                    <a href="javascript:void(0)" class="btn">BUY MY ITEMS</a>
                </div>
            </div>
        </div>
        <div class="perform-widget">
            <div class="top-bar-layout">
                <div class="top-bar-widgets">
                    <ul class="user-content-list">
                        <li>
                            <a href="javascript:void(0)" class="user-free-content">FREE CONTENT</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="user-premium-content">PREMIUM CONTENT</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="user-details-content">Full Details</a>
                        </li>
                    </ul>
                    <!--<div class="switch-view">
                        <span class="list"><img src="<?= base_url('assets/images/icon-list.png') ?>" alt="list" /></span>
                    <span class="grid"><img src="<?= base_url('assets/images/icon-grid.png') ?>" alt="grid" /></span>
                </div>-->
                </div>
            </div>
            <?php
            if ($user[0]['images'] != '') {
                $img = explode(',', $user[0]['images']);
            } else {
                $img = array();
            }
            ?>
            <div class="user-content-block">
                <div class="img-masgrid">
                    
                        <ul>
                            <?php
                            if (!empty($img)) {
                                for ($i = 0; $i < (count($img) / 2); $i++) {
                                    ?>
                                    <li>
                                        <?php if (empty($subs)) { ?>
                                            <div class="item-subscribe">
                                                <figure>
                                                    <img src="<?= base_url('assets/images/lock-icon.png') ?>" alt="lock" />
                                                    <a href="javascript:void(0)" onclick="subscribe('<?= $user[0]['id'] ?>', '<?= $this->session->userdata('UserId') ?>')" class="btn subscribebtn">SUBSCRIBE TO UNLOCK</a>
                                                </figure>
                                            </div>
                                        <?php } else { ?>
                                            <div class="item-subscribe" <?php if ($subs[0]->status == 1) {
                                                                                        print 'style="display:none;"';
                                                                                    } ?>>
                                                <figure>
                                                    <img src="<?= base_url('assets/images/lock-icon.png') ?>" alt="lock" />
                                                    <a href="javascript:void(0)" onclick="subscribe('<?= $user[0]['id'] ?>', '<?= $this->session->userdata('UserId') ?>')" class="btn subscribebtn">SUBSCRIBE TO UNLOCK</a>
                                                </figure>
                                            </div>
                                        <?php } ?>
                                        <img src="<?= base_url('assets/performer_gallery/' . $img[$i]) ?>">
                                    </li>
                            <?php }
                            } ?>
                        </ul>
                    
                    <?php 
                    /*
                    <div class="img-masgrid-rgt">
                        <ul>
                            <?php
                            //if(!empty($img)){
                            //for($i = (count($img)/2); $i < count($img); $i++){
                            ?>
                            <li>
                                <?php if (empty($subs)) { ?>
                                    <div class="item-subscribe">
                                        <figure>
                                            <img src="<?= base_url('assets/images/lock-icon.png') ?>" alt="lock" />
                                            <a href="javascript:void(0)" onclick="subscribe('<?= $user[0]['id'] ?>', '<?= $this->session->userdata('UserId') ?>')" class="btn subscribebtn">SUBSCRIBE TO UNLOCK</a>
                                        </figure>
                                    </div>
                                <?php } else { ?>
                                    <div class="item-subscribe" <?php if ($subs[0]->status == 1) {
                                                                        print 'style="display:none;"';
                                                                    } ?>>
                                        <figure>
                                            <img src="<?= base_url('assets/images/lock-icon.png') ?>" alt="lock" />
                                            <a href="javascript:void(0)" onclick="subscribe('<?= $user[0]['id'] ?>', '<?= $this->session->userdata('UserId') ?>')" class="btn subscribebtn">SUBSCRIBE TO UNLOCK</a>
                                        </figure>
                                    </div>
                                <?php } ?>
                                <img src="<?= base_url('assets/images/2.jpg') ?>">
                            </li>
                            <?php //} } 
                            ?>
                            <li>
                                <?php if (empty($subs)) { ?>
                                    <div class="item-subscribe">
                                        <figure>
                                            <img src="<?= base_url('assets/images/lock-icon.png') ?>" alt="lock" />
                                            <a href="javascript:void(0)" onclick="subscribe('<?= $user[0]['id'] ?>', '<?= $this->session->userdata('UserId') ?>')" class="btn subscribebtn">SUBSCRIBE TO UNLOCK</a>
                                        </figure>
                                    </div>
                                <?php } else { ?>
                                    <div class="item-subscribe" <?php if ($subs[0]->status == 1) {
                                                                        print 'style="display:none;"';
                                                                    } ?>>
                                        <figure>
                                            <img src="<?= base_url('assets/images/lock-icon.png') ?>" alt="lock" />
                                            <a href="javascript:void(0)" onclick="subscribe('<?= $user[0]['id'] ?>', '<?= $this->session->userdata('UserId') ?>')" class="btn subscribebtn">SUBSCRIBE TO UNLOCK</a>
                                        </figure>
                                    </div>
                                <?php } ?>
                                <img src="<?= base_url('assets/images/4.jpg') ?>">
                            </li>
                            <li>
                                <ul>
                                    <li>
                                        <ul>
                                            <li>
                                                <?php if (empty($subs)) { ?>
                                                    <div class="item-subscribe">
                                                        <figure>
                                                            <img src="<?= base_url('assets/images/lock-icon.png') ?>" alt="lock" />
                                                            <a href="javascript:void(0)" onclick="subscribe('<?= $user[0]['id'] ?>', '<?= $this->session->userdata('UserId') ?>')" class="btn subscribebtn">SUBSCRIBE TO UNLOCK</a>
                                                        </figure>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="item-subscribe" <?php if ($subs[0]->status == 1) {
                                                                                        print 'style="display:none;"';
                                                                                    } ?>>
                                                        <figure>
                                                            <img src="<?= base_url('assets/images/lock-icon.png') ?>" alt="lock" />
                                                            <a href="javascript:void(0)" onclick="subscribe('<?= $user[0]['id'] ?>', '<?= $this->session->userdata('UserId') ?>')" class="btn subscribebtn">SUBSCRIBE TO UNLOCK</a>
                                                        </figure>
                                                    </div>
                                                <?php } ?>
                                                <img src="<?= base_url('assets/images/6') ?>.jpg">
                                            </li>
                                            <li>
                                                <?php if (empty($subs)) { ?>
                                                    <div class="item-subscribe">
                                                        <figure>
                                                            <img src="<?= base_url('assets/images/lock-icon.png') ?>" alt="lock" />
                                                            <a href="javascript:void(0)" onclick="subscribe('<?= $user[0]['id'] ?>', '<?= $this->session->userdata('UserId') ?>')" class="btn subscribebtn">SUBSCRIBE TO UNLOCK</a>
                                                        </figure>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="item-subscribe" <?php if ($subs[0]->status == 1) {
                                                                                        print 'style="display:none;"';
                                                                                    } ?>>
                                                        <figure>
                                                            <img src="<?= base_url('assets/images/lock-icon.png') ?>" alt="lock" />
                                                            <a href="javascript:void(0)" onclick="subscribe('<?= $user[0]['id'] ?>', '<?= $this->session->userdata('UserId') ?>')" class="btn subscribebtn">SUBSCRIBE TO UNLOCK</a>
                                                        </figure>
                                                    </div>
                                                <?php } ?>
                                                <img src="<?= base_url('assets/images/8.jpg') ?>">
                                            </li>

                                        </ul>
                                    </li>
                                    <li>
                                        <ul>
                                            <li>
                                                <?php if (empty($subs)) { ?>
                                                    <div class="item-subscribe">
                                                        <figure>
                                                            <img src="<?= base_url('assets/images/lock-icon.png') ?>" alt="lock" />
                                                            <a href="javascript:void(0)" class="btn subscribebtn">SUBSCRIBE TO UNLOCK</a>
                                                        </figure>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="item-subscribe" <?php if ($subs[0]->status == 1) {
                                                                                        print 'style="display:none;"';
                                                                                    } ?>>
                                                        <figure>
                                                            <img src="<?= base_url('assets/images/lock-icon.png') ?>" alt="lock" />
                                                            <a href="javascript:void(0)" class="btn subscribebtn">SUBSCRIBE TO UNLOCK</a>
                                                        </figure>
                                                    </div>
                                                <?php } ?>
                                                <img src="<?= base_url('assets/images/7.jpg') ?>">
                                            </li>
                                            <li class="txtblock">
                                                <?php if (empty($subs)) { ?>
                                                    <div class="item-subscribe">
                                                        <figure>
                                                            <img src="<?= base_url('assets/images/lock-icon.png') ?>" alt="lock" />
                                                            <a href="javascript:void(0)" class="btn subscribebtn">SUBSCRIBE TO UNLOCK</a>
                                                        </figure>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="item-subscribe" <?php if ($subs[0]->status == 1) {
                                                                                        print 'style="display:none;"';
                                                                                    } ?>>
                                                        <figure>
                                                            <img src="<?= base_url('assets/images/lock-icon.png') ?>" alt="lock" />
                                                            <a href="javascript:void(0)" class="btn subscribebtn">SUBSCRIBE TO UNLOCK</a>
                                                        </figure>
                                                    </div>
                                                <?php } ?>
                                                <h3>#Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus aliquet </h3>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    */
                    ?>
                </div>
            </div>
            <div class="user-content-block d-none">
                <p>Content coming soon.</p>
            </div>
            <div class="user-content-block d-none pt-2">
                <h2>Performer Details</h2>
                <table class="performer-details"
                    <tbody>
                        <tr>
                            <th align="left">Full Name</th>
                            <td><?= db_val( $user[0]['display_name'] ) ?></td>
                        </tr>
                        <tr>
                            <th align="left">Sexual Preference</th>
                            <td><?= db_val( $user[0]['sexual_pref'] ) ?></td>
                        </tr>
                        <tr>
                            <th align="left">Height</th>
                            <td><?= db_val( $user[0]['height'] ) ?></td>
                        </tr>
                        <tr>
                            <th align="left">Weight</th>
                            <td><?= db_val( $user[0]['weight'] ) ?></td>
                        </tr>
                        <tr>
                            <th align="left">Hair Colour</th>
                            <td><?= db_val( $user[0]['hair'] ) ?></td>
                        </tr>
                        <tr>
                            <th align="left">Eye Colour</th>
                            <td><?= db_val( $user[0]['eye'] ) ?></td>
                        </tr>
                        <tr>
                            <th align="left">Zodiac Sign</th>
                            <td><?= db_val( $user[0]['zodiac'] ) ?></td>
                        </tr>
                        <tr>
                            <th align="left">Build</th>
                            <td><?= db_val( $user[0]['build'] ) ?></td>
                        </tr>
                        <tr>
                            <th align="left"><?= $user[0]['gender'] == 'Male' ? 'Chest' : 'Breast' ?> Size</th>
                            <td><?= db_val( $user[0]['chest'] ) ?></td>
                        </tr>
                        <tr>
                            <th align="left">Burst Size</th>
                            <td><?= db_val( $user[0]['burst'] ) ?></td>
                        </tr>
                        <?php if( $user[0]['gender'] == 'Female' ) : ?>
                        <tr>
                            <th align="left">Cup</th>
                            <td><?= db_val( $user[0]['cup'] ) ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th align="left">Display Age As</th>
                            <td><?= db_val( $user[0]['age'] ) ?></td>
                        </tr>
                        <?php if( $user[0]['gender'] == 'Male' ) : ?>
                        <tr>
                            <th align="left">Penis Size</th>
                            <td><?= db_val( $user[0]['penis'] ) ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th align="left">Pubic Hair</th>
                            <td><?= db_val( $user[0]['pubic_hair'] ) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </section>
</main>
</section>