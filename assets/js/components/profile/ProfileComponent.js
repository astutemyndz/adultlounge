const _perform_typeEl = document.querySelector('#perform_type');
const _privatePriceEl = document.querySelector('#privatePriceEl');
const _groupPriceEl = document.querySelector('#groupPriceEl');

//_privatePriceEl.style.display = 'none';
//_groupPriceEl.style.display = 'none';
if(_perform_typeEl != null) {
    _perform_typeEl.addEventListener('change', function(e) {
        console.log();
         const v = e.target.value;
         if(v  === 'private') {
            _groupPriceEl.style.display = 'none';
            _privatePriceEl.style.display = 'block';
         } else {
            _privatePriceEl.style.display = 'none';
            _groupPriceEl.style.display = 'block';
         }
    }, false)
}
