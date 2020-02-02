import React, { Component } from 'react'
import Modal from 'react-modal';
import './SubscribeModalComponent.css';
import SubscribePackage from './SubscribePackage';

class SubscribeModalComponent extends Component {
      constructor(props) {
        super(props);
        this.state = {
          modalIsOpen: this.props.modalIsOpen
        };
      }
      openModal = () => {
        this.setState({modalIsOpen: true});
      }
      closeModal = () => {
        this.setState({modalIsOpen: false});
      }
      componentWillMount() {
        Modal.setAppElement('body');
      }
      render() {
        let _subscribePackages = [];
        let i = 0;
        for(; i < 3; i++) {
            _subscribePackages.push(<SubscribePackage/>);                  
        }
        
        return (
          <div>
              <Modal
                isOpen={this.state.modalIsOpen}
                onRequestClose={this.closeModal}
                shouldCloseOnOverlayClick={false}
                {...this.props}
                portalClassName={"modal buy_modal __subscribeModal"} 
                className={""} 
                overlayClassName={"Overlay"}
              >
              <div className="modal-content">
                  <div className="modal-header">
                      <h2>Subscribe</h2>
                      <span className="close" onClick={this.props.closeModal}>&times;</span>
                  </div>
                  <div className="modal-body">
                      <div className="clearfix"></div>
                      <div className="credit-slider">
                          {
                            _subscribePackages
                          }
                      </div>
                      
                  </div>
              </div>
            </Modal>
          </div>
        );
      }
}
export default SubscribeModalComponent;