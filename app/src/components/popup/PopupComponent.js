import React, { Component } from 'react'
import Modal from 'react-modal';

class PopupComponent extends Component {
      constructor(props) {
        super(props);
     
        this.state = {
          modalIsOpen: this.props.modalIsOpen
        };
     
        this.openModal = this.openModal.bind(this);
        this.closeModal = this.closeModal.bind(this);
        console.log(this.state);
      }
     
      openModal() {
        this.setState({modalIsOpen: true});
      }
     
      closeModal() {
        this.setState({modalIsOpen: false});
      }

      componentWillMount() {
        Modal.setAppElement('body');
    }
     
      render() {
        
        return (
          <div>
            <button onClick={this.openModal}>Open Modal</button>
              <Modal
                isOpen={this.state.modalIsOpen}
                onRequestClose={this.closeModal}
                shouldCloseOnOverlayClick={false}
                {...this.props}
              >
              {this.props.children}
            </Modal>
          </div>
        );
      }
}
export default PopupComponent;