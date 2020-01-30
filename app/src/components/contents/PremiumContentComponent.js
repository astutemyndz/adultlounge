// import React, { Component } from 'react'
// import ImageGalleryComponent from './ImageGalleryComponent';
// import VideoGalleryComponent from './VideoGalleryComponent';
// import EmptyGalleryComponent from './EmptyGalleryComponent';


// const PremiumContentComponent = (props) => {
//     const {videos, images} = props.premiumContents;
//     const options = {
//         videos: videos,
//         images: images,
//         visible: props.visible,
//         loadMore: props.loadMore,
//         lockIconPath: props.lockIconPath,
//         isFree: false
//     }
//     return(
//         <div className="user-content-block d-none" id="PremiumContent">
//             <div className="video-grid">
//                 <h4 className="free-image-heading">Premium Video</h4>
//                     {(videos.length > 0) ? <VideoGalleryComponent {...options}/> : <EmptyGalleryComponent/>}
//             </div>
//             <hr className="hr-devider" />
//             <div className="premium-video-area">
//                 <h4 className="free-image-heading">Premium Image</h4>
//                     {(images.length > 0) ? <ImageGalleryComponent {...options}/> : <EmptyGalleryComponent/>}
//             </div>
//         </div>
//     )
// }
// export default PremiumContentComponent;


import React, { Component } from 'react'
import ImageGalleryComponent from './ImageGalleryComponent';
import PremiumVideoGalleryComponent from './PremiumVideoGalleryComponent';
import EmptyGalleryComponent from './EmptyGalleryComponent';
import PremiumImageGalleryComponent from './PremiumImageGalleryComponent';
import GalleryComponent from './GalleryComponent';


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
    console.log('premium:',options);
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
