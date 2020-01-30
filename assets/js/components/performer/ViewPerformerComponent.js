import JSComponent from '../JSComponent.js';

export default class ViewPerformerComponent extends JSComponent {
    __freeImageGridEl;
    __freeVideoGridEl;
    __premiumImageGridEl;
    __premiumVideoGridEl;
    constructor() {
        super();
        this.setState({
            freeContents: [],
            premiumContents: [],
            performerDetails: {}
        })
        this.init();
    }

    init() {
        this.__freeImageGridEl            = document.querySelector('.__freeImageGridEl');
        this.__freeVideoGridEl            = document.querySelector('.__freeVideoGridEl');

        this.__premiumImageGridEl            = document.querySelector('.__premiumImageGridEl');
        this.__premiumVideoGridEl            = document.querySelector('.__premiumVideoGridEl');

        this.componentDidMount(this.render);
        //this.render();
    }

    componentDidMount = (callback) => {
        //console.log(customerID);
        this.fetch(API_URL + `performer/contents?customer_id=${customerID}&performer_id=${performerID}`)
        .then(data => {
            if(data) {
                //console.log(data)
                this.setState({
                    ...this.state,
                    freeContents: data.freeContents,
                    premiumContents: data.premiumContents,
                    performerDetails: data.performerDetails,
                });
                //console.log('componentDidMount',this.state);
                callback();
            } else {
                //console.log('else componentDidMount',this.state);
                this.setState({
                    ...this.state,
                })
            }
        })
        
    }
    EmptyImageComponent = () => {
        return(`<div>This performer currently has no photos.</div>`);
    }
    EmptyVideoComponent = () => {
        return(`<div>This performer currently has no videos.</div>`);
    }
    FreeImageComponent = (props) => {
        return(`<li><img src="${base_url}${props.imagePath}"></li>`);
    }
    FreeVideoComponent = (props) => {
        return(`
            <div class="video-view ">
                <div class="video-play">
                    <video width="424.72" controls>
                        <source src="${base_url}${props.videoPath}" type="video/mp4" />
                    </video>
                    
                    <div class="video-time">
                        <div class="time-show">
                            <h5>4:57</h5>
                        </div>
                    </div>
                </div>
                <div class="video-details">
                    <h4>Lorem Ipsum Dolor Text</h4>
                    <div class="video-pricing-area">
                        <h5>User Id: 6474314</h5>
                        <p>29 Dec, 2019</p>
                    </div>
                </div>
            </div>
        `);
    }
    LockComponent = (props) => {
        return(`
            <span class="tooltiptext">Inpremium, login to view & purchase videos</span>
            <div class="lock-video">
                <a href="#"><img src="${base_url}assets/images/lock-icon.png"></a>
            </div>
        `);
    }
    PremiumImageComponent = (props) => {
        let lock = '';
        let imageBlurClass = '';
        if(!props.subscribe) {
            lock = this.LockComponent();
            imageBlurClass = 'image-blur';
        } 
        return(`<li class="${imageBlurClass} tooltip"><img  src="${base_url}${props.imagePath}">${lock}</li>`);
    }
    PremiumVideoComponent = (props) => {
        let lock = '';
        if(!props.subscribe) {
            lock = this.LockComponent();
        } 
        return(`
        <div class="video-view tooltip">
            <div class="video-play">
                <video width="424.72" controls>
                    <source src="${base_url}${props.videoPath}" type="video/mp4" />
                </video>
                ${lock}
                <div class="video-time">
                    <div class="time-show">
                        <h5>4:57</h5>
                    </div>
                </div>
            </div>
            <div class="video-details">
                <h4>Lorem Ipsum Dolor Text</h4>
                <div class="video-pricing-area">
                    <h5>User Id: 6474314</h5>
                    <a href="#" class="video-price-btn">$20.00</a>
                </div>
            </div>
        </div>
        `);
    }
    render = () => {
        const {freeContents, premiumContents} = this.state;
        const freeImages = []
        const freeVideos = [];

        const premiumImages = []
        const premiumVideos = [];

        if(freeContents) {
            freeContents.images.map((image) => freeImages.push(this.FreeImageComponent(image)));
        }
        
        if(freeContents) {
            freeContents.videos.map((video) => freeVideos.push(this.FreeVideoComponent(video)));
        }
        //Premium
        if(premiumContents) {
            premiumContents.images.map((image) => premiumImages.push(this.PremiumImageComponent(image)));
        }
        
        if(premiumContents) {
            premiumContents.videos.map((video) => premiumVideos.push(this.PremiumVideoComponent(video)));
        }

        if(freeImages.length > 0) {
            this.__freeImageGridEl.insertAdjacentHTML('beforeend', freeImages);
        } else {
            this.__freeImageGridEl.innerHTML = this.EmptyImageComponent();
        }
        
        if(freeVideos.length > 0) {
            this.__freeVideoGridEl.insertAdjacentHTML('beforeend', freeVideos);
        } else {
            this.__freeVideoGridEl.innerHTML = this.EmptyVideoComponent();
        }

        // Premium
        if(premiumImages.length > 0) {
            this.__premiumImageGridEl.insertAdjacentHTML('beforeend', premiumImages);
        } else {
            this.__premiumImageGridEl.innerHTML = this.EmptyImageComponent();
        }
        
        if(premiumVideos.length > 0) {
            this.__premiumVideoGridEl.insertAdjacentHTML('beforeend', premiumVideos );
        } else {
            this.__premiumVideoGridEl.innerHTML = this.EmptyVideoComponent();
        }
    }
}
new ViewPerformerComponent();