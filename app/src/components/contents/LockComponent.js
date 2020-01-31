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
            return(
                <React.Fragment>
                    {this.lockRender()}
                    {this.state.modalIsOpen && (
                    <PopupComponent style={customStyles} portalClassName={"modal buy_modal __subscribeModal"} className={""} overlayClassName={"Overlay"} modalIsOpen={this.state.modalIsOpen}>
                        
                        <div className="modal-content">
    <div className="modal-header">
        <h2>Subscribe</h2>
        <span className="close" onClick={this.handleCloseModal}>&times;</span>
    </div>
    
    <div className="modal-body">
        <div className="clearfix"></div>
        <div className="credit-slider">
        <div className="credit-list">
        <h3>
         6 Months
        </h3>
            <h2>£99.90</h2>
            <p>Lorem Ipsum is simply dummy text</p>
            <a href="http://localhost/adultlounge/process-payment/4q2VolejRejNmGQB" className="btn">SUBSCRIBE
            </a>
        </div>
        <div className="credit-list">
        <h3>
            1 Years
        </h3>
            <h2>£99.90</h2>
            <p>Lorem Ipsum is simply dummy text</p>
            <a href="http://localhost/adultlounge/process-payment/4q2VolejRejNmGQB" className="btn">SUBSCRIBE
            </a>
        </div>
        <div className="credit-list">
        <h3>
        3 Years
        </h3>
            <h2>£99.90</h2>
            <p>Lorem Ipsum is simply dummy text</p>
            <a href="http://localhost/adultlounge/process-payment/4q2VolejRejNmGQB" className="btn">SUBSCRIBE
            </a>
        </div>
           
        </div>
    </div>
</div>
            </PopupComponent>)}
            </React.Fragment>)
        
        
    }
}
export default LockComponent;

