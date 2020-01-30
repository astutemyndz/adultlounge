import React from 'react'
import LoadMoreComponent from '../LoadMoreComponent';
import VideoComponent from './VideoComponent';

const PremiumVideoGalleryComponent = (props) => {
    const {visible, videos, loadMore,lockIconPath} = props;
    let _videoComponents = '';
    if(videos) {
        _videoComponents = videos.slice(0, visible).map(function(video, index) {
            return <VideoComponent key={index} lockIconPath={lockIconPath} isFree={(video.subscribe) ? true : false} subscribe={video.subscribe} video={video}/>
        });
    }
    return (
            <React.Fragment>
                {_videoComponents}
                {visible < videos.length &&
                    <LoadMoreComponent loadMore={loadMore}/>
                }
            </React.Fragment>
    )
}
export default PremiumVideoGalleryComponent;
