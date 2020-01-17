export default class State {
    state = {};

    setState(state) {
        this.state = state;
        return this;
    }
    getState() {
        return this.state;
    }
}