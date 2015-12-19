(function(f){if(typeof exports==="object"&&typeof module!=="undefined"){module.exports=f()}else if(typeof define==="function"&&define.amd){define([],f)}else{var g;if(typeof window!=="undefined"){g=window}else if(typeof global!=="undefined"){g=global}else if(typeof self!=="undefined"){g=self}else{g=this}g.Eloquent = f()}})(function(){var define,module,exports;return (function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
require("whatwg-fetch"),module.exports=self.fetch.bind(self);

},{"whatwg-fetch":2}],2:[function(require,module,exports){
!function(){"use strict";function t(t){if("string"!=typeof t&&(t=String(t)),/[^a-z0-9\-#$%&'*+.\^_`|~]/i.test(t))throw new TypeError("Invalid character in header field name");return t.toLowerCase()}function e(t){return"string"!=typeof t&&(t=String(t)),t}function r(t){this.map={},t instanceof r?t.forEach(function(t,e){this.append(e,t)},this):t&&Object.getOwnPropertyNames(t).forEach(function(e){this.append(e,t[e])},this)}function o(t){return t.bodyUsed?Promise.reject(new TypeError("Already read")):void(t.bodyUsed=!0)}function n(t){return new Promise(function(e,r){t.onload=function(){e(t.result)},t.onerror=function(){r(t.error)}})}function s(t){var e=new FileReader;return e.readAsArrayBuffer(t),n(e)}function i(t){var e=new FileReader;return e.readAsText(t),n(e)}function a(){return this.bodyUsed=!1,this._initBody=function(t){if(this._bodyInit=t,"string"==typeof t)this._bodyText=t;else if(p.blob&&Blob.prototype.isPrototypeOf(t))this._bodyBlob=t;else if(p.formData&&FormData.prototype.isPrototypeOf(t))this._bodyFormData=t;else if(t){if(!p.arrayBuffer||!ArrayBuffer.prototype.isPrototypeOf(t))throw new Error("unsupported BodyInit type")}else this._bodyText=""},p.blob?(this.blob=function(){var t=o(this);if(t)return t;if(this._bodyBlob)return Promise.resolve(this._bodyBlob);if(this._bodyFormData)throw new Error("could not read FormData body as blob");return Promise.resolve(new Blob([this._bodyText]))},this.arrayBuffer=function(){return this.blob().then(s)},this.text=function(){var t=o(this);if(t)return t;if(this._bodyBlob)return i(this._bodyBlob);if(this._bodyFormData)throw new Error("could not read FormData body as text");return Promise.resolve(this._bodyText)}):this.text=function(){var t=o(this);return t?t:Promise.resolve(this._bodyText)},p.formData&&(this.formData=function(){return this.text().then(f)}),this.json=function(){return this.text().then(JSON.parse)},this}function u(t){var e=t.toUpperCase();return c.indexOf(e)>-1?e:t}function h(t,e){e=e||{};var o=e.body;if(h.prototype.isPrototypeOf(t)){if(t.bodyUsed)throw new TypeError("Already read");this.url=t.url,this.credentials=t.credentials,e.headers||(this.headers=new r(t.headers)),this.method=t.method,this.mode=t.mode,o||(o=t._bodyInit,t.bodyUsed=!0)}else this.url=t;if(this.credentials=e.credentials||this.credentials||"omit",(e.headers||!this.headers)&&(this.headers=new r(e.headers)),this.method=u(e.method||this.method||"GET"),this.mode=e.mode||this.mode||null,this.referrer=null,("GET"===this.method||"HEAD"===this.method)&&o)throw new TypeError("Body not allowed for GET or HEAD requests");this._initBody(o)}function f(t){var e=new FormData;return t.trim().split("&").forEach(function(t){if(t){var r=t.split("="),o=r.shift().replace(/\+/g," "),n=r.join("=").replace(/\+/g," ");e.append(decodeURIComponent(o),decodeURIComponent(n))}}),e}function d(t){var e=new r,o=t.getAllResponseHeaders().trim().split("\n");return o.forEach(function(t){var r=t.trim().split(":"),o=r.shift().trim(),n=r.join(":").trim();e.append(o,n)}),e}function l(t,e){e||(e={}),this._initBody(t),this.type="default",this.status=e.status,this.ok=this.status>=200&&this.status<300,this.statusText=e.statusText,this.headers=e.headers instanceof r?e.headers:new r(e.headers),this.url=e.url||""}if(!self.fetch){r.prototype.append=function(r,o){r=t(r),o=e(o);var n=this.map[r];n||(n=[],this.map[r]=n),n.push(o)},r.prototype["delete"]=function(e){delete this.map[t(e)]},r.prototype.get=function(e){var r=this.map[t(e)];return r?r[0]:null},r.prototype.getAll=function(e){return this.map[t(e)]||[]},r.prototype.has=function(e){return this.map.hasOwnProperty(t(e))},r.prototype.set=function(r,o){this.map[t(r)]=[e(o)]},r.prototype.forEach=function(t,e){Object.getOwnPropertyNames(this.map).forEach(function(r){this.map[r].forEach(function(o){t.call(e,o,r,this)},this)},this)};var p={blob:"FileReader"in self&&"Blob"in self&&function(){try{return new Blob,!0}catch(t){return!1}}(),formData:"FormData"in self,arrayBuffer:"ArrayBuffer"in self},c=["DELETE","GET","HEAD","OPTIONS","POST","PUT"];h.prototype.clone=function(){return new h(this)},a.call(h.prototype),a.call(l.prototype),l.prototype.clone=function(){return new l(this._bodyInit,{status:this.status,statusText:this.statusText,headers:new r(this.headers),url:this.url})},l.error=function(){var t=new l(null,{status:0,statusText:""});return t.type="error",t};var y=[301,302,303,307,308];l.redirect=function(t,e){if(-1===y.indexOf(e))throw new RangeError("Invalid status code");return new l(null,{status:e,headers:{location:t}})},self.Headers=r,self.Request=h,self.Response=l,self.fetch=function(t,e){return new Promise(function(r,o){function n(){return"responseURL"in i?i.responseURL:/^X-Request-URL:/m.test(i.getAllResponseHeaders())?i.getResponseHeader("X-Request-URL"):void 0}var s;s=h.prototype.isPrototypeOf(t)&&!e?t:new h(t,e);var i=new XMLHttpRequest;i.onload=function(){var t=1223===i.status?204:i.status;if(100>t||t>599)return void o(new TypeError("Network request failed"));var e={status:t,statusText:i.statusText,headers:d(i),url:n()},s="response"in i?i.response:i.responseText;r(new l(s,e))},i.onerror=function(){o(new TypeError("Network request failed"))},i.open(s.method,s.url,!0),"include"===s.credentials&&(i.withCredentials=!0),"responseType"in i&&p.blob&&(i.responseType="blob"),s.headers.forEach(function(t,e){i.setRequestHeader(e,t)}),i.send("undefined"==typeof s._bodyInit?null:s._bodyInit)})},self.fetch.polyfill=!0}}();

},{}],3:[function(require,module,exports){
"use strict";function _classCallCheck(e,r){if(!(e instanceof r))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(exports,"__esModule",{value:!0});var _createClass=function(){function e(e,r){for(var t=0;t<r.length;t++){var n=r[t];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(r,t,n){return t&&e(r.prototype,t),n&&e(r,n),r}}(),Container=function(){function e(){_classCallCheck(this,e),this.bindings={},this.resolvers={}}return _createClass(e,[{key:"register",value:function(e,r){return this.bindings[e]=r,this}},{key:"get",value:function(e){var r=this.bindings[e];if("undefined"==typeof r)throw new Error("Nothing registered for ["+e+"]");return r}},{key:"resolving",value:function(e,r){return this.resolvers[e]=r,this}},{key:"make",value:function(e){var r=this.get(e);if(this.resolvers[e]){var t=this.resolvers[e](r,this);if(t)return t}return"function"==typeof r?new r:r}}]),e}();exports["default"]=Container,module.exports=exports["default"];

},{}],4:[function(require,module,exports){
"use strict";function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function unwrapFirst(e){return e[0]?e[0]:null}function throwIfNotFound(e){if(null===e)throw new Error("ModelNotFoundException");return e}Object.defineProperty(exports,"__esModule",{value:!0});var _createClass=function(){function e(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,r,n){return r&&e(t.prototype,r),n&&e(t,n),t}}(),Builder=function(){function e(t){if(_classCallCheck(this,e),!t||"function"!=typeof t.get)throw new Error("Missing argument 1 for Builder, expected Transport");this.transport=t,this.stack=[],this.endpoint=null,this._model=null}return _createClass(e,[{key:"_call",value:function(e,t){return this.stack.push([e,t]),this}},{key:"from",value:function(e){return this.endpoint=e,this}},{key:"select",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("select",t)}},{key:"addSelect",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("addSelect",t)}},{key:"distinct",value:function(){return this._call("distinct",[])}},{key:"where",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("where",t)}},{key:"orWhere",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("orWhere",t)}},{key:"whereBetween",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("whereBetween",t)}},{key:"orWhereBetween",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("orWhereBetween",t)}},{key:"whereNotBetween",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("whereNotBetween",t)}},{key:"orWhereNotBetween",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("orWhereNotBetween",t)}},{key:"whereNested",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("whereNested",t)}},{key:"whereExists",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("whereExists",t)}},{key:"orWhereExists",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("orWhereExists",t)}},{key:"whereNotExists",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("whereNotExists",t)}},{key:"orWhereNotExists",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("orWhereNotExists",t)}},{key:"whereIn",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("whereIn",t)}},{key:"orWhereIn",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("orWhereIn",t)}},{key:"whereNotIn",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("whereNotIn",t)}},{key:"orWhereNotIn",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("orWhereNotIn",t)}},{key:"whereNull",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("whereNull",t)}},{key:"orWhereNull",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("orWhereNull",t)}},{key:"whereNotNull",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("whereNotNull",t)}},{key:"orWhereNotNull",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("orWhereNotNull",t)}},{key:"whereDate",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("whereDate",t)}},{key:"whereDay",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("whereDay",t)}},{key:"whereMonth",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("whereMonth",t)}},{key:"whereYear",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("whereYear",t)}},{key:"groupBy",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("groupBy",t)}},{key:"having",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("having",t)}},{key:"orHaving",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("orHaving",t)}},{key:"orderBy",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("orderBy",t)}},{key:"latest",value:function(e){return this._call("latest",e?[e]:[])}},{key:"oldest",value:function(e){return this._call("oldest",e?[e]:[])}},{key:"offset",value:function(e){return this._call("offset",[e])}},{key:"skip",value:function(e){return this._call("skip",[e])}},{key:"limit",value:function(e){return this._call("limit",[e])}},{key:"take",value:function(e){return this._call("take",[e])}},{key:"forPage",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("forPage",t)}},{key:"with",value:function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];return this._call("with",t),this}},{key:"find",value:function(e,t){return Array.isArray(e)?this.findMany(e,t):this.from(this.getEndpoint(e)).getOne()}},{key:"findMany",value:function(e,t){return this.whereIn(this._model.getKeyName(),e).get(t)}},{key:"findOrFail",value:function(e,t){return this.find(e,t).then(throwIfNotFound)}},{key:"first",value:function(e){return this.limit(1).get(e).then(unwrapFirst)}},{key:"firstOrFail",value:function(e){return this.first(e).then(throwIfNotFound)}},{key:"value",value:function(e){return this.first(e).then(function(t){return t[e]})}},{key:"lists",value:function(e){return this.get(e).then(function(t){return t.map(function(t){return t[e]})})}},{key:"scope",value:function(e,t){var r=[e];return t&&r.push(t),this._call("scope",r),this}},{key:"get",value:function(e){var t=this;return e&&this.select(e),this.transport.get(this.getEndpoint(),this.stack).then(function(e){return t._model.hydrate(e)})}},{key:"getOne",value:function(e){var t=this;return e&&this.select(e),this.transport.get(this.getEndpoint(),this.stack).then(function(e){return e?t._model.newInstance(e):null})}},{key:"insert",value:function(e){return this.transport.post(this.getEndpoint(),e)}},{key:"update",value:function(e){return this.transport.put(this.getEndpoint(this._model.getKey()||"*"),e,this.stack)}},{key:"delete",value:function(){return this.transport["delete"](this.getEndpoint(this._model.getKey()||"*"),this.stack)}},{key:"getEndpoint",value:function(e){if(!this.endpoint)throw new Error("Endpoint is required but is not set.");return e?this.endpoint+"/"+e:this.endpoint}},{key:"_getModel",value:function(){return this._model}},{key:"_setModel",value:function(e){var t=this;this._model=e,this.from(e.definition.endpoint),(e.definition.scopes||[]).forEach(function(e){t[e]=function(){for(var t=arguments.length,r=Array(t),n=0;t>n;n++)r[n]=arguments[n];return this.scope(e,r),this}})}}]),e}();exports["default"]=Builder,module.exports=exports["default"];

},{}],5:[function(require,module,exports){
"use strict";function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function addMethod(e,t,n,r){return"undefined"==typeof e[t]||r?Object.defineProperty(e,t,{value:n}):e}function asUnixTimestamp(){return Math.round(this.valueOf()/1e3)}Object.defineProperty(exports,"__esModule",{value:!0});var _createClass=function(){function e(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}return function(t,n,r){return n&&e(t.prototype,n),r&&e(t,r),t}}(),_index=require("../index"),Model=function(){function e(){var t=arguments.length<=0||void 0===arguments[0]?{}:arguments[0];_classCallCheck(this,e),this.bootIfNotBooted(),Object.defineProperties(this,{original:{writable:!0},exists:{value:!1,writable:!0},definition:{value:this.constructor}}),this.fill(t),this._syncOriginal()}return _createClass(e,[{key:"bootIfNotBooted",value:function(){this.constructor.booted||this.constructor.boot()}},{key:"fill",value:function(e){for(var t in e)this.setAttribute(t,e[t]);return this}},{key:"_syncOriginal",value:function(){this.original=this.getAttributes()}},{key:"getAttribute",value:function(e){return this[e]}},{key:"setAttribute",value:function(e,t){return this.isDate(e)&&(t=new Date(t),t.toJSON=asUnixTimestamp),this._isRelation(e)&&(t=this._makeRelated(e,t)),this[e]=t,this}},{key:"getAttributes",value:function(){var e=Object.assign({},this);for(var t in e)this.isDate(t)&&(e[t]=new Date(this[t]),e[t].toJSON=asUnixTimestamp),this._isRelation(t)&&delete e[t];return e}},{key:"getDirty",value:function(){var e=this.getAttributes();for(var t in e)"undefined"!=typeof this.original[t]&&this.original[t].valueOf()===e[t].valueOf()&&delete e[t];return e}},{key:"getKey",value:function(){return this[this.getKeyName()]}},{key:"getKeyName",value:function(){return this.definition.primaryKey||"id"}},{key:"isDate",value:function(e){return this.definition.dates.concat("created_at","updated_at","deleted_at").indexOf(e)>-1}},{key:"_isRelation",value:function(e){return Object.keys(this.definition.relations).indexOf(e)>-1}},{key:"newQuery",value:function(){var e=this.constructor._newBuilder();return e._setModel(this),e}},{key:"newInstance",value:function(){var e=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],t=arguments.length<=1||void 0===arguments[1]?!1:arguments[1],n=new this.constructor(e);return n.exists=t,n}},{key:"hydrate",value:function(e){var t=this;return e.map(function(e){return t.newInstance(e,!0)})}},{key:"save",value:function(){var e=this,t=void 0;return this.triggerEvent("saving")===!1?Promise.reject("saving.cancelled"):(t=this.exists?this._performUpdate():this._performInsert(),t.then(function(t){return e.exists=!0,e.triggerEvent("saved",!1),e.fill(t)&&e._syncOriginal()}))}},{key:"_performInsert",value:function(){var e=this;return this.triggerEvent("creating")===!1?Promise.reject("creating.cancelled"):this.newQuery().insert(this.getAttributes()).then(function(t){return e.triggerEvent("created",!1),t})}},{key:"_performUpdate",value:function(){var e=this;return this.triggerEvent("updating")===!1?Promise.reject("updating.cancelled"):this.newQuery().update(this.getDirty()).then(function(t){return e.triggerEvent("updated",!1),t})}},{key:"update",value:function(e){return this.exists?(this.fill(e),this.save()):this.newQuery().update(e)}},{key:"delete",value:function(){var e=this;return this.triggerEvent("deleting")===!1?Promise.reject("deleting.cancelled"):this.newQuery().where("id",this.getKey())["delete"]().then(function(t){return t&&(e.exists=!1),e.triggerEvent("deleted",!1),t})}},{key:"load",value:function(){for(var e=this,t=this.newQuery(),n=arguments.length,r=Array(n),i=0;n>i;i++)r[i]=arguments[i];return t.from(t.getEndpoint(this.getKey()))["with"](r).getOne().then(function(t){return e.fill(Object.assign(t,e.getDirty()))})}},{key:"_makeRelated",value:function(e,t){var n=new(_index.app.make(this.definition.relations[e]));return Array.isArray(t)?n.hydrate(t):n.fill(t)}},{key:"triggerEvent",value:function(e){for(var t=arguments.length<=1||void 0===arguments[1]?!0:arguments[1],n=this.constructor.events,r=0,i=(n[e]||[]).length;i>r;++r){var s=n[e][r](this);if(t&&"undefined"!=typeof s)return s}}}],[{key:"boot",value:function(){e.booted||this._bootBaseModel(),this._bootSelf()}},{key:"_bootSelf",value:function(){this.booted=!0,this.dates=this.dates||[],this.relations=this.relations||{},this.scopes&&this._bootScopes(this.scopes)}},{key:"_bootBaseModel",value:function(){this.events={};var t=Object.getPrototypeOf(this._newBuilder());Object.getOwnPropertyNames(t).filter(function(e){return"_"!==e.charAt(0)&&"constructor"!==e&&"function"==typeof t[e]}).forEach(function(t){addMethod(e.prototype,t,function(){var e=this.newQuery();return e[t].apply(e,arguments)}),addMethod(e,t,function(){var e=this.query();return e[t].apply(e,arguments)})})}},{key:"_bootScopes",value:function(e){e.forEach(function(e){addMethod(this,e,function(){for(var t=arguments.length,n=Array(t),r=0;t>r;r++)n[r]=arguments[r];return this.newQuery().scope(e,n)}),addMethod(this.constructor,e,function(){for(var t=arguments.length,n=Array(t),r=0;t>r;r++)n[r]=arguments[r];return this.query().scope(e,n)})},this.prototype)}},{key:"query",value:function(){return(new this).newQuery()}},{key:"_newBuilder",value:function(){return _index.app.make("Builder")}},{key:"create",value:function(){var e=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],t=new this(e);return t.save().then(function(e){return t})}},{key:"all",value:function(e){return(new this).newQuery().get(e)}},{key:"creating",value:function(e){this.registerEventHandler("creating",e)}},{key:"created",value:function(e){this.registerEventHandler("created",e)}},{key:"updating",value:function(e){this.registerEventHandler("updating",e)}},{key:"updated",value:function(e){this.registerEventHandler("updated",e)}},{key:"saving",value:function(e){this.registerEventHandler("saving",e)}},{key:"saved",value:function(e){this.registerEventHandler("saved",e)}},{key:"deleting",value:function(e){this.registerEventHandler("deleting",e)}},{key:"deleted",value:function(e){this.registerEventHandler("deleted",e)}},{key:"registerEventHandler",value:function(e,t){this.events[e]||(this.events[e]=[]),this.events[e].push(t)}}]),e}();exports["default"]=Model,module.exports=exports["default"];

},{"../index":7}],6:[function(require,module,exports){
"use strict";function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function buildUrl(e,t){return t&&t.length&&(e+="?query="+JSON.stringify(t)),e}function getInit(e,t,n){var r={credentials:"same-origin",headers:{Accept:"application/json","X-XSRF-TOKEN":getCsrfToken()}};return e&&(r.method=e),t&&(r.headers["Content-Type"]="application/json",r.body=JSON.stringify(t)),Object.assign(r,n||{})}function readJson(e){return e.json()}function getCsrfToken(){return"undefined"!=typeof document?decodeURIComponent((document.cookie.match("(^|; )XSRF-TOKEN=([^;]*)")||0)[2]):void 0}Object.defineProperty(exports,"__esModule",{value:!0});var _createClass=function(){function e(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}return function(t,n,r){return n&&e(t.prototype,n),r&&e(t,r),t}}();require("isomorphic-fetch");var Transport=function(){function e(){_classCallCheck(this,e)}return _createClass(e,[{key:"get",value:function(e){var t=arguments.length<=1||void 0===arguments[1]?[]:arguments[1];return fetch(buildUrl(e,t),getInit()).then(readJson)}},{key:"post",value:function(e){var t=arguments.length<=1||void 0===arguments[1]?{}:arguments[1];return fetch(e,getInit("post",t)).then(readJson)}},{key:"put",value:function(e,t,n){return fetch(buildUrl(e,n),getInit("put",t)).then(readJson)}},{key:"delete",value:function(e){var t=arguments.length<=1||void 0===arguments[1]?[]:arguments[1];return fetch(buildUrl(e,t),getInit("delete")).then(function(e){return 200===e.status})}}]),e}();exports["default"]=Transport,module.exports=exports["default"];

},{"isomorphic-fetch":1}],7:[function(require,module,exports){
"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{"default":e}}function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}Object.defineProperty(exports,"__esModule",{value:!0});var _get=function(e,t,r){for(var o=!0;o;){var n=e,u=t,i=r;o=!1,null===n&&(n=Function.prototype);var l=Object.getOwnPropertyDescriptor(n,u);if(void 0!==l){if("value"in l)return l.value;var a=l.get;if(void 0===a)return;return a.call(i)}var c=Object.getPrototypeOf(n);if(null===c)return;e=c,t=u,r=i,o=!0,l=c=void 0}},_EloquentBuilder=require("./Eloquent/Builder"),_EloquentBuilder2=_interopRequireDefault(_EloquentBuilder),_EloquentModel=require("./Eloquent/Model"),_EloquentModel2=_interopRequireDefault(_EloquentModel),_QueryTransport=require("./Query/Transport"),_QueryTransport2=_interopRequireDefault(_QueryTransport),_Container=require("./Container"),_Container2=_interopRequireDefault(_Container),container=new _Container2["default"],Eloquent=function e(t,r){if(e.booted||e.boot(),r){var o=function(){Object.defineProperty(e,t,{get:function(){return container.make(t)}});var o=r;return"function"!=typeof r&&(o=function(e){return Object.assign(e,r)}),container.resolving(t,function(e){var t=o(e);return t.prototype.bootIfNotBooted(),t}),{v:container.register(t,function(e){function t(){_classCallCheck(this,t),_get(Object.getPrototypeOf(t.prototype),"constructor",this).apply(this,arguments)}return _inherits(t,e),t}(container.get("Model")))}}();if("object"==typeof o)return o.v}return container.make(t)};Eloquent.boot=function(){Eloquent.booted=!0,container.register("Builder",_EloquentBuilder2["default"]),container.register("Transport",_QueryTransport2["default"]),container.register("Model",_EloquentModel2["default"]),container.resolving("Builder",function(e,t){return new e(t.make("Transport"))})},exports["default"]=Eloquent,exports.app=container,exports.Container=_Container2["default"],exports.Builder=_EloquentBuilder2["default"],exports.Model=_EloquentModel2["default"],exports.Transport=_QueryTransport2["default"];

},{"./Container":3,"./Eloquent/Builder":4,"./Eloquent/Model":5,"./Query/Transport":6}]},{},[7])(7)
});