"use strict";

$(document).ready(function () {
  
  var engine, remoteHost, template, empty;
  $.support.cors = true;
  remoteHost = API_URL;
  template = Handlebars.compile($("#result-template").html());
  empty = Handlebars.compile($("#empty-template").html());
  engine = new Bloodhound({
    identify: function identify(o) {
      return o.id_str;
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name', 'profile_image_url_https'),
    dupDetector: function dupDetector(a, b) {
      return a.id_str === b.id_str;
    },
    prefetch: remoteHost + '/search/model',
    remote: {
      url: remoteHost + '/search/model/?q=%QUERY',
      wildcard: '%QUERY'
    }
  }); // ensure default users are read on initialization

  engine.get('1090217586', '58502284', '10273252', '24477185');

  function engineWithDefaults(q, sync, async) {
    if (q === '') {
      sync(engine.get('1090217586', '58502284', '10273252', '24477185'));
      async([]);
    } else {
      engine.search(q, sync, async);
    }
  }

  $('#demo-input').typeahead({
    hint: $('.Typeahead-hint'),
    menu: $('.Typeahead-menu'),
    minLength: 0,
    classNames: {
      open: 'is-open',
      empty: 'is-empty',
      cursor: 'is-active',
      suggestion: 'Typeahead-suggestion',
      selectable: 'Typeahead-selectable'
    }
  }, {
    source: engineWithDefaults,
    displayKey: 'name',
    templates: {
      suggestion: template,
      empty: empty
    }
  }).on('typeahead:asyncrequest', function () {
    $('.Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function () {
    $('.Typeahead-spinner').hide();
  }).on('typeahead:select', function (event, suggestion) {
    console.log(suggestion);
        //var slug = suggestion.name;
        window.location.href = "".concat(base_url, "performer/").concat(suggestion.id, "/").concat(suggestion.slug, "/");
  });

  const filterButton = document.querySelector('#filterButton');
  console.log(filterButton);
    
  
  
});


function onClickFilterEventHandler(key, value) {
 /*
  var params;
  var updateQueryStringParam = function (key, value) {
    var baseUrl = [location.protocol, '//', location.host, location.pathname].join(''),
    urlQueryString = document.location.search,
    newParam = key + '=' + value;
    params = '?' + newParam;
  
    // If the "search" string exists, then build params from it
    if (urlQueryString) 
    {
      var updateRegex = new RegExp('([\?&])' + key + '[^&]*');
      var removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');
  
      if( typeof value == 'undefined' || value == null || value == '' ) { // Remove param if value is empty
  
          params = urlQueryString.replace(removeRegex, "$1");
          params = params.replace( /[&;]$/, "" );
  
      } else if (urlQueryString.match(updateRegex) !== null) { // If param exists already, update it
  
          params = urlQueryString.replace(updateRegex, "$1" + newParam);
  
      } else { // Otherwise, add it to end of query string
  
          params = urlQueryString + '&' + newParam;
  
      }
    }
    window.history.replaceState({}, "", baseUrl + params);
  }
  updateQueryStringParam(key, value);
  var $ListWidget = document.querySelector('#Filter');
  
  fetch(API_URL + '/filter/model' + params)
  .then((response) => {
    return response.json();
  })
  .then((myJson) => {
    
    var data = myJson.data;
    //console.log(data);
    const urlParams = new URLSearchParams(window.location.search);
    if(data.length > 0) {
      $ListWidget.innerHTML = FilterListWidgetComponent({
        models: data,
        params:  [
          {key: 'performer',  title: (urlParams.has('performer'))?urlParams.get('performer') : ''},
          {key: 'category',   title: (urlParams.has('category'))?urlParams.get('category') : ''},
          {key: 'show_type',  title: (urlParams.has('show_type'))?urlParams.get('show_type') : ''},
          {key: 'age',        title: (urlParams.has('age'))?urlParams.get('age') : ''},
          {key: 'willingness',title: (urlParams.has('willingness'))?urlParams.get('willingness') : ''},
          {key: 'appearance', title: (urlParams.has('appearance'))?urlParams.get('appearance') : ''}
        ]
      });
    } else {
      $ListWidget.innerHTML = FilterEmptyComponent({message: myJson.message});
    }
  });
  */
}
/*
const FilterEmptyComponent = (props) => (`<h4>${props.message}</h4>`)
const FilterHeadingComponent = (props) => (` <div class="main-heading">
<h3>BBW <a href="#"><img src="`+base_url+`assets/images/icon-reload.png"></a> <span><a href="#">703 members</a></span></h3>
</div>`);
const FilterAttributeComponent = (props) => (`<div class="shorting-list">
<ul>
`+
  props.params.map(function(param) {
    if(param.title) {
      return `<li>`+param.title+`<a href="javascript:void(0);" onclick="onClickFilterEventHandler('`+param.key+`', '`+param.title+`');"><i class="fa fa-times-circle" aria-hidden="true"></i></a></li>`;
    }
    
  })
+`
</ul>
</div>`);
const FilterGridViewComponent = (props) => {
  const {models} = props;
  return(
  `<div class="col gridview">`+
    models.map(function(model) {
      return ModelComponent(model)
    })
  +`</div>`
  );
};

const FilterListWidgetComponent  = (props) => (
  `<div class="list-widget">
    `+FilterHeadingComponent(props)+`
    `+FilterAttributeComponent(props)+`
    `+FilterGridViewComponent(props)+`
  </div>`
  );
const ModelComponent = (props) => {
  return(`
  <div class="col-grid">
              <figure class="active">
                  <span class="strapbox">In Group</span>
                  <a href="#"><img src="${props.img}" alt="img" /></a>
                  <figcaption>
                      <h4><span class="active-circle"></span><a href="javascript:void(0)">${props.display_name}</a></h4>
                      <ul>
                          <li>PRIVATE: <span>${props.currency}${props.price_in_private}</span> p/m</li>
                          <li>GROUP: <span>${props.currency}${props.price_in_group}</span> p/M</li>
                      </ul>
                  </figcaption>
              </figure>
          </div>
  `);
}



*/