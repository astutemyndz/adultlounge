import QueryStringComponent from '../query_string/QueryStringComponent.js';

class FilterComponent extends QueryStringComponent {
    filterAttrs = null;
    _filterElements;
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
        this.onInitDOM();
        this.state          = {};
        this.api         = this.getBaseUrl() + 'api/v1';
        this.assetsDirPath  = 'assets/';
        this.baseURL        = this.getBaseUrl();
       
        

        this.onClickFilterElementEventHandler   = this.onClickFilterElementEventHandler.bind(this);
        this.FilterEmptyComponent               = this.FilterEmptyComponent.bind(this);
        this.HeadingComponent                   = this.HeadingComponent.bind(this);
        this.render                             = this.render.bind(this);
        this.reload                             = this.reload.bind(this);
        this.setQueryString                     = this.setQueryString.bind(this);
        this.objectToQueryString                = this.objectToQueryString.bind(this);
        this.onInitDOM                          = this.onInitDOM.bind(this);
        this.onload                             = this.onload.bind(this);
    }

   
    setState = (value) => {
        this.state = value;
        return this;
    }
    onInitDOM = () => {
        this._filterElements                = document.querySelectorAll('._filter');
        this._renderModelElement            = document.querySelector('#_render_model_element');
        this._renderFilterElement           = document.querySelector('#_render_filter_element');
        this._app                           = document.querySelector('._app');
        this.onload();
        this.reload();
        
    }
    initReloadDOMCallBack() {
        //this._reload = document.querySelector('#_reload');
    }
    reload = () => {
        //Event Delegation 
        this._renderModelElement.addEventListener('click', (e) => {
            console.log('fetching...');
            if(!e.target.matches('#reload')) {
                console.log(e.target);
            }  else {
                console.log(event.currentTarget);
                window.setTimeout(() => {
                    this.onload();
                    console.log('fetched');
                }, 200);
            }
        })
    }
    onload = () => {
        const _context = this;

        console.log(_context.getBaseUrl());
        window.addEventListener('load', (event) => {
            console.log('page is fully loaded');
          });

        this.fetchModels(_context.api + '/filter/model')
        .then(res => {
            if(res.data.length > 0) {
                this.setState({
                    models: res.data,
                });
                this._renderModelElement.innerHTML =  this.render();
            } else{
                this._renderModelElement.innerHTML =  this.FilterEmptyComponent({message: res.message});
            }
            
        })
    }
    setQueryString = (key, value) => this.updateQueryStringParam(key, value);
    
    queryStringToObject = (str) => this.queryStringToJSObject(str);

    objectToQueryString = (obj) =>  this.jSObjectToQueryString(obj);
    
    onClickFilterElementEventHandler = () => {
        this._filterElements.forEach((filterElement) => {
            filterElement.addEventListener('click', function() {
                const queryString = this.setQueryString(filterElement.getAttribute('data-key'),filterElement.getAttribute('data-value'));
                const params = this.queryStringToObject(queryString);
                let paramsArr = [];
                for (const property in params) {
                    if(property != 'category') {
                        paramsArr.push({
                            key: property,
                            value: params[property],
                        })
                    }
                }
                  
                this.fetchModels(this.api + '/filter/model?', params)
                .then(res => {
                    if(res.data.length > 0) {
                        this.setState({
                            models: res.data,
                            tags: paramsArr,
                            category: (params.category) ? params.category: ''
                        });
                        this._renderFilterElement.innerHTML =  this.render();
                    } else{
                        this._renderFilterElement.innerHTML =  this.FilterEmptyComponent({message: res.message});
                    }
                    
                })
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
        const {models, tags, category} = this.state;
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
        return(
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
    }
    FilterEmptyComponent = (props) => {
        const {message} = props;
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
    TagComponent = (props) => (`<li>${props.value.toUpperCase()} <a href="javascript:void(0);" ><i class="fa fa-times-circle" aria-hidden="true"></i></a></li>`);
    
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
                    <h4><span class="active-circle"></span><a href="javascript:void(0)">${display_name}</a></h4>
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
