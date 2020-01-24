export default class JSComponent {
    state = {};
    constructor() {
        //super();
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
}