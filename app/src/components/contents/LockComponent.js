import React from 'react'
import ReactModal from 'react-modal';

class LockComponent extends React.Component {
    constructor(props) {
        super();
        this.state = {
        showModal: false
        };
        
        this.handleOpenModal = this.handleOpenModal.bind(this);
        this.handleCloseModal = this.handleCloseModal.bind(this);
    }
    handleOpenModal () {
        this.setState({ showModal: true });
    }
      
    handleCloseModal () {
        this.setState({ showModal: false });
    }
    lockRender() {
        return(
            <div>
                <span className="tooltiptext">Inpremium, subscribe to view & purchase</span>
                <div className="lock-video">
                    <a href="javascript:void(0);" onClick={this.handleOpenModal}>
                        <img src={this.props.lockIconPath}></img>
                    </a>
                </div>
            </div>
        )
    }

    render() {
        const customStyles = {
            content : {
              top                   : '50%',
              left                  : '50%',
              right                 : 'auto',
              bottom                : 'auto',
              marginRight           : '-50%',
              transform             : 'translate(-50%, -50%)'
            }
          };
        return(
            <div>
                {this.lockRender()}
            
            { this.state.showModal && (
               <ReactModal 
               isOpen={this.state.showModal}
               contentLabel="onRequestClose Example"
               onRequestClose={this.handleCloseModal}
               shouldCloseOnOverlayClick={false}
               style={customStyles}
            >
              <div>I am a modal</div>
                <form>
                    
                </form>
              <button onClick={this.handleCloseModal}>Close Modal</button>
            </ReactModal>
              
            )}
            </div>
        )
    }
}
export default LockComponent;

