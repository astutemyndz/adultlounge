import QueryStringComponent from '../query_string/QueryStringComponent.js';

class FilterComponent extends QueryStringComponent {
    filterAttrs = null;
    _filterElements;
    _shortListingElements;
    key;
    value;
    queryStringInstance;
    _renderFilterElement;
    state;
    assetsDirPath;
    baseURL;
    _app;
    api;
    _context;
    constructor() {
        super();
        this.setState({
            models: [],
            tags: [],
            category: null,
            message: null,
            paramsArr: [],
            params: {},
            isLoading: false,
        })
        this.onInitDOM();
        
        this.api         = this.getBaseUrl() + 'api/v1';
        this.assetsDirPath  = 'assets/';
        this.baseURL        = this.getBaseUrl();
       
        
        

        // this.onClickFilterElementEventHandler   = this.onClickFilterElementEventHandler.bind(this);
        // this.FilterEmptyComponent               = this.FilterEmptyComponent.bind(this);
        // this.HeadingComponent                   = this.HeadingComponent.bind(this);
        // this.render                             = this.render.bind(this);
        // this.reload                             = this.reload.bind(this);
        // this.setQueryString                     = this.setQueryString.bind(this);
        // this.objectToQueryString                = this.objectToQueryString.bind(this);
        // this.onInitDOM                          = this.onInitDOM.bind(this);
        //this.onload                             = this.onload.bind(this);
    }

   
    setState = (obj) => {
        this.state = obj;
        return this;
    }
    onInitDOM = () => {
        this._filterElements                = document.querySelectorAll('._filter');
        this._renderModelElement            = document.querySelector('#_render_model_element');
        this._renderFilterElement           = document.querySelector('#_render_filter_element');
        this._app                           = document.querySelector('._app');
        this._shortListingElements                  = document.querySelector('._tag');

        
        this.componentDidMount();
        
        this.onClickFilterElementEventHandler();
        //this.onClickRemoveTagElementEventHandler();
        //this.reload();
        
    }
    initReloadDOMCallBack() {
        //this._reload = document.querySelector('#_reload');
    }
    reload = () => {

        //Event Delegation 
        
        this._app.addEventListener('click', (e) => {
            console.log(this);
            if(e.target.matches('_tag')) {
                console.log(event.currentTarget);
                window.setTimeout(() => {
                    this.componentDidMount();
                    console.log('fetched');
                }, 200);
            }  else {
                console.log(event.currentTarget);
                
            }
        })
    }
    WithLoading(component) {
        return function WihLoadingComponent({ isLoading, ...props }) {
          if (!isLoading) return component();
          return (`<p>Be Hold, fetching data may take some time :)</p>`);
        }
    }
    componentDidMount = () => {
        const {paramsArr, params} = this.state;
        this.fetchModels('http://localhost/adultlounge/api/v1/filter/model')
        .then(res => {
            if(res.data.length > 0) {
                this.setState({
                    ...this.state,
                    models: res.data,
                    tags: paramsArr,
                    category: (params.category) ? params.category: '',
                    message: ''
                });
                
                this.render();
            } else {
                this.setState({
                    ...this.state,
                    models: [],
                    tags: [],
                    category: '',
                    message: res.message
                })
                this.render();
            }
            console.log('componentDidMount',this.state);
        })
        
    }
    componentDidUpdate = () => {
        
        const {paramsArr, params} = this.state;
        this.fetchModels('http://localhost/adultlounge/api/v1/filter/model?', params)
        .then(res => {
            if(res.data.length > 0) {
                this.setState({
                    ...this.state,
                    models: res.data,
                    tags: paramsArr,
                    category: (params.category) ? params.category: '',
                    message: ''
                });
                
                this.render();
            } else {
                this.setState({
                    ...this.state,
                    models: [],
                    tags: [],
                    category: '',
                    message: res.message
                })
                this.render();
            }
            console.log('componentDidUpdate',this.state);
        })
    }

    
    setQueryString = (key, value) => this.updateQueryStringParam(key, value);
    
    queryStringToObject = (str) => this.queryStringToJSObject(str);

    objectToQueryString = (obj) =>  this.jSObjectToQueryString(obj);
    
