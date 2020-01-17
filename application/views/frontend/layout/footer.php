<!--------vote-PopUp---------->
<div class="vote-bg">
    <div class="vote-container">
        <div class="vote-hed">
            <h3>Vote</h3>
            <span class="voteClose">&times;</span>
        </div>
        <div class="vote-body">
            <p id="vote_nm"></p>
            <span id="vote_pts"></span>
            <p id="vote_rnk"></p>
            <a href="javascript:void(0);" class="btn voteBtn">VOTE FOR ME</a>
            <a href="javascript:void(0);">LEGAL DISCLAIMER: </a>
        </div>
    </div>
</div>
<!--------vote-PopUp---------->

<!--------gift-PopUp---------->
<?php $this->load->view('partials/popups/gift') ?>
<!--------gift-PopUp---------->

<?php $this->load->view('partials/popups/credit-plans') ?>

<!-- Buy Credits -->
<!--<div class="modal-buy fade" id="buy-credits" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>-->
<!-- Buy Credits -->

<script src="<?=base_url('assets/js/jquery.min.js')?>"></script>

<script src="<?=base_url('assets/js/owl.carousel.min.js')?>"></script>
<script src="<?=base_url('assets/js/sweetalert2.min.js')?>"></script>
<script src="<?=base_url('assets/js/jquery.mCustomScrollbar.concat.min.js')?>"></script>
<script src="<?=base_url('assets/js/jquery.multipurpose_tabcontent.js')?>"></script>
<script src="<?=base_url('assets/js/jquery.overlayScrollbars.min.js')?>"></script>
<script src="<?=base_url('assets/js/waitMe.min.js')?>"></script>
<script src="<?= base_url('assets/js/jquery.switcher.min.js') ?>"></script>

<!--Result Template-->
<script id="result-template" type="text/x-handlebars-template">
    <div class="ProfileCard u-cf">
    <img class="ProfileCard-avatar" src="{{profile_image_url_https}}">
    <span class="active-circle"></span>

    <div class="ProfileCard-details">
        <div class="ProfileCard-realName">{{name}}</div>
        <div class="ProfileCard-screenName">30 y/tests female</div>
        <div class="ProfileCard-description">Private</div> 
    </div>

    <!-- <div class="ProfileCard-stats">
        <div class="ProfileCard-stat"><span class="ProfileCard-stat-label">Tweets:</span> {{statuses_count}}</div>
        <div class="ProfileCard-stat"><span class="ProfileCard-stat-label">Following:</span> {{friends_count}}</div>
        <div class="ProfileCard-stat"><span class="ProfileCard-stat-label">Followers:</span> {{followers_count}}</div>
    </div> -->
    </div>
</script>
<!--Result Template-->

<!--Empty Template-->
<script id="empty-template" type="text/x-handlebars-template">
    <div class="EmptyMessage">Sorry, we could not find any results for your search</div>
</script>
<!--Empty Template-->


<script src="<?= base_url('assets/plugins/typeahead/js/handlebars.js') ?>"></script>
<script src="<?= base_url('assets/plugins/typeahead/js/jquery.xdomainrequest.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/typeahead/js/typeahead.bundle.js') ?>"></script>

<link href="<?=base_url('assets/css/material-components-web.min.css')?>" rel="stylesheet">
<script src="<?=base_url('assets/js/material-components-web.min.js')?>"></script>

