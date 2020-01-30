import React from 'react'

export default function LoadMoreComponent(props) {
    
    return (
        <div className="load-more-btn">
            <a href="javascript:void(0);" onClick={props.loadMore} className="btn-load-more">Load More...</a>
        </div>
    )
}
