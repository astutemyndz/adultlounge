import React,{useState} from 'react'
import LockComponent from './LockComponent';

const ImageComponent = (props) => {
    
    if(props.isFree) {
        return(
        <li>
            <img src={props.image.imagePath} onClick={(e) => props._propOpenLightbox(props.index, e)}></img>
        </li>
        );
    } else {
        return(
        <li className={"image-blur tooltip"}>
            <img src={props.image.imagePath}></img>
            <div >
                <LockComponent {...props}/>
            </div>
            
        </li>
        );
    }
    
}
export default ImageComponent;