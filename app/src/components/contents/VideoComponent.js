import React from 'react'
import LockComponent from './LockComponent';

const VideoComponent = (props) => {
    if(props.isFree) {
            return(
                <div className="video-view tooltip">
                    <div className="video-play">
                        <video width="424.72" controls>
                            <source src={props.video.videoPath} type="video/mp4" />
                        </video>
                        <div className="video-time">
                            <div className="time-show">
                                <h5>4:57</h5>
                            </div>
                        </div>
                    </div>
                    <div className="video-details">
                        <h4>Lorem Ipsum Dolor Text</h4>
                        <div className="video-pricing-area">
                            <h5>User Id: 6474314</h5>
                            <a href="#" className="video-price-btn">$20.00</a>
                        </div>
                    </div>
                </div>
            );
        } else {
            return(
                <div className="video-view tooltip">
                <div className="video-play">
                    <video width="424.72" controls>
                        <source src={props.video.videoPath} type="video/mp4" />
                    </video>
                    <LockComponent {...props}/>
                    <div className="video-time">
                        <div className="time-show">
                            <h5>4:57</h5>
                        </div>
                    </div>
                </div>
                <div className="video-details">
                    <h4>Lorem Ipsum Dolor Text</h4>
                    <div className="video-pricing-area">
                        <h5>User Id: 6474314</h5>
                        <a href="#" className="video-price-btn">$20.00</a>
                    </div>
                </div>
            </div>
            );
    }
}
export default VideoComponent;