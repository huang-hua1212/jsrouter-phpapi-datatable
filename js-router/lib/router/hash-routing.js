
var l = class {
  constructor(t, e, i = null, c = null) {
    // this.path = null;
    // this.params = [];
    // this.callback = null;
    // this.name = null;
    // this.regex_path = null;

    // versoion1
    this.path = t || null;
    this.params = t.match(/(:\w+)/gi) || [];
    this.callback = e || null;
    this.name = i || null;
    this.regex_path = new RegExp(
        '^' + t.replace(/:[^\s/]+/g, '([\\w-]+)') + '$'
      );
    this.class = c || null; 
    // versoion2
    // (this.path = t),
    // (this.params = t.match(/(:\w+)/gi) || []),
    // (this.callback = e),
    // (this.name = i),
    // (this.regex_path = new RegExp(
    //   '^' + t.replace(/:[^\s/]+/g, '([\\w-]+)') + '$'
    // ));
  }
  match(t) {
    let e = t.match(this.regex_path);
    return e === null
      ? null
      : (e.shift(),
      {
        path: this.path,
        callback: this.callback,
        name: this.name,
        params: e.reduce((i, a, s) => {
          if (this.params[s]) {
            let h = this.params[s].replace(':', '');
            i[h] = a;
          }
          return i;
        }, {}),
        class: this.class,
      });
  }
},
  Router = class {
    constructor(t = {}) {
      this.mode = 'history';
      this.root = '/';
      this.routes = [];
      this.current = null;
      this.interval = null;
      this.previous = [];
      this.prefixes = [];
      this.renderClass = null;
      this.current_route = null;
      
      // version1
      // (this.mode = window.history.pushState ? 'history' : 'hash'),
      //   t.mode && (this.mode = t.mode),
      //   t.root && (this.root = t.root),
      //   t.routes && this.defineRoutes(t.routes),
      //   (this.watchUrl = this.watchUrl.bind(this)),

      // version2
      // this.mode = window.history.pushState ? 'history' : 'hash';
      // this.mode =  t.mode || 'history';
      // this.root = t.root || '/';
      // t.routes && this.defineRoutes(t.routes);
      // this.watchUrl = this.watchUrl.bind(this);

      // version3
      this.mode = window.history.pushState ? 'history' : 'hash';
      t.mode && (this.mode = t.mode);  // if t.mode存在，執行this.mode = t.mode
      t.root && (this.root = t.root); //  if t.root存在，執行this.root = t.root
      t.routes && this.defineRoutes(t.routes);
      this.watchUrl = this.watchUrl.bind(this);


      this.listen();
    }
    add(t, e, i, c) {
      return (
        this.prefixes.length > 0 && (t = this.prefixes.join('/') + '/' + t),
        this.routes.push(new l(Router.clearSlashes(t), e, i, c)),
        this
      );
    }
    remove(t) {
      return (this.routes = this.routes.filter((e) => e.path !== t)), this;
    }
    back() {
      this.mode === 'history' && window.history.back();
    }
    forward() {
      this.mode === 'history' && window.history.forward();
    }
    flush() {
      return (this.routes = []), this;
    }
    navigate(t = {}) {
      let e;
      if (typeof t == 'string') e = t;
      else if (t.name) {
        let i = t.params || {},
          a = this.routes.find((s) => s.name === t.name);
        if (a) {
          // e = a.path;
          e = a.path == null ? ' ': a.path; //空格
          for (let s in i){
            i.hasOwnProperty(s) && (e = e.replace(':' + s, i[s]));
          }
        }
      } else e = t.path;
      if (!e) return;
      if (this.mode === 'history') {
        e == ' '? window.history.pushState(null, null, this.root):window.history.pushState(null, null, this.root +'/'+ Router.clearSlashes(e));
      } else {
        let i = `${window.location.href.replace(/#(.*)$/, '')}#${e}`;
        this.previous.unshift(i), (window.location.href = i);
      }
      return this;
    }
    group(t, e) {
      return (
        this.prefixes.unshift(Router.clearSlashes(t)),
        e.apply(this),
        this.prefixes.shift(),
        this
      );
    }
    defineRoutes(t) {
      for (let e of t)
        e.group
          ? this.group(e.group, () => {
            this.add(e.path, e.callback, e.name, e.class);
          })
          : this.add(e.path, e.callback, e.name, e.class);
    }
    getFragment() {
      let t;
      if (this.mode === 'history')
        (t = Router.clearSlashes(
          decodeURI(window.location.pathname + window.location.search)
        )),
          (t = t.replace(/\?(.*)$/, '')),
          (t = this.root !== '/' ? t.replace(this.root, '') : t);
      else {
        let e = window.location.href.match(/#(.*)$/);
        t = e ? e[1] : '';
      }
      return Router.clearSlashes(t);
    }
    listen() {
      clearInterval(this.interval),
        (this.interval = setInterval(this.watchUrl, 20));
    }
    watchUrl() {
      if (this.current === this.getFragment()) return;
      this.current = this.getFragment();
      for (let t of this.routes) {
        let e = t.match(this.current);
        if(e!==null) {
          this.current_route = e;
        }
        
        if (e !== null) { // 
          let i = [...Object.values(e.params), this.current, t];
          e.callback.apply(this, i); // 執行callback function
          break;
        }
      }
    }
    static clearSlashes(t) {
      return t.toString().replace(/(^\/)|(\/$)/gi, '');
    }
  }
window && document && (window.Router = Router);

export default Router;