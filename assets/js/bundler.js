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
