import QueryStringComponent from './query_string/QueryStringComponent.js';
export default class JSComponent {
    queryStringComponentInstance;
    state = {};
    constructor() {
        //super();
        this.queryStringComponentInstance = new QueryStringComponent();
    }
    setState(state) {
        this.state = state;
        return this;
    }
    getState() {
        return this.state;
    }

    
    async fetch(url) {
        let response = await fetch(url);
        let data = await response.json()
        return data;
    }

    baseUrl() {
        return this.queryStringComponentInstance.baseUrl();
    }
}