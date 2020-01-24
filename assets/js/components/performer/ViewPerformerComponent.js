import JSComponent from '../JSComponent.js';

export default class ViewPerformerComponent extends JSComponent {
    
    constructor() {
        super();
        this.setState({
            freeContents: [],
            premiumContents: [],
            performerDetails: {}
        })
        this.init();
    }

    // onload = () => {
    //     window.load = function() {
    //         return true;
    //     }
    // }
    init() {
        this.componentDidMount();
    }

    componentDidMount = () => {
        
        this.fetch('http://localhost/adultlounge/api/v1/view/performer')
        .then(data => {
            if(data) {
                this.setState({
                    ...this.state,
                    freeContents: data.freeContents,
                    premiumContents: data.premiumContents,
                    performerDetails: data.performerDetails,
                });
                console.log('componentDidMount',this.state);
            } else {
                console.log('else componentDidMount',this.state);
                this.setState({
                    ...this.state,
                })
            }
        })
        
    }
}
new ViewPerformerComponent();
