// hash routing-render

import router from '../../router/index.js';

class RoutingRender extends HTMLElement {
    
    constructor() {
        super();
        
    }
    connectedCallback() {
        this.onInit_();
    }
    onInit_() {
        // only hash
        window.onhashchange = (currentHash) => this.onHasChange(currentHash);
        this.renderView_(router);
        window.addHistoryListener('history', ()=>{
            console.log('窗口的history改变了');
            const router = window.routerInstance;
            this.renderView_(router);
        })
    }
    onHasChange(currentHash){
        let router = window.routerInstance;
        this.renderView_(router);
    }
    renderView_(router) {
        console.log(router);
        // history and hash success
        if(router.mode == 'hash'){
            console.log(window.location.hash);
            console.log(router.routes)
            var cur_route = router.routes.find(element => {
                return element.path == null? (''== window.location.hash) : ('#'+element.path) == window.location.hash;
            });
            console.log(cur_route);
        }else {
            console.log(router);
            console.log(window.location.pathname);
            var cur_route = router.routes.find(element => {
                return element.path == null? (router.root  == window.location.pathname) : (router.root+'/'+element.path) == window.location.pathname;
            });
        }
        // only hash success
        // var cur_route = router.routes.find(element => {
        //     return element.path == null? ('/'== window.location.pathname) : ('#'+element.path) == window.location.hash;
        // });

        var rou_ins = new cur_route.class();
        // let array = Object.getOwnPropertyNames(rou_ins);
        this.innerHTML = rou_ins.template;

        rou_ins.init();
    }
}




//////////////////////////////
class Dep {                  // 订阅池
    constructor(name){
        this.id = new Date() //这里简单的运用时间戳做订阅池的ID
        this.subs = []       //该事件下被订阅对象的集合
    }
    defined(){              // 添加订阅者
        Dep.watch.add(this);
    }
    notify() {              //通知订阅者有变化
        this.subs.forEach((e, i) => {
            if(typeof e.update === 'function'){
                try {
                   e.update.apply(e)  //触发订阅者更新函数
                } catch(err){
                    console.warr(err)
                }
            }
        })
    }
    
}
Dep.watch = null;

class Watch {
    constructor(name, fn){
        this.name = name;       //订阅消息的名称
        this.id = new Date();   //这里简单的运用时间戳做订阅者的ID
        this.callBack = fn;     //订阅消息发送改变时->订阅者执行的回调函数     
    }
    add(dep) {                  //将订阅者放入dep订阅池
       dep.subs.push(this);
    }
    update() {                  //将订阅者更新方法
        var cb = this.callBack; //赋值为了不改变函数内调用的this
        cb(this.name);          
    }
}

var addHistoryMethod = (function(){
        var historyDep = new Dep();
        return function(name) {
            if(name === 'historychange'){
                return function(name, fn){
                    var event = new Watch(name, fn)
                    Dep.watch = event;
                    historyDep.defined();
                    Dep.watch = null;       //置空供下一个订阅者使用
                }
            } else if(name === 'pushState' || name === 'replaceState') {
                var method = history[name];
                return function(){
                    method.apply(history, arguments);
                    historyDep.notify();
                }
            }
            
        }
}())

window.addHistoryListener = addHistoryMethod('historychange');
history.pushState =  addHistoryMethod('pushState');
history.replaceState =  addHistoryMethod('replaceState');

// window.addHistoryListener('history',function(){
//     console.log('窗口的history改变了');
//     //////
//     var cur_route = router.routes.find(element => {
//         return element.path == null? ('/'== window.location.pathname) : ('/'+element.path) == window.location.pathname;
//     });
//     var rou_ins = new cur_route.class();
//     console.log(rou_ins);
//     console.log(this.innerHTML);
//     this.innerHTML = rou_ins.getTemplate();
//     // // this.innerHTML = rou_ins.template;
//     rou_ins.init();
// })
// window.addHistoryListener('history',function(){
//     console.log('窗口的history改变了-我也听到了');
// })
// history.pushState({first:'first'}, "page2", "/first")
// console.log(history);


////////////////////






export default RoutingRender;