import React, { Component } from 'react'
import PremiumVideoGalleryComponent from './PremiumVideoGalleryComponent';
import EmptyGalleryComponent from './EmptyGalleryComponent';
import PremiumImageGalleryComponent from './PremiumImageGalleryComponent';


const PremiumContentComponent = (props) => {
    const {videos, images} = props.premiumContents;
    const options = {
        videos: videos,
        images: images,
        visible: props.premiumVisible,
        loadMore: props.premiumLoadMore,
        lockIconPath: props.lockIconPath,
        isFree: false
    }
    return(
        <div className="user-content-block d-none" id="PremiumContent">
            <div className="video-grid">
                <h4 className="free-image-heading">Premium Video</h4>
                    {(videos.length > 0) ? <PremiumVideoGalleryComponent {...options}/> : <EmptyGalleryComponent message="This performer currently has no video."/>}
            </div>
            <hr className="hr-devider" />
            <div className="premium-lock-image">
                <h4 className="free-image-heading">Premium Image</h4>
                    {(images.length > 0) ? <PremiumImageGalleryComponent {...options}/> : <EmptyGalleryComponent message="This performer currently has no photos."/>}
            </div>
        </div>
    )
}
export default PremiumContentComponent;
