import React, { Component } from 'react'
import DropIn from "braintree-web-drop-in-react";

class BraintreeWebDropInComponent extends Component {
    instance;
    constructor(props) {
        super(props);
        this.state = {
            clientToken: this.props.clientToken
        };
    }
 
 
  // async componentDidMount() {
  //   // Get a client token for authorization from your server
  //   // const response = await fetch("server.test/");
  //   // const clientToken = await response.json(); // If returned as JSON string
 
  //   this.setState({
  //     clientToken: 'sandbox_ndqstx7c_fz3wygqqc3zknf95'
  //   });
  // }
 
  async buy() {
    // Send the nonce to your server
    const { nonce } = await this.instance.requestPaymentMethod();
    await fetch(`server.test/purchase/${nonce}`);
  }
 
  render() {
    if (!this.state.clientToken) {
      return (
        <div>
          <h1>Loading...</h1>
        </div>
      );
    } else {
      return (
        <div>
          <DropIn
            options={{ authorization: this.state.clientToken }}
            onInstance={instance => (this.instance = instance)}
          />
          <button onClick={this.buy.bind(this)}>Buy</button>
        </div>
      );
    }
  }
}
export default BraintreeWebDropInComponent;