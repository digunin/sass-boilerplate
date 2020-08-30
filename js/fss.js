const byID = function(id){
    return document.getElementById(id);
}

var current = +localStorage.getItem(pageName+'currentSection')||0;
var sectionCount = 0;
var wheelDelay = false;

const fssOnClick = function(n){
    if(n==current) return;
    moveTo(n);
}

const moveTo = function(index) {
    setCurrentSection(index);
    current = index;
    localStorage.setItem(pageName+'currentSection', current);
    if(pageName == "index-"){
        let callback_widget = document.getElementsByClassName('bazz-widget')[0];
        if(!callback_widget) return;
        if(current > 0 && current < 4){
            callback_widget.style.display = "none";
            console.log(callback_widget);
        }else{
            callback_widget.style.display = "block";
        }
    }
}

const setCurrentSection = function(n){
    let buttons = document.getElementsByClassName('fss-button');
    sectionsNames.map(function(name, i){
        let section = byID(name);
        let btn = buttons[i];
        i<n ? setPrevious(section) : (i==n ? setActive(section) : setNext(section));
        i==n ? btn.classList.add('active') : btn.classList.remove('active');
    })
}

const setPrevious = function(elem){
    elem.classList.remove('active-section');
    elem.classList.remove('next-section');
    if(!elem.classList.contains('previous-section')) elem.classList.add('previous-section');
}
const setActive = function(elem){
    elem.classList.remove('previous-section');
    elem.classList.remove('next-section');
    if(!elem.classList.contains('active-section')) elem.classList.add('active-section');
    elem.classList.add('active-section');
}
const setNext = function(elem){
    elem.classList.remove('previous-section');
    elem.classList.remove('active-section');
    if(!elem.classList.contains('next-section')) elem.classList.add('next-section');
}

// const setCurrentButton = function(n){
//     let buttons = document.getElementsByClassName('fss-button');
//     console.log(`current = ${current}`);
//     for(let i=0; i<sectionCount;i++){
//         let elem = buttons[i];
//         i==current ? elem.classList.add('active') : elem.classList.remove('active');
//     }
// }

const keyHandler = function(event){
    if(event.code == "ArrowDown"||event.code == "ArrowRight"){
        current<sectionCount-1&&moveToNext();
    }
    if(event.code == "ArrowUp"||event.code == "ArrowLeft"){
        current>0&&moveToPrevious();
    }
}

const moveToNext = function(){
    moveTo(current+1);
}

const moveToPrevious = function(){
    moveTo(current-1);
}

const wheelHandler = function(event){
    if(wheelDelay) return;
    if(event.deltaY < 0){
        current>0&&moveToPrevious();
    }else{
        current<sectionCount-1&&moveToNext();
    }
    wheelDelay = true;
    setTimeout(function(){wheelDelay = false}, 400);
}

window.onload = function(){
    sectionCount = sectionsNames.length;
    document.body.addEventListener("keyup", keyHandler);
    document.body.addEventListener("wheel", wheelHandler);
    moveTo(current);
}