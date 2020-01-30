import React,{useStyles}from 'react'
import ReactModal from 'react-modal';
import PopupComponent from '../popup/PopupComponent';

class LockComponent extends React.Component {
    constructor(props) {
        super();
        this.state = {
        modalIsOpen: false
        };
        
        this.handleOpenModal = this.handleOpenModal.bind(this);
        this.handleCloseModal = this.handleCloseModal.bind(this);
    }
    handleOpenModal () {
        this.setState({ modalIsOpen: true });
    }
      
    handleCloseModal () {
        this.setState({ modalIsOpen: false });
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
        if(this.state.modalIsOpen) {
            return(<PopupComponent portalClassName={""} className={""} overlayClassName={""} modalIsOpen={this.state.modalIsOpen}>
                <div className="modal-header">
                        <h2>Subscribe</h2>
                        <p>You currently have <span className="credit-total">4511 Credit</span></p>
                        <span className="close" onClick={this.handleCloseModal}>×</span>
                       
                    </div>
                    <form>
                        <button>Do Subscribe</button>
                    </form>
            </PopupComponent>)
        } else {
            return(<React.Fragment>
                {this.lockRender()} 
            </React.Fragment>)
        }
        
    }
}
export default LockComponent;

