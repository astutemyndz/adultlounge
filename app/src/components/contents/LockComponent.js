import React,{useStyles}from 'react'
import SubscribeModalComponent from '../performer/SubscribeModalComponent';

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
              top          : '50%',
              left         : '50%',
              right        : 'auto',
              bottom       : 'auto',
              marginRight  : '-50%',
              transform    : 'translate(-50%, -50%)',
            }
          };
        return(
            <React.Fragment>
                {this.lockRender()}
                {this.state.modalIsOpen && (
                    <SubscribeModalComponent closeModal={this.handleCloseModal} style={customStyles}  modalIsOpen={this.state.modalIsOpen}/>
                )}
        </React.Fragment>)
    }
}
export default LockComponent;