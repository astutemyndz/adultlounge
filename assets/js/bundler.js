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
  var updateQueryStringParam = function (key, value) {
    var baseUrl = [location.protocol, '//', location.host, location.pathname].join(''),
    urlQueryString = document.location.search,
    newParam = key + '=' + value,
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
   
  
}




