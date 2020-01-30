import React, { Component } from 'react'
import FreeImageGalleryComponent from './FreeImageGalleryComponent';
import FreeVideoGalleryComponent from './FreeVideoGalleryComponent';
import EmptyGalleryComponent from './EmptyGalleryComponent';
import GalleryComponent from './GalleryComponent';


const FreeContentComponent = (props) => {
    const {videos, images} = props.freeContents;
    const options = {
        videos: videos,
        images: images,
        visible: props.freeVisible,
        loadMore: props.freeLoadMore,
        lockIconPath: props.lockIconPath,
        isFree: true,
    }
    return(
        <div className="user-content-block" id="FreeContent">
            <div className="video-grid">
                <h4 className="free-image-heading">Free Video</h4>
                    {(videos.length > 0) ? <FreeVideoGalleryComponent {...options}/> : <EmptyGalleryComponent message="This performer currently has no video."/>}
            </div>
            <hr className="hr-devider" />
            <div className="">
                <h4 className="free-image-heading">Free Image</h4>
                    {(images.length > 0) ? <FreeImageGalleryComponent {...options}/> : <EmptyGalleryComponent message="This performer currently has no photos."/>}
            </div>
        </div>
    )
}
export default FreeContentComponent;
