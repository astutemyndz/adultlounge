<link rel="stylesheet" href="<?= base_url('assets/node_modules/lightgallery.js/dist/css/lightgallery.min.css') ?>">
<style>
.awards-list video {
	max-width: 100%;
	object-fit: cover;
	max-height: 100%;    
}
</style>
<main class="content-wrapper loyalty-page">
	<section class="content-sec awards-container">
		<div class="slider-head">
			<p>THE TOP 100 MODELS IN AWARDS</p>
		</div>
		<div class="awards-slider">
        	<div class="owl-carousel owl-theme slider-awards">
                <div class="item">
                	<img src="<?=base_url('assets/images/awards-slider.jpg')?>" alt=""/>
                    <div class="awards-slider-content">
                    	<ul>
                        	<li>
                            	<div class="step-work">
                                	<p>no.</p>
                                    <h2>23</h2>
                                </div>
                                <div class="step-description">
                                	<h3><i class="fa fa-circle" aria-hidden="true"></i> AlisMorris</h3>
                                    <p>Winnings $100 - 13,903 points</p>
                                    <p>PRIVATE: £6.99 p/m  &nbsp; &nbsp;  GROUP: £3.99 p/M</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="item">
                	<img src="<?=base_url('assets/images/awards-slider.jpg')?>" alt=""/>
                </div>
            </div>
        </div>
        <div class="awards-list">
        	<div class="col gridview index-p-div" id="html5-videos">
                <?php if (count($performer_videos)) : ?>
                    <?php foreach ($performer_videos as $performer_video) : ?>
                        <div class="col-grid">
                            <figure class="active">
                                <span class="strapbox"><?= str_replace( '_', ' ', $performer_video->video_type ) ?></span>
                                <a class="vid-item" href="javascript:void()" data-html="#video<?= encrypt_id( $performer_video->id ) ?>">
                                    <video height="143" loop preload="none" style="pointer-events: none;">
                                        <source src="<?= base_url('assets/profile_videos/' . $performer_video->video ) ?>"></source>
                                    </video>
                                </a>
                                <figcaption>
                                    <h4>
                                        <span class="active-circle"></span>
                                        <a href="javascript:void()"><?= $performer_video->name ?></a>
                                    </h4>
                                    <ul>
                                        <li>PRIVATE: <span>£6.99</span> p/m</li>
                                    </ul>
                                </figcaption>
                            </figure>
                            <div style="display:none" id="video<?= encrypt_id( $performer_video->id ) ?>">
                                <video class="lg-video-object lg-html5" controls preload="none">
                                    <source src="<?= base_url('assets/profile_videos/' . $performer_video->video ) ?>" type="video/mp4">
                                    Your browser does not support HTML5 video.
                                </video>
                            </div>                            
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>                
          	</div>
        </div>
	</section>
</main>
<script src="<?= base_url('assets/node_modules/lightgallery.js/dist/js/lightgallery.min.js') ?>"></script>
<script src="<?= base_url('assets/node_modules/lightgallery.js/dist/js/lg-video.min.js') ?>"></script>
<script>
    // lightGallery(document.getElementById('html5-videos', {
    //     selector : '.vid-item',
    // })); 
</script>