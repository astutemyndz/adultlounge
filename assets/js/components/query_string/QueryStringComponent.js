export default class QueryStringComponent {
    qs = {};
    s = null;
    qsParts;
    _baseUrl;
    _urlQueryString;
    _newParam;
    _params;
    _updateRegex;
    _removeRegex;
    constructor() {}
    onInit() {
        this.qs = {};
        this.s = location.search.replace( /^\?|#.*$/g, '' );
        if(this.s) {
            this.qsParts = this.s.split('&');
            var i, nv;
            for (i = 0; i < this.qsParts.length; i++) {
                nv = this.qsParts[i].split('=');
                this.qs[nv[0]] = nv[1];
            }
        }
    }
    add(name, value ) {
        if( arguments.length == 1 && arguments[0].constructor == Object ) {
            this.addMany( arguments[0] );
            return;
        }
        this.qs[name] = value;
    }
    addMany( newValues ) {
        for( nv in newValues ) {
            this.qs[nv] = newValues[nv];
        }
    }
    remove( name ) {
        if( arguments.length == 1 && arguments[0].constructor == Array ) {
            this.removeMany( arguments[0] );
            return;
        }
        delete this.qs[name];
    }
    removeMany( deleteNames ) {
        var i;
        for( i = 0; i < deleteNames.length; i++ ) {
            delete this.qs[deleteNames[i]];
        }
    }
    getQueryString() {
        var nv, q = [];
        for( nv in this.qs ) {
            q[q.length] = nv+'='+this.qs[nv];
        }
        return q.join( '&' );
    }
    toString() {
        return this.getQueryString;
    }
    addOrReplaceParam(param, value) {
        param = encodeURIComponent(param);
        var r = "([&?]|&amp;)" + param + "\\b(?:=(?:[^&#]*))*";
        var a = document.createElement('a');
        var regex = new RegExp(r);
        var str = param + (value ? "=" + encodeURIComponent(value) : ""); 
        a.href = this.basUrl;
        var q = a.search.replace(regex, "$1"+str);
        if (q === a.search) {
           a.search += (a.search ? "&" : "") + str;
        } else {
           a.search = q;
        }
        return a.href;
     }
     updateQueryStringParam(key, value) {
        this._baseUrl = [location.protocol, '//', location.host, location.pathname].join('');
        this._urlQueryString = document.location.search;
        this._newParam = key + '=' + value;
        this._params = '?' + this._newParam;
      
        // If the "search" string exists, then build params from it
        if (this._urlQueryString) 
        {
          this._updateRegex = new RegExp('([\?&])' + key + '[^&]*');
          this._removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');
      
          if( typeof value == 'undefined' || value == null || value == '' ) { // Remove param if value is empty
      
              this._params = this._urlQueryString.replace(this._removeRegex, "$1");
              this._params = this._params.replace( /[&;]$/, "" );
      
          } else if (this._urlQueryString.match(this._updateRegex) !== null) { // If param exists already, update it
      
              this._params = this._urlQueryString.replace(this._updateRegex, "$1" + this._newParam);
      
          } else { // Otherwise, add it to end of query string
      
              this._params = this._urlQueryString + '&' + this._newParam;
      
          }
        }
        window.history.replaceState({}, "", this._baseUrl + this._params);
        return this._params;
      }

      getBaseUrl() {
          return this._baseUrl = [location.protocol, '//', location.host, location.pathname].join('');
      }
    jSObjectToQueryString(obj) {
        var str = [];
        for (var p in obj)
          if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
          }
        return str.join("&");
      }
    queryStringToJSObject(queryString) {
        const urlParams = new URLSearchParams(queryString);
        const entries = urlParams.entries();
        const params = Object.fromEntries(entries);
        return params;
    }
    test() {
        console.log(1);
    }

    baseUrl() {
        return window.location.origin;
    }
     
}


/*


    //examples
    //instantiation
    var qs = new QS;
    alert( qs );
    
    //add a sinle name/value
    qs.add( 'new', 'true' );
    alert( qs );
    
    //add multiple key/values
    qs.add( { x: 'X', y: 'Y' } );
    alert( qs );
    
    //remove single key
    qs.remove( 'new' )
    alert( qs );
    
    //remove multiple keys
    qs.remove( ['x', 'bogus'] )
    alert( qs );
    */