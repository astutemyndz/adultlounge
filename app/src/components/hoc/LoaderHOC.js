import React from 'react'
import './LoadingHOC.css';
  
const LoaderHOC = (propName) => (WrappedComponent) => {
    return class LoaderHOC extends React.Component {
        isEmpty(prop) {
            return(
                prop === null ||
                prop === undefined ||
                (prop.hasOwnProperty('length') && prop.length === 0) ||
                (prop.constructor === Object && Object.keys(prop).length === 0)
                );
        }
        render() {
            return this.isEmpty(this.props[propName]) ? <div className="loader"></div> : <WrappedComponent {...this.props}/>
        }
    }
}

export default LoaderHOC;