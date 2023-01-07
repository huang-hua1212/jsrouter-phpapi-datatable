var ajax = new XMLHttpRequest();
ajax.open("GET", `./views/mainPage/mainPage.html`, false);
ajax.send();

class MainPage {
    
    constructor() {
        this._template = ajax.responseText;
    }
    getTemplate() {
        return Object.getOwnPropertyNames(this);
    }
    get template() {
        return  this._template;
    }
  
    set template(c) {
        this._template = ajax.responseText;
    }
    init() {
        $('#next').on('click', (e) => {
            console.log('main page click success!!!');
            window.routerInstance.navigate({ name: 'posts-page' })
            // window.routerInstance.navigate('posts-page');
        })
    }
}


export default MainPage;