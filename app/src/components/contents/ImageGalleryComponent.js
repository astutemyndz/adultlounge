import React from 'react'
import Masonry from 'react-masonry-component';
import ImageComponent from './ImageComponent';
import LoadMoreComponent from '../LoadMoreComponent';

const masonryOptions = {
    percentPosition: true,
    fitWidth: true,
    horizontalOrder: true
};

const ImageGalleryComponent = (props) => {
    const {visible, images, loadMore, lockIconPath} = props;
    let isFree = null;
    
    let _imageComponents = '';
    if(images) {
        _imageComponents = images.slice(0, visible).map(function(image, index) {
            if(image.subscribe) {
                isFree = true;
            } else {
                isFree = false;
            }
            return <ImageComponent key={index} lockIconPath={lockIconPath} subscribe={image.subscribe} isFree={isFree} image={image}/>
        });
    }
    return (
        <React.Fragment>
            <Masonry
                    className={'grid masonary-ul'}
                    elementType={'ul'}
                    options={masonryOptions}
            >
                {_imageComponents}
            </Masonry>  
            {visible < images.length &&
                <LoadMoreComponent loadMore={loadMore}/>
            }
        </React.Fragment>
    )
}
export default ImageGalleryComponent;
