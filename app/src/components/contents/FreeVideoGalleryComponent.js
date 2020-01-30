import React from 'react'
import LoadMoreComponent from '../LoadMoreComponent';
import VideoComponent from './VideoComponent';

const FreeVideoGalleryComponent = (props) => {
    const {visible, videos, loadMore,lockIconPath} = props;
    let _videoComponents = '';
    if(videos) {
        _videoComponents = videos.slice(0, visible).map(function(video, index) {
            return <VideoComponent key={index} lockIconPath={lockIconPath} isFree={(video.subscribe) ? false : true} subscribe={video.subscribe} video={video}/>
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
export default FreeVideoGalleryComponent;
