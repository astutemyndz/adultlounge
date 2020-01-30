import React, { Component } from 'react'
import axios from 'axios';
import FreeContentComponent from './FreeContentComponent'
import PremiumContentComponent from './PremiumContentComponent'

export default class ContentComponent extends Component {
    constructor(props) {
        super(props);
        this.state = {
            freeContents: {
                images: [],
                videos: [],
            },
            premiumContents: {
                images: [],
                videos: [],
            },
            freeVisible: 8,
            premiumVisible: 8,
            error: false,
            lockIconPath: '',
            isFree: null,
        }
        //this.loadMore = this.loadMore.bind(this);
    }
    freeLoadMore = () => {
        this.setState((prev) => {
          return {freeVisible: prev.freeVisible + 4};
        });
    }
    premiumLoadMore = () => {
        this.setState((prev) => {
          return {premiumVisible: prev.premiumVisible + 4};
        });
    }
    componentDidMount() {
        const self = this;
        axios.get(API_URL + `performer/contents?customer_id=${customerID}&performer_id=${performerID}`)
        .then(function (response) {
            const data = response.data;
            if(data) {
                self.setState({
                    ...self.state,
                    freeContents: data.freeContents,
                    premiumContents: data.premiumContents,
                    freeLoadMore: self.freeLoadMore,
                    premiumLoadMore: self.premiumLoadMore,
                    lockIconPath: data.lockIconPath
                });
            }
        })
        .catch(function (error) {
            self.setState({
                error: true
            });
        });
    }
    render() {
        return (
            <div>
                <FreeContentComponent {...this.state}/>
                <PremiumContentComponent {...this.state}/>
            </div>
        )
    }
}