    onClickFilterElementEventHandlerCallBack = () => {
        
    }
    onClickFilterElementEventHandler = (e) => {
        var self = this;
        this._filterElements.forEach((filterElement) => {
            filterElement.addEventListener('click', function() {
                const queryString = self.setQueryString(filterElement.getAttribute('data-key'),filterElement.getAttribute('data-value'));
                const params = self.queryStringToObject(queryString);
                let paramsArr = [];
                for (const property in params) {
                    if(property != 'category') {
                        paramsArr.push({
                            key: property,
                            value: params[property],
                        })
                    }
                }
                self.setState({
                    ...self.state,
                    paramsArr: paramsArr,
                    params: params,
                })
                //console.log(self.state);
                self.componentDidUpdate();
                self.render();
            });
        })
    }
    onClickRemoveTagElementEventHandler = (e) => {
        var self = this;
        this._shortListingElements.forEach((shortListingElement) => {
            shortListingElement.addEventListener('click', function() {
                if(e.target.matches('_tag')) {
                    console.log(1);
                }
                // const queryString = self.setQueryString(filterElement.getAttribute('data-key'),filterElement.getAttribute('data-value'));
                // const params = self.queryStringToObject(queryString);
                // let paramsArr = [];
                // for (const property in params) {
                //     if(property != 'category') {
                //         paramsArr.push({
                //             key: property,
                //             value: params[property],
                //         })
                //     }
                // }
                // self.setState({
                //     ...self.state,
                //     paramsArr: paramsArr,
                //     params: params,
                // })
                // self.componentDidUpdate();
                // self.render();
            });
        })
    }
    async fetchModels(url, params) {
        const objToQueryString = this.objectToQueryString(params);
        let response = await fetch(`${url}${objToQueryString}`);
        let data = await response.json()
        return data;
    }

    render = () => {
        var self = this;
        const {models, tags, category, params} = self.state;
        const items = []
        const _tags = [];

        if(models) {
            models.map((model) => items.push(this.ItemComponent(model)));
        }

        if(tags) {
            tags.map((tag) => {
                if(tag.value.length > 0) {
                    _tags.push(this.TagComponent(tag));
                }
            });
        }
        let heading = this.HeadingComponent({category: 'All Girls Cams', totalModel: models.length});
        if(category) {
            heading = this.HeadingComponent({category, totalModel: models.length});
        } 
        if(Object.keys(params).length > 0) {
            if(models.length > 0) {
                this._renderFilterElement.innerHTML =  (
                    `<div class="list-widget">
                        ${heading}
                        <div class="shorting-list">
                            <ul>
                                ${_tags}
                            </ul>
                        </div>
                        <div class="col gridview">
                            ${items}
                        </div>
                    </div>`
                    );
            } else {
                this._renderFilterElement.innerHTML =  this.FilterEmptyComponent();
            }
        } else {
            if(models.length > 0) {
                this._renderModelElement.innerHTML =  (
                    `<div class="list-widget">
                        ${heading}
                        <div class="shorting-list">
                            <ul>
                                ${_tags}
                            </ul>
                        </div>
                        <div class="col gridview">
                            ${items}
                        </div>
                    </div>`
                    );
            } else {
                this._renderModelElement.innerHTML =  this.FilterEmptyComponent();
            }
        }

        
        
        
        
        
    }
    FilterEmptyComponent = () => {
        const {message} = this.state;
        return (`<div class="main-heading"><h3>${message}<a href="javascript:void(0);"><img src="${this.baseURL}${this.assetsDirPath}images/icon-reload.png"></a> <span><a href="#">0 Models Found</a></span></h3></div>`)
    }
    HeadingComponent = (props) => {
        const {category, totalModel} = props;
        return (`
            <div class="main-heading">
                <h3>${category.toUpperCase()} <a href="javascript:void(0);" id="reload"><img src="${this.baseURL}${this.assetsDirPath}images/icon-reload.png"></a> <span><a href="#">${totalModel} Models Found </a></span></h3>
            </div>
        `);
    }
    TagComponent = (props) => (`<li class="_tag" data-key="${props.key}" data-value="${props.value}">${props.value.toUpperCase()} <a href="javascript:void(0);" ><i class="fa fa-times-circle" aria-hidden="true"></i></a></li>`);
    
    ItemComponent(props) {
        const {id, name,slug, display_name, price_in_private, price_in_group, img} = props;
        let performType;
        //const performType = (price_in_private && price_in_private != '0.00') ? 'In Private' : (price_in_group && price_in_group != '0.00') ? 'In Group' : 'In Private';
        if(price_in_private && price_in_private != '0.00') {
            performType = 'In Private';
        }
        if(price_in_group && price_in_group != '0.00') {
            performType = 'In Group';
        }
        return(`
        <div class="col-grid">
            <figure class="active">
                <span class="strapbox">${performType}</span>
                <a href="performer/${id}/${slug}"><img src="${img}" alt="${display_name}" /></a>
                <figcaption>
                    <h4><span class="active-circle"></span><a href="performer/${id}/${slug}">${display_name}</a></h4>
                    <ul>
                        <li>PRIVATE: <span>£${price_in_private}</span> p/m</li>
                        <li>GROUP: <span>£${price_in_group}</span> p/M</li>
                    </ul>
                </figcaption>
            </figure>
        </div>
        `);
    }
   

}
new FilterComponent();
