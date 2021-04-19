function modifyInner(id) {
    const elFormM = document.getElementById('formF');
    const elDescr = document.getElementById('line-'+id);
    const elDiv = document.getElementById('h-'+id);
    const elInput = document.getElementById('i-'+id);
    const elDn = document.getElementById('dn-'+id);
    const blur = document.getElementById('blur');
    const body = document.getElementsByTagName('body')[0];
    const action = window.location.origin+'/'+'adphoto';
    let top = parseInt(Math.abs(body.getBoundingClientRect().top));

    body.classList.add('overflow');
    blur.classList.remove('hide');
    blur.classList.add('blur');
    blur.setAttribute('style', 'top: '+top+'px;');
    elDescr.classList.add('showblock');
    elDescr.setAttribute('style', 'top: '+(top+300)+'px; z-index: 2;');
    elDn.setAttribute('name', 'dn');
    elDiv.classList.remove('hide');
    elDiv.setAttribute('style', 'z-index: 2');
    
    elFormM.setAttribute('action', action);
    elInput.setAttribute('name', 'pic');
    elInput.setAttribute('required', true);
}
function returnModify (id) {
    const elFormM = document.getElementById('formF');
    const elDescr = document.getElementById('line-'+id);
    const elDiv = document.getElementById('h-'+id);
    const elInput = document.getElementById('i-'+id);
    const elDn = document.getElementById('dn-'+id);
    const blur = document.getElementById('blur');
    const body = document.getElementsByTagName('body')[0];

    body.classList.remove('overflow');
    blur.classList.add('hide');
    blur.classList.remove('blur');
    blur.setAttribute('style', 'top: 0;');
    elDescr.classList.remove('showblock');
    elDescr.removeAttribute('style');
    elDn.removeAttribute('name');
    elDiv.removeAttribute('style');
    elDiv.classList.add('hide');
    
    elFormM.removeAttribute('action');
    elInput.removeAttribute('name');
    elInput.removeAttribute('required');
    //TODO
}
function sendPhoto() {
    document.getElementsByTagName('button')[0].classList.add('hide');
}
document.getElementById('formR').onclick = function(ev) {
    let target = ev.target;
    let targetId = target.getAttribute('app-data');
    if (targetId != null) {
        modifyInner(targetId);
    }
}
// el.forEach(function(oneEl) {
//     let p = oneEl.addEventListener("click", function(){modifyInner(2)}, false);
//     console.log(p);
// })