<script src="<?= base_url('assets/js/bundler.js') ?>"></script>
<script>

    $(document).ready(function() {
        $('.sidebar-menu > li > a').click(function() {
            $(this).next().slideToggle();
            $(this).parent().siblings().find('ul').slideUp();
        });
        $('.list').click(function() {
            $('.list-widget .col').removeClass('gridview').addClass('listview');
            //$('.list-widget .col').toggleClass('gridview listview');
        });
        $('.grid').click(function() {
            $('.list-widget .col').removeClass('listview').addClass('gridview');
        });
        $('.logbtn').click(function() {
            $('.modal').addClass('open');
        });
        $('.modal .overlay').click(function() {
            $('.modal').removeClass('open');
        });
        $.mCustomScrollbar.defaults.scrollButtons.enable = true; //enable scrolling buttons by default
        //$.mCustomScrollbar.defaults.axis = "yx"; //enable 2 axis scrollbars by default
        $("#content-ltn").mCustomScrollbar({
            theme: "inset"
        });
        $(".chat-ul").mCustomScrollbar({
            theme: "inset"
        }).mCustomScrollbar("scrollTo", "bottom", {
            scrollInertia: 0
        });
        $(".second_tab").champ({
            plugin_type: "tab",
            side: "left",
            active_tab: "1",
            controllers: "false"
        });
        // $(".msg-container").mCustomScrollbar({
        // theme: "inset"
        // }).mCustomScrollbar("scrollTo", "top", {
        // scrollInertia: 0
        // }); 

        loadOwlCarouselEventHandler();

        //BUY CREDITS
        // Get the modal
        var modal = document.getElementById("buy-modal");
        onCLickBuyCreditButtonEventHandler({modal:modal});
        onCLickBuyCreditModalCloseButtonEventHandler({modal:modal});
        onCLickBuy2CreditButtonEventHandler({modal:modal});

       

        // When the user clicks anywhere outside of the modal, close it
        //window.onclick = function(event) {
        //  if (event.target == modal) {
        //    modal.style.display = "none";
        //  }
        //}
    });


    // var objDiv = $(".chat-sec");
    // var h = objDiv.get(0).scrollHeight;
    // objDiv.animate({scrollTop: h});

    function updateScroll() {
        var element = document.getElementsByClassName(".chat-sec");
        element.scrollTop = element.scrollHeight;
    }

    const loadOwlCarouselEventHandler = function() {
        $('.slider-reward').owlCarousel({
            loop:false,
            margin:10,
            nav:false,
                dots: true,
            responsive:{
                0:{
                    items:2
                },
                600:{
                    items:4
                },
                1000:{
                    items:6
                }
            }
        });
    }

    const onCLickBuyCreditButtonEventHandler = function(options = null) {
        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        if(! btn) {
            return;
        }

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            options.modal.style.display = "block";
        }
    }
    const onCLickBuy2CreditButtonEventHandler = function(options = null) {
        // Get the button that opens the modal
        var btn = document.getElementById("myBtn2");

        if(! btn) {
            return;
        }

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            options.modal.style.display = "block";
        }
    }
    const onCLickBuyCreditModalCloseButtonEventHandler = function(options = null) {
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        if(! span) {
            return;
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            options.modal.style.display = "none";
        }
    }

</script>
<script src="<?=base_url('assets/js/custom.js')?>"></script>
<script src="<?=base_url('assets/js/videoChat.js')?>"></script>

<div class=""></div>
<link href="<?=base_url('assets/plugins/fakeLoader/css/fakeLoader.min.css')?>" rel="stylesheet" type="text/css" />
<script src="<?= base_url('assets/plugins/fakeLoader/js/fakeLoader.min.js') ?>"></script>
<script src="<?= base_url('assets/js/masonry.pkgd.min.js') ?>"></script>
<script>
    $(document).ready(function(){
      

                
            });
/*
var elem = document.querySelector('.grid');
var msnry = new Masonry( elem, {
  itemSelector: '.grid-item',
  columnWidth: 200
});
var msnry = new Masonry( '.grid', {
});
*/
</script>
<script type="module" defer src="<?=base_url('assets/js/components/filter/FilterComponent.js')?>"></script>
<script type="module" defer src="<?=base_url('assets/js/components/profile/ProfileComponent.js')?>"></script>
<script type="module" defer src="<?=base_url('assets/js/components/performer/PerformerDetailsComponent.js')?>"></script>
</body>

</html>
