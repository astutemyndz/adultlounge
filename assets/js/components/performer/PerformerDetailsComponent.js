import StateFullComponent from '../StateFullComponent.js';

export default class PerformerDetailsComponent extends StateFullComponent {
    
    constructor() {
        super();
        this.setState({
            freeContents: [],
            premiumContents: [],
            performerDetails: {}
        })
        this.componentDidMount();
    }

    componentDidMount = () => {
        console.log('componentDidMount',this.state);
    }
}
new PerformerDetailsComponent();