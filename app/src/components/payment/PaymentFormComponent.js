import React, { Component } from 'react'
import Modal from 'react-modal';

class PaymentFormComponent extends Component {
    constructor(props) {
        super(props);
        this.state = {
          modalIsOpen: this.props.modalIsOpen,
        };
        this.openModal = this.openModal.bind(this);
        this.closeModal = this.closeModal.bind(this);
    }
     
    openModal() {
        this.setState({modalIsOpen: true});
    }
    
    closeModal() {
        this.setState({modalIsOpen: false});
    }

   
    render() {
        const customStyles = {
            content : {
              top                   : '50%',
              left                  : '50%',
              right                 : 'auto',
              bottom                : 'auto',
              marginRight           : '-50%',
              transform             : 'translate(-50%, -50%)',
            }
          };
        return (
            <React.Fragment>
                <Modal
                    style={customStyles}
                    isOpen={this.state.modalIsOpen}
                    onRequestClose={this.closeModal}
                    shouldCloseOnOverlayClick={false}
                    {...this.props}
                >
                    <div className="modal-content">
                        <div className="modal-header">
                            <h2>Payment</h2>
                            <span className="close" onClick={this.closeModal}>&times;</span>
                        </div>
                        <div className="modal-body">
                            <div className="clearfix"></div>
                            <div className="credit-slider">
                                <form action="/" id="my-sample-form">
                                    <input type="hidden" name="payment_method_nonce"></input>
                                    <label for="card-number">Card Number</label>
                                    <div id="card-number"></div>

                                    <label for="cvv">CVV</label>
                                    <div id="cvv"></div>

                                    <label for="expiration-date">Expiration Date</label>
                                    <div id="expiration-date"></div>

                                    <input id="my-submit" type="submit" value="Pay" disabled></input>
                                </form>
                            </div>
                        </div>
                    </div>
                </Modal>
            </React.Fragment>
        )
    }
}
export default PaymentFormComponent