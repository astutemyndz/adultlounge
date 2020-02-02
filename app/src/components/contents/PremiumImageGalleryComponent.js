import React from 'react'
import Masonry from 'react-masonry-component';
import ImageComponent from './ImageComponent';
import LoadMoreComponent from '../LoadMoreComponent';
import LoaderHOC from '../hoc/LoaderHOC';
import Lightbox from 'react-image-lightbox';
import 'react-image-lightbox/style.css';
const masonryOptions = {
    percentPosition: true,
};

class PremiumImageGalleryComponent extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
          isOpen: false,
          photoIndex: 0,
        };
        this.openLightbox = this.openLightbox.bind(this);
    }
    openLightbox(index, event) {
        event.preventDefault();
        this.setState({
            photoIndex: index,
            isOpen: true,
        });
    }
    
    renderGallery() {
        const {visible, images, loadMore, lockIconPath} = this.props;
        let _imageComponents = '';
        let self = this;
        if(images) {
            _imageComponents = images.slice(0, visible).map(function(image, index) {
                return(
                     <ImageComponent key={index} _propOpenLightbox={self.openLightbox} index={index}  lockIconPath={lockIconPath} subscribe={image.subscribe} isFree={(image.subscribe) ? true : false} image={image}/>
                )
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

    render() {
        const { photoIndex, isOpen } = this.state;
        const {images} = this.props;
        let _images = [];
        if(images) {
            _images = images.map(function(img) {
                return img.imagePath;
            })
        }
        return(
            <div>
	           {this.renderGallery()}
               {isOpen && (
                <Lightbox
                    mainSrc={_images[photoIndex]}
                    nextSrc={_images[(photoIndex + 1) % _images.length]}
                    prevSrc={_images[(photoIndex + _images.length - 1) % _images.length]}
                    onCloseRequest={() => this.setState({ isOpen: false })}
                    onMovePrevRequest={() =>
                        this.setState({
                            photoIndex: (photoIndex + _images.length - 1) % _images.length,
                        })
                    }
                    onMoveNextRequest={() =>
                        this.setState({
                            photoIndex: (photoIndex + 1) % _images.length,
                        })
                    }
                />
                )}
            </div>
            
        )
    }

}
export default LoaderHOC('images')(PremiumImageGalleryComponent)