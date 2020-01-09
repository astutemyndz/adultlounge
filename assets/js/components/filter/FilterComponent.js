import QueryStringComponent from '../query_string/QueryStringComponent.js';

class FilterComponent {
    filterAttrs = null;
    _filterElements;
    key;
    value;
    qs;
    _context;
    apiURL;
    _renderFilterElement;
    state;
    assetsDirPath;
    baseURL;
    _app;
    _reload;
    constructor() {
        this.onInit();
        this.state = {};
        this.apiURL = this.qs.getBaseUrl() + 'api/v1';
        this.assetsDirPath = 'assets/';
        this.baseURL = this.qs.getBaseUrl();
        this._context = this;
        this.onload();
    }
    setState(value) {
        this.state = value;
        return this;
    }
    onInit() {
        this._filterElements = document.querySelectorAll('._filter');
        this._renderModelElement = document.querySelector('#_render_model_element');
        this._renderFilterElement = document.querySelector('#_render_filter_element');
        this._app = document.querySelector('._app');
        

        
        
        this.qs = new QueryStringComponent();
        
        this.onClickFilterElementEventHandler();
        
    }
    initReloadDOMCallBack() {
        this._reload = document.querySelector('#_reload');
    }
    reload() {
        this._reload.addEventListener('click', () => {
            console.log('fetching...');
            window.setTimeout(() => {
                this.onload();
                console.log('fetched');
            }, 500);
          });
    }
    onload() {
        window.addEventListener('load', (event) => {
            console.log('page is fully loaded');
          });

        this.fetchModels(this.apiURL + '/filter/model')
        .then(res => {
            if(res.data.length > 0) {
                this.setState({
                    models: res.data,
                });
                this._renderModelElement.innerHTML =  this.render();
                //this.initReloadDOMCallBack();
            } else{
                this._renderModelElement.innerHTML =  this.FilterEmptyComponent({_context: this, message: res.message});
            }
            
        })
    }
    setQueryString(key, value) {
        return this.qs.updateQueryStringParam(key, value);
    }
    queryStringToObject(str) {
        return this.qs.queryStringToJSObject(str);
    }
    objectToQueryString(obj) {
        return this.qs.jSObjectToQueryString(obj);
    }
    onClickFilterElementEventHandler() {
        let _context = this;
        const urlParams = new URLSearchParams(window.location.search);
        this._filterElements.forEach((filterElement) => {
            filterElement.addEventListener('click', function() {
                const queryString = _context.setQueryString(filterElement.getAttribute('data-key'),filterElement.getAttribute('data-value'));
                const params = _context.queryStringToObject(queryString);
                let paramsArr = [];
                for (const property in params) {
                    if(property != 'category') {
                        paramsArr.push({
                            key: property,
                            value: params[property],
                        })
                    }
                }
                  
                _context.fetchModels(_context.apiURL + '/filter/model?', params)
                .then(res => {
                    if(res.data.length > 0) {
                        _context.setState({
                            models: res.data,
                            tags: paramsArr,
                            category: (params.category) ? params.category: ''
                        });
                        _context._renderFilterElement.innerHTML =  _context.render();
                    } else{
                        _context._renderFilterElement.innerHTML =  _context.FilterEmptyComponent({_context: _context, message: res.message});
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

    render() {
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
        
        let _context = this;
        let heading = this.HeadingComponent({_context, category: 'All Girls Cams', totalModel: models.length});
        if(category) {
            heading = this.HeadingComponent({_context, category, totalModel: models.length});
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
        const {_context, message} = props;
        return (`<div class="main-heading"><h3>${message}<a href="javascript:void(0);"><img src="${_context.baseURL}${_context.assetsDirPath}images/icon-reload.png"></a> <span><a href="#">0 Models Found</a></span></h3></div>`)
    }
    HeadingComponent = (props) => {
        const {_context, category, totalModel} = props;
        return (`
            <div class="main-heading">
                <h3>${category.toUpperCase()} <a href="javascript:void(0);" id="_reload"><img src="${_context.baseURL}${_context.assetsDirPath}images/icon-reload.png"></a> <span><a href="#">${totalModel} Models Found </a></span></h3>
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
