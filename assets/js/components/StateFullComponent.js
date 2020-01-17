export default class StateFullComponent {
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
}