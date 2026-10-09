// Jquery
!function(e,t){"use strict";"object"==typeof module&&"object"==typeof module.exports?module.exports=e.document?t(e,!0):function(e){if(!e.document)throw new Error("jQuery requires a window with a document");return t(e)}:t(e)}("undefined"!=typeof window?window:this,function(C,e){"use strict";var t=[],r=Object.getPrototypeOf,s=t.slice,g=t.flat?function(e){return t.flat.call(e)}:function(e){return t.concat.apply([],e)},u=t.push,i=t.indexOf,n={},o=n.toString,v=n.hasOwnProperty,a=v.toString,l=a.call(Object),y={},m=function(e){return"function"==typeof e&&"number"!=typeof e.nodeType&&"function"!=typeof e.item},x=function(e){return null!=e&&e===e.window},E=C.document,c={type:!0,src:!0,nonce:!0,noModule:!0};function b(e,t,n){var r,i,o=(n=n||E).createElement("script");if(o.text=e,t)for(r in c)(i=t[r]||t.getAttribute&&t.getAttribute(r))&&o.setAttribute(r,i);n.head.appendChild(o).parentNode.removeChild(o)}function w(e){return null==e?e+"":"object"==typeof e||"function"==typeof e?n[o.call(e)]||"object":typeof e}var f="3.6.0",S=function(e,t){return new S.fn.init(e,t)};function p(e){var t=!!e&&"length"in e&&e.length,n=w(e);return!m(e)&&!x(e)&&("array"===n||0===t||"number"==typeof t&&0<t&&t-1 in e)}S.fn=S.prototype={jquery:f,constructor:S,length:0,toArray:function(){return s.call(this)},get:function(e){return null==e?s.call(this):e<0?this[e+this.length]:this[e]},pushStack:function(e){var t=S.merge(this.constructor(),e);return t.prevObject=this,t},each:function(e){return S.each(this,e)},map:function(n){return this.pushStack(S.map(this,function(e,t){return n.call(e,t,e)}))},slice:function(){return this.pushStack(s.apply(this,arguments))},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},even:function(){return this.pushStack(S.grep(this,function(e,t){return(t+1)%2}))},odd:function(){return this.pushStack(S.grep(this,function(e,t){return t%2}))},eq:function(e){var t=this.length,n=+e+(e<0?t:0);return this.pushStack(0<=n&&n<t?[this[n]]:[])},end:function(){return this.prevObject||this.constructor()},push:u,sort:t.sort,splice:t.splice},S.extend=S.fn.extend=function(){var e,t,n,r,i,o,a=arguments[0]||{},s=1,u=arguments.length,l=!1;for("boolean"==typeof a&&(l=a,a=arguments[s]||{},s++),"object"==typeof a||m(a)||(a={}),s===u&&(a=this,s--);s<u;s++)if(null!=(e=arguments[s]))for(t in e)r=e[t],"__proto__"!==t&&a!==r&&(l&&r&&(S.isPlainObject(r)||(i=Array.isArray(r)))?(n=a[t],o=i&&!Array.isArray(n)?[]:i||S.isPlainObject(n)?n:{},i=!1,a[t]=S.extend(l,o,r)):void 0!==r&&(a[t]=r));return a},S.extend({expando:"jQuery"+(f+Math.random()).replace(/\D/g,""),isReady:!0,error:function(e){throw new Error(e)},noop:function(){},isPlainObject:function(e){var t,n;return!(!e||"[object Object]"!==o.call(e))&&(!(t=r(e))||"function"==typeof(n=v.call(t,"constructor")&&t.constructor)&&a.call(n)===l)},isEmptyObject:function(e){var t;for(t in e)return!1;return!0},globalEval:function(e,t,n){b(e,{nonce:t&&t.nonce},n)},each:function(e,t){var n,r=0;if(p(e)){for(n=e.length;r<n;r++)if(!1===t.call(e[r],r,e[r]))break}else for(r in e)if(!1===t.call(e[r],r,e[r]))break;return e},makeArray:function(e,t){var n=t||[];return null!=e&&(p(Object(e))?S.merge(n,"string"==typeof e?[e]:e):u.call(n,e)),n},inArray:function(e,t,n){return null==t?-1:i.call(t,e,n)},merge:function(e,t){for(var n=+t.length,r=0,i=e.length;r<n;r++)e[i++]=t[r];return e.length=i,e},grep:function(e,t,n){for(var r=[],i=0,o=e.length,a=!n;i<o;i++)!t(e[i],i)!==a&&r.push(e[i]);return r},map:function(e,t,n){var r,i,o=0,a=[];if(p(e))for(r=e.length;o<r;o++)null!=(i=t(e[o],o,n))&&a.push(i);else for(o in e)null!=(i=t(e[o],o,n))&&a.push(i);return g(a)},guid:1,support:y}),"function"==typeof Symbol&&(S.fn[Symbol.iterator]=t[Symbol.iterator]),S.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "),function(e,t){n["[object "+t+"]"]=t.toLowerCase()});var d=function(n){var e,d,b,o,i,h,f,g,w,u,l,T,C,a,E,v,s,c,y,S="sizzle"+1*new Date,p=n.document,k=0,r=0,m=ue(),x=ue(),A=ue(),N=ue(),j=function(e,t){return e===t&&(l=!0),0},D={}.hasOwnProperty,t=[],q=t.pop,L=t.push,H=t.push,O=t.slice,P=function(e,t){for(var n=0,r=e.length;n<r;n++)if(e[n]===t)return n;return-1},R="checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",M="[\\x20\\t\\r\\n\\f]",I="(?:\\\\[\\da-fA-F]{1,6}"+M+"?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",W="\\["+M+"*("+I+")(?:"+M+"*([*^$|!~]?=)"+M+"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|("+I+"))|)"+M+"*\\]",F=":("+I+")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|"+W+")*)|.*)\\)|)",B=new RegExp(M+"+","g"),$=new RegExp("^"+M+"+|((?:^|[^\\\\])(?:\\\\.)*)"+M+"+$","g"),_=new RegExp("^"+M+"*,"+M+"*"),z=new RegExp("^"+M+"*([>+~]|"+M+")"+M+"*"),U=new RegExp(M+"|>"),X=new RegExp(F),V=new RegExp("^"+I+"$"),G={ID:new RegExp("^#("+I+")"),CLASS:new RegExp("^\\.("+I+")"),TAG:new RegExp("^("+I+"|[*])"),ATTR:new RegExp("^"+W),PSEUDO:new RegExp("^"+F),CHILD:new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\("+M+"*(even|odd|(([+-]|)(\\d*)n|)"+M+"*(?:([+-]|)"+M+"*(\\d+)|))"+M+"*\\)|)","i"),bool:new RegExp("^(?:"+R+")$","i"),needsContext:new RegExp("^"+M+"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\("+M+"*((?:-\\d)?\\d*)"+M+"*\\)|)(?=[^-]|$)","i")},Y=/HTML$/i,Q=/^(?:input|select|textarea|button)$/i,J=/^h\d$/i,K=/^[^{]+\{\s*\[native \w/,Z=/^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,ee=/[+~]/,te=new RegExp("\\\\[\\da-fA-F]{1,6}"+M+"?|\\\\([^\\r\\n\\f])","g"),ne=function(e,t){var n="0x"+e.slice(1)-65536;return t||(n<0?String.fromCharCode(n+65536):String.fromCharCode(n>>10|55296,1023&n|56320))},re=/([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,ie=function(e,t){return t?"\0"===e?"\ufffd":e.slice(0,-1)+"\\"+e.charCodeAt(e.length-1).toString(16)+" ":"\\"+e},oe=function(){T()},ae=be(function(e){return!0===e.disabled&&"fieldset"===e.nodeName.toLowerCase()},{dir:"parentNode",next:"legend"});try{H.apply(t=O.call(p.childNodes),p.childNodes),t[p.childNodes.length].nodeType}catch(e){H={apply:t.length?function(e,t){L.apply(e,O.call(t))}:function(e,t){var n=e.length,r=0;while(e[n++]=t[r++]);e.length=n-1}}}function se(t,e,n,r){var i,o,a,s,u,l,c,f=e&&e.ownerDocument,p=e?e.nodeType:9;if(n=n||[],"string"!=typeof t||!t||1!==p&&9!==p&&11!==p)return n;if(!r&&(T(e),e=e||C,E)){if(11!==p&&(u=Z.exec(t)))if(i=u[1]){if(9===p){if(!(a=e.getElementById(i)))return n;if(a.id===i)return n.push(a),n}else if(f&&(a=f.getElementById(i))&&y(e,a)&&a.id===i)return n.push(a),n}else{if(u[2])return H.apply(n,e.getElementsByTagName(t)),n;if((i=u[3])&&d.getElementsByClassName&&e.getElementsByClassName)return H.apply(n,e.getElementsByClassName(i)),n}if(d.qsa&&!N[t+" "]&&(!v||!v.test(t))&&(1!==p||"object"!==e.nodeName.toLowerCase())){if(c=t,f=e,1===p&&(U.test(t)||z.test(t))){(f=ee.test(t)&&ye(e.parentNode)||e)===e&&d.scope||((s=e.getAttribute("id"))?s=s.replace(re,ie):e.setAttribute("id",s=S)),o=(l=h(t)).length;while(o--)l[o]=(s?"#"+s:":scope")+" "+xe(l[o]);c=l.join(",")}try{return H.apply(n,f.querySelectorAll(c)),n}catch(e){N(t,!0)}finally{s===S&&e.removeAttribute("id")}}}return g(t.replace($,"$1"),e,n,r)}function ue(){var r=[];return function e(t,n){return r.push(t+" ")>b.cacheLength&&delete e[r.shift()],e[t+" "]=n}}function le(e){return e[S]=!0,e}function ce(e){var t=C.createElement("fieldset");try{return!!e(t)}catch(e){return!1}finally{t.parentNode&&t.parentNode.removeChild(t),t=null}}function fe(e,t){var n=e.split("|"),r=n.length;while(r--)b.attrHandle[n[r]]=t}function pe(e,t){var n=t&&e,r=n&&1===e.nodeType&&1===t.nodeType&&e.sourceIndex-t.sourceIndex;if(r)return r;if(n)while(n=n.nextSibling)if(n===t)return-1;return e?1:-1}function de(t){return function(e){return"input"===e.nodeName.toLowerCase()&&e.type===t}}function he(n){return function(e){var t=e.nodeName.toLowerCase();return("input"===t||"button"===t)&&e.type===n}}function ge(t){return function(e){return"form"in e?e.parentNode&&!1===e.disabled?"label"in e?"label"in e.parentNode?e.parentNode.disabled===t:e.disabled===t:e.isDisabled===t||e.isDisabled!==!t&&ae(e)===t:e.disabled===t:"label"in e&&e.disabled===t}}function ve(a){return le(function(o){return o=+o,le(function(e,t){var n,r=a([],e.length,o),i=r.length;while(i--)e[n=r[i]]&&(e[n]=!(t[n]=e[n]))})})}function ye(e){return e&&"undefined"!=typeof e.getElementsByTagName&&e}for(e in d=se.support={},i=se.isXML=function(e){var t=e&&e.namespaceURI,n=e&&(e.ownerDocument||e).documentElement;return!Y.test(t||n&&n.nodeName||"HTML")},T=se.setDocument=function(e){var t,n,r=e?e.ownerDocument||e:p;return r!=C&&9===r.nodeType&&r.documentElement&&(a=(C=r).documentElement,E=!i(C),p!=C&&(n=C.defaultView)&&n.top!==n&&(n.addEventListener?n.addEventListener("unload",oe,!1):n.attachEvent&&n.attachEvent("onunload",oe)),d.scope=ce(function(e){return a.appendChild(e).appendChild(C.createElement("div")),"undefined"!=typeof e.querySelectorAll&&!e.querySelectorAll(":scope fieldset div").length}),d.attributes=ce(function(e){return e.className="i",!e.getAttribute("className")}),d.getElementsByTagName=ce(function(e){return e.appendChild(C.createComment("")),!e.getElementsByTagName("*").length}),d.getElementsByClassName=K.test(C.getElementsByClassName),d.getById=ce(function(e){return a.appendChild(e).id=S,!C.getElementsByName||!C.getElementsByName(S).length}),d.getById?(b.filter.ID=function(e){var t=e.replace(te,ne);return function(e){return e.getAttribute("id")===t}},b.find.ID=function(e,t){if("undefined"!=typeof t.getElementById&&E){var n=t.getElementById(e);return n?[n]:[]}}):(b.filter.ID=function(e){var n=e.replace(te,ne);return function(e){var t="undefined"!=typeof e.getAttributeNode&&e.getAttributeNode("id");return t&&t.value===n}},b.find.ID=function(e,t){if("undefined"!=typeof t.getElementById&&E){var n,r,i,o=t.getElementById(e);if(o){if((n=o.getAttributeNode("id"))&&n.value===e)return[o];i=t.getElementsByName(e),r=0;while(o=i[r++])if((n=o.getAttributeNode("id"))&&n.value===e)return[o]}return[]}}),b.find.TAG=d.getElementsByTagName?function(e,t){return"undefined"!=typeof t.getElementsByTagName?t.getElementsByTagName(e):d.qsa?t.querySelectorAll(e):void 0}:function(e,t){var n,r=[],i=0,o=t.getElementsByTagName(e);if("*"===e){while(n=o[i++])1===n.nodeType&&r.push(n);return r}return o},b.find.CLASS=d.getElementsByClassName&&function(e,t){if("undefined"!=typeof t.getElementsByClassName&&E)return t.getElementsByClassName(e)},s=[],v=[],(d.qsa=K.test(C.querySelectorAll))&&(ce(function(e){var t;a.appendChild(e).innerHTML="<a id='"+S+"'></a><select id='"+S+"-\r\\' msallowcapture=''><option selected=''></option></select>",e.querySelectorAll("[msallowcapture^='']").length&&v.push("[*^$]="+M+"*(?:''|\"\")"),e.querySelectorAll("[selected]").length||v.push("\\["+M+"*(?:value|"+R+")"),e.querySelectorAll("[id~="+S+"-]").length||v.push("~="),(t=C.createElement("input")).setAttribute("name",""),e.appendChild(t),e.querySelectorAll("[name='']").length||v.push("\\["+M+"*name"+M+"*="+M+"*(?:''|\"\")"),e.querySelectorAll(":checked").length||v.push(":checked"),e.querySelectorAll("a#"+S+"+*").length||v.push(".#.+[+~]"),e.querySelectorAll("\\\f"),v.push("[\\r\\n\\f]")}),ce(function(e){e.innerHTML="<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";var t=C.createElement("input");t.setAttribute("type","hidden"),e.appendChild(t).setAttribute("name","D"),e.querySelectorAll("[name=d]").length&&v.push("name"+M+"*[*^$|!~]?="),2!==e.querySelectorAll(":enabled").length&&v.push(":enabled",":disabled"),a.appendChild(e).disabled=!0,2!==e.querySelectorAll(":disabled").length&&v.push(":enabled",":disabled"),e.querySelectorAll("*,:x"),v.push(",.*:")})),(d.matchesSelector=K.test(c=a.matches||a.webkitMatchesSelector||a.mozMatchesSelector||a.oMatchesSelector||a.msMatchesSelector))&&ce(function(e){d.disconnectedMatch=c.call(e,"*"),c.call(e,"[s!='']:x"),s.push("!=",F)}),v=v.length&&new RegExp(v.join("|")),s=s.length&&new RegExp(s.join("|")),t=K.test(a.compareDocumentPosition),y=t||K.test(a.contains)?function(e,t){var n=9===e.nodeType?e.documentElement:e,r=t&&t.parentNode;return e===r||!(!r||1!==r.nodeType||!(n.contains?n.contains(r):e.compareDocumentPosition&&16&e.compareDocumentPosition(r)))}:function(e,t){if(t)while(t=t.parentNode)if(t===e)return!0;return!1},j=t?function(e,t){if(e===t)return l=!0,0;var n=!e.compareDocumentPosition-!t.compareDocumentPosition;return n||(1&(n=(e.ownerDocument||e)==(t.ownerDocument||t)?e.compareDocumentPosition(t):1)||!d.sortDetached&&t.compareDocumentPosition(e)===n?e==C||e.ownerDocument==p&&y(p,e)?-1:t==C||t.ownerDocument==p&&y(p,t)?1:u?P(u,e)-P(u,t):0:4&n?-1:1)}:function(e,t){if(e===t)return l=!0,0;var n,r=0,i=e.parentNode,o=t.parentNode,a=[e],s=[t];if(!i||!o)return e==C?-1:t==C?1:i?-1:o?1:u?P(u,e)-P(u,t):0;if(i===o)return pe(e,t);n=e;while(n=n.parentNode)a.unshift(n);n=t;while(n=n.parentNode)s.unshift(n);while(a[r]===s[r])r++;return r?pe(a[r],s[r]):a[r]==p?-1:s[r]==p?1:0}),C},se.matches=function(e,t){return se(e,null,null,t)},se.matchesSelector=function(e,t){if(T(e),d.matchesSelector&&E&&!N[t+" "]&&(!s||!s.test(t))&&(!v||!v.test(t)))try{var n=c.call(e,t);if(n||d.disconnectedMatch||e.document&&11!==e.document.nodeType)return n}catch(e){N(t,!0)}return 0<se(t,C,null,[e]).length},se.contains=function(e,t){return(e.ownerDocument||e)!=C&&T(e),y(e,t)},se.attr=function(e,t){(e.ownerDocument||e)!=C&&T(e);var n=b.attrHandle[t.toLowerCase()],r=n&&D.call(b.attrHandle,t.toLowerCase())?n(e,t,!E):void 0;return void 0!==r?r:d.attributes||!E?e.getAttribute(t):(r=e.getAttributeNode(t))&&r.specified?r.value:null},se.escape=function(e){return(e+"").replace(re,ie)},se.error=function(e){throw new Error("Syntax error, unrecognized expression: "+e)},se.uniqueSort=function(e){var t,n=[],r=0,i=0;if(l=!d.detectDuplicates,u=!d.sortStable&&e.slice(0),e.sort(j),l){while(t=e[i++])t===e[i]&&(r=n.push(i));while(r--)e.splice(n[r],1)}return u=null,e},o=se.getText=function(e){var t,n="",r=0,i=e.nodeType;if(i){if(1===i||9===i||11===i){if("string"==typeof e.textContent)return e.textContent;for(e=e.firstChild;e;e=e.nextSibling)n+=o(e)}else if(3===i||4===i)return e.nodeValue}else while(t=e[r++])n+=o(t);return n},(b=se.selectors={cacheLength:50,createPseudo:le,match:G,attrHandle:{},find:{},relative:{">":{dir:"parentNode",first:!0}," ":{dir:"parentNode"},"+":{dir:"previousSibling",first:!0},"~":{dir:"previousSibling"}},preFilter:{ATTR:function(e){return e[1]=e[1].replace(te,ne),e[3]=(e[3]||e[4]||e[5]||"").replace(te,ne),"~="===e[2]&&(e[3]=" "+e[3]+" "),e.slice(0,4)},CHILD:function(e){return e[1]=e[1].toLowerCase(),"nth"===e[1].slice(0,3)?(e[3]||se.error(e[0]),e[4]=+(e[4]?e[5]+(e[6]||1):2*("even"===e[3]||"odd"===e[3])),e[5]=+(e[7]+e[8]||"odd"===e[3])):e[3]&&se.error(e[0]),e},PSEUDO:function(e){var t,n=!e[6]&&e[2];return G.CHILD.test(e[0])?null:(e[3]?e[2]=e[4]||e[5]||"":n&&X.test(n)&&(t=h(n,!0))&&(t=n.indexOf(")",n.length-t)-n.length)&&(e[0]=e[0].slice(0,t),e[2]=n.slice(0,t)),e.slice(0,3))}},filter:{TAG:function(e){var t=e.replace(te,ne).toLowerCase();return"*"===e?function(){return!0}:function(e){return e.nodeName&&e.nodeName.toLowerCase()===t}},CLASS:function(e){var t=m[e+" "];return t||(t=new RegExp("(^|"+M+")"+e+"("+M+"|$)"))&&m(e,function(e){return t.test("string"==typeof e.className&&e.className||"undefined"!=typeof e.getAttribute&&e.getAttribute("class")||"")})},ATTR:function(n,r,i){return function(e){var t=se.attr(e,n);return null==t?"!="===r:!r||(t+="","="===r?t===i:"!="===r?t!==i:"^="===r?i&&0===t.indexOf(i):"*="===r?i&&-1<t.indexOf(i):"$="===r?i&&t.slice(-i.length)===i:"~="===r?-1<(" "+t.replace(B," ")+" ").indexOf(i):"|="===r&&(t===i||t.slice(0,i.length+1)===i+"-"))}},CHILD:function(h,e,t,g,v){var y="nth"!==h.slice(0,3),m="last"!==h.slice(-4),x="of-type"===e;return 1===g&&0===v?function(e){return!!e.parentNode}:function(e,t,n){var r,i,o,a,s,u,l=y!==m?"nextSibling":"previousSibling",c=e.parentNode,f=x&&e.nodeName.toLowerCase(),p=!n&&!x,d=!1;if(c){if(y){while(l){a=e;while(a=a[l])if(x?a.nodeName.toLowerCase()===f:1===a.nodeType)return!1;u=l="only"===h&&!u&&"nextSibling"}return!0}if(u=[m?c.firstChild:c.lastChild],m&&p){d=(s=(r=(i=(o=(a=c)[S]||(a[S]={}))[a.uniqueID]||(o[a.uniqueID]={}))[h]||[])[0]===k&&r[1])&&r[2],a=s&&c.childNodes[s];while(a=++s&&a&&a[l]||(d=s=0)||u.pop())if(1===a.nodeType&&++d&&a===e){i[h]=[k,s,d];break}}else if(p&&(d=s=(r=(i=(o=(a=e)[S]||(a[S]={}))[a.uniqueID]||(o[a.uniqueID]={}))[h]||[])[0]===k&&r[1]),!1===d)while(a=++s&&a&&a[l]||(d=s=0)||u.pop())if((x?a.nodeName.toLowerCase()===f:1===a.nodeType)&&++d&&(p&&((i=(o=a[S]||(a[S]={}))[a.uniqueID]||(o[a.uniqueID]={}))[h]=[k,d]),a===e))break;return(d-=v)===g||d%g==0&&0<=d/g}}},PSEUDO:function(e,o){var t,a=b.pseudos[e]||b.setFilters[e.toLowerCase()]||se.error("unsupported pseudo: "+e);return a[S]?a(o):1<a.length?(t=[e,e,"",o],b.setFilters.hasOwnProperty(e.toLowerCase())?le(function(e,t){var n,r=a(e,o),i=r.length;while(i--)e[n=P(e,r[i])]=!(t[n]=r[i])}):function(e){return a(e,0,t)}):a}},pseudos:{not:le(function(e){var r=[],i=[],s=f(e.replace($,"$1"));return s[S]?le(function(e,t,n,r){var i,o=s(e,null,r,[]),a=e.length;while(a--)(i=o[a])&&(e[a]=!(t[a]=i))}):function(e,t,n){return r[0]=e,s(r,null,n,i),r[0]=null,!i.pop()}}),has:le(function(t){return function(e){return 0<se(t,e).length}}),contains:le(function(t){return t=t.replace(te,ne),function(e){return-1<(e.textContent||o(e)).indexOf(t)}}),lang:le(function(n){return V.test(n||"")||se.error("unsupported lang: "+n),n=n.replace(te,ne).toLowerCase(),function(e){var t;do{if(t=E?e.lang:e.getAttribute("xml:lang")||e.getAttribute("lang"))return(t=t.toLowerCase())===n||0===t.indexOf(n+"-")}while((e=e.parentNode)&&1===e.nodeType);return!1}}),target:function(e){var t=n.location&&n.location.hash;return t&&t.slice(1)===e.id},root:function(e){return e===a},focus:function(e){return e===C.activeElement&&(!C.hasFocus||C.hasFocus())&&!!(e.type||e.href||~e.tabIndex)},enabled:ge(!1),disabled:ge(!0),checked:function(e){var t=e.nodeName.toLowerCase();return"input"===t&&!!e.checked||"option"===t&&!!e.selected},selected:function(e){return e.parentNode&&e.parentNode.selectedIndex,!0===e.selected},empty:function(e){for(e=e.firstChild;e;e=e.nextSibling)if(e.nodeType<6)return!1;return!0},parent:function(e){return!b.pseudos.empty(e)},header:function(e){return J.test(e.nodeName)},input:function(e){return Q.test(e.nodeName)},button:function(e){var t=e.nodeName.toLowerCase();return"input"===t&&"button"===e.type||"button"===t},text:function(e){var t;return"input"===e.nodeName.toLowerCase()&&"text"===e.type&&(null==(t=e.getAttribute("type"))||"text"===t.toLowerCase())},first:ve(function(){return[0]}),last:ve(function(e,t){return[t-1]}),eq:ve(function(e,t,n){return[n<0?n+t:n]}),even:ve(function(e,t){for(var n=0;n<t;n+=2)e.push(n);return e}),odd:ve(function(e,t){for(var n=1;n<t;n+=2)e.push(n);return e}),lt:ve(function(e,t,n){for(var r=n<0?n+t:t<n?t:n;0<=--r;)e.push(r);return e}),gt:ve(function(e,t,n){for(var r=n<0?n+t:n;++r<t;)e.push(r);return e})}}).pseudos.nth=b.pseudos.eq,{radio:!0,checkbox:!0,file:!0,password:!0,image:!0})b.pseudos[e]=de(e);for(e in{submit:!0,reset:!0})b.pseudos[e]=he(e);function me(){}function xe(e){for(var t=0,n=e.length,r="";t<n;t++)r+=e[t].value;return r}function be(s,e,t){var u=e.dir,l=e.next,c=l||u,f=t&&"parentNode"===c,p=r++;return e.first?function(e,t,n){while(e=e[u])if(1===e.nodeType||f)return s(e,t,n);return!1}:function(e,t,n){var r,i,o,a=[k,p];if(n){while(e=e[u])if((1===e.nodeType||f)&&s(e,t,n))return!0}else while(e=e[u])if(1===e.nodeType||f)if(i=(o=e[S]||(e[S]={}))[e.uniqueID]||(o[e.uniqueID]={}),l&&l===e.nodeName.toLowerCase())e=e[u]||e;else{if((r=i[c])&&r[0]===k&&r[1]===p)return a[2]=r[2];if((i[c]=a)[2]=s(e,t,n))return!0}return!1}}function we(i){return 1<i.length?function(e,t,n){var r=i.length;while(r--)if(!i[r](e,t,n))return!1;return!0}:i[0]}function Te(e,t,n,r,i){for(var o,a=[],s=0,u=e.length,l=null!=t;s<u;s++)(o=e[s])&&(n&&!n(o,r,i)||(a.push(o),l&&t.push(s)));return a}function Ce(d,h,g,v,y,e){return v&&!v[S]&&(v=Ce(v)),y&&!y[S]&&(y=Ce(y,e)),le(function(e,t,n,r){var i,o,a,s=[],u=[],l=t.length,c=e||function(e,t,n){for(var r=0,i=t.length;r<i;r++)se(e,t[r],n);return n}(h||"*",n.nodeType?[n]:n,[]),f=!d||!e&&h?c:Te(c,s,d,n,r),p=g?y||(e?d:l||v)?[]:t:f;if(g&&g(f,p,n,r),v){i=Te(p,u),v(i,[],n,r),o=i.length;while(o--)(a=i[o])&&(p[u[o]]=!(f[u[o]]=a))}if(e){if(y||d){if(y){i=[],o=p.length;while(o--)(a=p[o])&&i.push(f[o]=a);y(null,p=[],i,r)}o=p.length;while(o--)(a=p[o])&&-1<(i=y?P(e,a):s[o])&&(e[i]=!(t[i]=a))}}else p=Te(p===t?p.splice(l,p.length):p),y?y(null,t,p,r):H.apply(t,p)})}function Ee(e){for(var i,t,n,r=e.length,o=b.relative[e[0].type],a=o||b.relative[" "],s=o?1:0,u=be(function(e){return e===i},a,!0),l=be(function(e){return-1<P(i,e)},a,!0),c=[function(e,t,n){var r=!o&&(n||t!==w)||((i=t).nodeType?u(e,t,n):l(e,t,n));return i=null,r}];s<r;s++)if(t=b.relative[e[s].type])c=[be(we(c),t)];else{if((t=b.filter[e[s].type].apply(null,e[s].matches))[S]){for(n=++s;n<r;n++)if(b.relative[e[n].type])break;return Ce(1<s&&we(c),1<s&&xe(e.slice(0,s-1).concat({value:" "===e[s-2].type?"*":""})).replace($,"$1"),t,s<n&&Ee(e.slice(s,n)),n<r&&Ee(e=e.slice(n)),n<r&&xe(e))}c.push(t)}return we(c)}return me.prototype=b.filters=b.pseudos,b.setFilters=new me,h=se.tokenize=function(e,t){var n,r,i,o,a,s,u,l=x[e+" "];if(l)return t?0:l.slice(0);a=e,s=[],u=b.preFilter;while(a){for(o in n&&!(r=_.exec(a))||(r&&(a=a.slice(r[0].length)||a),s.push(i=[])),n=!1,(r=z.exec(a))&&(n=r.shift(),i.push({value:n,type:r[0].replace($," ")}),a=a.slice(n.length)),b.filter)!(r=G[o].exec(a))||u[o]&&!(r=u[o](r))||(n=r.shift(),i.push({value:n,type:o,matches:r}),a=a.slice(n.length));if(!n)break}return t?a.length:a?se.error(e):x(e,s).slice(0)},f=se.compile=function(e,t){var n,v,y,m,x,r,i=[],o=[],a=A[e+" "];if(!a){t||(t=h(e)),n=t.length;while(n--)(a=Ee(t[n]))[S]?i.push(a):o.push(a);(a=A(e,(v=o,m=0<(y=i).length,x=0<v.length,r=function(e,t,n,r,i){var o,a,s,u=0,l="0",c=e&&[],f=[],p=w,d=e||x&&b.find.TAG("*",i),h=k+=null==p?1:Math.random()||.1,g=d.length;for(i&&(w=t==C||t||i);l!==g&&null!=(o=d[l]);l++){if(x&&o){a=0,t||o.ownerDocument==C||(T(o),n=!E);while(s=v[a++])if(s(o,t||C,n)){r.push(o);break}i&&(k=h)}m&&((o=!s&&o)&&u--,e&&c.push(o))}if(u+=l,m&&l!==u){a=0;while(s=y[a++])s(c,f,t,n);if(e){if(0<u)while(l--)c[l]||f[l]||(f[l]=q.call(r));f=Te(f)}H.apply(r,f),i&&!e&&0<f.length&&1<u+y.length&&se.uniqueSort(r)}return i&&(k=h,w=p),c},m?le(r):r))).selector=e}return a},g=se.select=function(e,t,n,r){var i,o,a,s,u,l="function"==typeof e&&e,c=!r&&h(e=l.selector||e);if(n=n||[],1===c.length){if(2<(o=c[0]=c[0].slice(0)).length&&"ID"===(a=o[0]).type&&9===t.nodeType&&E&&b.relative[o[1].type]){if(!(t=(b.find.ID(a.matches[0].replace(te,ne),t)||[])[0]))return n;l&&(t=t.parentNode),e=e.slice(o.shift().value.length)}i=G.needsContext.test(e)?0:o.length;while(i--){if(a=o[i],b.relative[s=a.type])break;if((u=b.find[s])&&(r=u(a.matches[0].replace(te,ne),ee.test(o[0].type)&&ye(t.parentNode)||t))){if(o.splice(i,1),!(e=r.length&&xe(o)))return H.apply(n,r),n;break}}}return(l||f(e,c))(r,t,!E,n,!t||ee.test(e)&&ye(t.parentNode)||t),n},d.sortStable=S.split("").sort(j).join("")===S,d.detectDuplicates=!!l,T(),d.sortDetached=ce(function(e){return 1&e.compareDocumentPosition(C.createElement("fieldset"))}),ce(function(e){return e.innerHTML="<a href='#'></a>","#"===e.firstChild.getAttribute("href")})||fe("type|href|height|width",function(e,t,n){if(!n)return e.getAttribute(t,"type"===t.toLowerCase()?1:2)}),d.attributes&&ce(function(e){return e.innerHTML="<input/>",e.firstChild.setAttribute("value",""),""===e.firstChild.getAttribute("value")})||fe("value",function(e,t,n){if(!n&&"input"===e.nodeName.toLowerCase())return e.defaultValue}),ce(function(e){return null==e.getAttribute("disabled")})||fe(R,function(e,t,n){var r;if(!n)return!0===e[t]?t.toLowerCase():(r=e.getAttributeNode(t))&&r.specified?r.value:null}),se}(C);S.find=d,S.expr=d.selectors,S.expr[":"]=S.expr.pseudos,S.uniqueSort=S.unique=d.uniqueSort,S.text=d.getText,S.isXMLDoc=d.isXML,S.contains=d.contains,S.escapeSelector=d.escape;var h=function(e,t,n){var r=[],i=void 0!==n;while((e=e[t])&&9!==e.nodeType)if(1===e.nodeType){if(i&&S(e).is(n))break;r.push(e)}return r},T=function(e,t){for(var n=[];e;e=e.nextSibling)1===e.nodeType&&e!==t&&n.push(e);return n},k=S.expr.match.needsContext;function A(e,t){return e.nodeName&&e.nodeName.toLowerCase()===t.toLowerCase()}var N=/^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;function j(e,n,r){return m(n)?S.grep(e,function(e,t){return!!n.call(e,t,e)!==r}):n.nodeType?S.grep(e,function(e){return e===n!==r}):"string"!=typeof n?S.grep(e,function(e){return-1<i.call(n,e)!==r}):S.filter(n,e,r)}S.filter=function(e,t,n){var r=t[0];return n&&(e=":not("+e+")"),1===t.length&&1===r.nodeType?S.find.matchesSelector(r,e)?[r]:[]:S.find.matches(e,S.grep(t,function(e){return 1===e.nodeType}))},S.fn.extend({find:function(e){var t,n,r=this.length,i=this;if("string"!=typeof e)return this.pushStack(S(e).filter(function(){for(t=0;t<r;t++)if(S.contains(i[t],this))return!0}));for(n=this.pushStack([]),t=0;t<r;t++)S.find(e,i[t],n);return 1<r?S.uniqueSort(n):n},filter:function(e){return this.pushStack(j(this,e||[],!1))},not:function(e){return this.pushStack(j(this,e||[],!0))},is:function(e){return!!j(this,"string"==typeof e&&k.test(e)?S(e):e||[],!1).length}});var D,q=/^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;(S.fn.init=function(e,t,n){var r,i;if(!e)return this;if(n=n||D,"string"==typeof e){if(!(r="<"===e[0]&&">"===e[e.length-1]&&3<=e.length?[null,e,null]:q.exec(e))||!r[1]&&t)return!t||t.jquery?(t||n).find(e):this.constructor(t).find(e);if(r[1]){if(t=t instanceof S?t[0]:t,S.merge(this,S.parseHTML(r[1],t&&t.nodeType?t.ownerDocument||t:E,!0)),N.test(r[1])&&S.isPlainObject(t))for(r in t)m(this[r])?this[r](t[r]):this.attr(r,t[r]);return this}return(i=E.getElementById(r[2]))&&(this[0]=i,this.length=1),this}return e.nodeType?(this[0]=e,this.length=1,this):m(e)?void 0!==n.ready?n.ready(e):e(S):S.makeArray(e,this)}).prototype=S.fn,D=S(E);var L=/^(?:parents|prev(?:Until|All))/,H={children:!0,contents:!0,next:!0,prev:!0};function O(e,t){while((e=e[t])&&1!==e.nodeType);return e}S.fn.extend({has:function(e){var t=S(e,this),n=t.length;return this.filter(function(){for(var e=0;e<n;e++)if(S.contains(this,t[e]))return!0})},closest:function(e,t){var n,r=0,i=this.length,o=[],a="string"!=typeof e&&S(e);if(!k.test(e))for(;r<i;r++)for(n=this[r];n&&n!==t;n=n.parentNode)if(n.nodeType<11&&(a?-1<a.index(n):1===n.nodeType&&S.find.matchesSelector(n,e))){o.push(n);break}return this.pushStack(1<o.length?S.uniqueSort(o):o)},index:function(e){return e?"string"==typeof e?i.call(S(e),this[0]):i.call(this,e.jquery?e[0]:e):this[0]&&this[0].parentNode?this.first().prevAll().length:-1},add:function(e,t){return this.pushStack(S.uniqueSort(S.merge(this.get(),S(e,t))))},addBack:function(e){return this.add(null==e?this.prevObject:this.prevObject.filter(e))}}),S.each({parent:function(e){var t=e.parentNode;return t&&11!==t.nodeType?t:null},parents:function(e){return h(e,"parentNode")},parentsUntil:function(e,t,n){return h(e,"parentNode",n)},next:function(e){return O(e,"nextSibling")},prev:function(e){return O(e,"previousSibling")},nextAll:function(e){return h(e,"nextSibling")},prevAll:function(e){return h(e,"previousSibling")},nextUntil:function(e,t,n){return h(e,"nextSibling",n)},prevUntil:function(e,t,n){return h(e,"previousSibling",n)},siblings:function(e){return T((e.parentNode||{}).firstChild,e)},children:function(e){return T(e.firstChild)},contents:function(e){return null!=e.contentDocument&&r(e.contentDocument)?e.contentDocument:(A(e,"template")&&(e=e.content||e),S.merge([],e.childNodes))}},function(r,i){S.fn[r]=function(e,t){var n=S.map(this,i,e);return"Until"!==r.slice(-5)&&(t=e),t&&"string"==typeof t&&(n=S.filter(t,n)),1<this.length&&(H[r]||S.uniqueSort(n),L.test(r)&&n.reverse()),this.pushStack(n)}});var P=/[^\x20\t\r\n\f]+/g;function R(e){return e}function M(e){throw e}function I(e,t,n,r){var i;try{e&&m(i=e.promise)?i.call(e).done(t).fail(n):e&&m(i=e.then)?i.call(e,t,n):t.apply(void 0,[e].slice(r))}catch(e){n.apply(void 0,[e])}}S.Callbacks=function(r){var e,n;r="string"==typeof r?(e=r,n={},S.each(e.match(P)||[],function(e,t){n[t]=!0}),n):S.extend({},r);var i,t,o,a,s=[],u=[],l=-1,c=function(){for(a=a||r.once,o=i=!0;u.length;l=-1){t=u.shift();while(++l<s.length)!1===s[l].apply(t[0],t[1])&&r.stopOnFalse&&(l=s.length,t=!1)}r.memory||(t=!1),i=!1,a&&(s=t?[]:"")},f={add:function(){return s&&(t&&!i&&(l=s.length-1,u.push(t)),function n(e){S.each(e,function(e,t){m(t)?r.unique&&f.has(t)||s.push(t):t&&t.length&&"string"!==w(t)&&n(t)})}(arguments),t&&!i&&c()),this},remove:function(){return S.each(arguments,function(e,t){var n;while(-1<(n=S.inArray(t,s,n)))s.splice(n,1),n<=l&&l--}),this},has:function(e){return e?-1<S.inArray(e,s):0<s.length},empty:function(){return s&&(s=[]),this},disable:function(){return a=u=[],s=t="",this},disabled:function(){return!s},lock:function(){return a=u=[],t||i||(s=t=""),this},locked:function(){return!!a},fireWith:function(e,t){return a||(t=[e,(t=t||[]).slice?t.slice():t],u.push(t),i||c()),this},fire:function(){return f.fireWith(this,arguments),this},fired:function(){return!!o}};return f},S.extend({Deferred:function(e){var o=[["notify","progress",S.Callbacks("memory"),S.Callbacks("memory"),2],["resolve","done",S.Callbacks("once memory"),S.Callbacks("once memory"),0,"resolved"],["reject","fail",S.Callbacks("once memory"),S.Callbacks("once memory"),1,"rejected"]],i="pending",a={state:function(){return i},always:function(){return s.done(arguments).fail(arguments),this},"catch":function(e){return a.then(null,e)},pipe:function(){var i=arguments;return S.Deferred(function(r){S.each(o,function(e,t){var n=m(i[t[4]])&&i[t[4]];s[t[1]](function(){var e=n&&n.apply(this,arguments);e&&m(e.promise)?e.promise().progress(r.notify).done(r.resolve).fail(r.reject):r[t[0]+"With"](this,n?[e]:arguments)})}),i=null}).promise()},then:function(t,n,r){var u=0;function l(i,o,a,s){return function(){var n=this,r=arguments,e=function(){var e,t;if(!(i<u)){if((e=a.apply(n,r))===o.promise())throw new TypeError("Thenable self-resolution");t=e&&("object"==typeof e||"function"==typeof e)&&e.then,m(t)?s?t.call(e,l(u,o,R,s),l(u,o,M,s)):(u++,t.call(e,l(u,o,R,s),l(u,o,M,s),l(u,o,R,o.notifyWith))):(a!==R&&(n=void 0,r=[e]),(s||o.resolveWith)(n,r))}},t=s?e:function(){try{e()}catch(e){S.Deferred.exceptionHook&&S.Deferred.exceptionHook(e,t.stackTrace),u<=i+1&&(a!==M&&(n=void 0,r=[e]),o.rejectWith(n,r))}};i?t():(S.Deferred.getStackHook&&(t.stackTrace=S.Deferred.getStackHook()),C.setTimeout(t))}}return S.Deferred(function(e){o[0][3].add(l(0,e,m(r)?r:R,e.notifyWith)),o[1][3].add(l(0,e,m(t)?t:R)),o[2][3].add(l(0,e,m(n)?n:M))}).promise()},promise:function(e){return null!=e?S.extend(e,a):a}},s={};return S.each(o,function(e,t){var n=t[2],r=t[5];a[t[1]]=n.add,r&&n.add(function(){i=r},o[3-e][2].disable,o[3-e][3].disable,o[0][2].lock,o[0][3].lock),n.add(t[3].fire),s[t[0]]=function(){return s[t[0]+"With"](this===s?void 0:this,arguments),this},s[t[0]+"With"]=n.fireWith}),a.promise(s),e&&e.call(s,s),s},when:function(e){var n=arguments.length,t=n,r=Array(t),i=s.call(arguments),o=S.Deferred(),a=function(t){return function(e){r[t]=this,i[t]=1<arguments.length?s.call(arguments):e,--n||o.resolveWith(r,i)}};if(n<=1&&(I(e,o.done(a(t)).resolve,o.reject,!n),"pending"===o.state()||m(i[t]&&i[t].then)))return o.then();while(t--)I(i[t],a(t),o.reject);return o.promise()}});var W=/^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;S.Deferred.exceptionHook=function(e,t){C.console&&C.console.warn&&e&&W.test(e.name)&&C.console.warn("jQuery.Deferred exception: "+e.message,e.stack,t)},S.readyException=function(e){C.setTimeout(function(){throw e})};var F=S.Deferred();function B(){E.removeEventListener("DOMContentLoaded",B),C.removeEventListener("load",B),S.ready()}S.fn.ready=function(e){return F.then(e)["catch"](function(e){S.readyException(e)}),this},S.extend({isReady:!1,readyWait:1,ready:function(e){(!0===e?--S.readyWait:S.isReady)||(S.isReady=!0)!==e&&0<--S.readyWait||F.resolveWith(E,[S])}}),S.ready.then=F.then,"complete"===E.readyState||"loading"!==E.readyState&&!E.documentElement.doScroll?C.setTimeout(S.ready):(E.addEventListener("DOMContentLoaded",B),C.addEventListener("load",B));var $=function(e,t,n,r,i,o,a){var s=0,u=e.length,l=null==n;if("object"===w(n))for(s in i=!0,n)$(e,t,s,n[s],!0,o,a);else if(void 0!==r&&(i=!0,m(r)||(a=!0),l&&(a?(t.call(e,r),t=null):(l=t,t=function(e,t,n){return l.call(S(e),n)})),t))for(;s<u;s++)t(e[s],n,a?r:r.call(e[s],s,t(e[s],n)));return i?e:l?t.call(e):u?t(e[0],n):o},_=/^-ms-/,z=/-([a-z])/g;function U(e,t){return t.toUpperCase()}function X(e){return e.replace(_,"ms-").replace(z,U)}var V=function(e){return 1===e.nodeType||9===e.nodeType||!+e.nodeType};function G(){this.expando=S.expando+G.uid++}G.uid=1,G.prototype={cache:function(e){var t=e[this.expando];return t||(t={},V(e)&&(e.nodeType?e[this.expando]=t:Object.defineProperty(e,this.expando,{value:t,configurable:!0}))),t},set:function(e,t,n){var r,i=this.cache(e);if("string"==typeof t)i[X(t)]=n;else for(r in t)i[X(r)]=t[r];return i},get:function(e,t){return void 0===t?this.cache(e):e[this.expando]&&e[this.expando][X(t)]},access:function(e,t,n){return void 0===t||t&&"string"==typeof t&&void 0===n?this.get(e,t):(this.set(e,t,n),void 0!==n?n:t)},remove:function(e,t){var n,r=e[this.expando];if(void 0!==r){if(void 0!==t){n=(t=Array.isArray(t)?t.map(X):(t=X(t))in r?[t]:t.match(P)||[]).length;while(n--)delete r[t[n]]}(void 0===t||S.isEmptyObject(r))&&(e.nodeType?e[this.expando]=void 0:delete e[this.expando])}},hasData:function(e){var t=e[this.expando];return void 0!==t&&!S.isEmptyObject(t)}};var Y=new G,Q=new G,J=/^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,K=/[A-Z]/g;function Z(e,t,n){var r,i;if(void 0===n&&1===e.nodeType)if(r="data-"+t.replace(K,"-$&").toLowerCase(),"string"==typeof(n=e.getAttribute(r))){try{n="true"===(i=n)||"false"!==i&&("null"===i?null:i===+i+""?+i:J.test(i)?JSON.parse(i):i)}catch(e){}Q.set(e,t,n)}else n=void 0;return n}S.extend({hasData:function(e){return Q.hasData(e)||Y.hasData(e)},data:function(e,t,n){return Q.access(e,t,n)},removeData:function(e,t){Q.remove(e,t)},_data:function(e,t,n){return Y.access(e,t,n)},_removeData:function(e,t){Y.remove(e,t)}}),S.fn.extend({data:function(n,e){var t,r,i,o=this[0],a=o&&o.attributes;if(void 0===n){if(this.length&&(i=Q.get(o),1===o.nodeType&&!Y.get(o,"hasDataAttrs"))){t=a.length;while(t--)a[t]&&0===(r=a[t].name).indexOf("data-")&&(r=X(r.slice(5)),Z(o,r,i[r]));Y.set(o,"hasDataAttrs",!0)}return i}return"object"==typeof n?this.each(function(){Q.set(this,n)}):$(this,function(e){var t;if(o&&void 0===e)return void 0!==(t=Q.get(o,n))?t:void 0!==(t=Z(o,n))?t:void 0;this.each(function(){Q.set(this,n,e)})},null,e,1<arguments.length,null,!0)},removeData:function(e){return this.each(function(){Q.remove(this,e)})}}),S.extend({queue:function(e,t,n){var r;if(e)return t=(t||"fx")+"queue",r=Y.get(e,t),n&&(!r||Array.isArray(n)?r=Y.access(e,t,S.makeArray(n)):r.push(n)),r||[]},dequeue:function(e,t){t=t||"fx";var n=S.queue(e,t),r=n.length,i=n.shift(),o=S._queueHooks(e,t);"inprogress"===i&&(i=n.shift(),r--),i&&("fx"===t&&n.unshift("inprogress"),delete o.stop,i.call(e,function(){S.dequeue(e,t)},o)),!r&&o&&o.empty.fire()},_queueHooks:function(e,t){var n=t+"queueHooks";return Y.get(e,n)||Y.access(e,n,{empty:S.Callbacks("once memory").add(function(){Y.remove(e,[t+"queue",n])})})}}),S.fn.extend({queue:function(t,n){var e=2;return"string"!=typeof t&&(n=t,t="fx",e--),arguments.length<e?S.queue(this[0],t):void 0===n?this:this.each(function(){var e=S.queue(this,t,n);S._queueHooks(this,t),"fx"===t&&"inprogress"!==e[0]&&S.dequeue(this,t)})},dequeue:function(e){return this.each(function(){S.dequeue(this,e)})},clearQueue:function(e){return this.queue(e||"fx",[])},promise:function(e,t){var n,r=1,i=S.Deferred(),o=this,a=this.length,s=function(){--r||i.resolveWith(o,[o])};"string"!=typeof e&&(t=e,e=void 0),e=e||"fx";while(a--)(n=Y.get(o[a],e+"queueHooks"))&&n.empty&&(r++,n.empty.add(s));return s(),i.promise(t)}});var ee=/[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,te=new RegExp("^(?:([+-])=|)("+ee+")([a-z%]*)$","i"),ne=["Top","Right","Bottom","Left"],re=E.documentElement,ie=function(e){return S.contains(e.ownerDocument,e)},oe={composed:!0};re.getRootNode&&(ie=function(e){return S.contains(e.ownerDocument,e)||e.getRootNode(oe)===e.ownerDocument});var ae=function(e,t){return"none"===(e=t||e).style.display||""===e.style.display&&ie(e)&&"none"===S.css(e,"display")};function se(e,t,n,r){var i,o,a=20,s=r?function(){return r.cur()}:function(){return S.css(e,t,"")},u=s(),l=n&&n[3]||(S.cssNumber[t]?"":"px"),c=e.nodeType&&(S.cssNumber[t]||"px"!==l&&+u)&&te.exec(S.css(e,t));if(c&&c[3]!==l){u/=2,l=l||c[3],c=+u||1;while(a--)S.style(e,t,c+l),(1-o)*(1-(o=s()/u||.5))<=0&&(a=0),c/=o;c*=2,S.style(e,t,c+l),n=n||[]}return n&&(c=+c||+u||0,i=n[1]?c+(n[1]+1)*n[2]:+n[2],r&&(r.unit=l,r.start=c,r.end=i)),i}var ue={};function le(e,t){for(var n,r,i,o,a,s,u,l=[],c=0,f=e.length;c<f;c++)(r=e[c]).style&&(n=r.style.display,t?("none"===n&&(l[c]=Y.get(r,"display")||null,l[c]||(r.style.display="")),""===r.style.display&&ae(r)&&(l[c]=(u=a=o=void 0,a=(i=r).ownerDocument,s=i.nodeName,(u=ue[s])||(o=a.body.appendChild(a.createElement(s)),u=S.css(o,"display"),o.parentNode.removeChild(o),"none"===u&&(u="block"),ue[s]=u)))):"none"!==n&&(l[c]="none",Y.set(r,"display",n)));for(c=0;c<f;c++)null!=l[c]&&(e[c].style.display=l[c]);return e}S.fn.extend({show:function(){return le(this,!0)},hide:function(){return le(this)},toggle:function(e){return"boolean"==typeof e?e?this.show():this.hide():this.each(function(){ae(this)?S(this).show():S(this).hide()})}});var ce,fe,pe=/^(?:checkbox|radio)$/i,de=/<([a-z][^\/\0>\x20\t\r\n\f]*)/i,he=/^$|^module$|\/(?:java|ecma)script/i;ce=E.createDocumentFragment().appendChild(E.createElement("div")),(fe=E.createElement("input")).setAttribute("type","radio"),fe.setAttribute("checked","checked"),fe.setAttribute("name","t"),ce.appendChild(fe),y.checkClone=ce.cloneNode(!0).cloneNode(!0).lastChild.checked,ce.innerHTML="<textarea>x</textarea>",y.noCloneChecked=!!ce.cloneNode(!0).lastChild.defaultValue,ce.innerHTML="<option></option>",y.option=!!ce.lastChild;var ge={thead:[1,"<table>","</table>"],col:[2,"<table><colgroup>","</colgroup></table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_default:[0,"",""]};function ve(e,t){var n;return n="undefined"!=typeof e.getElementsByTagName?e.getElementsByTagName(t||"*"):"undefined"!=typeof e.querySelectorAll?e.querySelectorAll(t||"*"):[],void 0===t||t&&A(e,t)?S.merge([e],n):n}function ye(e,t){for(var n=0,r=e.length;n<r;n++)Y.set(e[n],"globalEval",!t||Y.get(t[n],"globalEval"))}ge.tbody=ge.tfoot=ge.colgroup=ge.caption=ge.thead,ge.th=ge.td,y.option||(ge.optgroup=ge.option=[1,"<select multiple='multiple'>","</select>"]);var me=/<|&#?\w+;/;function xe(e,t,n,r,i){for(var o,a,s,u,l,c,f=t.createDocumentFragment(),p=[],d=0,h=e.length;d<h;d++)if((o=e[d])||0===o)if("object"===w(o))S.merge(p,o.nodeType?[o]:o);else if(me.test(o)){a=a||f.appendChild(t.createElement("div")),s=(de.exec(o)||["",""])[1].toLowerCase(),u=ge[s]||ge._default,a.innerHTML=u[1]+S.htmlPrefilter(o)+u[2],c=u[0];while(c--)a=a.lastChild;S.merge(p,a.childNodes),(a=f.firstChild).textContent=""}else p.push(t.createTextNode(o));f.textContent="",d=0;while(o=p[d++])if(r&&-1<S.inArray(o,r))i&&i.push(o);else if(l=ie(o),a=ve(f.appendChild(o),"script"),l&&ye(a),n){c=0;while(o=a[c++])he.test(o.type||"")&&n.push(o)}return f}var be=/^([^.]*)(?:\.(.+)|)/;function we(){return!0}function Te(){return!1}function Ce(e,t){return e===function(){try{return E.activeElement}catch(e){}}()==("focus"===t)}function Ee(e,t,n,r,i,o){var a,s;if("object"==typeof t){for(s in"string"!=typeof n&&(r=r||n,n=void 0),t)Ee(e,s,n,r,t[s],o);return e}if(null==r&&null==i?(i=n,r=n=void 0):null==i&&("string"==typeof n?(i=r,r=void 0):(i=r,r=n,n=void 0)),!1===i)i=Te;else if(!i)return e;return 1===o&&(a=i,(i=function(e){return S().off(e),a.apply(this,arguments)}).guid=a.guid||(a.guid=S.guid++)),e.each(function(){S.event.add(this,t,i,r,n)})}function Se(e,i,o){o?(Y.set(e,i,!1),S.event.add(e,i,{namespace:!1,handler:function(e){var t,n,r=Y.get(this,i);if(1&e.isTrigger&&this[i]){if(r.length)(S.event.special[i]||{}).delegateType&&e.stopPropagation();else if(r=s.call(arguments),Y.set(this,i,r),t=o(this,i),this[i](),r!==(n=Y.get(this,i))||t?Y.set(this,i,!1):n={},r!==n)return e.stopImmediatePropagation(),e.preventDefault(),n&&n.value}else r.length&&(Y.set(this,i,{value:S.event.trigger(S.extend(r[0],S.Event.prototype),r.slice(1),this)}),e.stopImmediatePropagation())}})):void 0===Y.get(e,i)&&S.event.add(e,i,we)}S.event={global:{},add:function(t,e,n,r,i){var o,a,s,u,l,c,f,p,d,h,g,v=Y.get(t);if(V(t)){n.handler&&(n=(o=n).handler,i=o.selector),i&&S.find.matchesSelector(re,i),n.guid||(n.guid=S.guid++),(u=v.events)||(u=v.events=Object.create(null)),(a=v.handle)||(a=v.handle=function(e){return"undefined"!=typeof S&&S.event.triggered!==e.type?S.event.dispatch.apply(t,arguments):void 0}),l=(e=(e||"").match(P)||[""]).length;while(l--)d=g=(s=be.exec(e[l])||[])[1],h=(s[2]||"").split(".").sort(),d&&(f=S.event.special[d]||{},d=(i?f.delegateType:f.bindType)||d,f=S.event.special[d]||{},c=S.extend({type:d,origType:g,data:r,handler:n,guid:n.guid,selector:i,needsContext:i&&S.expr.match.needsContext.test(i),namespace:h.join(".")},o),(p=u[d])||((p=u[d]=[]).delegateCount=0,f.setup&&!1!==f.setup.call(t,r,h,a)||t.addEventListener&&t.addEventListener(d,a)),f.add&&(f.add.call(t,c),c.handler.guid||(c.handler.guid=n.guid)),i?p.splice(p.delegateCount++,0,c):p.push(c),S.event.global[d]=!0)}},remove:function(e,t,n,r,i){var o,a,s,u,l,c,f,p,d,h,g,v=Y.hasData(e)&&Y.get(e);if(v&&(u=v.events)){l=(t=(t||"").match(P)||[""]).length;while(l--)if(d=g=(s=be.exec(t[l])||[])[1],h=(s[2]||"").split(".").sort(),d){f=S.event.special[d]||{},p=u[d=(r?f.delegateType:f.bindType)||d]||[],s=s[2]&&new RegExp("(^|\\.)"+h.join("\\.(?:.*\\.|)")+"(\\.|$)"),a=o=p.length;while(o--)c=p[o],!i&&g!==c.origType||n&&n.guid!==c.guid||s&&!s.test(c.namespace)||r&&r!==c.selector&&("**"!==r||!c.selector)||(p.splice(o,1),c.selector&&p.delegateCount--,f.remove&&f.remove.call(e,c));a&&!p.length&&(f.teardown&&!1!==f.teardown.call(e,h,v.handle)||S.removeEvent(e,d,v.handle),delete u[d])}else for(d in u)S.event.remove(e,d+t[l],n,r,!0);S.isEmptyObject(u)&&Y.remove(e,"handle events")}},dispatch:function(e){var t,n,r,i,o,a,s=new Array(arguments.length),u=S.event.fix(e),l=(Y.get(this,"events")||Object.create(null))[u.type]||[],c=S.event.special[u.type]||{};for(s[0]=u,t=1;t<arguments.length;t++)s[t]=arguments[t];if(u.delegateTarget=this,!c.preDispatch||!1!==c.preDispatch.call(this,u)){a=S.event.handlers.call(this,u,l),t=0;while((i=a[t++])&&!u.isPropagationStopped()){u.currentTarget=i.elem,n=0;while((o=i.handlers[n++])&&!u.isImmediatePropagationStopped())u.rnamespace&&!1!==o.namespace&&!u.rnamespace.test(o.namespace)||(u.handleObj=o,u.data=o.data,void 0!==(r=((S.event.special[o.origType]||{}).handle||o.handler).apply(i.elem,s))&&!1===(u.result=r)&&(u.preventDefault(),u.stopPropagation()))}return c.postDispatch&&c.postDispatch.call(this,u),u.result}},handlers:function(e,t){var n,r,i,o,a,s=[],u=t.delegateCount,l=e.target;if(u&&l.nodeType&&!("click"===e.type&&1<=e.button))for(;l!==this;l=l.parentNode||this)if(1===l.nodeType&&("click"!==e.type||!0!==l.disabled)){for(o=[],a={},n=0;n<u;n++)void 0===a[i=(r=t[n]).selector+" "]&&(a[i]=r.needsContext?-1<S(i,this).index(l):S.find(i,this,null,[l]).length),a[i]&&o.push(r);o.length&&s.push({elem:l,handlers:o})}return l=this,u<t.length&&s.push({elem:l,handlers:t.slice(u)}),s},addProp:function(t,e){Object.defineProperty(S.Event.prototype,t,{enumerable:!0,configurable:!0,get:m(e)?function(){if(this.originalEvent)return e(this.originalEvent)}:function(){if(this.originalEvent)return this.originalEvent[t]},set:function(e){Object.defineProperty(this,t,{enumerable:!0,configurable:!0,writable:!0,value:e})}})},fix:function(e){return e[S.expando]?e:new S.Event(e)},special:{load:{noBubble:!0},click:{setup:function(e){var t=this||e;return pe.test(t.type)&&t.click&&A(t,"input")&&Se(t,"click",we),!1},trigger:function(e){var t=this||e;return pe.test(t.type)&&t.click&&A(t,"input")&&Se(t,"click"),!0},_default:function(e){var t=e.target;return pe.test(t.type)&&t.click&&A(t,"input")&&Y.get(t,"click")||A(t,"a")}},beforeunload:{postDispatch:function(e){void 0!==e.result&&e.originalEvent&&(e.originalEvent.returnValue=e.result)}}}},S.removeEvent=function(e,t,n){e.removeEventListener&&e.removeEventListener(t,n)},S.Event=function(e,t){if(!(this instanceof S.Event))return new S.Event(e,t);e&&e.type?(this.originalEvent=e,this.type=e.type,this.isDefaultPrevented=e.defaultPrevented||void 0===e.defaultPrevented&&!1===e.returnValue?we:Te,this.target=e.target&&3===e.target.nodeType?e.target.parentNode:e.target,this.currentTarget=e.currentTarget,this.relatedTarget=e.relatedTarget):this.type=e,t&&S.extend(this,t),this.timeStamp=e&&e.timeStamp||Date.now(),this[S.expando]=!0},S.Event.prototype={constructor:S.Event,isDefaultPrevented:Te,isPropagationStopped:Te,isImmediatePropagationStopped:Te,isSimulated:!1,preventDefault:function(){var e=this.originalEvent;this.isDefaultPrevented=we,e&&!this.isSimulated&&e.preventDefault()},stopPropagation:function(){var e=this.originalEvent;this.isPropagationStopped=we,e&&!this.isSimulated&&e.stopPropagation()},stopImmediatePropagation:function(){var e=this.originalEvent;this.isImmediatePropagationStopped=we,e&&!this.isSimulated&&e.stopImmediatePropagation(),this.stopPropagation()}},S.each({altKey:!0,bubbles:!0,cancelable:!0,changedTouches:!0,ctrlKey:!0,detail:!0,eventPhase:!0,metaKey:!0,pageX:!0,pageY:!0,shiftKey:!0,view:!0,"char":!0,code:!0,charCode:!0,key:!0,keyCode:!0,button:!0,buttons:!0,clientX:!0,clientY:!0,offsetX:!0,offsetY:!0,pointerId:!0,pointerType:!0,screenX:!0,screenY:!0,targetTouches:!0,toElement:!0,touches:!0,which:!0},S.event.addProp),S.each({focus:"focusin",blur:"focusout"},function(e,t){S.event.special[e]={setup:function(){return Se(this,e,Ce),!1},trigger:function(){return Se(this,e),!0},_default:function(){return!0},delegateType:t}}),S.each({mouseenter:"mouseover",mouseleave:"mouseout",pointerenter:"pointerover",pointerleave:"pointerout"},function(e,i){S.event.special[e]={delegateType:i,bindType:i,handle:function(e){var t,n=e.relatedTarget,r=e.handleObj;return n&&(n===this||S.contains(this,n))||(e.type=r.origType,t=r.handler.apply(this,arguments),e.type=i),t}}}),S.fn.extend({on:function(e,t,n,r){return Ee(this,e,t,n,r)},one:function(e,t,n,r){return Ee(this,e,t,n,r,1)},off:function(e,t,n){var r,i;if(e&&e.preventDefault&&e.handleObj)return r=e.handleObj,S(e.delegateTarget).off(r.namespace?r.origType+"."+r.namespace:r.origType,r.selector,r.handler),this;if("object"==typeof e){for(i in e)this.off(i,t,e[i]);return this}return!1!==t&&"function"!=typeof t||(n=t,t=void 0),!1===n&&(n=Te),this.each(function(){S.event.remove(this,e,n,t)})}});var ke=/<script|<style|<link/i,Ae=/checked\s*(?:[^=]|=\s*.checked.)/i,Ne=/^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;function je(e,t){return A(e,"table")&&A(11!==t.nodeType?t:t.firstChild,"tr")&&S(e).children("tbody")[0]||e}function De(e){return e.type=(null!==e.getAttribute("type"))+"/"+e.type,e}function qe(e){return"true/"===(e.type||"").slice(0,5)?e.type=e.type.slice(5):e.removeAttribute("type"),e}function Le(e,t){var n,r,i,o,a,s;if(1===t.nodeType){if(Y.hasData(e)&&(s=Y.get(e).events))for(i in Y.remove(t,"handle events"),s)for(n=0,r=s[i].length;n<r;n++)S.event.add(t,i,s[i][n]);Q.hasData(e)&&(o=Q.access(e),a=S.extend({},o),Q.set(t,a))}}function He(n,r,i,o){r=g(r);var e,t,a,s,u,l,c=0,f=n.length,p=f-1,d=r[0],h=m(d);if(h||1<f&&"string"==typeof d&&!y.checkClone&&Ae.test(d))return n.each(function(e){var t=n.eq(e);h&&(r[0]=d.call(this,e,t.html())),He(t,r,i,o)});if(f&&(t=(e=xe(r,n[0].ownerDocument,!1,n,o)).firstChild,1===e.childNodes.length&&(e=t),t||o)){for(s=(a=S.map(ve(e,"script"),De)).length;c<f;c++)u=e,c!==p&&(u=S.clone(u,!0,!0),s&&S.merge(a,ve(u,"script"))),i.call(n[c],u,c);if(s)for(l=a[a.length-1].ownerDocument,S.map(a,qe),c=0;c<s;c++)u=a[c],he.test(u.type||"")&&!Y.access(u,"globalEval")&&S.contains(l,u)&&(u.src&&"module"!==(u.type||"").toLowerCase()?S._evalUrl&&!u.noModule&&S._evalUrl(u.src,{nonce:u.nonce||u.getAttribute("nonce")},l):b(u.textContent.replace(Ne,""),u,l))}return n}function Oe(e,t,n){for(var r,i=t?S.filter(t,e):e,o=0;null!=(r=i[o]);o++)n||1!==r.nodeType||S.cleanData(ve(r)),r.parentNode&&(n&&ie(r)&&ye(ve(r,"script")),r.parentNode.removeChild(r));return e}S.extend({htmlPrefilter:function(e){return e},clone:function(e,t,n){var r,i,o,a,s,u,l,c=e.cloneNode(!0),f=ie(e);if(!(y.noCloneChecked||1!==e.nodeType&&11!==e.nodeType||S.isXMLDoc(e)))for(a=ve(c),r=0,i=(o=ve(e)).length;r<i;r++)s=o[r],u=a[r],void 0,"input"===(l=u.nodeName.toLowerCase())&&pe.test(s.type)?u.checked=s.checked:"input"!==l&&"textarea"!==l||(u.defaultValue=s.defaultValue);if(t)if(n)for(o=o||ve(e),a=a||ve(c),r=0,i=o.length;r<i;r++)Le(o[r],a[r]);else Le(e,c);return 0<(a=ve(c,"script")).length&&ye(a,!f&&ve(e,"script")),c},cleanData:function(e){for(var t,n,r,i=S.event.special,o=0;void 0!==(n=e[o]);o++)if(V(n)){if(t=n[Y.expando]){if(t.events)for(r in t.events)i[r]?S.event.remove(n,r):S.removeEvent(n,r,t.handle);n[Y.expando]=void 0}n[Q.expando]&&(n[Q.expando]=void 0)}}}),S.fn.extend({detach:function(e){return Oe(this,e,!0)},remove:function(e){return Oe(this,e)},text:function(e){return $(this,function(e){return void 0===e?S.text(this):this.empty().each(function(){1!==this.nodeType&&11!==this.nodeType&&9!==this.nodeType||(this.textContent=e)})},null,e,arguments.length)},append:function(){return He(this,arguments,function(e){1!==this.nodeType&&11!==this.nodeType&&9!==this.nodeType||je(this,e).appendChild(e)})},prepend:function(){return He(this,arguments,function(e){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var t=je(this,e);t.insertBefore(e,t.firstChild)}})},before:function(){return He(this,arguments,function(e){this.parentNode&&this.parentNode.insertBefore(e,this)})},after:function(){return He(this,arguments,function(e){this.parentNode&&this.parentNode.insertBefore(e,this.nextSibling)})},empty:function(){for(var e,t=0;null!=(e=this[t]);t++)1===e.nodeType&&(S.cleanData(ve(e,!1)),e.textContent="");return this},clone:function(e,t){return e=null!=e&&e,t=null==t?e:t,this.map(function(){return S.clone(this,e,t)})},html:function(e){return $(this,function(e){var t=this[0]||{},n=0,r=this.length;if(void 0===e&&1===t.nodeType)return t.innerHTML;if("string"==typeof e&&!ke.test(e)&&!ge[(de.exec(e)||["",""])[1].toLowerCase()]){e=S.htmlPrefilter(e);try{for(;n<r;n++)1===(t=this[n]||{}).nodeType&&(S.cleanData(ve(t,!1)),t.innerHTML=e);t=0}catch(e){}}t&&this.empty().append(e)},null,e,arguments.length)},replaceWith:function(){var n=[];return He(this,arguments,function(e){var t=this.parentNode;S.inArray(this,n)<0&&(S.cleanData(ve(this)),t&&t.replaceChild(e,this))},n)}}),S.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(e,a){S.fn[e]=function(e){for(var t,n=[],r=S(e),i=r.length-1,o=0;o<=i;o++)t=o===i?this:this.clone(!0),S(r[o])[a](t),u.apply(n,t.get());return this.pushStack(n)}});var Pe=new RegExp("^("+ee+")(?!px)[a-z%]+$","i"),Re=function(e){var t=e.ownerDocument.defaultView;return t&&t.opener||(t=C),t.getComputedStyle(e)},Me=function(e,t,n){var r,i,o={};for(i in t)o[i]=e.style[i],e.style[i]=t[i];for(i in r=n.call(e),t)e.style[i]=o[i];return r},Ie=new RegExp(ne.join("|"),"i");function We(e,t,n){var r,i,o,a,s=e.style;return(n=n||Re(e))&&(""!==(a=n.getPropertyValue(t)||n[t])||ie(e)||(a=S.style(e,t)),!y.pixelBoxStyles()&&Pe.test(a)&&Ie.test(t)&&(r=s.width,i=s.minWidth,o=s.maxWidth,s.minWidth=s.maxWidth=s.width=a,a=n.width,s.width=r,s.minWidth=i,s.maxWidth=o)),void 0!==a?a+"":a}function Fe(e,t){return{get:function(){if(!e())return(this.get=t).apply(this,arguments);delete this.get}}}!function(){function e(){if(l){u.style.cssText="position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0",l.style.cssText="position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%",re.appendChild(u).appendChild(l);var e=C.getComputedStyle(l);n="1%"!==e.top,s=12===t(e.marginLeft),l.style.right="60%",o=36===t(e.right),r=36===t(e.width),l.style.position="absolute",i=12===t(l.offsetWidth/3),re.removeChild(u),l=null}}function t(e){return Math.round(parseFloat(e))}var n,r,i,o,a,s,u=E.createElement("div"),l=E.createElement("div");l.style&&(l.style.backgroundClip="content-box",l.cloneNode(!0).style.backgroundClip="",y.clearCloneStyle="content-box"===l.style.backgroundClip,S.extend(y,{boxSizingReliable:function(){return e(),r},pixelBoxStyles:function(){return e(),o},pixelPosition:function(){return e(),n},reliableMarginLeft:function(){return e(),s},scrollboxSize:function(){return e(),i},reliableTrDimensions:function(){var e,t,n,r;return null==a&&(e=E.createElement("table"),t=E.createElement("tr"),n=E.createElement("div"),e.style.cssText="position:absolute;left:-11111px;border-collapse:separate",t.style.cssText="border:1px solid",t.style.height="1px",n.style.height="9px",n.style.display="block",re.appendChild(e).appendChild(t).appendChild(n),r=C.getComputedStyle(t),a=parseInt(r.height,10)+parseInt(r.borderTopWidth,10)+parseInt(r.borderBottomWidth,10)===t.offsetHeight,re.removeChild(e)),a}}))}();var Be=["Webkit","Moz","ms"],$e=E.createElement("div").style,_e={};function ze(e){var t=S.cssProps[e]||_e[e];return t||(e in $e?e:_e[e]=function(e){var t=e[0].toUpperCase()+e.slice(1),n=Be.length;while(n--)if((e=Be[n]+t)in $e)return e}(e)||e)}var Ue=/^(none|table(?!-c[ea]).+)/,Xe=/^--/,Ve={position:"absolute",visibility:"hidden",display:"block"},Ge={letterSpacing:"0",fontWeight:"400"};function Ye(e,t,n){var r=te.exec(t);return r?Math.max(0,r[2]-(n||0))+(r[3]||"px"):t}function Qe(e,t,n,r,i,o){var a="width"===t?1:0,s=0,u=0;if(n===(r?"border":"content"))return 0;for(;a<4;a+=2)"margin"===n&&(u+=S.css(e,n+ne[a],!0,i)),r?("content"===n&&(u-=S.css(e,"padding"+ne[a],!0,i)),"margin"!==n&&(u-=S.css(e,"border"+ne[a]+"Width",!0,i))):(u+=S.css(e,"padding"+ne[a],!0,i),"padding"!==n?u+=S.css(e,"border"+ne[a]+"Width",!0,i):s+=S.css(e,"border"+ne[a]+"Width",!0,i));return!r&&0<=o&&(u+=Math.max(0,Math.ceil(e["offset"+t[0].toUpperCase()+t.slice(1)]-o-u-s-.5))||0),u}function Je(e,t,n){var r=Re(e),i=(!y.boxSizingReliable()||n)&&"border-box"===S.css(e,"boxSizing",!1,r),o=i,a=We(e,t,r),s="offset"+t[0].toUpperCase()+t.slice(1);if(Pe.test(a)){if(!n)return a;a="auto"}return(!y.boxSizingReliable()&&i||!y.reliableTrDimensions()&&A(e,"tr")||"auto"===a||!parseFloat(a)&&"inline"===S.css(e,"display",!1,r))&&e.getClientRects().length&&(i="border-box"===S.css(e,"boxSizing",!1,r),(o=s in e)&&(a=e[s])),(a=parseFloat(a)||0)+Qe(e,t,n||(i?"border":"content"),o,r,a)+"px"}function Ke(e,t,n,r,i){return new Ke.prototype.init(e,t,n,r,i)}S.extend({cssHooks:{opacity:{get:function(e,t){if(t){var n=We(e,"opacity");return""===n?"1":n}}}},cssNumber:{animationIterationCount:!0,columnCount:!0,fillOpacity:!0,flexGrow:!0,flexShrink:!0,fontWeight:!0,gridArea:!0,gridColumn:!0,gridColumnEnd:!0,gridColumnStart:!0,gridRow:!0,gridRowEnd:!0,gridRowStart:!0,lineHeight:!0,opacity:!0,order:!0,orphans:!0,widows:!0,zIndex:!0,zoom:!0},cssProps:{},style:function(e,t,n,r){if(e&&3!==e.nodeType&&8!==e.nodeType&&e.style){var i,o,a,s=X(t),u=Xe.test(t),l=e.style;if(u||(t=ze(s)),a=S.cssHooks[t]||S.cssHooks[s],void 0===n)return a&&"get"in a&&void 0!==(i=a.get(e,!1,r))?i:l[t];"string"===(o=typeof n)&&(i=te.exec(n))&&i[1]&&(n=se(e,t,i),o="number"),null!=n&&n==n&&("number"!==o||u||(n+=i&&i[3]||(S.cssNumber[s]?"":"px")),y.clearCloneStyle||""!==n||0!==t.indexOf("background")||(l[t]="inherit"),a&&"set"in a&&void 0===(n=a.set(e,n,r))||(u?l.setProperty(t,n):l[t]=n))}},css:function(e,t,n,r){var i,o,a,s=X(t);return Xe.test(t)||(t=ze(s)),(a=S.cssHooks[t]||S.cssHooks[s])&&"get"in a&&(i=a.get(e,!0,n)),void 0===i&&(i=We(e,t,r)),"normal"===i&&t in Ge&&(i=Ge[t]),""===n||n?(o=parseFloat(i),!0===n||isFinite(o)?o||0:i):i}}),S.each(["height","width"],function(e,u){S.cssHooks[u]={get:function(e,t,n){if(t)return!Ue.test(S.css(e,"display"))||e.getClientRects().length&&e.getBoundingClientRect().width?Je(e,u,n):Me(e,Ve,function(){return Je(e,u,n)})},set:function(e,t,n){var r,i=Re(e),o=!y.scrollboxSize()&&"absolute"===i.position,a=(o||n)&&"border-box"===S.css(e,"boxSizing",!1,i),s=n?Qe(e,u,n,a,i):0;return a&&o&&(s-=Math.ceil(e["offset"+u[0].toUpperCase()+u.slice(1)]-parseFloat(i[u])-Qe(e,u,"border",!1,i)-.5)),s&&(r=te.exec(t))&&"px"!==(r[3]||"px")&&(e.style[u]=t,t=S.css(e,u)),Ye(0,t,s)}}}),S.cssHooks.marginLeft=Fe(y.reliableMarginLeft,function(e,t){if(t)return(parseFloat(We(e,"marginLeft"))||e.getBoundingClientRect().left-Me(e,{marginLeft:0},function(){return e.getBoundingClientRect().left}))+"px"}),S.each({margin:"",padding:"",border:"Width"},function(i,o){S.cssHooks[i+o]={expand:function(e){for(var t=0,n={},r="string"==typeof e?e.split(" "):[e];t<4;t++)n[i+ne[t]+o]=r[t]||r[t-2]||r[0];return n}},"margin"!==i&&(S.cssHooks[i+o].set=Ye)}),S.fn.extend({css:function(e,t){return $(this,function(e,t,n){var r,i,o={},a=0;if(Array.isArray(t)){for(r=Re(e),i=t.length;a<i;a++)o[t[a]]=S.css(e,t[a],!1,r);return o}return void 0!==n?S.style(e,t,n):S.css(e,t)},e,t,1<arguments.length)}}),((S.Tween=Ke).prototype={constructor:Ke,init:function(e,t,n,r,i,o){this.elem=e,this.prop=n,this.easing=i||S.easing._default,this.options=t,this.start=this.now=this.cur(),this.end=r,this.unit=o||(S.cssNumber[n]?"":"px")},cur:function(){var e=Ke.propHooks[this.prop];return e&&e.get?e.get(this):Ke.propHooks._default.get(this)},run:function(e){var t,n=Ke.propHooks[this.prop];return this.options.duration?this.pos=t=S.easing[this.easing](e,this.options.duration*e,0,1,this.options.duration):this.pos=t=e,this.now=(this.end-this.start)*t+this.start,this.options.step&&this.options.step.call(this.elem,this.now,this),n&&n.set?n.set(this):Ke.propHooks._default.set(this),this}}).init.prototype=Ke.prototype,(Ke.propHooks={_default:{get:function(e){var t;return 1!==e.elem.nodeType||null!=e.elem[e.prop]&&null==e.elem.style[e.prop]?e.elem[e.prop]:(t=S.css(e.elem,e.prop,""))&&"auto"!==t?t:0},set:function(e){S.fx.step[e.prop]?S.fx.step[e.prop](e):1!==e.elem.nodeType||!S.cssHooks[e.prop]&&null==e.elem.style[ze(e.prop)]?e.elem[e.prop]=e.now:S.style(e.elem,e.prop,e.now+e.unit)}}}).scrollTop=Ke.propHooks.scrollLeft={set:function(e){e.elem.nodeType&&e.elem.parentNode&&(e.elem[e.prop]=e.now)}},S.easing={linear:function(e){return e},swing:function(e){return.5-Math.cos(e*Math.PI)/2},_default:"swing"},S.fx=Ke.prototype.init,S.fx.step={};var Ze,et,tt,nt,rt=/^(?:toggle|show|hide)$/,it=/queueHooks$/;function ot(){et&&(!1===E.hidden&&C.requestAnimationFrame?C.requestAnimationFrame(ot):C.setTimeout(ot,S.fx.interval),S.fx.tick())}function at(){return C.setTimeout(function(){Ze=void 0}),Ze=Date.now()}function st(e,t){var n,r=0,i={height:e};for(t=t?1:0;r<4;r+=2-t)i["margin"+(n=ne[r])]=i["padding"+n]=e;return t&&(i.opacity=i.width=e),i}function ut(e,t,n){for(var r,i=(lt.tweeners[t]||[]).concat(lt.tweeners["*"]),o=0,a=i.length;o<a;o++)if(r=i[o].call(n,t,e))return r}function lt(o,e,t){var n,a,r=0,i=lt.prefilters.length,s=S.Deferred().always(function(){delete u.elem}),u=function(){if(a)return!1;for(var e=Ze||at(),t=Math.max(0,l.startTime+l.duration-e),n=1-(t/l.duration||0),r=0,i=l.tweens.length;r<i;r++)l.tweens[r].run(n);return s.notifyWith(o,[l,n,t]),n<1&&i?t:(i||s.notifyWith(o,[l,1,0]),s.resolveWith(o,[l]),!1)},l=s.promise({elem:o,props:S.extend({},e),opts:S.extend(!0,{specialEasing:{},easing:S.easing._default},t),originalProperties:e,originalOptions:t,startTime:Ze||at(),duration:t.duration,tweens:[],createTween:function(e,t){var n=S.Tween(o,l.opts,e,t,l.opts.specialEasing[e]||l.opts.easing);return l.tweens.push(n),n},stop:function(e){var t=0,n=e?l.tweens.length:0;if(a)return this;for(a=!0;t<n;t++)l.tweens[t].run(1);return e?(s.notifyWith(o,[l,1,0]),s.resolveWith(o,[l,e])):s.rejectWith(o,[l,e]),this}}),c=l.props;for(!function(e,t){var n,r,i,o,a;for(n in e)if(i=t[r=X(n)],o=e[n],Array.isArray(o)&&(i=o[1],o=e[n]=o[0]),n!==r&&(e[r]=o,delete e[n]),(a=S.cssHooks[r])&&"expand"in a)for(n in o=a.expand(o),delete e[r],o)n in e||(e[n]=o[n],t[n]=i);else t[r]=i}(c,l.opts.specialEasing);r<i;r++)if(n=lt.prefilters[r].call(l,o,c,l.opts))return m(n.stop)&&(S._queueHooks(l.elem,l.opts.queue).stop=n.stop.bind(n)),n;return S.map(c,ut,l),m(l.opts.start)&&l.opts.start.call(o,l),l.progress(l.opts.progress).done(l.opts.done,l.opts.complete).fail(l.opts.fail).always(l.opts.always),S.fx.timer(S.extend(u,{elem:o,anim:l,queue:l.opts.queue})),l}S.Animation=S.extend(lt,{tweeners:{"*":[function(e,t){var n=this.createTween(e,t);return se(n.elem,e,te.exec(t),n),n}]},tweener:function(e,t){m(e)?(t=e,e=["*"]):e=e.match(P);for(var n,r=0,i=e.length;r<i;r++)n=e[r],lt.tweeners[n]=lt.tweeners[n]||[],lt.tweeners[n].unshift(t)},prefilters:[function(e,t,n){var r,i,o,a,s,u,l,c,f="width"in t||"height"in t,p=this,d={},h=e.style,g=e.nodeType&&ae(e),v=Y.get(e,"fxshow");for(r in n.queue||(null==(a=S._queueHooks(e,"fx")).unqueued&&(a.unqueued=0,s=a.empty.fire,a.empty.fire=function(){a.unqueued||s()}),a.unqueued++,p.always(function(){p.always(function(){a.unqueued--,S.queue(e,"fx").length||a.empty.fire()})})),t)if(i=t[r],rt.test(i)){if(delete t[r],o=o||"toggle"===i,i===(g?"hide":"show")){if("show"!==i||!v||void 0===v[r])continue;g=!0}d[r]=v&&v[r]||S.style(e,r)}if((u=!S.isEmptyObject(t))||!S.isEmptyObject(d))for(r in f&&1===e.nodeType&&(n.overflow=[h.overflow,h.overflowX,h.overflowY],null==(l=v&&v.display)&&(l=Y.get(e,"display")),"none"===(c=S.css(e,"display"))&&(l?c=l:(le([e],!0),l=e.style.display||l,c=S.css(e,"display"),le([e]))),("inline"===c||"inline-block"===c&&null!=l)&&"none"===S.css(e,"float")&&(u||(p.done(function(){h.display=l}),null==l&&(c=h.display,l="none"===c?"":c)),h.display="inline-block")),n.overflow&&(h.overflow="hidden",p.always(function(){h.overflow=n.overflow[0],h.overflowX=n.overflow[1],h.overflowY=n.overflow[2]})),u=!1,d)u||(v?"hidden"in v&&(g=v.hidden):v=Y.access(e,"fxshow",{display:l}),o&&(v.hidden=!g),g&&le([e],!0),p.done(function(){for(r in g||le([e]),Y.remove(e,"fxshow"),d)S.style(e,r,d[r])})),u=ut(g?v[r]:0,r,p),r in v||(v[r]=u.start,g&&(u.end=u.start,u.start=0))}],prefilter:function(e,t){t?lt.prefilters.unshift(e):lt.prefilters.push(e)}}),S.speed=function(e,t,n){var r=e&&"object"==typeof e?S.extend({},e):{complete:n||!n&&t||m(e)&&e,duration:e,easing:n&&t||t&&!m(t)&&t};return S.fx.off?r.duration=0:"number"!=typeof r.duration&&(r.duration in S.fx.speeds?r.duration=S.fx.speeds[r.duration]:r.duration=S.fx.speeds._default),null!=r.queue&&!0!==r.queue||(r.queue="fx"),r.old=r.complete,r.complete=function(){m(r.old)&&r.old.call(this),r.queue&&S.dequeue(this,r.queue)},r},S.fn.extend({fadeTo:function(e,t,n,r){return this.filter(ae).css("opacity",0).show().end().animate({opacity:t},e,n,r)},animate:function(t,e,n,r){var i=S.isEmptyObject(t),o=S.speed(e,n,r),a=function(){var e=lt(this,S.extend({},t),o);(i||Y.get(this,"finish"))&&e.stop(!0)};return a.finish=a,i||!1===o.queue?this.each(a):this.queue(o.queue,a)},stop:function(i,e,o){var a=function(e){var t=e.stop;delete e.stop,t(o)};return"string"!=typeof i&&(o=e,e=i,i=void 0),e&&this.queue(i||"fx",[]),this.each(function(){var e=!0,t=null!=i&&i+"queueHooks",n=S.timers,r=Y.get(this);if(t)r[t]&&r[t].stop&&a(r[t]);else for(t in r)r[t]&&r[t].stop&&it.test(t)&&a(r[t]);for(t=n.length;t--;)n[t].elem!==this||null!=i&&n[t].queue!==i||(n[t].anim.stop(o),e=!1,n.splice(t,1));!e&&o||S.dequeue(this,i)})},finish:function(a){return!1!==a&&(a=a||"fx"),this.each(function(){var e,t=Y.get(this),n=t[a+"queue"],r=t[a+"queueHooks"],i=S.timers,o=n?n.length:0;for(t.finish=!0,S.queue(this,a,[]),r&&r.stop&&r.stop.call(this,!0),e=i.length;e--;)i[e].elem===this&&i[e].queue===a&&(i[e].anim.stop(!0),i.splice(e,1));for(e=0;e<o;e++)n[e]&&n[e].finish&&n[e].finish.call(this);delete t.finish})}}),S.each(["toggle","show","hide"],function(e,r){var i=S.fn[r];S.fn[r]=function(e,t,n){return null==e||"boolean"==typeof e?i.apply(this,arguments):this.animate(st(r,!0),e,t,n)}}),S.each({slideDown:st("show"),slideUp:st("hide"),slideToggle:st("toggle"),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(e,r){S.fn[e]=function(e,t,n){return this.animate(r,e,t,n)}}),S.timers=[],S.fx.tick=function(){var e,t=0,n=S.timers;for(Ze=Date.now();t<n.length;t++)(e=n[t])()||n[t]!==e||n.splice(t--,1);n.length||S.fx.stop(),Ze=void 0},S.fx.timer=function(e){S.timers.push(e),S.fx.start()},S.fx.interval=13,S.fx.start=function(){et||(et=!0,ot())},S.fx.stop=function(){et=null},S.fx.speeds={slow:600,fast:200,_default:400},S.fn.delay=function(r,e){return r=S.fx&&S.fx.speeds[r]||r,e=e||"fx",this.queue(e,function(e,t){var n=C.setTimeout(e,r);t.stop=function(){C.clearTimeout(n)}})},tt=E.createElement("input"),nt=E.createElement("select").appendChild(E.createElement("option")),tt.type="checkbox",y.checkOn=""!==tt.value,y.optSelected=nt.selected,(tt=E.createElement("input")).value="t",tt.type="radio",y.radioValue="t"===tt.value;var ct,ft=S.expr.attrHandle;S.fn.extend({attr:function(e,t){return $(this,S.attr,e,t,1<arguments.length)},removeAttr:function(e){return this.each(function(){S.removeAttr(this,e)})}}),S.extend({attr:function(e,t,n){var r,i,o=e.nodeType;if(3!==o&&8!==o&&2!==o)return"undefined"==typeof e.getAttribute?S.prop(e,t,n):(1===o&&S.isXMLDoc(e)||(i=S.attrHooks[t.toLowerCase()]||(S.expr.match.bool.test(t)?ct:void 0)),void 0!==n?null===n?void S.removeAttr(e,t):i&&"set"in i&&void 0!==(r=i.set(e,n,t))?r:(e.setAttribute(t,n+""),n):i&&"get"in i&&null!==(r=i.get(e,t))?r:null==(r=S.find.attr(e,t))?void 0:r)},attrHooks:{type:{set:function(e,t){if(!y.radioValue&&"radio"===t&&A(e,"input")){var n=e.value;return e.setAttribute("type",t),n&&(e.value=n),t}}}},removeAttr:function(e,t){var n,r=0,i=t&&t.match(P);if(i&&1===e.nodeType)while(n=i[r++])e.removeAttribute(n)}}),ct={set:function(e,t,n){return!1===t?S.removeAttr(e,n):e.setAttribute(n,n),n}},S.each(S.expr.match.bool.source.match(/\w+/g),function(e,t){var a=ft[t]||S.find.attr;ft[t]=function(e,t,n){var r,i,o=t.toLowerCase();return n||(i=ft[o],ft[o]=r,r=null!=a(e,t,n)?o:null,ft[o]=i),r}});var pt=/^(?:input|select|textarea|button)$/i,dt=/^(?:a|area)$/i;function ht(e){return(e.match(P)||[]).join(" ")}function gt(e){return e.getAttribute&&e.getAttribute("class")||""}function vt(e){return Array.isArray(e)?e:"string"==typeof e&&e.match(P)||[]}S.fn.extend({prop:function(e,t){return $(this,S.prop,e,t,1<arguments.length)},removeProp:function(e){return this.each(function(){delete this[S.propFix[e]||e]})}}),S.extend({prop:function(e,t,n){var r,i,o=e.nodeType;if(3!==o&&8!==o&&2!==o)return 1===o&&S.isXMLDoc(e)||(t=S.propFix[t]||t,i=S.propHooks[t]),void 0!==n?i&&"set"in i&&void 0!==(r=i.set(e,n,t))?r:e[t]=n:i&&"get"in i&&null!==(r=i.get(e,t))?r:e[t]},propHooks:{tabIndex:{get:function(e){var t=S.find.attr(e,"tabindex");return t?parseInt(t,10):pt.test(e.nodeName)||dt.test(e.nodeName)&&e.href?0:-1}}},propFix:{"for":"htmlFor","class":"className"}}),y.optSelected||(S.propHooks.selected={get:function(e){var t=e.parentNode;return t&&t.parentNode&&t.parentNode.selectedIndex,null},set:function(e){var t=e.parentNode;t&&(t.selectedIndex,t.parentNode&&t.parentNode.selectedIndex)}}),S.each(["tabIndex","readOnly","maxLength","cellSpacing","cellPadding","rowSpan","colSpan","useMap","frameBorder","contentEditable"],function(){S.propFix[this.toLowerCase()]=this}),S.fn.extend({addClass:function(t){var e,n,r,i,o,a,s,u=0;if(m(t))return this.each(function(e){S(this).addClass(t.call(this,e,gt(this)))});if((e=vt(t)).length)while(n=this[u++])if(i=gt(n),r=1===n.nodeType&&" "+ht(i)+" "){a=0;while(o=e[a++])r.indexOf(" "+o+" ")<0&&(r+=o+" ");i!==(s=ht(r))&&n.setAttribute("class",s)}return this},removeClass:function(t){var e,n,r,i,o,a,s,u=0;if(m(t))return this.each(function(e){S(this).removeClass(t.call(this,e,gt(this)))});if(!arguments.length)return this.attr("class","");if((e=vt(t)).length)while(n=this[u++])if(i=gt(n),r=1===n.nodeType&&" "+ht(i)+" "){a=0;while(o=e[a++])while(-1<r.indexOf(" "+o+" "))r=r.replace(" "+o+" "," ");i!==(s=ht(r))&&n.setAttribute("class",s)}return this},toggleClass:function(i,t){var o=typeof i,a="string"===o||Array.isArray(i);return"boolean"==typeof t&&a?t?this.addClass(i):this.removeClass(i):m(i)?this.each(function(e){S(this).toggleClass(i.call(this,e,gt(this),t),t)}):this.each(function(){var e,t,n,r;if(a){t=0,n=S(this),r=vt(i);while(e=r[t++])n.hasClass(e)?n.removeClass(e):n.addClass(e)}else void 0!==i&&"boolean"!==o||((e=gt(this))&&Y.set(this,"__className__",e),this.setAttribute&&this.setAttribute("class",e||!1===i?"":Y.get(this,"__className__")||""))})},hasClass:function(e){var t,n,r=0;t=" "+e+" ";while(n=this[r++])if(1===n.nodeType&&-1<(" "+ht(gt(n))+" ").indexOf(t))return!0;return!1}});var yt=/\r/g;S.fn.extend({val:function(n){var r,e,i,t=this[0];return arguments.length?(i=m(n),this.each(function(e){var t;1===this.nodeType&&(null==(t=i?n.call(this,e,S(this).val()):n)?t="":"number"==typeof t?t+="":Array.isArray(t)&&(t=S.map(t,function(e){return null==e?"":e+""})),(r=S.valHooks[this.type]||S.valHooks[this.nodeName.toLowerCase()])&&"set"in r&&void 0!==r.set(this,t,"value")||(this.value=t))})):t?(r=S.valHooks[t.type]||S.valHooks[t.nodeName.toLowerCase()])&&"get"in r&&void 0!==(e=r.get(t,"value"))?e:"string"==typeof(e=t.value)?e.replace(yt,""):null==e?"":e:void 0}}),S.extend({valHooks:{option:{get:function(e){var t=S.find.attr(e,"value");return null!=t?t:ht(S.text(e))}},select:{get:function(e){var t,n,r,i=e.options,o=e.selectedIndex,a="select-one"===e.type,s=a?null:[],u=a?o+1:i.length;for(r=o<0?u:a?o:0;r<u;r++)if(((n=i[r]).selected||r===o)&&!n.disabled&&(!n.parentNode.disabled||!A(n.parentNode,"optgroup"))){if(t=S(n).val(),a)return t;s.push(t)}return s},set:function(e,t){var n,r,i=e.options,o=S.makeArray(t),a=i.length;while(a--)((r=i[a]).selected=-1<S.inArray(S.valHooks.option.get(r),o))&&(n=!0);return n||(e.selectedIndex=-1),o}}}}),S.each(["radio","checkbox"],function(){S.valHooks[this]={set:function(e,t){if(Array.isArray(t))return e.checked=-1<S.inArray(S(e).val(),t)}},y.checkOn||(S.valHooks[this].get=function(e){return null===e.getAttribute("value")?"on":e.value})}),y.focusin="onfocusin"in C;var mt=/^(?:focusinfocus|focusoutblur)$/,xt=function(e){e.stopPropagation()};S.extend(S.event,{trigger:function(e,t,n,r){var i,o,a,s,u,l,c,f,p=[n||E],d=v.call(e,"type")?e.type:e,h=v.call(e,"namespace")?e.namespace.split("."):[];if(o=f=a=n=n||E,3!==n.nodeType&&8!==n.nodeType&&!mt.test(d+S.event.triggered)&&(-1<d.indexOf(".")&&(d=(h=d.split(".")).shift(),h.sort()),u=d.indexOf(":")<0&&"on"+d,(e=e[S.expando]?e:new S.Event(d,"object"==typeof e&&e)).isTrigger=r?2:3,e.namespace=h.join("."),e.rnamespace=e.namespace?new RegExp("(^|\\.)"+h.join("\\.(?:.*\\.|)")+"(\\.|$)"):null,e.result=void 0,e.target||(e.target=n),t=null==t?[e]:S.makeArray(t,[e]),c=S.event.special[d]||{},r||!c.trigger||!1!==c.trigger.apply(n,t))){if(!r&&!c.noBubble&&!x(n)){for(s=c.delegateType||d,mt.test(s+d)||(o=o.parentNode);o;o=o.parentNode)p.push(o),a=o;a===(n.ownerDocument||E)&&p.push(a.defaultView||a.parentWindow||C)}i=0;while((o=p[i++])&&!e.isPropagationStopped())f=o,e.type=1<i?s:c.bindType||d,(l=(Y.get(o,"events")||Object.create(null))[e.type]&&Y.get(o,"handle"))&&l.apply(o,t),(l=u&&o[u])&&l.apply&&V(o)&&(e.result=l.apply(o,t),!1===e.result&&e.preventDefault());return e.type=d,r||e.isDefaultPrevented()||c._default&&!1!==c._default.apply(p.pop(),t)||!V(n)||u&&m(n[d])&&!x(n)&&((a=n[u])&&(n[u]=null),S.event.triggered=d,e.isPropagationStopped()&&f.addEventListener(d,xt),n[d](),e.isPropagationStopped()&&f.removeEventListener(d,xt),S.event.triggered=void 0,a&&(n[u]=a)),e.result}},simulate:function(e,t,n){var r=S.extend(new S.Event,n,{type:e,isSimulated:!0});S.event.trigger(r,null,t)}}),S.fn.extend({trigger:function(e,t){return this.each(function(){S.event.trigger(e,t,this)})},triggerHandler:function(e,t){var n=this[0];if(n)return S.event.trigger(e,t,n,!0)}}),y.focusin||S.each({focus:"focusin",blur:"focusout"},function(n,r){var i=function(e){S.event.simulate(r,e.target,S.event.fix(e))};S.event.special[r]={setup:function(){var e=this.ownerDocument||this.document||this,t=Y.access(e,r);t||e.addEventListener(n,i,!0),Y.access(e,r,(t||0)+1)},teardown:function(){var e=this.ownerDocument||this.document||this,t=Y.access(e,r)-1;t?Y.access(e,r,t):(e.removeEventListener(n,i,!0),Y.remove(e,r))}}});var bt=C.location,wt={guid:Date.now()},Tt=/\?/;S.parseXML=function(e){var t,n;if(!e||"string"!=typeof e)return null;try{t=(new C.DOMParser).parseFromString(e,"text/xml")}catch(e){}return n=t&&t.getElementsByTagName("parsererror")[0],t&&!n||S.error("Invalid XML: "+(n?S.map(n.childNodes,function(e){return e.textContent}).join("\n"):e)),t};var Ct=/\[\]$/,Et=/\r?\n/g,St=/^(?:submit|button|image|reset|file)$/i,kt=/^(?:input|select|textarea|keygen)/i;function At(n,e,r,i){var t;if(Array.isArray(e))S.each(e,function(e,t){r||Ct.test(n)?i(n,t):At(n+"["+("object"==typeof t&&null!=t?e:"")+"]",t,r,i)});else if(r||"object"!==w(e))i(n,e);else for(t in e)At(n+"["+t+"]",e[t],r,i)}S.param=function(e,t){var n,r=[],i=function(e,t){var n=m(t)?t():t;r[r.length]=encodeURIComponent(e)+"="+encodeURIComponent(null==n?"":n)};if(null==e)return"";if(Array.isArray(e)||e.jquery&&!S.isPlainObject(e))S.each(e,function(){i(this.name,this.value)});else for(n in e)At(n,e[n],t,i);return r.join("&")},S.fn.extend({serialize:function(){return S.param(this.serializeArray())},serializeArray:function(){return this.map(function(){var e=S.prop(this,"elements");return e?S.makeArray(e):this}).filter(function(){var e=this.type;return this.name&&!S(this).is(":disabled")&&kt.test(this.nodeName)&&!St.test(e)&&(this.checked||!pe.test(e))}).map(function(e,t){var n=S(this).val();return null==n?null:Array.isArray(n)?S.map(n,function(e){return{name:t.name,value:e.replace(Et,"\r\n")}}):{name:t.name,value:n.replace(Et,"\r\n")}}).get()}});var Nt=/%20/g,jt=/#.*$/,Dt=/([?&])_=[^&]*/,qt=/^(.*?):[ \t]*([^\r\n]*)$/gm,Lt=/^(?:GET|HEAD)$/,Ht=/^\/\//,Ot={},Pt={},Rt="*/".concat("*"),Mt=E.createElement("a");function It(o){return function(e,t){"string"!=typeof e&&(t=e,e="*");var n,r=0,i=e.toLowerCase().match(P)||[];if(m(t))while(n=i[r++])"+"===n[0]?(n=n.slice(1)||"*",(o[n]=o[n]||[]).unshift(t)):(o[n]=o[n]||[]).push(t)}}function Wt(t,i,o,a){var s={},u=t===Pt;function l(e){var r;return s[e]=!0,S.each(t[e]||[],function(e,t){var n=t(i,o,a);return"string"!=typeof n||u||s[n]?u?!(r=n):void 0:(i.dataTypes.unshift(n),l(n),!1)}),r}return l(i.dataTypes[0])||!s["*"]&&l("*")}function Ft(e,t){var n,r,i=S.ajaxSettings.flatOptions||{};for(n in t)void 0!==t[n]&&((i[n]?e:r||(r={}))[n]=t[n]);return r&&S.extend(!0,e,r),e}Mt.href=bt.href,S.extend({active:0,lastModified:{},etag:{},ajaxSettings:{url:bt.href,type:"GET",isLocal:/^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(bt.protocol),global:!0,processData:!0,async:!0,contentType:"application/x-www-form-urlencoded; charset=UTF-8",accepts:{"*":Rt,text:"text/plain",html:"text/html",xml:"application/xml, text/xml",json:"application/json, text/javascript"},contents:{xml:/\bxml\b/,html:/\bhtml/,json:/\bjson\b/},responseFields:{xml:"responseXML",text:"responseText",json:"responseJSON"},converters:{"* text":String,"text html":!0,"text json":JSON.parse,"text xml":S.parseXML},flatOptions:{url:!0,context:!0}},ajaxSetup:function(e,t){return t?Ft(Ft(e,S.ajaxSettings),t):Ft(S.ajaxSettings,e)},ajaxPrefilter:It(Ot),ajaxTransport:It(Pt),ajax:function(e,t){"object"==typeof e&&(t=e,e=void 0),t=t||{};var c,f,p,n,d,r,h,g,i,o,v=S.ajaxSetup({},t),y=v.context||v,m=v.context&&(y.nodeType||y.jquery)?S(y):S.event,x=S.Deferred(),b=S.Callbacks("once memory"),w=v.statusCode||{},a={},s={},u="canceled",T={readyState:0,getResponseHeader:function(e){var t;if(h){if(!n){n={};while(t=qt.exec(p))n[t[1].toLowerCase()+" "]=(n[t[1].toLowerCase()+" "]||[]).concat(t[2])}t=n[e.toLowerCase()+" "]}return null==t?null:t.join(", ")},getAllResponseHeaders:function(){return h?p:null},setRequestHeader:function(e,t){return null==h&&(e=s[e.toLowerCase()]=s[e.toLowerCase()]||e,a[e]=t),this},overrideMimeType:function(e){return null==h&&(v.mimeType=e),this},statusCode:function(e){var t;if(e)if(h)T.always(e[T.status]);else for(t in e)w[t]=[w[t],e[t]];return this},abort:function(e){var t=e||u;return c&&c.abort(t),l(0,t),this}};if(x.promise(T),v.url=((e||v.url||bt.href)+"").replace(Ht,bt.protocol+"//"),v.type=t.method||t.type||v.method||v.type,v.dataTypes=(v.dataType||"*").toLowerCase().match(P)||[""],null==v.crossDomain){r=E.createElement("a");try{r.href=v.url,r.href=r.href,v.crossDomain=Mt.protocol+"//"+Mt.host!=r.protocol+"//"+r.host}catch(e){v.crossDomain=!0}}if(v.data&&v.processData&&"string"!=typeof v.data&&(v.data=S.param(v.data,v.traditional)),Wt(Ot,v,t,T),h)return T;for(i in(g=S.event&&v.global)&&0==S.active++&&S.event.trigger("ajaxStart"),v.type=v.type.toUpperCase(),v.hasContent=!Lt.test(v.type),f=v.url.replace(jt,""),v.hasContent?v.data&&v.processData&&0===(v.contentType||"").indexOf("application/x-www-form-urlencoded")&&(v.data=v.data.replace(Nt,"+")):(o=v.url.slice(f.length),v.data&&(v.processData||"string"==typeof v.data)&&(f+=(Tt.test(f)?"&":"?")+v.data,delete v.data),!1===v.cache&&(f=f.replace(Dt,"$1"),o=(Tt.test(f)?"&":"?")+"_="+wt.guid+++o),v.url=f+o),v.ifModified&&(S.lastModified[f]&&T.setRequestHeader("If-Modified-Since",S.lastModified[f]),S.etag[f]&&T.setRequestHeader("If-None-Match",S.etag[f])),(v.data&&v.hasContent&&!1!==v.contentType||t.contentType)&&T.setRequestHeader("Content-Type",v.contentType),T.setRequestHeader("Accept",v.dataTypes[0]&&v.accepts[v.dataTypes[0]]?v.accepts[v.dataTypes[0]]+("*"!==v.dataTypes[0]?", "+Rt+"; q=0.01":""):v.accepts["*"]),v.headers)T.setRequestHeader(i,v.headers[i]);if(v.beforeSend&&(!1===v.beforeSend.call(y,T,v)||h))return T.abort();if(u="abort",b.add(v.complete),T.done(v.success),T.fail(v.error),c=Wt(Pt,v,t,T)){if(T.readyState=1,g&&m.trigger("ajaxSend",[T,v]),h)return T;v.async&&0<v.timeout&&(d=C.setTimeout(function(){T.abort("timeout")},v.timeout));try{h=!1,c.send(a,l)}catch(e){if(h)throw e;l(-1,e)}}else l(-1,"No Transport");function l(e,t,n,r){var i,o,a,s,u,l=t;h||(h=!0,d&&C.clearTimeout(d),c=void 0,p=r||"",T.readyState=0<e?4:0,i=200<=e&&e<300||304===e,n&&(s=function(e,t,n){var r,i,o,a,s=e.contents,u=e.dataTypes;while("*"===u[0])u.shift(),void 0===r&&(r=e.mimeType||t.getResponseHeader("Content-Type"));if(r)for(i in s)if(s[i]&&s[i].test(r)){u.unshift(i);break}if(u[0]in n)o=u[0];else{for(i in n){if(!u[0]||e.converters[i+" "+u[0]]){o=i;break}a||(a=i)}o=o||a}if(o)return o!==u[0]&&u.unshift(o),n[o]}(v,T,n)),!i&&-1<S.inArray("script",v.dataTypes)&&S.inArray("json",v.dataTypes)<0&&(v.converters["text script"]=function(){}),s=function(e,t,n,r){var i,o,a,s,u,l={},c=e.dataTypes.slice();if(c[1])for(a in e.converters)l[a.toLowerCase()]=e.converters[a];o=c.shift();while(o)if(e.responseFields[o]&&(n[e.responseFields[o]]=t),!u&&r&&e.dataFilter&&(t=e.dataFilter(t,e.dataType)),u=o,o=c.shift())if("*"===o)o=u;else if("*"!==u&&u!==o){if(!(a=l[u+" "+o]||l["* "+o]))for(i in l)if((s=i.split(" "))[1]===o&&(a=l[u+" "+s[0]]||l["* "+s[0]])){!0===a?a=l[i]:!0!==l[i]&&(o=s[0],c.unshift(s[1]));break}if(!0!==a)if(a&&e["throws"])t=a(t);else try{t=a(t)}catch(e){return{state:"parsererror",error:a?e:"No conversion from "+u+" to "+o}}}return{state:"success",data:t}}(v,s,T,i),i?(v.ifModified&&((u=T.getResponseHeader("Last-Modified"))&&(S.lastModified[f]=u),(u=T.getResponseHeader("etag"))&&(S.etag[f]=u)),204===e||"HEAD"===v.type?l="nocontent":304===e?l="notmodified":(l=s.state,o=s.data,i=!(a=s.error))):(a=l,!e&&l||(l="error",e<0&&(e=0))),T.status=e,T.statusText=(t||l)+"",i?x.resolveWith(y,[o,l,T]):x.rejectWith(y,[T,l,a]),T.statusCode(w),w=void 0,g&&m.trigger(i?"ajaxSuccess":"ajaxError",[T,v,i?o:a]),b.fireWith(y,[T,l]),g&&(m.trigger("ajaxComplete",[T,v]),--S.active||S.event.trigger("ajaxStop")))}return T},getJSON:function(e,t,n){return S.get(e,t,n,"json")},getScript:function(e,t){return S.get(e,void 0,t,"script")}}),S.each(["get","post"],function(e,i){S[i]=function(e,t,n,r){return m(t)&&(r=r||n,n=t,t=void 0),S.ajax(S.extend({url:e,type:i,dataType:r,data:t,success:n},S.isPlainObject(e)&&e))}}),S.ajaxPrefilter(function(e){var t;for(t in e.headers)"content-type"===t.toLowerCase()&&(e.contentType=e.headers[t]||"")}),S._evalUrl=function(e,t,n){return S.ajax({url:e,type:"GET",dataType:"script",cache:!0,async:!1,global:!1,converters:{"text script":function(){}},dataFilter:function(e){S.globalEval(e,t,n)}})},S.fn.extend({wrapAll:function(e){var t;return this[0]&&(m(e)&&(e=e.call(this[0])),t=S(e,this[0].ownerDocument).eq(0).clone(!0),this[0].parentNode&&t.insertBefore(this[0]),t.map(function(){var e=this;while(e.firstElementChild)e=e.firstElementChild;return e}).append(this)),this},wrapInner:function(n){return m(n)?this.each(function(e){S(this).wrapInner(n.call(this,e))}):this.each(function(){var e=S(this),t=e.contents();t.length?t.wrapAll(n):e.append(n)})},wrap:function(t){var n=m(t);return this.each(function(e){S(this).wrapAll(n?t.call(this,e):t)})},unwrap:function(e){return this.parent(e).not("body").each(function(){S(this).replaceWith(this.childNodes)}),this}}),S.expr.pseudos.hidden=function(e){return!S.expr.pseudos.visible(e)},S.expr.pseudos.visible=function(e){return!!(e.offsetWidth||e.offsetHeight||e.getClientRects().length)},S.ajaxSettings.xhr=function(){try{return new C.XMLHttpRequest}catch(e){}};var Bt={0:200,1223:204},$t=S.ajaxSettings.xhr();y.cors=!!$t&&"withCredentials"in $t,y.ajax=$t=!!$t,S.ajaxTransport(function(i){var o,a;if(y.cors||$t&&!i.crossDomain)return{send:function(e,t){var n,r=i.xhr();if(r.open(i.type,i.url,i.async,i.username,i.password),i.xhrFields)for(n in i.xhrFields)r[n]=i.xhrFields[n];for(n in i.mimeType&&r.overrideMimeType&&r.overrideMimeType(i.mimeType),i.crossDomain||e["X-Requested-With"]||(e["X-Requested-With"]="XMLHttpRequest"),e)r.setRequestHeader(n,e[n]);o=function(e){return function(){o&&(o=a=r.onload=r.onerror=r.onabort=r.ontimeout=r.onreadystatechange=null,"abort"===e?r.abort():"error"===e?"number"!=typeof r.status?t(0,"error"):t(r.status,r.statusText):t(Bt[r.status]||r.status,r.statusText,"text"!==(r.responseType||"text")||"string"!=typeof r.responseText?{binary:r.response}:{text:r.responseText},r.getAllResponseHeaders()))}},r.onload=o(),a=r.onerror=r.ontimeout=o("error"),void 0!==r.onabort?r.onabort=a:r.onreadystatechange=function(){4===r.readyState&&C.setTimeout(function(){o&&a()})},o=o("abort");try{r.send(i.hasContent&&i.data||null)}catch(e){if(o)throw e}},abort:function(){o&&o()}}}),S.ajaxPrefilter(function(e){e.crossDomain&&(e.contents.script=!1)}),S.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/\b(?:java|ecma)script\b/},converters:{"text script":function(e){return S.globalEval(e),e}}}),S.ajaxPrefilter("script",function(e){void 0===e.cache&&(e.cache=!1),e.crossDomain&&(e.type="GET")}),S.ajaxTransport("script",function(n){var r,i;if(n.crossDomain||n.scriptAttrs)return{send:function(e,t){r=S("<script>").attr(n.scriptAttrs||{}).prop({charset:n.scriptCharset,src:n.url}).on("load error",i=function(e){r.remove(),i=null,e&&t("error"===e.type?404:200,e.type)}),E.head.appendChild(r[0])},abort:function(){i&&i()}}});var _t,zt=[],Ut=/(=)\?(?=&|$)|\?\?/;S.ajaxSetup({jsonp:"callback",jsonpCallback:function(){var e=zt.pop()||S.expando+"_"+wt.guid++;return this[e]=!0,e}}),S.ajaxPrefilter("json jsonp",function(e,t,n){var r,i,o,a=!1!==e.jsonp&&(Ut.test(e.url)?"url":"string"==typeof e.data&&0===(e.contentType||"").indexOf("application/x-www-form-urlencoded")&&Ut.test(e.data)&&"data");if(a||"jsonp"===e.dataTypes[0])return r=e.jsonpCallback=m(e.jsonpCallback)?e.jsonpCallback():e.jsonpCallback,a?e[a]=e[a].replace(Ut,"$1"+r):!1!==e.jsonp&&(e.url+=(Tt.test(e.url)?"&":"?")+e.jsonp+"="+r),e.converters["script json"]=function(){return o||S.error(r+" was not called"),o[0]},e.dataTypes[0]="json",i=C[r],C[r]=function(){o=arguments},n.always(function(){void 0===i?S(C).removeProp(r):C[r]=i,e[r]&&(e.jsonpCallback=t.jsonpCallback,zt.push(r)),o&&m(i)&&i(o[0]),o=i=void 0}),"script"}),y.createHTMLDocument=((_t=E.implementation.createHTMLDocument("").body).innerHTML="<form></form><form></form>",2===_t.childNodes.length),S.parseHTML=function(e,t,n){return"string"!=typeof e?[]:("boolean"==typeof t&&(n=t,t=!1),t||(y.createHTMLDocument?((r=(t=E.implementation.createHTMLDocument("")).createElement("base")).href=E.location.href,t.head.appendChild(r)):t=E),o=!n&&[],(i=N.exec(e))?[t.createElement(i[1])]:(i=xe([e],t,o),o&&o.length&&S(o).remove(),S.merge([],i.childNodes)));var r,i,o},S.fn.load=function(e,t,n){var r,i,o,a=this,s=e.indexOf(" ");return-1<s&&(r=ht(e.slice(s)),e=e.slice(0,s)),m(t)?(n=t,t=void 0):t&&"object"==typeof t&&(i="POST"),0<a.length&&S.ajax({url:e,type:i||"GET",dataType:"html",data:t}).done(function(e){o=arguments,a.html(r?S("<div>").append(S.parseHTML(e)).find(r):e)}).always(n&&function(e,t){a.each(function(){n.apply(this,o||[e.responseText,t,e])})}),this},S.expr.pseudos.animated=function(t){return S.grep(S.timers,function(e){return t===e.elem}).length},S.offset={setOffset:function(e,t,n){var r,i,o,a,s,u,l=S.css(e,"position"),c=S(e),f={};"static"===l&&(e.style.position="relative"),s=c.offset(),o=S.css(e,"top"),u=S.css(e,"left"),("absolute"===l||"fixed"===l)&&-1<(o+u).indexOf("auto")?(a=(r=c.position()).top,i=r.left):(a=parseFloat(o)||0,i=parseFloat(u)||0),m(t)&&(t=t.call(e,n,S.extend({},s))),null!=t.top&&(f.top=t.top-s.top+a),null!=t.left&&(f.left=t.left-s.left+i),"using"in t?t.using.call(e,f):c.css(f)}},S.fn.extend({offset:function(t){if(arguments.length)return void 0===t?this:this.each(function(e){S.offset.setOffset(this,t,e)});var e,n,r=this[0];return r?r.getClientRects().length?(e=r.getBoundingClientRect(),n=r.ownerDocument.defaultView,{top:e.top+n.pageYOffset,left:e.left+n.pageXOffset}):{top:0,left:0}:void 0},position:function(){if(this[0]){var e,t,n,r=this[0],i={top:0,left:0};if("fixed"===S.css(r,"position"))t=r.getBoundingClientRect();else{t=this.offset(),n=r.ownerDocument,e=r.offsetParent||n.documentElement;while(e&&(e===n.body||e===n.documentElement)&&"static"===S.css(e,"position"))e=e.parentNode;e&&e!==r&&1===e.nodeType&&((i=S(e).offset()).top+=S.css(e,"borderTopWidth",!0),i.left+=S.css(e,"borderLeftWidth",!0))}return{top:t.top-i.top-S.css(r,"marginTop",!0),left:t.left-i.left-S.css(r,"marginLeft",!0)}}},offsetParent:function(){return this.map(function(){var e=this.offsetParent;while(e&&"static"===S.css(e,"position"))e=e.offsetParent;return e||re})}}),S.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(t,i){var o="pageYOffset"===i;S.fn[t]=function(e){return $(this,function(e,t,n){var r;if(x(e)?r=e:9===e.nodeType&&(r=e.defaultView),void 0===n)return r?r[i]:e[t];r?r.scrollTo(o?r.pageXOffset:n,o?n:r.pageYOffset):e[t]=n},t,e,arguments.length)}}),S.each(["top","left"],function(e,n){S.cssHooks[n]=Fe(y.pixelPosition,function(e,t){if(t)return t=We(e,n),Pe.test(t)?S(e).position()[n]+"px":t})}),S.each({Height:"height",Width:"width"},function(a,s){S.each({padding:"inner"+a,content:s,"":"outer"+a},function(r,o){S.fn[o]=function(e,t){var n=arguments.length&&(r||"boolean"!=typeof e),i=r||(!0===e||!0===t?"margin":"border");return $(this,function(e,t,n){var r;return x(e)?0===o.indexOf("outer")?e["inner"+a]:e.document.documentElement["client"+a]:9===e.nodeType?(r=e.documentElement,Math.max(e.body["scroll"+a],r["scroll"+a],e.body["offset"+a],r["offset"+a],r["client"+a])):void 0===n?S.css(e,t,i):S.style(e,t,n,i)},s,n?e:void 0,n)}})}),S.each(["ajaxStart","ajaxStop","ajaxComplete","ajaxError","ajaxSuccess","ajaxSend"],function(e,t){S.fn[t]=function(e){return this.on(t,e)}}),S.fn.extend({bind:function(e,t,n){return this.on(e,null,t,n)},unbind:function(e,t){return this.off(e,null,t)},delegate:function(e,t,n,r){return this.on(t,e,n,r)},undelegate:function(e,t,n){return 1===arguments.length?this.off(e,"**"):this.off(t,e||"**",n)},hover:function(e,t){return this.mouseenter(e).mouseleave(t||e)}}),S.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "),function(e,n){S.fn[n]=function(e,t){return 0<arguments.length?this.on(n,null,e,t):this.trigger(n)}});var Xt=/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;S.proxy=function(e,t){var n,r,i;if("string"==typeof t&&(n=e[t],t=e,e=n),m(e))return r=s.call(arguments,2),(i=function(){return e.apply(t||this,r.concat(s.call(arguments)))}).guid=e.guid=e.guid||S.guid++,i},S.holdReady=function(e){e?S.readyWait++:S.ready(!0)},S.isArray=Array.isArray,S.parseJSON=JSON.parse,S.nodeName=A,S.isFunction=m,S.isWindow=x,S.camelCase=X,S.type=w,S.now=Date.now,S.isNumeric=function(e){var t=S.type(e);return("number"===t||"string"===t)&&!isNaN(e-parseFloat(e))},S.trim=function(e){return null==e?"":(e+"").replace(Xt,"")},"function"==typeof define&&define.amd&&define("jquery",[],function(){return S});var Vt=C.jQuery,Gt=C.$;return S.noConflict=function(e){return C.$===S&&(C.$=Gt),e&&C.jQuery===S&&(C.jQuery=Vt),S},"undefined"==typeof e&&(C.jQuery=C.$=S),S});
// Jquery

// Swiper
var Swiper=function(){"use strict";function e(e){return null!==e&&"object"==typeof e&&"constructor"in e&&e.constructor===Object}function t(s,a){void 0===s&&(s={}),void 0===a&&(a={});const i=["__proto__","constructor","prototype"];Object.keys(a).filter((e=>i.indexOf(e)<0)).forEach((i=>{void 0===s[i]?s[i]=a[i]:e(a[i])&&e(s[i])&&Object.keys(a[i]).length>0&&t(s[i],a[i])}))}const s={body:{},addEventListener(){},removeEventListener(){},activeElement:{blur(){},nodeName:""},querySelector:()=>null,querySelectorAll:()=>[],getElementById:()=>null,createEvent:()=>({initEvent(){}}),createElement:()=>({children:[],childNodes:[],style:{},setAttribute(){},getElementsByTagName:()=>[]}),createElementNS:()=>({}),importNode:()=>null,location:{hash:"",host:"",hostname:"",href:"",origin:"",pathname:"",protocol:"",search:""}};function a(){const e="undefined"!=typeof document?document:{};return t(e,s),e}const i={document:s,navigator:{userAgent:""},location:{hash:"",host:"",hostname:"",href:"",origin:"",pathname:"",protocol:"",search:""},history:{replaceState(){},pushState(){},go(){},back(){}},CustomEvent:function(){return this},addEventListener(){},removeEventListener(){},getComputedStyle:()=>({getPropertyValue:()=>""}),Image(){},Date(){},screen:{},setTimeout(){},clearTimeout(){},matchMedia:()=>({}),requestAnimationFrame:e=>"undefined"==typeof setTimeout?(e(),null):setTimeout(e,0),cancelAnimationFrame(e){"undefined"!=typeof setTimeout&&clearTimeout(e)}};function r(){const e="undefined"!=typeof window?window:{};return t(e,i),e}function n(e){return void 0===e&&(e=""),e.trim().split(" ").filter((e=>!!e.trim()))}function l(e,t){return void 0===t&&(t=0),setTimeout(e,t)}function o(){return Date.now()}function d(e,t){void 0===t&&(t="x");const s=r();let a,i,n;const l=function(e){const t=r();let s;return t.getComputedStyle&&(s=t.getComputedStyle(e,null)),!s&&e.currentStyle&&(s=e.currentStyle),s||(s=e.style),s}(e);return s.WebKitCSSMatrix?(i=l.transform||l.webkitTransform,i.split(",").length>6&&(i=i.split(", ").map((e=>e.replace(",","."))).join(", ")),n=new s.WebKitCSSMatrix("none"===i?"":i)):(n=l.MozTransform||l.OTransform||l.MsTransform||l.msTransform||l.transform||l.getPropertyValue("transform").replace("translate(","matrix(1, 0, 0, 1,"),a=n.toString().split(",")),"x"===t&&(i=s.WebKitCSSMatrix?n.m41:16===a.length?parseFloat(a[12]):parseFloat(a[4])),"y"===t&&(i=s.WebKitCSSMatrix?n.m42:16===a.length?parseFloat(a[13]):parseFloat(a[5])),i||0}function c(e){return"object"==typeof e&&null!==e&&e.constructor&&"Object"===Object.prototype.toString.call(e).slice(8,-1)}function p(){const e=Object(arguments.length<=0?void 0:arguments[0]),t=["__proto__","constructor","prototype"];for(let a=1;a<arguments.length;a+=1){const i=a<0||arguments.length<=a?void 0:arguments[a];if(null!=i&&(s=i,!("undefined"!=typeof window&&void 0!==window.HTMLElement?s instanceof HTMLElement:s&&(1===s.nodeType||11===s.nodeType)))){const s=Object.keys(Object(i)).filter((e=>t.indexOf(e)<0));for(let t=0,a=s.length;t<a;t+=1){const a=s[t],r=Object.getOwnPropertyDescriptor(i,a);void 0!==r&&r.enumerable&&(c(e[a])&&c(i[a])?i[a].__swiper__?e[a]=i[a]:p(e[a],i[a]):!c(e[a])&&c(i[a])?(e[a]={},i[a].__swiper__?e[a]=i[a]:p(e[a],i[a])):e[a]=i[a])}}}var s;return e}function u(e,t,s){e.style.setProperty(t,s)}function m(e){let{swiper:t,targetPosition:s,side:a}=e;const i=r(),n=-t.translate;let l,o=null;const d=t.params.speed;t.wrapperEl.style.scrollSnapType="none",i.cancelAnimationFrame(t.cssModeFrameID);const c=s>n?"next":"prev",p=(e,t)=>"next"===c&&e>=t||"prev"===c&&e<=t,u=()=>{l=(new Date).getTime(),null===o&&(o=l);const e=Math.max(Math.min((l-o)/d,1),0),r=.5-Math.cos(e*Math.PI)/2;let c=n+r*(s-n);if(p(c,s)&&(c=s),t.wrapperEl.scrollTo({[a]:c}),p(c,s))return t.wrapperEl.style.overflow="hidden",t.wrapperEl.style.scrollSnapType="",setTimeout((()=>{t.wrapperEl.style.overflow="",t.wrapperEl.scrollTo({[a]:c})})),void i.cancelAnimationFrame(t.cssModeFrameID);t.cssModeFrameID=i.requestAnimationFrame(u)};u()}function h(e){return e.querySelector(".swiper-slide-transform")||e.shadowRoot&&e.shadowRoot.querySelector(".swiper-slide-transform")||e}function f(e,t){void 0===t&&(t="");const s=r(),a=[...e.children];return s.HTMLSlotElement&&e instanceof HTMLSlotElement&&a.push(...e.assignedElements()),t?a.filter((e=>e.matches(t))):a}function g(e){try{return void console.warn(e)}catch(e){}}function v(e,t){void 0===t&&(t=[]);const s=document.createElement(e);return s.classList.add(...Array.isArray(t)?t:n(t)),s}function w(e){const t=r(),s=a(),i=e.getBoundingClientRect(),n=s.body,l=e.clientTop||n.clientTop||0,o=e.clientLeft||n.clientLeft||0,d=e===t?t.scrollY:e.scrollTop,c=e===t?t.scrollX:e.scrollLeft;return{top:i.top+d-l,left:i.left+c-o}}function b(e,t){return r().getComputedStyle(e,null).getPropertyValue(t)}function y(e){let t,s=e;if(s){for(t=0;null!==(s=s.previousSibling);)1===s.nodeType&&(t+=1);return t}}function E(e,t){const s=[];let a=e.parentElement;for(;a;)t?a.matches(t)&&s.push(a):s.push(a),a=a.parentElement;return s}function x(e,t){t&&e.addEventListener("transitionend",(function s(a){a.target===e&&(t.call(e,a),e.removeEventListener("transitionend",s))}))}function S(e,t,s){const a=r();return s?e["width"===t?"offsetWidth":"offsetHeight"]+parseFloat(a.getComputedStyle(e,null).getPropertyValue("width"===t?"margin-right":"margin-top"))+parseFloat(a.getComputedStyle(e,null).getPropertyValue("width"===t?"margin-left":"margin-bottom")):e.offsetWidth}function T(e){return(Array.isArray(e)?e:[e]).filter((e=>!!e))}function M(e){return t=>Math.abs(t)>0&&e.browser&&e.browser.need3dFix&&Math.abs(t)%90==0?t+.001:t}function C(e,t){void 0===t&&(t=""),"undefined"!=typeof trustedTypes?e.innerHTML=trustedTypes.createPolicy("html",{createHTML:e=>e}).createHTML(t):e.innerHTML=t}let P,L,I;function z(){return P||(P=function(){const e=r(),t=a();return{smoothScroll:t.documentElement&&t.documentElement.style&&"scrollBehavior"in t.documentElement.style,touch:!!("ontouchstart"in e||e.DocumentTouch&&t instanceof e.DocumentTouch)}}()),P}function A(e){return void 0===e&&(e={}),L||(L=function(e){let{userAgent:t}=void 0===e?{}:e;const s=z(),a=r(),i=a.navigator.platform,n=t||a.navigator.userAgent,l={ios:!1,android:!1},o=a.screen.width,d=a.screen.height,c=n.match(/(Android);?[\s\/]+([\d.]+)?/);let p=n.match(/(iPad).*OS\s([\d_]+)/);const u=n.match(/(iPod)(.*OS\s([\d_]+))?/),m=!p&&n.match(/(iPhone\sOS|iOS)\s([\d_]+)/),h="Win32"===i;let f="MacIntel"===i;return!p&&f&&s.touch&&["1024x1366","1366x1024","834x1194","1194x834","834x1112","1112x834","768x1024","1024x768","820x1180","1180x820","810x1080","1080x810"].indexOf(`${o}x${d}`)>=0&&(p=n.match(/(Version)\/([\d.]+)/),p||(p=[0,1,"13_0_0"]),f=!1),c&&!h&&(l.os="android",l.android=!0),(p||m||u)&&(l.os="ios",l.ios=!0),l}(e)),L}function $(){return I||(I=function(){const e=r(),t=A();let s=!1;function a(){const t=e.navigator.userAgent.toLowerCase();return t.indexOf("safari")>=0&&t.indexOf("chrome")<0&&t.indexOf("android")<0}if(a()){const t=String(e.navigator.userAgent);if(t.includes("Version/")){const[e,a]=t.split("Version/")[1].split(" ")[0].split(".").map((e=>Number(e)));s=e<16||16===e&&a<2}}const i=/(iPhone|iPod|iPad).*AppleWebKit(?!.*Safari)/i.test(e.navigator.userAgent),n=a();return{isSafari:s||n,needPerspectiveFix:s,need3dFix:n||i&&t.ios,isWebView:i}}()),I}var k={on(e,t,s){const a=this;if(!a.eventsListeners||a.destroyed)return a;if("function"!=typeof t)return a;const i=s?"unshift":"push";return e.split(" ").forEach((e=>{a.eventsListeners[e]||(a.eventsListeners[e]=[]),a.eventsListeners[e][i](t)})),a},once(e,t,s){const a=this;if(!a.eventsListeners||a.destroyed)return a;if("function"!=typeof t)return a;function i(){a.off(e,i),i.__emitterProxy&&delete i.__emitterProxy;for(var s=arguments.length,r=new Array(s),n=0;n<s;n++)r[n]=arguments[n];t.apply(a,r)}return i.__emitterProxy=t,a.on(e,i,s)},onAny(e,t){const s=this;if(!s.eventsListeners||s.destroyed)return s;if("function"!=typeof e)return s;const a=t?"unshift":"push";return s.eventsAnyListeners.indexOf(e)<0&&s.eventsAnyListeners[a](e),s},offAny(e){const t=this;if(!t.eventsListeners||t.destroyed)return t;if(!t.eventsAnyListeners)return t;const s=t.eventsAnyListeners.indexOf(e);return s>=0&&t.eventsAnyListeners.splice(s,1),t},off(e,t){const s=this;return!s.eventsListeners||s.destroyed?s:s.eventsListeners?(e.split(" ").forEach((e=>{void 0===t?s.eventsListeners[e]=[]:s.eventsListeners[e]&&s.eventsListeners[e].forEach(((a,i)=>{(a===t||a.__emitterProxy&&a.__emitterProxy===t)&&s.eventsListeners[e].splice(i,1)}))})),s):s},emit(){const e=this;if(!e.eventsListeners||e.destroyed)return e;if(!e.eventsListeners)return e;let t,s,a;for(var i=arguments.length,r=new Array(i),n=0;n<i;n++)r[n]=arguments[n];"string"==typeof r[0]||Array.isArray(r[0])?(t=r[0],s=r.slice(1,r.length),a=e):(t=r[0].events,s=r[0].data,a=r[0].context||e),s.unshift(a);return(Array.isArray(t)?t:t.split(" ")).forEach((t=>{e.eventsAnyListeners&&e.eventsAnyListeners.length&&e.eventsAnyListeners.forEach((e=>{e.apply(a,[t,...s])})),e.eventsListeners&&e.eventsListeners[t]&&e.eventsListeners[t].forEach((e=>{e.apply(a,s)}))})),e}};const O=(e,t,s)=>{t&&!e.classList.contains(s)?e.classList.add(s):!t&&e.classList.contains(s)&&e.classList.remove(s)};const D=(e,t,s)=>{t&&!e.classList.contains(s)?e.classList.add(s):!t&&e.classList.contains(s)&&e.classList.remove(s)};const G=(e,t)=>{if(!e||e.destroyed||!e.params)return;const s=t.closest(e.isElement?"swiper-slide":`.${e.params.slideClass}`);if(s){let t=s.querySelector(`.${e.params.lazyPreloaderClass}`);!t&&e.isElement&&(s.shadowRoot?t=s.shadowRoot.querySelector(`.${e.params.lazyPreloaderClass}`):requestAnimationFrame((()=>{s.shadowRoot&&(t=s.shadowRoot.querySelector(`.${e.params.lazyPreloaderClass}`),t&&t.remove())}))),t&&t.remove()}},X=(e,t)=>{if(!e.slides[t])return;const s=e.slides[t].querySelector('[loading="lazy"]');s&&s.removeAttribute("loading")},Y=e=>{if(!e||e.destroyed||!e.params)return;let t=e.params.lazyPreloadPrevNext;const s=e.slides.length;if(!s||!t||t<0)return;t=Math.min(t,s);const a="auto"===e.params.slidesPerView?e.slidesPerViewDynamic():Math.ceil(e.params.slidesPerView),i=e.activeIndex;if(e.params.grid&&e.params.grid.rows>1){const s=i,r=[s-t];return r.push(...Array.from({length:t}).map(((e,t)=>s+a+t))),void e.slides.forEach(((t,s)=>{r.includes(t.column)&&X(e,s)}))}const r=i+a-1;if(e.params.rewind||e.params.loop)for(let a=i-t;a<=r+t;a+=1){const t=(a%s+s)%s;(t<i||t>r)&&X(e,t)}else for(let a=Math.max(i-t,0);a<=Math.min(r+t,s-1);a+=1)a!==i&&(a>r||a<i)&&X(e,a)};var B={updateSize:function(){const e=this;let t,s;const a=e.el;t=void 0!==e.params.width&&null!==e.params.width?e.params.width:a.clientWidth,s=void 0!==e.params.height&&null!==e.params.height?e.params.height:a.clientHeight,0===t&&e.isHorizontal()||0===s&&e.isVertical()||(t=t-parseInt(b(a,"padding-left")||0,10)-parseInt(b(a,"padding-right")||0,10),s=s-parseInt(b(a,"padding-top")||0,10)-parseInt(b(a,"padding-bottom")||0,10),Number.isNaN(t)&&(t=0),Number.isNaN(s)&&(s=0),Object.assign(e,{width:t,height:s,size:e.isHorizontal()?t:s}))},updateSlides:function(){const e=this;function t(t,s){return parseFloat(t.getPropertyValue(e.getDirectionLabel(s))||0)}const s=e.params,{wrapperEl:a,slidesEl:i,size:r,rtlTranslate:n,wrongRTL:l}=e,o=e.virtual&&s.virtual.enabled,d=o?e.virtual.slides.length:e.slides.length,c=f(i,`.${e.params.slideClass}, swiper-slide`),p=o?e.virtual.slides.length:c.length;let m=[];const h=[],g=[];let v=s.slidesOffsetBefore;"function"==typeof v&&(v=s.slidesOffsetBefore.call(e));let w=s.slidesOffsetAfter;"function"==typeof w&&(w=s.slidesOffsetAfter.call(e));const y=e.snapGrid.length,E=e.slidesGrid.length;let x=s.spaceBetween,T=-v,M=0,C=0;if(void 0===r)return;"string"==typeof x&&x.indexOf("%")>=0?x=parseFloat(x.replace("%",""))/100*r:"string"==typeof x&&(x=parseFloat(x)),e.virtualSize=-x,c.forEach((e=>{n?e.style.marginLeft="":e.style.marginRight="",e.style.marginBottom="",e.style.marginTop=""})),s.centeredSlides&&s.cssMode&&(u(a,"--swiper-centered-offset-before",""),u(a,"--swiper-centered-offset-after",""));const P=s.grid&&s.grid.rows>1&&e.grid;let L;P?e.grid.initSlides(c):e.grid&&e.grid.unsetSlides();const I="auto"===s.slidesPerView&&s.breakpoints&&Object.keys(s.breakpoints).filter((e=>void 0!==s.breakpoints[e].slidesPerView)).length>0;for(let a=0;a<p;a+=1){let i;if(L=0,c[a]&&(i=c[a]),P&&e.grid.updateSlide(a,i,c),!c[a]||"none"!==b(i,"display")){if("auto"===s.slidesPerView){I&&(c[a].style[e.getDirectionLabel("width")]="");const r=getComputedStyle(i),n=i.style.transform,l=i.style.webkitTransform;if(n&&(i.style.transform="none"),l&&(i.style.webkitTransform="none"),s.roundLengths)L=e.isHorizontal()?S(i,"width",!0):S(i,"height",!0);else{const e=t(r,"width"),s=t(r,"padding-left"),a=t(r,"padding-right"),n=t(r,"margin-left"),l=t(r,"margin-right"),o=r.getPropertyValue("box-sizing");if(o&&"border-box"===o)L=e+n+l;else{const{clientWidth:t,offsetWidth:r}=i;L=e+s+a+n+l+(r-t)}}n&&(i.style.transform=n),l&&(i.style.webkitTransform=l),s.roundLengths&&(L=Math.floor(L))}else L=(r-(s.slidesPerView-1)*x)/s.slidesPerView,s.roundLengths&&(L=Math.floor(L)),c[a]&&(c[a].style[e.getDirectionLabel("width")]=`${L}px`);c[a]&&(c[a].swiperSlideSize=L),g.push(L),s.centeredSlides?(T=T+L/2+M/2+x,0===M&&0!==a&&(T=T-r/2-x),0===a&&(T=T-r/2-x),Math.abs(T)<.001&&(T=0),s.roundLengths&&(T=Math.floor(T)),C%s.slidesPerGroup==0&&m.push(T),h.push(T)):(s.roundLengths&&(T=Math.floor(T)),(C-Math.min(e.params.slidesPerGroupSkip,C))%e.params.slidesPerGroup==0&&m.push(T),h.push(T),T=T+L+x),e.virtualSize+=L+x,M=L,C+=1}}if(e.virtualSize=Math.max(e.virtualSize,r)+w,n&&l&&("slide"===s.effect||"coverflow"===s.effect)&&(a.style.width=`${e.virtualSize+x}px`),s.setWrapperSize&&(a.style[e.getDirectionLabel("width")]=`${e.virtualSize+x}px`),P&&e.grid.updateWrapperSize(L,m),!s.centeredSlides){const t=[];for(let a=0;a<m.length;a+=1){let i=m[a];s.roundLengths&&(i=Math.floor(i)),m[a]<=e.virtualSize-r&&t.push(i)}m=t,Math.floor(e.virtualSize-r)-Math.floor(m[m.length-1])>1&&m.push(e.virtualSize-r)}if(o&&s.loop){const t=g[0]+x;if(s.slidesPerGroup>1){const a=Math.ceil((e.virtual.slidesBefore+e.virtual.slidesAfter)/s.slidesPerGroup),i=t*s.slidesPerGroup;for(let e=0;e<a;e+=1)m.push(m[m.length-1]+i)}for(let a=0;a<e.virtual.slidesBefore+e.virtual.slidesAfter;a+=1)1===s.slidesPerGroup&&m.push(m[m.length-1]+t),h.push(h[h.length-1]+t),e.virtualSize+=t}if(0===m.length&&(m=[0]),0!==x){const t=e.isHorizontal()&&n?"marginLeft":e.getDirectionLabel("marginRight");c.filter(((e,t)=>!(s.cssMode&&!s.loop)||t!==c.length-1)).forEach((e=>{e.style[t]=`${x}px`}))}if(s.centeredSlides&&s.centeredSlidesBounds){let e=0;g.forEach((t=>{e+=t+(x||0)})),e-=x;const t=e>r?e-r:0;m=m.map((e=>e<=0?-v:e>t?t+w:e))}if(s.centerInsufficientSlides){let e=0;g.forEach((t=>{e+=t+(x||0)})),e-=x;const t=(s.slidesOffsetBefore||0)+(s.slidesOffsetAfter||0);if(e+t<r){const s=(r-e-t)/2;m.forEach(((e,t)=>{m[t]=e-s})),h.forEach(((e,t)=>{h[t]=e+s}))}}if(Object.assign(e,{slides:c,snapGrid:m,slidesGrid:h,slidesSizesGrid:g}),s.centeredSlides&&s.cssMode&&!s.centeredSlidesBounds){u(a,"--swiper-centered-offset-before",-m[0]+"px"),u(a,"--swiper-centered-offset-after",e.size/2-g[g.length-1]/2+"px");const t=-e.snapGrid[0],s=-e.slidesGrid[0];e.snapGrid=e.snapGrid.map((e=>e+t)),e.slidesGrid=e.slidesGrid.map((e=>e+s))}if(p!==d&&e.emit("slidesLengthChange"),m.length!==y&&(e.params.watchOverflow&&e.checkOverflow(),e.emit("snapGridLengthChange")),h.length!==E&&e.emit("slidesGridLengthChange"),s.watchSlidesProgress&&e.updateSlidesOffset(),e.emit("slidesUpdated"),!(o||s.cssMode||"slide"!==s.effect&&"fade"!==s.effect)){const t=`${s.containerModifierClass}backface-hidden`,a=e.el.classList.contains(t);p<=s.maxBackfaceHiddenSlides?a||e.el.classList.add(t):a&&e.el.classList.remove(t)}},updateAutoHeight:function(e){const t=this,s=[],a=t.virtual&&t.params.virtual.enabled;let i,r=0;"number"==typeof e?t.setTransition(e):!0===e&&t.setTransition(t.params.speed);const n=e=>a?t.slides[t.getSlideIndexByData(e)]:t.slides[e];if("auto"!==t.params.slidesPerView&&t.params.slidesPerView>1)if(t.params.centeredSlides)(t.visibleSlides||[]).forEach((e=>{s.push(e)}));else for(i=0;i<Math.ceil(t.params.slidesPerView);i+=1){const e=t.activeIndex+i;if(e>t.slides.length&&!a)break;s.push(n(e))}else s.push(n(t.activeIndex));for(i=0;i<s.length;i+=1)if(void 0!==s[i]){const e=s[i].offsetHeight;r=e>r?e:r}(r||0===r)&&(t.wrapperEl.style.height=`${r}px`)},updateSlidesOffset:function(){const e=this,t=e.slides,s=e.isElement?e.isHorizontal()?e.wrapperEl.offsetLeft:e.wrapperEl.offsetTop:0;for(let a=0;a<t.length;a+=1)t[a].swiperSlideOffset=(e.isHorizontal()?t[a].offsetLeft:t[a].offsetTop)-s-e.cssOverflowAdjustment()},updateSlidesProgress:function(e){void 0===e&&(e=this&&this.translate||0);const t=this,s=t.params,{slides:a,rtlTranslate:i,snapGrid:r}=t;if(0===a.length)return;void 0===a[0].swiperSlideOffset&&t.updateSlidesOffset();let n=-e;i&&(n=e),t.visibleSlidesIndexes=[],t.visibleSlides=[];let l=s.spaceBetween;"string"==typeof l&&l.indexOf("%")>=0?l=parseFloat(l.replace("%",""))/100*t.size:"string"==typeof l&&(l=parseFloat(l));for(let e=0;e<a.length;e+=1){const o=a[e];let d=o.swiperSlideOffset;s.cssMode&&s.centeredSlides&&(d-=a[0].swiperSlideOffset);const c=(n+(s.centeredSlides?t.minTranslate():0)-d)/(o.swiperSlideSize+l),p=(n-r[0]+(s.centeredSlides?t.minTranslate():0)-d)/(o.swiperSlideSize+l),u=-(n-d),m=u+t.slidesSizesGrid[e],h=u>=0&&u<=t.size-t.slidesSizesGrid[e],f=u>=0&&u<t.size-1||m>1&&m<=t.size||u<=0&&m>=t.size;f&&(t.visibleSlides.push(o),t.visibleSlidesIndexes.push(e)),O(o,f,s.slideVisibleClass),O(o,h,s.slideFullyVisibleClass),o.progress=i?-c:c,o.originalProgress=i?-p:p}},updateProgress:function(e){const t=this;if(void 0===e){const s=t.rtlTranslate?-1:1;e=t&&t.translate&&t.translate*s||0}const s=t.params,a=t.maxTranslate()-t.minTranslate();let{progress:i,isBeginning:r,isEnd:n,progressLoop:l}=t;const o=r,d=n;if(0===a)i=0,r=!0,n=!0;else{i=(e-t.minTranslate())/a;const s=Math.abs(e-t.minTranslate())<1,l=Math.abs(e-t.maxTranslate())<1;r=s||i<=0,n=l||i>=1,s&&(i=0),l&&(i=1)}if(s.loop){const s=t.getSlideIndexByData(0),a=t.getSlideIndexByData(t.slides.length-1),i=t.slidesGrid[s],r=t.slidesGrid[a],n=t.slidesGrid[t.slidesGrid.length-1],o=Math.abs(e);l=o>=i?(o-i)/n:(o+n-r)/n,l>1&&(l-=1)}Object.assign(t,{progress:i,progressLoop:l,isBeginning:r,isEnd:n}),(s.watchSlidesProgress||s.centeredSlides&&s.autoHeight)&&t.updateSlidesProgress(e),r&&!o&&t.emit("reachBeginning toEdge"),n&&!d&&t.emit("reachEnd toEdge"),(o&&!r||d&&!n)&&t.emit("fromEdge"),t.emit("progress",i)},updateSlidesClasses:function(){const e=this,{slides:t,params:s,slidesEl:a,activeIndex:i}=e,r=e.virtual&&s.virtual.enabled,n=e.grid&&s.grid&&s.grid.rows>1,l=e=>f(a,`.${s.slideClass}${e}, swiper-slide${e}`)[0];let o,d,c;if(r)if(s.loop){let t=i-e.virtual.slidesBefore;t<0&&(t=e.virtual.slides.length+t),t>=e.virtual.slides.length&&(t-=e.virtual.slides.length),o=l(`[data-swiper-slide-index="${t}"]`)}else o=l(`[data-swiper-slide-index="${i}"]`);else n?(o=t.find((e=>e.column===i)),c=t.find((e=>e.column===i+1)),d=t.find((e=>e.column===i-1))):o=t[i];o&&(n||(c=function(e,t){const s=[];for(;e.nextElementSibling;){const a=e.nextElementSibling;t?a.matches(t)&&s.push(a):s.push(a),e=a}return s}(o,`.${s.slideClass}, swiper-slide`)[0],s.loop&&!c&&(c=t[0]),d=function(e,t){const s=[];for(;e.previousElementSibling;){const a=e.previousElementSibling;t?a.matches(t)&&s.push(a):s.push(a),e=a}return s}(o,`.${s.slideClass}, swiper-slide`)[0],s.loop&&0===!d&&(d=t[t.length-1]))),t.forEach((e=>{D(e,e===o,s.slideActiveClass),D(e,e===c,s.slideNextClass),D(e,e===d,s.slidePrevClass)})),e.emitSlidesClasses()},updateActiveIndex:function(e){const t=this,s=t.rtlTranslate?t.translate:-t.translate,{snapGrid:a,params:i,activeIndex:r,realIndex:n,snapIndex:l}=t;let o,d=e;const c=e=>{let s=e-t.virtual.slidesBefore;return s<0&&(s=t.virtual.slides.length+s),s>=t.virtual.slides.length&&(s-=t.virtual.slides.length),s};if(void 0===d&&(d=function(e){const{slidesGrid:t,params:s}=e,a=e.rtlTranslate?e.translate:-e.translate;let i;for(let e=0;e<t.length;e+=1)void 0!==t[e+1]?a>=t[e]&&a<t[e+1]-(t[e+1]-t[e])/2?i=e:a>=t[e]&&a<t[e+1]&&(i=e+1):a>=t[e]&&(i=e);return s.normalizeSlideIndex&&(i<0||void 0===i)&&(i=0),i}(t)),a.indexOf(s)>=0)o=a.indexOf(s);else{const e=Math.min(i.slidesPerGroupSkip,d);o=e+Math.floor((d-e)/i.slidesPerGroup)}if(o>=a.length&&(o=a.length-1),d===r&&!t.params.loop)return void(o!==l&&(t.snapIndex=o,t.emit("snapIndexChange")));if(d===r&&t.params.loop&&t.virtual&&t.params.virtual.enabled)return void(t.realIndex=c(d));const p=t.grid&&i.grid&&i.grid.rows>1;let u;if(t.virtual&&i.virtual.enabled&&i.loop)u=c(d);else if(p){const e=t.slides.find((e=>e.column===d));let s=parseInt(e.getAttribute("data-swiper-slide-index"),10);Number.isNaN(s)&&(s=Math.max(t.slides.indexOf(e),0)),u=Math.floor(s/i.grid.rows)}else if(t.slides[d]){const e=t.slides[d].getAttribute("data-swiper-slide-index");u=e?parseInt(e,10):d}else u=d;Object.assign(t,{previousSnapIndex:l,snapIndex:o,previousRealIndex:n,realIndex:u,previousIndex:r,activeIndex:d}),t.initialized&&Y(t),t.emit("activeIndexChange"),t.emit("snapIndexChange"),(t.initialized||t.params.runCallbacksOnInit)&&(n!==u&&t.emit("realIndexChange"),t.emit("slideChange"))},updateClickedSlide:function(e,t){const s=this,a=s.params;let i=e.closest(`.${a.slideClass}, swiper-slide`);!i&&s.isElement&&t&&t.length>1&&t.includes(e)&&[...t.slice(t.indexOf(e)+1,t.length)].forEach((e=>{!i&&e.matches&&e.matches(`.${a.slideClass}, swiper-slide`)&&(i=e)}));let r,n=!1;if(i)for(let e=0;e<s.slides.length;e+=1)if(s.slides[e]===i){n=!0,r=e;break}if(!i||!n)return s.clickedSlide=void 0,void(s.clickedIndex=void 0);s.clickedSlide=i,s.virtual&&s.params.virtual.enabled?s.clickedIndex=parseInt(i.getAttribute("data-swiper-slide-index"),10):s.clickedIndex=r,a.slideToClickedSlide&&void 0!==s.clickedIndex&&s.clickedIndex!==s.activeIndex&&s.slideToClickedSlide()}};var H={getTranslate:function(e){void 0===e&&(e=this.isHorizontal()?"x":"y");const{params:t,rtlTranslate:s,translate:a,wrapperEl:i}=this;if(t.virtualTranslate)return s?-a:a;if(t.cssMode)return a;let r=d(i,e);return r+=this.cssOverflowAdjustment(),s&&(r=-r),r||0},setTranslate:function(e,t){const s=this,{rtlTranslate:a,params:i,wrapperEl:r,progress:n}=s;let l,o=0,d=0;s.isHorizontal()?o=a?-e:e:d=e,i.roundLengths&&(o=Math.floor(o),d=Math.floor(d)),s.previousTranslate=s.translate,s.translate=s.isHorizontal()?o:d,i.cssMode?r[s.isHorizontal()?"scrollLeft":"scrollTop"]=s.isHorizontal()?-o:-d:i.virtualTranslate||(s.isHorizontal()?o-=s.cssOverflowAdjustment():d-=s.cssOverflowAdjustment(),r.style.transform=`translate3d(${o}px, ${d}px, 0px)`);const c=s.maxTranslate()-s.minTranslate();l=0===c?0:(e-s.minTranslate())/c,l!==n&&s.updateProgress(e),s.emit("setTranslate",s.translate,t)},minTranslate:function(){return-this.snapGrid[0]},maxTranslate:function(){return-this.snapGrid[this.snapGrid.length-1]},translateTo:function(e,t,s,a,i){void 0===e&&(e=0),void 0===t&&(t=this.params.speed),void 0===s&&(s=!0),void 0===a&&(a=!0);const r=this,{params:n,wrapperEl:l}=r;if(r.animating&&n.preventInteractionOnTransition)return!1;const o=r.minTranslate(),d=r.maxTranslate();let c;if(c=a&&e>o?o:a&&e<d?d:e,r.updateProgress(c),n.cssMode){const e=r.isHorizontal();if(0===t)l[e?"scrollLeft":"scrollTop"]=-c;else{if(!r.support.smoothScroll)return m({swiper:r,targetPosition:-c,side:e?"left":"top"}),!0;l.scrollTo({[e?"left":"top"]:-c,behavior:"smooth"})}return!0}return 0===t?(r.setTransition(0),r.setTranslate(c),s&&(r.emit("beforeTransitionStart",t,i),r.emit("transitionEnd"))):(r.setTransition(t),r.setTranslate(c),s&&(r.emit("beforeTransitionStart",t,i),r.emit("transitionStart")),r.animating||(r.animating=!0,r.onTranslateToWrapperTransitionEnd||(r.onTranslateToWrapperTransitionEnd=function(e){r&&!r.destroyed&&e.target===this&&(r.wrapperEl.removeEventListener("transitionend",r.onTranslateToWrapperTransitionEnd),r.onTranslateToWrapperTransitionEnd=null,delete r.onTranslateToWrapperTransitionEnd,r.animating=!1,s&&r.emit("transitionEnd"))}),r.wrapperEl.addEventListener("transitionend",r.onTranslateToWrapperTransitionEnd))),!0}};function N(e){let{swiper:t,runCallbacks:s,direction:a,step:i}=e;const{activeIndex:r,previousIndex:n}=t;let l=a;l||(l=r>n?"next":r<n?"prev":"reset"),t.emit(`transition${i}`),s&&"reset"===l?t.emit(`slideResetTransition${i}`):s&&r!==n&&(t.emit(`slideChangeTransition${i}`),"next"===l?t.emit(`slideNextTransition${i}`):t.emit(`slidePrevTransition${i}`))}var R={slideTo:function(e,t,s,a,i){void 0===e&&(e=0),void 0===s&&(s=!0),"string"==typeof e&&(e=parseInt(e,10));const r=this;let n=e;n<0&&(n=0);const{params:l,snapGrid:o,slidesGrid:d,previousIndex:c,activeIndex:p,rtlTranslate:u,wrapperEl:h,enabled:f}=r;if(!f&&!a&&!i||r.destroyed||r.animating&&l.preventInteractionOnTransition)return!1;void 0===t&&(t=r.params.speed);const g=Math.min(r.params.slidesPerGroupSkip,n);let v=g+Math.floor((n-g)/r.params.slidesPerGroup);v>=o.length&&(v=o.length-1);const w=-o[v];if(l.normalizeSlideIndex)for(let e=0;e<d.length;e+=1){const t=-Math.floor(100*w),s=Math.floor(100*d[e]),a=Math.floor(100*d[e+1]);void 0!==d[e+1]?t>=s&&t<a-(a-s)/2?n=e:t>=s&&t<a&&(n=e+1):t>=s&&(n=e)}if(r.initialized&&n!==p){if(!r.allowSlideNext&&(u?w>r.translate&&w>r.minTranslate():w<r.translate&&w<r.minTranslate()))return!1;if(!r.allowSlidePrev&&w>r.translate&&w>r.maxTranslate()&&(p||0)!==n)return!1}let b;n!==(c||0)&&s&&r.emit("beforeSlideChangeStart"),r.updateProgress(w),b=n>p?"next":n<p?"prev":"reset";const y=r.virtual&&r.params.virtual.enabled;if(!(y&&i)&&(u&&-w===r.translate||!u&&w===r.translate))return r.updateActiveIndex(n),l.autoHeight&&r.updateAutoHeight(),r.updateSlidesClasses(),"slide"!==l.effect&&r.setTranslate(w),"reset"!==b&&(r.transitionStart(s,b),r.transitionEnd(s,b)),!1;if(l.cssMode){const e=r.isHorizontal(),s=u?w:-w;if(0===t)y&&(r.wrapperEl.style.scrollSnapType="none",r._immediateVirtual=!0),y&&!r._cssModeVirtualInitialSet&&r.params.initialSlide>0?(r._cssModeVirtualInitialSet=!0,requestAnimationFrame((()=>{h[e?"scrollLeft":"scrollTop"]=s}))):h[e?"scrollLeft":"scrollTop"]=s,y&&requestAnimationFrame((()=>{r.wrapperEl.style.scrollSnapType="",r._immediateVirtual=!1}));else{if(!r.support.smoothScroll)return m({swiper:r,targetPosition:s,side:e?"left":"top"}),!0;h.scrollTo({[e?"left":"top"]:s,behavior:"smooth"})}return!0}const E=$().isSafari;return y&&!i&&E&&r.isElement&&r.virtual.update(!1,!1,n),r.setTransition(t),r.setTranslate(w),r.updateActiveIndex(n),r.updateSlidesClasses(),r.emit("beforeTransitionStart",t,a),r.transitionStart(s,b),0===t?r.transitionEnd(s,b):r.animating||(r.animating=!0,r.onSlideToWrapperTransitionEnd||(r.onSlideToWrapperTransitionEnd=function(e){r&&!r.destroyed&&e.target===this&&(r.wrapperEl.removeEventListener("transitionend",r.onSlideToWrapperTransitionEnd),r.onSlideToWrapperTransitionEnd=null,delete r.onSlideToWrapperTransitionEnd,r.transitionEnd(s,b))}),r.wrapperEl.addEventListener("transitionend",r.onSlideToWrapperTransitionEnd)),!0},slideToLoop:function(e,t,s,a){if(void 0===e&&(e=0),void 0===s&&(s=!0),"string"==typeof e){e=parseInt(e,10)}const i=this;if(i.destroyed)return;void 0===t&&(t=i.params.speed);const r=i.grid&&i.params.grid&&i.params.grid.rows>1;let n=e;if(i.params.loop)if(i.virtual&&i.params.virtual.enabled)n+=i.virtual.slidesBefore;else{let e;if(r){const t=n*i.params.grid.rows;e=i.slides.find((e=>1*e.getAttribute("data-swiper-slide-index")===t)).column}else e=i.getSlideIndexByData(n);const t=r?Math.ceil(i.slides.length/i.params.grid.rows):i.slides.length,{centeredSlides:s}=i.params;let l=i.params.slidesPerView;"auto"===l?l=i.slidesPerViewDynamic():(l=Math.ceil(parseFloat(i.params.slidesPerView,10)),s&&l%2==0&&(l+=1));let o=t-e<l;if(s&&(o=o||e<Math.ceil(l/2)),a&&s&&"auto"!==i.params.slidesPerView&&!r&&(o=!1),o){const a=s?e<i.activeIndex?"prev":"next":e-i.activeIndex-1<i.params.slidesPerView?"next":"prev";i.loopFix({direction:a,slideTo:!0,activeSlideIndex:"next"===a?e+1:e-t+1,slideRealIndex:"next"===a?i.realIndex:void 0})}if(r){const e=n*i.params.grid.rows;n=i.slides.find((t=>1*t.getAttribute("data-swiper-slide-index")===e)).column}else n=i.getSlideIndexByData(n)}return requestAnimationFrame((()=>{i.slideTo(n,t,s,a)})),i},slideNext:function(e,t,s){void 0===t&&(t=!0);const a=this,{enabled:i,params:r,animating:n}=a;if(!i||a.destroyed)return a;void 0===e&&(e=a.params.speed);let l=r.slidesPerGroup;"auto"===r.slidesPerView&&1===r.slidesPerGroup&&r.slidesPerGroupAuto&&(l=Math.max(a.slidesPerViewDynamic("current",!0),1));const o=a.activeIndex<r.slidesPerGroupSkip?1:l,d=a.virtual&&r.virtual.enabled;if(r.loop){if(n&&!d&&r.loopPreventsSliding)return!1;if(a.loopFix({direction:"next"}),a._clientLeft=a.wrapperEl.clientLeft,a.activeIndex===a.slides.length-1&&r.cssMode)return requestAnimationFrame((()=>{a.slideTo(a.activeIndex+o,e,t,s)})),!0}return r.rewind&&a.isEnd?a.slideTo(0,e,t,s):a.slideTo(a.activeIndex+o,e,t,s)},slidePrev:function(e,t,s){void 0===t&&(t=!0);const a=this,{params:i,snapGrid:r,slidesGrid:n,rtlTranslate:l,enabled:o,animating:d}=a;if(!o||a.destroyed)return a;void 0===e&&(e=a.params.speed);const c=a.virtual&&i.virtual.enabled;if(i.loop){if(d&&!c&&i.loopPreventsSliding)return!1;a.loopFix({direction:"prev"}),a._clientLeft=a.wrapperEl.clientLeft}function p(e){return e<0?-Math.floor(Math.abs(e)):Math.floor(e)}const u=p(l?a.translate:-a.translate),m=r.map((e=>p(e))),h=i.freeMode&&i.freeMode.enabled;let f=r[m.indexOf(u)-1];if(void 0===f&&(i.cssMode||h)){let e;r.forEach(((t,s)=>{u>=t&&(e=s)})),void 0!==e&&(f=h?r[e]:r[e>0?e-1:e])}let g=0;if(void 0!==f&&(g=n.indexOf(f),g<0&&(g=a.activeIndex-1),"auto"===i.slidesPerView&&1===i.slidesPerGroup&&i.slidesPerGroupAuto&&(g=g-a.slidesPerViewDynamic("previous",!0)+1,g=Math.max(g,0))),i.rewind&&a.isBeginning){const i=a.params.virtual&&a.params.virtual.enabled&&a.virtual?a.virtual.slides.length-1:a.slides.length-1;return a.slideTo(i,e,t,s)}return i.loop&&0===a.activeIndex&&i.cssMode?(requestAnimationFrame((()=>{a.slideTo(g,e,t,s)})),!0):a.slideTo(g,e,t,s)},slideReset:function(e,t,s){void 0===t&&(t=!0);const a=this;if(!a.destroyed)return void 0===e&&(e=a.params.speed),a.slideTo(a.activeIndex,e,t,s)},slideToClosest:function(e,t,s,a){void 0===t&&(t=!0),void 0===a&&(a=.5);const i=this;if(i.destroyed)return;void 0===e&&(e=i.params.speed);let r=i.activeIndex;const n=Math.min(i.params.slidesPerGroupSkip,r),l=n+Math.floor((r-n)/i.params.slidesPerGroup),o=i.rtlTranslate?i.translate:-i.translate;if(o>=i.snapGrid[l]){const e=i.snapGrid[l];o-e>(i.snapGrid[l+1]-e)*a&&(r+=i.params.slidesPerGroup)}else{const e=i.snapGrid[l-1];o-e<=(i.snapGrid[l]-e)*a&&(r-=i.params.slidesPerGroup)}return r=Math.max(r,0),r=Math.min(r,i.slidesGrid.length-1),i.slideTo(r,e,t,s)},slideToClickedSlide:function(){const e=this;if(e.destroyed)return;const{params:t,slidesEl:s}=e,a="auto"===t.slidesPerView?e.slidesPerViewDynamic():t.slidesPerView;let i,r=e.getSlideIndexWhenGrid(e.clickedIndex);const n=e.isElement?"swiper-slide":`.${t.slideClass}`,o=e.grid&&e.params.grid&&e.params.grid.rows>1;if(t.loop){if(e.animating)return;i=parseInt(e.clickedSlide.getAttribute("data-swiper-slide-index"),10),t.centeredSlides?e.slideToLoop(i):r>(o?(e.slides.length-a)/2-(e.params.grid.rows-1):e.slides.length-a)?(e.loopFix(),r=e.getSlideIndex(f(s,`${n}[data-swiper-slide-index="${i}"]`)[0]),l((()=>{e.slideTo(r)}))):e.slideTo(r)}else e.slideTo(r)}};var _={loopCreate:function(e,t){const s=this,{params:a,slidesEl:i}=s;if(!a.loop||s.virtual&&s.params.virtual.enabled)return;const r=()=>{f(i,`.${a.slideClass}, swiper-slide`).forEach(((e,t)=>{e.setAttribute("data-swiper-slide-index",t)}))},n=s.grid&&a.grid&&a.grid.rows>1;a.loopAddBlankSlides&&(a.slidesPerGroup>1||n)&&(()=>{const e=f(i,`.${a.slideBlankClass}`);e.forEach((e=>{e.remove()})),e.length>0&&(s.recalcSlides(),s.updateSlides())})();const l=a.slidesPerGroup*(n?a.grid.rows:1),o=s.slides.length%l!=0,d=n&&s.slides.length%a.grid.rows!=0,c=e=>{for(let t=0;t<e;t+=1){const e=s.isElement?v("swiper-slide",[a.slideBlankClass]):v("div",[a.slideClass,a.slideBlankClass]);s.slidesEl.append(e)}};if(o){if(a.loopAddBlankSlides){c(l-s.slides.length%l),s.recalcSlides(),s.updateSlides()}else g("Swiper Loop Warning: The number of slides is not even to slidesPerGroup, loop mode may not function properly. You need to add more slides (or make duplicates, or empty slides)");r()}else if(d){if(a.loopAddBlankSlides){c(a.grid.rows-s.slides.length%a.grid.rows),s.recalcSlides(),s.updateSlides()}else g("Swiper Loop Warning: The number of slides is not even to grid.rows, loop mode may not function properly. You need to add more slides (or make duplicates, or empty slides)");r()}else r();s.loopFix({slideRealIndex:e,direction:a.centeredSlides?void 0:"next",initial:t})},loopFix:function(e){let{slideRealIndex:t,slideTo:s=!0,direction:a,setTranslate:i,activeSlideIndex:r,initial:n,byController:l,byMousewheel:o}=void 0===e?{}:e;const d=this;if(!d.params.loop)return;d.emit("beforeLoopFix");const{slides:c,allowSlidePrev:p,allowSlideNext:u,slidesEl:m,params:h}=d,{centeredSlides:f,initialSlide:v}=h;if(d.allowSlidePrev=!0,d.allowSlideNext=!0,d.virtual&&h.virtual.enabled)return s&&(h.centeredSlides||0!==d.snapIndex?h.centeredSlides&&d.snapIndex<h.slidesPerView?d.slideTo(d.virtual.slides.length+d.snapIndex,0,!1,!0):d.snapIndex===d.snapGrid.length-1&&d.slideTo(d.virtual.slidesBefore,0,!1,!0):d.slideTo(d.virtual.slides.length,0,!1,!0)),d.allowSlidePrev=p,d.allowSlideNext=u,void d.emit("loopFix");let w=h.slidesPerView;"auto"===w?w=d.slidesPerViewDynamic():(w=Math.ceil(parseFloat(h.slidesPerView,10)),f&&w%2==0&&(w+=1));const b=h.slidesPerGroupAuto?w:h.slidesPerGroup;let y=f?Math.max(b,Math.ceil(w/2)):b;y%b!=0&&(y+=b-y%b),y+=h.loopAdditionalSlides,d.loopedSlides=y;const E=d.grid&&h.grid&&h.grid.rows>1;c.length<w+y||"cards"===d.params.effect&&c.length<w+2*y?g("Swiper Loop Warning: The number of slides is not enough for loop mode, it will be disabled or not function properly. You need to add more slides (or make duplicates) or lower the values of slidesPerView and slidesPerGroup parameters"):E&&"row"===h.grid.fill&&g("Swiper Loop Warning: Loop mode is not compatible with grid.fill = `row`");const x=[],S=[],T=E?Math.ceil(c.length/h.grid.rows):c.length,M=n&&T-v<w&&!f;let C=M?v:d.activeIndex;void 0===r?r=d.getSlideIndex(c.find((e=>e.classList.contains(h.slideActiveClass)))):C=r;const P="next"===a||!a,L="prev"===a||!a;let I=0,z=0;const A=(E?c[r].column:r)+(f&&void 0===i?-w/2+.5:0);if(A<y){I=Math.max(y-A,b);for(let e=0;e<y-A;e+=1){const t=e-Math.floor(e/T)*T;if(E){const e=T-t-1;for(let t=c.length-1;t>=0;t-=1)c[t].column===e&&x.push(t)}else x.push(T-t-1)}}else if(A+w>T-y){z=Math.max(A-(T-2*y),b),M&&(z=Math.max(z,w-T+v+1));for(let e=0;e<z;e+=1){const t=e-Math.floor(e/T)*T;E?c.forEach(((e,s)=>{e.column===t&&S.push(s)})):S.push(t)}}if(d.__preventObserver__=!0,requestAnimationFrame((()=>{d.__preventObserver__=!1})),"cards"===d.params.effect&&c.length<w+2*y&&(S.includes(r)&&S.splice(S.indexOf(r),1),x.includes(r)&&x.splice(x.indexOf(r),1)),L&&x.forEach((e=>{c[e].swiperLoopMoveDOM=!0,m.prepend(c[e]),c[e].swiperLoopMoveDOM=!1})),P&&S.forEach((e=>{c[e].swiperLoopMoveDOM=!0,m.append(c[e]),c[e].swiperLoopMoveDOM=!1})),d.recalcSlides(),"auto"===h.slidesPerView?d.updateSlides():E&&(x.length>0&&L||S.length>0&&P)&&d.slides.forEach(((e,t)=>{d.grid.updateSlide(t,e,d.slides)})),h.watchSlidesProgress&&d.updateSlidesOffset(),s)if(x.length>0&&L){if(void 0===t){const e=d.slidesGrid[C],t=d.slidesGrid[C+I]-e;o?d.setTranslate(d.translate-t):(d.slideTo(C+Math.ceil(I),0,!1,!0),i&&(d.touchEventsData.startTranslate=d.touchEventsData.startTranslate-t,d.touchEventsData.currentTranslate=d.touchEventsData.currentTranslate-t))}else if(i){const e=E?x.length/h.grid.rows:x.length;d.slideTo(d.activeIndex+e,0,!1,!0),d.touchEventsData.currentTranslate=d.translate}}else if(S.length>0&&P)if(void 0===t){const e=d.slidesGrid[C],t=d.slidesGrid[C-z]-e;o?d.setTranslate(d.translate-t):(d.slideTo(C-z,0,!1,!0),i&&(d.touchEventsData.startTranslate=d.touchEventsData.startTranslate-t,d.touchEventsData.currentTranslate=d.touchEventsData.currentTranslate-t))}else{const e=E?S.length/h.grid.rows:S.length;d.slideTo(d.activeIndex-e,0,!1,!0)}if(d.allowSlidePrev=p,d.allowSlideNext=u,d.controller&&d.controller.control&&!l){const e={slideRealIndex:t,direction:a,setTranslate:i,activeSlideIndex:r,byController:!0};Array.isArray(d.controller.control)?d.controller.control.forEach((t=>{!t.destroyed&&t.params.loop&&t.loopFix({...e,slideTo:t.params.slidesPerView===h.slidesPerView&&s})})):d.controller.control instanceof d.constructor&&d.controller.control.params.loop&&d.controller.control.loopFix({...e,slideTo:d.controller.control.params.slidesPerView===h.slidesPerView&&s})}d.emit("loopFix")},loopDestroy:function(){const e=this,{params:t,slidesEl:s}=e;if(!t.loop||!s||e.virtual&&e.params.virtual.enabled)return;e.recalcSlides();const a=[];e.slides.forEach((e=>{const t=void 0===e.swiperSlideIndex?1*e.getAttribute("data-swiper-slide-index"):e.swiperSlideIndex;a[t]=e})),e.slides.forEach((e=>{e.removeAttribute("data-swiper-slide-index")})),a.forEach((e=>{s.append(e)})),e.recalcSlides(),e.slideTo(e.realIndex,0)}};function q(e,t,s){const a=r(),{params:i}=e,n=i.edgeSwipeDetection,l=i.edgeSwipeThreshold;return!n||!(s<=l||s>=a.innerWidth-l)||"prevent"===n&&(t.preventDefault(),!0)}function V(e){const t=this,s=a();let i=e;i.originalEvent&&(i=i.originalEvent);const n=t.touchEventsData;if("pointerdown"===i.type){if(null!==n.pointerId&&n.pointerId!==i.pointerId)return;n.pointerId=i.pointerId}else"touchstart"===i.type&&1===i.targetTouches.length&&(n.touchId=i.targetTouches[0].identifier);if("touchstart"===i.type)return void q(t,i,i.targetTouches[0].pageX);const{params:l,touches:d,enabled:c}=t;if(!c)return;if(!l.simulateTouch&&"mouse"===i.pointerType)return;if(t.animating&&l.preventInteractionOnTransition)return;!t.animating&&l.cssMode&&l.loop&&t.loopFix();let p=i.target;if("wrapper"===l.touchEventsTarget&&!function(e,t){const s=r();let a=t.contains(e);!a&&s.HTMLSlotElement&&t instanceof HTMLSlotElement&&(a=[...t.assignedElements()].includes(e),a||(a=function(e,t){const s=[t];for(;s.length>0;){const t=s.shift();if(e===t)return!0;s.push(...t.children,...t.shadowRoot?t.shadowRoot.children:[],...t.assignedElements?t.assignedElements():[])}}(e,t)));return a}(p,t.wrapperEl))return;if("which"in i&&3===i.which)return;if("button"in i&&i.button>0)return;if(n.isTouched&&n.isMoved)return;const u=!!l.noSwipingClass&&""!==l.noSwipingClass,m=i.composedPath?i.composedPath():i.path;u&&i.target&&i.target.shadowRoot&&m&&(p=m[0]);const h=l.noSwipingSelector?l.noSwipingSelector:`.${l.noSwipingClass}`,f=!(!i.target||!i.target.shadowRoot);if(l.noSwiping&&(f?function(e,t){return void 0===t&&(t=this),function t(s){if(!s||s===a()||s===r())return null;s.assignedSlot&&(s=s.assignedSlot);const i=s.closest(e);return i||s.getRootNode?i||t(s.getRootNode().host):null}(t)}(h,p):p.closest(h)))return void(t.allowClick=!0);if(l.swipeHandler&&!p.closest(l.swipeHandler))return;d.currentX=i.pageX,d.currentY=i.pageY;const g=d.currentX,v=d.currentY;if(!q(t,i,g))return;Object.assign(n,{isTouched:!0,isMoved:!1,allowTouchCallbacks:!0,isScrolling:void 0,startMoving:void 0}),d.startX=g,d.startY=v,n.touchStartTime=o(),t.allowClick=!0,t.updateSize(),t.swipeDirection=void 0,l.threshold>0&&(n.allowThresholdMove=!1);let w=!0;p.matches(n.focusableElements)&&(w=!1,"SELECT"===p.nodeName&&(n.isTouched=!1)),s.activeElement&&s.activeElement.matches(n.focusableElements)&&s.activeElement!==p&&("mouse"===i.pointerType||"mouse"!==i.pointerType&&!p.matches(n.focusableElements))&&s.activeElement.blur();const b=w&&t.allowTouchMove&&l.touchStartPreventDefault;!l.touchStartForcePreventDefault&&!b||p.isContentEditable||i.preventDefault(),l.freeMode&&l.freeMode.enabled&&t.freeMode&&t.animating&&!l.cssMode&&t.freeMode.onTouchStart(),t.emit("touchStart",i)}function F(e){const t=a(),s=this,i=s.touchEventsData,{params:r,touches:n,rtlTranslate:l,enabled:d}=s;if(!d)return;if(!r.simulateTouch&&"mouse"===e.pointerType)return;let c,p=e;if(p.originalEvent&&(p=p.originalEvent),"pointermove"===p.type){if(null!==i.touchId)return;if(p.pointerId!==i.pointerId)return}if("touchmove"===p.type){if(c=[...p.changedTouches].find((e=>e.identifier===i.touchId)),!c||c.identifier!==i.touchId)return}else c=p;if(!i.isTouched)return void(i.startMoving&&i.isScrolling&&s.emit("touchMoveOpposite",p));const u=c.pageX,m=c.pageY;if(p.preventedByNestedSwiper)return n.startX=u,void(n.startY=m);if(!s.allowTouchMove)return p.target.matches(i.focusableElements)||(s.allowClick=!1),void(i.isTouched&&(Object.assign(n,{startX:u,startY:m,currentX:u,currentY:m}),i.touchStartTime=o()));if(r.touchReleaseOnEdges&&!r.loop)if(s.isVertical()){if(m<n.startY&&s.translate<=s.maxTranslate()||m>n.startY&&s.translate>=s.minTranslate())return i.isTouched=!1,void(i.isMoved=!1)}else{if(l&&(u>n.startX&&-s.translate<=s.maxTranslate()||u<n.startX&&-s.translate>=s.minTranslate()))return;if(!l&&(u<n.startX&&s.translate<=s.maxTranslate()||u>n.startX&&s.translate>=s.minTranslate()))return}if(t.activeElement&&t.activeElement.matches(i.focusableElements)&&t.activeElement!==p.target&&"mouse"!==p.pointerType&&t.activeElement.blur(),t.activeElement&&p.target===t.activeElement&&p.target.matches(i.focusableElements))return i.isMoved=!0,void(s.allowClick=!1);i.allowTouchCallbacks&&s.emit("touchMove",p),n.previousX=n.currentX,n.previousY=n.currentY,n.currentX=u,n.currentY=m;const h=n.currentX-n.startX,f=n.currentY-n.startY;if(s.params.threshold&&Math.sqrt(h**2+f**2)<s.params.threshold)return;if(void 0===i.isScrolling){let e;s.isHorizontal()&&n.currentY===n.startY||s.isVertical()&&n.currentX===n.startX?i.isScrolling=!1:h*h+f*f>=25&&(e=180*Math.atan2(Math.abs(f),Math.abs(h))/Math.PI,i.isScrolling=s.isHorizontal()?e>r.touchAngle:90-e>r.touchAngle)}if(i.isScrolling&&s.emit("touchMoveOpposite",p),void 0===i.startMoving&&(n.currentX===n.startX&&n.currentY===n.startY||(i.startMoving=!0)),i.isScrolling||"touchmove"===p.type&&i.preventTouchMoveFromPointerMove)return void(i.isTouched=!1);if(!i.startMoving)return;s.allowClick=!1,!r.cssMode&&p.cancelable&&p.preventDefault(),r.touchMoveStopPropagation&&!r.nested&&p.stopPropagation();let g=s.isHorizontal()?h:f,v=s.isHorizontal()?n.currentX-n.previousX:n.currentY-n.previousY;r.oneWayMovement&&(g=Math.abs(g)*(l?1:-1),v=Math.abs(v)*(l?1:-1)),n.diff=g,g*=r.touchRatio,l&&(g=-g,v=-v);const w=s.touchesDirection;s.swipeDirection=g>0?"prev":"next",s.touchesDirection=v>0?"prev":"next";const b=s.params.loop&&!r.cssMode,y="next"===s.touchesDirection&&s.allowSlideNext||"prev"===s.touchesDirection&&s.allowSlidePrev;if(!i.isMoved){if(b&&y&&s.loopFix({direction:s.swipeDirection}),i.startTranslate=s.getTranslate(),s.setTransition(0),s.animating){const e=new window.CustomEvent("transitionend",{bubbles:!0,cancelable:!0,detail:{bySwiperTouchMove:!0}});s.wrapperEl.dispatchEvent(e)}i.allowMomentumBounce=!1,!r.grabCursor||!0!==s.allowSlideNext&&!0!==s.allowSlidePrev||s.setGrabCursor(!0),s.emit("sliderFirstMove",p)}if((new Date).getTime(),!1!==r._loopSwapReset&&i.isMoved&&i.allowThresholdMove&&w!==s.touchesDirection&&b&&y&&Math.abs(g)>=1)return Object.assign(n,{startX:u,startY:m,currentX:u,currentY:m,startTranslate:i.currentTranslate}),i.loopSwapReset=!0,void(i.startTranslate=i.currentTranslate);s.emit("sliderMove",p),i.isMoved=!0,i.currentTranslate=g+i.startTranslate;let E=!0,x=r.resistanceRatio;if(r.touchReleaseOnEdges&&(x=0),g>0?(b&&y&&i.allowThresholdMove&&i.currentTranslate>(r.centeredSlides?s.minTranslate()-s.slidesSizesGrid[s.activeIndex+1]-("auto"!==r.slidesPerView&&s.slides.length-r.slidesPerView>=2?s.slidesSizesGrid[s.activeIndex+1]+s.params.spaceBetween:0)-s.params.spaceBetween:s.minTranslate())&&s.loopFix({direction:"prev",setTranslate:!0,activeSlideIndex:0}),i.currentTranslate>s.minTranslate()&&(E=!1,r.resistance&&(i.currentTranslate=s.minTranslate()-1+(-s.minTranslate()+i.startTranslate+g)**x))):g<0&&(b&&y&&i.allowThresholdMove&&i.currentTranslate<(r.centeredSlides?s.maxTranslate()+s.slidesSizesGrid[s.slidesSizesGrid.length-1]+s.params.spaceBetween+("auto"!==r.slidesPerView&&s.slides.length-r.slidesPerView>=2?s.slidesSizesGrid[s.slidesSizesGrid.length-1]+s.params.spaceBetween:0):s.maxTranslate())&&s.loopFix({direction:"next",setTranslate:!0,activeSlideIndex:s.slides.length-("auto"===r.slidesPerView?s.slidesPerViewDynamic():Math.ceil(parseFloat(r.slidesPerView,10)))}),i.currentTranslate<s.maxTranslate()&&(E=!1,r.resistance&&(i.currentTranslate=s.maxTranslate()+1-(s.maxTranslate()-i.startTranslate-g)**x))),E&&(p.preventedByNestedSwiper=!0),!s.allowSlideNext&&"next"===s.swipeDirection&&i.currentTranslate<i.startTranslate&&(i.currentTranslate=i.startTranslate),!s.allowSlidePrev&&"prev"===s.swipeDirection&&i.currentTranslate>i.startTranslate&&(i.currentTranslate=i.startTranslate),s.allowSlidePrev||s.allowSlideNext||(i.currentTranslate=i.startTranslate),r.threshold>0){if(!(Math.abs(g)>r.threshold||i.allowThresholdMove))return void(i.currentTranslate=i.startTranslate);if(!i.allowThresholdMove)return i.allowThresholdMove=!0,n.startX=n.currentX,n.startY=n.currentY,i.currentTranslate=i.startTranslate,void(n.diff=s.isHorizontal()?n.currentX-n.startX:n.currentY-n.startY)}r.followFinger&&!r.cssMode&&((r.freeMode&&r.freeMode.enabled&&s.freeMode||r.watchSlidesProgress)&&(s.updateActiveIndex(),s.updateSlidesClasses()),r.freeMode&&r.freeMode.enabled&&s.freeMode&&s.freeMode.onTouchMove(),s.updateProgress(i.currentTranslate),s.setTranslate(i.currentTranslate))}function W(e){const t=this,s=t.touchEventsData;let a,i=e;i.originalEvent&&(i=i.originalEvent);if("touchend"===i.type||"touchcancel"===i.type){if(a=[...i.changedTouches].find((e=>e.identifier===s.touchId)),!a||a.identifier!==s.touchId)return}else{if(null!==s.touchId)return;if(i.pointerId!==s.pointerId)return;a=i}if(["pointercancel","pointerout","pointerleave","contextmenu"].includes(i.type)){if(!(["pointercancel","contextmenu"].includes(i.type)&&(t.browser.isSafari||t.browser.isWebView)))return}s.pointerId=null,s.touchId=null;const{params:r,touches:n,rtlTranslate:d,slidesGrid:c,enabled:p}=t;if(!p)return;if(!r.simulateTouch&&"mouse"===i.pointerType)return;if(s.allowTouchCallbacks&&t.emit("touchEnd",i),s.allowTouchCallbacks=!1,!s.isTouched)return s.isMoved&&r.grabCursor&&t.setGrabCursor(!1),s.isMoved=!1,void(s.startMoving=!1);r.grabCursor&&s.isMoved&&s.isTouched&&(!0===t.allowSlideNext||!0===t.allowSlidePrev)&&t.setGrabCursor(!1);const u=o(),m=u-s.touchStartTime;if(t.allowClick){const e=i.path||i.composedPath&&i.composedPath();t.updateClickedSlide(e&&e[0]||i.target,e),t.emit("tap click",i),m<300&&u-s.lastClickTime<300&&t.emit("doubleTap doubleClick",i)}if(s.lastClickTime=o(),l((()=>{t.destroyed||(t.allowClick=!0)})),!s.isTouched||!s.isMoved||!t.swipeDirection||0===n.diff&&!s.loopSwapReset||s.currentTranslate===s.startTranslate&&!s.loopSwapReset)return s.isTouched=!1,s.isMoved=!1,void(s.startMoving=!1);let h;if(s.isTouched=!1,s.isMoved=!1,s.startMoving=!1,h=r.followFinger?d?t.translate:-t.translate:-s.currentTranslate,r.cssMode)return;if(r.freeMode&&r.freeMode.enabled)return void t.freeMode.onTouchEnd({currentPos:h});const f=h>=-t.maxTranslate()&&!t.params.loop;let g=0,v=t.slidesSizesGrid[0];for(let e=0;e<c.length;e+=e<r.slidesPerGroupSkip?1:r.slidesPerGroup){const t=e<r.slidesPerGroupSkip-1?1:r.slidesPerGroup;void 0!==c[e+t]?(f||h>=c[e]&&h<c[e+t])&&(g=e,v=c[e+t]-c[e]):(f||h>=c[e])&&(g=e,v=c[c.length-1]-c[c.length-2])}let w=null,b=null;r.rewind&&(t.isBeginning?b=r.virtual&&r.virtual.enabled&&t.virtual?t.virtual.slides.length-1:t.slides.length-1:t.isEnd&&(w=0));const y=(h-c[g])/v,E=g<r.slidesPerGroupSkip-1?1:r.slidesPerGroup;if(m>r.longSwipesMs){if(!r.longSwipes)return void t.slideTo(t.activeIndex);"next"===t.swipeDirection&&(y>=r.longSwipesRatio?t.slideTo(r.rewind&&t.isEnd?w:g+E):t.slideTo(g)),"prev"===t.swipeDirection&&(y>1-r.longSwipesRatio?t.slideTo(g+E):null!==b&&y<0&&Math.abs(y)>r.longSwipesRatio?t.slideTo(b):t.slideTo(g))}else{if(!r.shortSwipes)return void t.slideTo(t.activeIndex);t.navigation&&(i.target===t.navigation.nextEl||i.target===t.navigation.prevEl)?i.target===t.navigation.nextEl?t.slideTo(g+E):t.slideTo(g):("next"===t.swipeDirection&&t.slideTo(null!==w?w:g+E),"prev"===t.swipeDirection&&t.slideTo(null!==b?b:g))}}function j(){const e=this,{params:t,el:s}=e;if(s&&0===s.offsetWidth)return;t.breakpoints&&e.setBreakpoint();const{allowSlideNext:a,allowSlidePrev:i,snapGrid:r}=e,n=e.virtual&&e.params.virtual.enabled;e.allowSlideNext=!0,e.allowSlidePrev=!0,e.updateSize(),e.updateSlides(),e.updateSlidesClasses();const l=n&&t.loop;!("auto"===t.slidesPerView||t.slidesPerView>1)||!e.isEnd||e.isBeginning||e.params.centeredSlides||l?e.params.loop&&!n?e.slideToLoop(e.realIndex,0,!1,!0):e.slideTo(e.activeIndex,0,!1,!0):e.slideTo(e.slides.length-1,0,!1,!0),e.autoplay&&e.autoplay.running&&e.autoplay.paused&&(clearTimeout(e.autoplay.resizeTimeout),e.autoplay.resizeTimeout=setTimeout((()=>{e.autoplay&&e.autoplay.running&&e.autoplay.paused&&e.autoplay.resume()}),500)),e.allowSlidePrev=i,e.allowSlideNext=a,e.params.watchOverflow&&r!==e.snapGrid&&e.checkOverflow()}function U(e){const t=this;t.enabled&&(t.allowClick||(t.params.preventClicks&&e.preventDefault(),t.params.preventClicksPropagation&&t.animating&&(e.stopPropagation(),e.stopImmediatePropagation())))}function K(){const e=this,{wrapperEl:t,rtlTranslate:s,enabled:a}=e;if(!a)return;let i;e.previousTranslate=e.translate,e.isHorizontal()?e.translate=-t.scrollLeft:e.translate=-t.scrollTop,0===e.translate&&(e.translate=0),e.updateActiveIndex(),e.updateSlidesClasses();const r=e.maxTranslate()-e.minTranslate();i=0===r?0:(e.translate-e.minTranslate())/r,i!==e.progress&&e.updateProgress(s?-e.translate:e.translate),e.emit("setTranslate",e.translate,!1)}function Z(e){const t=this;G(t,e.target),t.params.cssMode||"auto"!==t.params.slidesPerView&&!t.params.autoHeight||t.update()}function Q(){const e=this;e.documentTouchHandlerProceeded||(e.documentTouchHandlerProceeded=!0,e.params.touchReleaseOnEdges&&(e.el.style.touchAction="auto"))}const J=(e,t)=>{const s=a(),{params:i,el:r,wrapperEl:n,device:l}=e,o=!!i.nested,d="on"===t?"addEventListener":"removeEventListener",c=t;r&&"string"!=typeof r&&(s[d]("touchstart",e.onDocumentTouchStart,{passive:!1,capture:o}),r[d]("touchstart",e.onTouchStart,{passive:!1}),r[d]("pointerdown",e.onTouchStart,{passive:!1}),s[d]("touchmove",e.onTouchMove,{passive:!1,capture:o}),s[d]("pointermove",e.onTouchMove,{passive:!1,capture:o}),s[d]("touchend",e.onTouchEnd,{passive:!0}),s[d]("pointerup",e.onTouchEnd,{passive:!0}),s[d]("pointercancel",e.onTouchEnd,{passive:!0}),s[d]("touchcancel",e.onTouchEnd,{passive:!0}),s[d]("pointerout",e.onTouchEnd,{passive:!0}),s[d]("pointerleave",e.onTouchEnd,{passive:!0}),s[d]("contextmenu",e.onTouchEnd,{passive:!0}),(i.preventClicks||i.preventClicksPropagation)&&r[d]("click",e.onClick,!0),i.cssMode&&n[d]("scroll",e.onScroll),i.updateOnWindowResize?e[c](l.ios||l.android?"resize orientationchange observerUpdate":"resize observerUpdate",j,!0):e[c]("observerUpdate",j,!0),r[d]("load",e.onLoad,{capture:!0}))};const ee=(e,t)=>e.grid&&t.grid&&t.grid.rows>1;var te={init:!0,direction:"horizontal",oneWayMovement:!1,swiperElementNodeName:"SWIPER-CONTAINER",touchEventsTarget:"wrapper",initialSlide:0,speed:300,cssMode:!1,updateOnWindowResize:!0,resizeObserver:!0,nested:!1,createElements:!1,eventsPrefix:"swiper",enabled:!0,focusableElements:"input, select, option, textarea, button, video, label",width:null,height:null,preventInteractionOnTransition:!1,userAgent:null,url:null,edgeSwipeDetection:!1,edgeSwipeThreshold:20,autoHeight:!1,setWrapperSize:!1,virtualTranslate:!1,effect:"slide",breakpoints:void 0,breakpointsBase:"window",spaceBetween:0,slidesPerView:1,slidesPerGroup:1,slidesPerGroupSkip:0,slidesPerGroupAuto:!1,centeredSlides:!1,centeredSlidesBounds:!1,slidesOffsetBefore:0,slidesOffsetAfter:0,normalizeSlideIndex:!0,centerInsufficientSlides:!1,watchOverflow:!0,roundLengths:!1,touchRatio:1,touchAngle:45,simulateTouch:!0,shortSwipes:!0,longSwipes:!0,longSwipesRatio:.5,longSwipesMs:300,followFinger:!0,allowTouchMove:!0,threshold:5,touchMoveStopPropagation:!1,touchStartPreventDefault:!0,touchStartForcePreventDefault:!1,touchReleaseOnEdges:!1,uniqueNavElements:!0,resistance:!0,resistanceRatio:.85,watchSlidesProgress:!1,grabCursor:!1,preventClicks:!0,preventClicksPropagation:!0,slideToClickedSlide:!1,loop:!1,loopAddBlankSlides:!0,loopAdditionalSlides:0,loopPreventsSliding:!0,rewind:!1,allowSlidePrev:!0,allowSlideNext:!0,swipeHandler:null,noSwiping:!0,noSwipingClass:"swiper-no-swiping",noSwipingSelector:null,passiveListeners:!0,maxBackfaceHiddenSlides:10,containerModifierClass:"swiper-",slideClass:"swiper-slide",slideBlankClass:"swiper-slide-blank",slideActiveClass:"swiper-slide-active",slideVisibleClass:"swiper-slide-visible",slideFullyVisibleClass:"swiper-slide-fully-visible",slideNextClass:"swiper-slide-next",slidePrevClass:"swiper-slide-prev",wrapperClass:"swiper-wrapper",lazyPreloaderClass:"swiper-lazy-preloader",lazyPreloadPrevNext:0,runCallbacksOnInit:!0,_emitClasses:!1};function se(e,t){return function(s){void 0===s&&(s={});const a=Object.keys(s)[0],i=s[a];"object"==typeof i&&null!==i?(!0===e[a]&&(e[a]={enabled:!0}),"navigation"===a&&e[a]&&e[a].enabled&&!e[a].prevEl&&!e[a].nextEl&&(e[a].auto=!0),["pagination","scrollbar"].indexOf(a)>=0&&e[a]&&e[a].enabled&&!e[a].el&&(e[a].auto=!0),a in e&&"enabled"in i?("object"!=typeof e[a]||"enabled"in e[a]||(e[a].enabled=!0),e[a]||(e[a]={enabled:!1}),p(t,s)):p(t,s)):p(t,s)}}const ae={eventsEmitter:k,update:B,translate:H,transition:{setTransition:function(e,t){const s=this;s.params.cssMode||(s.wrapperEl.style.transitionDuration=`${e}ms`,s.wrapperEl.style.transitionDelay=0===e?"0ms":""),s.emit("setTransition",e,t)},transitionStart:function(e,t){void 0===e&&(e=!0);const s=this,{params:a}=s;a.cssMode||(a.autoHeight&&s.updateAutoHeight(),N({swiper:s,runCallbacks:e,direction:t,step:"Start"}))},transitionEnd:function(e,t){void 0===e&&(e=!0);const s=this,{params:a}=s;s.animating=!1,a.cssMode||(s.setTransition(0),N({swiper:s,runCallbacks:e,direction:t,step:"End"}))}},slide:R,loop:_,grabCursor:{setGrabCursor:function(e){const t=this;if(!t.params.simulateTouch||t.params.watchOverflow&&t.isLocked||t.params.cssMode)return;const s="container"===t.params.touchEventsTarget?t.el:t.wrapperEl;t.isElement&&(t.__preventObserver__=!0),s.style.cursor="move",s.style.cursor=e?"grabbing":"grab",t.isElement&&requestAnimationFrame((()=>{t.__preventObserver__=!1}))},unsetGrabCursor:function(){const e=this;e.params.watchOverflow&&e.isLocked||e.params.cssMode||(e.isElement&&(e.__preventObserver__=!0),e["container"===e.params.touchEventsTarget?"el":"wrapperEl"].style.cursor="",e.isElement&&requestAnimationFrame((()=>{e.__preventObserver__=!1})))}},events:{attachEvents:function(){const e=this,{params:t}=e;e.onTouchStart=V.bind(e),e.onTouchMove=F.bind(e),e.onTouchEnd=W.bind(e),e.onDocumentTouchStart=Q.bind(e),t.cssMode&&(e.onScroll=K.bind(e)),e.onClick=U.bind(e),e.onLoad=Z.bind(e),J(e,"on")},detachEvents:function(){J(this,"off")}},breakpoints:{setBreakpoint:function(){const e=this,{realIndex:t,initialized:s,params:i,el:r}=e,n=i.breakpoints;if(!n||n&&0===Object.keys(n).length)return;const l=a(),o="window"!==i.breakpointsBase&&i.breakpointsBase?"container":i.breakpointsBase,d=["window","container"].includes(i.breakpointsBase)||!i.breakpointsBase?e.el:l.querySelector(i.breakpointsBase),c=e.getBreakpoint(n,o,d);if(!c||e.currentBreakpoint===c)return;const u=(c in n?n[c]:void 0)||e.originalParams,m=ee(e,i),h=ee(e,u),f=e.params.grabCursor,g=u.grabCursor,v=i.enabled;m&&!h?(r.classList.remove(`${i.containerModifierClass}grid`,`${i.containerModifierClass}grid-column`),e.emitContainerClasses()):!m&&h&&(r.classList.add(`${i.containerModifierClass}grid`),(u.grid.fill&&"column"===u.grid.fill||!u.grid.fill&&"column"===i.grid.fill)&&r.classList.add(`${i.containerModifierClass}grid-column`),e.emitContainerClasses()),f&&!g?e.unsetGrabCursor():!f&&g&&e.setGrabCursor(),["navigation","pagination","scrollbar"].forEach((t=>{if(void 0===u[t])return;const s=i[t]&&i[t].enabled,a=u[t]&&u[t].enabled;s&&!a&&e[t].disable(),!s&&a&&e[t].enable()}));const w=u.direction&&u.direction!==i.direction,b=i.loop&&(u.slidesPerView!==i.slidesPerView||w),y=i.loop;w&&s&&e.changeDirection(),p(e.params,u);const E=e.params.enabled,x=e.params.loop;Object.assign(e,{allowTouchMove:e.params.allowTouchMove,allowSlideNext:e.params.allowSlideNext,allowSlidePrev:e.params.allowSlidePrev}),v&&!E?e.disable():!v&&E&&e.enable(),e.currentBreakpoint=c,e.emit("_beforeBreakpoint",u),s&&(b?(e.loopDestroy(),e.loopCreate(t),e.updateSlides()):!y&&x?(e.loopCreate(t),e.updateSlides()):y&&!x&&e.loopDestroy()),e.emit("breakpoint",u)},getBreakpoint:function(e,t,s){if(void 0===t&&(t="window"),!e||"container"===t&&!s)return;let a=!1;const i=r(),n="window"===t?i.innerHeight:s.clientHeight,l=Object.keys(e).map((e=>{if("string"==typeof e&&0===e.indexOf("@")){const t=parseFloat(e.substr(1));return{value:n*t,point:e}}return{value:e,point:e}}));l.sort(((e,t)=>parseInt(e.value,10)-parseInt(t.value,10)));for(let e=0;e<l.length;e+=1){const{point:r,value:n}=l[e];"window"===t?i.matchMedia(`(min-width: ${n}px)`).matches&&(a=r):n<=s.clientWidth&&(a=r)}return a||"max"}},checkOverflow:{checkOverflow:function(){const e=this,{isLocked:t,params:s}=e,{slidesOffsetBefore:a}=s;if(a){const t=e.slides.length-1,s=e.slidesGrid[t]+e.slidesSizesGrid[t]+2*a;e.isLocked=e.size>s}else e.isLocked=1===e.snapGrid.length;!0===s.allowSlideNext&&(e.allowSlideNext=!e.isLocked),!0===s.allowSlidePrev&&(e.allowSlidePrev=!e.isLocked),t&&t!==e.isLocked&&(e.isEnd=!1),t!==e.isLocked&&e.emit(e.isLocked?"lock":"unlock")}},classes:{addClasses:function(){const e=this,{classNames:t,params:s,rtl:a,el:i,device:r}=e,n=function(e,t){const s=[];return e.forEach((e=>{"object"==typeof e?Object.keys(e).forEach((a=>{e[a]&&s.push(t+a)})):"string"==typeof e&&s.push(t+e)})),s}(["initialized",s.direction,{"free-mode":e.params.freeMode&&s.freeMode.enabled},{autoheight:s.autoHeight},{rtl:a},{grid:s.grid&&s.grid.rows>1},{"grid-column":s.grid&&s.grid.rows>1&&"column"===s.grid.fill},{android:r.android},{ios:r.ios},{"css-mode":s.cssMode},{centered:s.cssMode&&s.centeredSlides},{"watch-progress":s.watchSlidesProgress}],s.containerModifierClass);t.push(...n),i.classList.add(...t),e.emitContainerClasses()},removeClasses:function(){const{el:e,classNames:t}=this;e&&"string"!=typeof e&&(e.classList.remove(...t),this.emitContainerClasses())}}},ie={};class re{constructor(){let e,t;for(var s=arguments.length,i=new Array(s),r=0;r<s;r++)i[r]=arguments[r];1===i.length&&i[0].constructor&&"Object"===Object.prototype.toString.call(i[0]).slice(8,-1)?t=i[0]:[e,t]=i,t||(t={}),t=p({},t),e&&!t.el&&(t.el=e);const n=a();if(t.el&&"string"==typeof t.el&&n.querySelectorAll(t.el).length>1){const e=[];return n.querySelectorAll(t.el).forEach((s=>{const a=p({},t,{el:s});e.push(new re(a))})),e}const l=this;l.__swiper__=!0,l.support=z(),l.device=A({userAgent:t.userAgent}),l.browser=$(),l.eventsListeners={},l.eventsAnyListeners=[],l.modules=[...l.__modules__],t.modules&&Array.isArray(t.modules)&&l.modules.push(...t.modules);const o={};l.modules.forEach((e=>{e({params:t,swiper:l,extendParams:se(t,o),on:l.on.bind(l),once:l.once.bind(l),off:l.off.bind(l),emit:l.emit.bind(l)})}));const d=p({},te,o);return l.params=p({},d,ie,t),l.originalParams=p({},l.params),l.passedParams=p({},t),l.params&&l.params.on&&Object.keys(l.params.on).forEach((e=>{l.on(e,l.params.on[e])})),l.params&&l.params.onAny&&l.onAny(l.params.onAny),Object.assign(l,{enabled:l.params.enabled,el:e,classNames:[],slides:[],slidesGrid:[],snapGrid:[],slidesSizesGrid:[],isHorizontal:()=>"horizontal"===l.params.direction,isVertical:()=>"vertical"===l.params.direction,activeIndex:0,realIndex:0,isBeginning:!0,isEnd:!1,translate:0,previousTranslate:0,progress:0,velocity:0,animating:!1,cssOverflowAdjustment(){return Math.trunc(this.translate/2**23)*2**23},allowSlideNext:l.params.allowSlideNext,allowSlidePrev:l.params.allowSlidePrev,touchEventsData:{isTouched:void 0,isMoved:void 0,allowTouchCallbacks:void 0,touchStartTime:void 0,isScrolling:void 0,currentTranslate:void 0,startTranslate:void 0,allowThresholdMove:void 0,focusableElements:l.params.focusableElements,lastClickTime:0,clickTimeout:void 0,velocities:[],allowMomentumBounce:void 0,startMoving:void 0,pointerId:null,touchId:null},allowClick:!0,allowTouchMove:l.params.allowTouchMove,touches:{startX:0,startY:0,currentX:0,currentY:0,diff:0},imagesToLoad:[],imagesLoaded:0}),l.emit("_swiper"),l.params.init&&l.init(),l}getDirectionLabel(e){return this.isHorizontal()?e:{width:"height","margin-top":"margin-left","margin-bottom ":"margin-right","margin-left":"margin-top","margin-right":"margin-bottom","padding-left":"padding-top","padding-right":"padding-bottom",marginRight:"marginBottom"}[e]}getSlideIndex(e){const{slidesEl:t,params:s}=this,a=y(f(t,`.${s.slideClass}, swiper-slide`)[0]);return y(e)-a}getSlideIndexByData(e){return this.getSlideIndex(this.slides.find((t=>1*t.getAttribute("data-swiper-slide-index")===e)))}getSlideIndexWhenGrid(e){return this.grid&&this.params.grid&&this.params.grid.rows>1&&("column"===this.params.grid.fill?e=Math.floor(e/this.params.grid.rows):"row"===this.params.grid.fill&&(e%=Math.ceil(this.slides.length/this.params.grid.rows))),e}recalcSlides(){const{slidesEl:e,params:t}=this;this.slides=f(e,`.${t.slideClass}, swiper-slide`)}enable(){const e=this;e.enabled||(e.enabled=!0,e.params.grabCursor&&e.setGrabCursor(),e.emit("enable"))}disable(){const e=this;e.enabled&&(e.enabled=!1,e.params.grabCursor&&e.unsetGrabCursor(),e.emit("disable"))}setProgress(e,t){const s=this;e=Math.min(Math.max(e,0),1);const a=s.minTranslate(),i=(s.maxTranslate()-a)*e+a;s.translateTo(i,void 0===t?0:t),s.updateActiveIndex(),s.updateSlidesClasses()}emitContainerClasses(){const e=this;if(!e.params._emitClasses||!e.el)return;const t=e.el.className.split(" ").filter((t=>0===t.indexOf("swiper")||0===t.indexOf(e.params.containerModifierClass)));e.emit("_containerClasses",t.join(" "))}getSlideClasses(e){const t=this;return t.destroyed?"":e.className.split(" ").filter((e=>0===e.indexOf("swiper-slide")||0===e.indexOf(t.params.slideClass))).join(" ")}emitSlidesClasses(){const e=this;if(!e.params._emitClasses||!e.el)return;const t=[];e.slides.forEach((s=>{const a=e.getSlideClasses(s);t.push({slideEl:s,classNames:a}),e.emit("_slideClass",s,a)})),e.emit("_slideClasses",t)}slidesPerViewDynamic(e,t){void 0===e&&(e="current"),void 0===t&&(t=!1);const{params:s,slides:a,slidesGrid:i,slidesSizesGrid:r,size:n,activeIndex:l}=this;let o=1;if("number"==typeof s.slidesPerView)return s.slidesPerView;if(s.centeredSlides){let e,t=a[l]?Math.ceil(a[l].swiperSlideSize):0;for(let s=l+1;s<a.length;s+=1)a[s]&&!e&&(t+=Math.ceil(a[s].swiperSlideSize),o+=1,t>n&&(e=!0));for(let s=l-1;s>=0;s-=1)a[s]&&!e&&(t+=a[s].swiperSlideSize,o+=1,t>n&&(e=!0))}else if("current"===e)for(let e=l+1;e<a.length;e+=1){(t?i[e]+r[e]-i[l]<n:i[e]-i[l]<n)&&(o+=1)}else for(let e=l-1;e>=0;e-=1){i[l]-i[e]<n&&(o+=1)}return o}update(){const e=this;if(!e||e.destroyed)return;const{snapGrid:t,params:s}=e;function a(){const t=e.rtlTranslate?-1*e.translate:e.translate,s=Math.min(Math.max(t,e.maxTranslate()),e.minTranslate());e.setTranslate(s),e.updateActiveIndex(),e.updateSlidesClasses()}let i;if(s.breakpoints&&e.setBreakpoint(),[...e.el.querySelectorAll('[loading="lazy"]')].forEach((t=>{t.complete&&G(e,t)})),e.updateSize(),e.updateSlides(),e.updateProgress(),e.updateSlidesClasses(),s.freeMode&&s.freeMode.enabled&&!s.cssMode)a(),s.autoHeight&&e.updateAutoHeight();else{if(("auto"===s.slidesPerView||s.slidesPerView>1)&&e.isEnd&&!s.centeredSlides){const t=e.virtual&&s.virtual.enabled?e.virtual.slides:e.slides;i=e.slideTo(t.length-1,0,!1,!0)}else i=e.slideTo(e.activeIndex,0,!1,!0);i||a()}s.watchOverflow&&t!==e.snapGrid&&e.checkOverflow(),e.emit("update")}changeDirection(e,t){void 0===t&&(t=!0);const s=this,a=s.params.direction;return e||(e="horizontal"===a?"vertical":"horizontal"),e===a||"horizontal"!==e&&"vertical"!==e||(s.el.classList.remove(`${s.params.containerModifierClass}${a}`),s.el.classList.add(`${s.params.containerModifierClass}${e}`),s.emitContainerClasses(),s.params.direction=e,s.slides.forEach((t=>{"vertical"===e?t.style.width="":t.style.height=""})),s.emit("changeDirection"),t&&s.update()),s}changeLanguageDirection(e){const t=this;t.rtl&&"rtl"===e||!t.rtl&&"ltr"===e||(t.rtl="rtl"===e,t.rtlTranslate="horizontal"===t.params.direction&&t.rtl,t.rtl?(t.el.classList.add(`${t.params.containerModifierClass}rtl`),t.el.dir="rtl"):(t.el.classList.remove(`${t.params.containerModifierClass}rtl`),t.el.dir="ltr"),t.update())}mount(e){const t=this;if(t.mounted)return!0;let s=e||t.params.el;if("string"==typeof s&&(s=document.querySelector(s)),!s)return!1;s.swiper=t,s.parentNode&&s.parentNode.host&&s.parentNode.host.nodeName===t.params.swiperElementNodeName.toUpperCase()&&(t.isElement=!0);const a=()=>`.${(t.params.wrapperClass||"").trim().split(" ").join(".")}`;let i=(()=>{if(s&&s.shadowRoot&&s.shadowRoot.querySelector){return s.shadowRoot.querySelector(a())}return f(s,a())[0]})();return!i&&t.params.createElements&&(i=v("div",t.params.wrapperClass),s.append(i),f(s,`.${t.params.slideClass}`).forEach((e=>{i.append(e)}))),Object.assign(t,{el:s,wrapperEl:i,slidesEl:t.isElement&&!s.parentNode.host.slideSlots?s.parentNode.host:i,hostEl:t.isElement?s.parentNode.host:s,mounted:!0,rtl:"rtl"===s.dir.toLowerCase()||"rtl"===b(s,"direction"),rtlTranslate:"horizontal"===t.params.direction&&("rtl"===s.dir.toLowerCase()||"rtl"===b(s,"direction")),wrongRTL:"-webkit-box"===b(i,"display")}),!0}init(e){const t=this;if(t.initialized)return t;if(!1===t.mount(e))return t;t.emit("beforeInit"),t.params.breakpoints&&t.setBreakpoint(),t.addClasses(),t.updateSize(),t.updateSlides(),t.params.watchOverflow&&t.checkOverflow(),t.params.grabCursor&&t.enabled&&t.setGrabCursor(),t.params.loop&&t.virtual&&t.params.virtual.enabled?t.slideTo(t.params.initialSlide+t.virtual.slidesBefore,0,t.params.runCallbacksOnInit,!1,!0):t.slideTo(t.params.initialSlide,0,t.params.runCallbacksOnInit,!1,!0),t.params.loop&&t.loopCreate(void 0,!0),t.attachEvents();const s=[...t.el.querySelectorAll('[loading="lazy"]')];return t.isElement&&s.push(...t.hostEl.querySelectorAll('[loading="lazy"]')),s.forEach((e=>{e.complete?G(t,e):e.addEventListener("load",(e=>{G(t,e.target)}))})),Y(t),t.initialized=!0,Y(t),t.emit("init"),t.emit("afterInit"),t}destroy(e,t){void 0===e&&(e=!0),void 0===t&&(t=!0);const s=this,{params:a,el:i,wrapperEl:r,slides:n}=s;return void 0===s.params||s.destroyed||(s.emit("beforeDestroy"),s.initialized=!1,s.detachEvents(),a.loop&&s.loopDestroy(),t&&(s.removeClasses(),i&&"string"!=typeof i&&i.removeAttribute("style"),r&&r.removeAttribute("style"),n&&n.length&&n.forEach((e=>{e.classList.remove(a.slideVisibleClass,a.slideFullyVisibleClass,a.slideActiveClass,a.slideNextClass,a.slidePrevClass),e.removeAttribute("style"),e.removeAttribute("data-swiper-slide-index")}))),s.emit("destroy"),Object.keys(s.eventsListeners).forEach((e=>{s.off(e)})),!1!==e&&(s.el&&"string"!=typeof s.el&&(s.el.swiper=null),function(e){const t=e;Object.keys(t).forEach((e=>{try{t[e]=null}catch(e){}try{delete t[e]}catch(e){}}))}(s)),s.destroyed=!0),null}static extendDefaults(e){p(ie,e)}static get extendedDefaults(){return ie}static get defaults(){return te}static installModule(e){re.prototype.__modules__||(re.prototype.__modules__=[]);const t=re.prototype.__modules__;"function"==typeof e&&t.indexOf(e)<0&&t.push(e)}static use(e){return Array.isArray(e)?(e.forEach((e=>re.installModule(e))),re):(re.installModule(e),re)}}function ne(e,t,s,a){return e.params.createElements&&Object.keys(a).forEach((i=>{if(!s[i]&&!0===s.auto){let r=f(e.el,`.${a[i]}`)[0];r||(r=v("div",a[i]),r.className=a[i],e.el.append(r)),s[i]=r,t[i]=r}})),s}function le(e){return void 0===e&&(e=""),`.${e.trim().replace(/([\.:!+\/()[\]])/g,"\\$1").replace(/ /g,".")}`}function oe(e){const t=this,{params:s,slidesEl:a}=t;s.loop&&t.loopDestroy();const i=e=>{if("string"==typeof e){const t=document.createElement("div");C(t,e),a.append(t.children[0]),C(t,"")}else a.append(e)};if("object"==typeof e&&"length"in e)for(let t=0;t<e.length;t+=1)e[t]&&i(e[t]);else i(e);t.recalcSlides(),s.loop&&t.loopCreate(),s.observer&&!t.isElement||t.update()}function de(e){const t=this,{params:s,activeIndex:a,slidesEl:i}=t;s.loop&&t.loopDestroy();let r=a+1;const n=e=>{if("string"==typeof e){const t=document.createElement("div");C(t,e),i.prepend(t.children[0]),C(t,"")}else i.prepend(e)};if("object"==typeof e&&"length"in e){for(let t=0;t<e.length;t+=1)e[t]&&n(e[t]);r=a+e.length}else n(e);t.recalcSlides(),s.loop&&t.loopCreate(),s.observer&&!t.isElement||t.update(),t.slideTo(r,0,!1)}function ce(e,t){const s=this,{params:a,activeIndex:i,slidesEl:r}=s;let n=i;a.loop&&(n-=s.loopedSlides,s.loopDestroy(),s.recalcSlides());const l=s.slides.length;if(e<=0)return void s.prependSlide(t);if(e>=l)return void s.appendSlide(t);let o=n>e?n+1:n;const d=[];for(let t=l-1;t>=e;t-=1){const e=s.slides[t];e.remove(),d.unshift(e)}if("object"==typeof t&&"length"in t){for(let e=0;e<t.length;e+=1)t[e]&&r.append(t[e]);o=n>e?n+t.length:n}else r.append(t);for(let e=0;e<d.length;e+=1)r.append(d[e]);s.recalcSlides(),a.loop&&s.loopCreate(),a.observer&&!s.isElement||s.update(),a.loop?s.slideTo(o+s.loopedSlides,0,!1):s.slideTo(o,0,!1)}function pe(e){const t=this,{params:s,activeIndex:a}=t;let i=a;s.loop&&(i-=t.loopedSlides,t.loopDestroy());let r,n=i;if("object"==typeof e&&"length"in e){for(let s=0;s<e.length;s+=1)r=e[s],t.slides[r]&&t.slides[r].remove(),r<n&&(n-=1);n=Math.max(n,0)}else r=e,t.slides[r]&&t.slides[r].remove(),r<n&&(n-=1),n=Math.max(n,0);t.recalcSlides(),s.loop&&t.loopCreate(),s.observer&&!t.isElement||t.update(),s.loop?t.slideTo(n+t.loopedSlides,0,!1):t.slideTo(n,0,!1)}function ue(){const e=this,t=[];for(let s=0;s<e.slides.length;s+=1)t.push(s);e.removeSlide(t)}function me(e){const{effect:t,swiper:s,on:a,setTranslate:i,setTransition:r,overwriteParams:n,perspective:l,recreateShadows:o,getEffectParams:d}=e;let c;a("beforeInit",(()=>{if(s.params.effect!==t)return;s.classNames.push(`${s.params.containerModifierClass}${t}`),l&&l()&&s.classNames.push(`${s.params.containerModifierClass}3d`);const e=n?n():{};Object.assign(s.params,e),Object.assign(s.originalParams,e)})),a("setTranslate _virtualUpdated",(()=>{s.params.effect===t&&i()})),a("setTransition",((e,a)=>{s.params.effect===t&&r(a)})),a("transitionEnd",(()=>{if(s.params.effect===t&&o){if(!d||!d().slideShadows)return;s.slides.forEach((e=>{e.querySelectorAll(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").forEach((e=>e.remove()))})),o()}})),a("virtualUpdate",(()=>{s.params.effect===t&&(s.slides.length||(c=!0),requestAnimationFrame((()=>{c&&s.slides&&s.slides.length&&(i(),c=!1)})))}))}function he(e,t){const s=h(t);return s!==t&&(s.style.backfaceVisibility="hidden",s.style["-webkit-backface-visibility"]="hidden"),s}function fe(e){let{swiper:t,duration:s,transformElements:a,allSlides:i}=e;const{activeIndex:r}=t;if(t.params.virtualTranslate&&0!==s){let e,s=!1;e=i?a:a.filter((e=>{const s=e.classList.contains("swiper-slide-transform")?(e=>{if(!e.parentElement)return t.slides.find((t=>t.shadowRoot&&t.shadowRoot===e.parentNode));return e.parentElement})(e):e;return t.getSlideIndex(s)===r})),e.forEach((e=>{x(e,(()=>{if(s)return;if(!t||t.destroyed)return;s=!0,t.animating=!1;const e=new window.CustomEvent("transitionend",{bubbles:!0,cancelable:!0});t.wrapperEl.dispatchEvent(e)}))}))}}function ge(e,t,s){const a=`swiper-slide-shadow${s?`-${s}`:""}${e?` swiper-slide-shadow-${e}`:""}`,i=h(t);let r=i.querySelector(`.${a.split(" ").join(".")}`);return r||(r=v("div",a.split(" ")),i.append(r)),r}Object.keys(ae).forEach((e=>{Object.keys(ae[e]).forEach((t=>{re.prototype[t]=ae[e][t]}))})),re.use([function(e){let{swiper:t,on:s,emit:a}=e;const i=r();let n=null,l=null;const o=()=>{t&&!t.destroyed&&t.initialized&&(a("beforeResize"),a("resize"))},d=()=>{t&&!t.destroyed&&t.initialized&&a("orientationchange")};s("init",(()=>{t.params.resizeObserver&&void 0!==i.ResizeObserver?t&&!t.destroyed&&t.initialized&&(n=new ResizeObserver((e=>{l=i.requestAnimationFrame((()=>{const{width:s,height:a}=t;let i=s,r=a;e.forEach((e=>{let{contentBoxSize:s,contentRect:a,target:n}=e;n&&n!==t.el||(i=a?a.width:(s[0]||s).inlineSize,r=a?a.height:(s[0]||s).blockSize)})),i===s&&r===a||o()}))})),n.observe(t.el)):(i.addEventListener("resize",o),i.addEventListener("orientationchange",d))})),s("destroy",(()=>{l&&i.cancelAnimationFrame(l),n&&n.unobserve&&t.el&&(n.unobserve(t.el),n=null),i.removeEventListener("resize",o),i.removeEventListener("orientationchange",d)}))},function(e){let{swiper:t,extendParams:s,on:a,emit:i}=e;const n=[],l=r(),o=function(e,s){void 0===s&&(s={});const a=new(l.MutationObserver||l.WebkitMutationObserver)((e=>{if(t.__preventObserver__)return;if(1===e.length)return void i("observerUpdate",e[0]);const s=function(){i("observerUpdate",e[0])};l.requestAnimationFrame?l.requestAnimationFrame(s):l.setTimeout(s,0)}));a.observe(e,{attributes:void 0===s.attributes||s.attributes,childList:t.isElement||(void 0===s.childList||s).childList,characterData:void 0===s.characterData||s.characterData}),n.push(a)};s({observer:!1,observeParents:!1,observeSlideChildren:!1}),a("init",(()=>{if(t.params.observer){if(t.params.observeParents){const e=E(t.hostEl);for(let t=0;t<e.length;t+=1)o(e[t])}o(t.hostEl,{childList:t.params.observeSlideChildren}),o(t.wrapperEl,{attributes:!1})}})),a("destroy",(()=>{n.forEach((e=>{e.disconnect()})),n.splice(0,n.length)}))}]);const ve=[function(e){let t,{swiper:s,extendParams:i,on:r,emit:n}=e;i({virtual:{enabled:!1,slides:[],cache:!0,renderSlide:null,renderExternal:null,renderExternalUpdate:!0,addSlidesBefore:0,addSlidesAfter:0}});const l=a();s.virtual={cache:{},from:void 0,to:void 0,slides:[],offset:0,slidesGrid:[]};const o=l.createElement("div");function d(e,t){const a=s.params.virtual;if(a.cache&&s.virtual.cache[t])return s.virtual.cache[t];let i;return a.renderSlide?(i=a.renderSlide.call(s,e,t),"string"==typeof i&&(C(o,i),i=o.children[0])):i=s.isElement?v("swiper-slide"):v("div",s.params.slideClass),i.setAttribute("data-swiper-slide-index",t),a.renderSlide||C(i,e),a.cache&&(s.virtual.cache[t]=i),i}function c(e,t,a){const{slidesPerView:i,slidesPerGroup:r,centeredSlides:l,loop:o,initialSlide:c}=s.params;if(t&&!o&&c>0)return;const{addSlidesBefore:p,addSlidesAfter:u}=s.params.virtual,{from:m,to:h,slides:g,slidesGrid:v,offset:w}=s.virtual;s.params.cssMode||s.updateActiveIndex();const b=void 0===a?s.activeIndex||0:a;let y,E,x;y=s.rtlTranslate?"right":s.isHorizontal()?"left":"top",l?(E=Math.floor(i/2)+r+u,x=Math.floor(i/2)+r+p):(E=i+(r-1)+u,x=(o?i:r)+p);let S=b-x,T=b+E;o||(S=Math.max(S,0),T=Math.min(T,g.length-1));let M=(s.slidesGrid[S]||0)-(s.slidesGrid[0]||0);function C(){s.updateSlides(),s.updateProgress(),s.updateSlidesClasses(),n("virtualUpdate")}if(o&&b>=x?(S-=x,l||(M+=s.slidesGrid[0])):o&&b<x&&(S=-x,l&&(M+=s.slidesGrid[0])),Object.assign(s.virtual,{from:S,to:T,offset:M,slidesGrid:s.slidesGrid,slidesBefore:x,slidesAfter:E}),m===S&&h===T&&!e)return s.slidesGrid!==v&&M!==w&&s.slides.forEach((e=>{e.style[y]=M-Math.abs(s.cssOverflowAdjustment())+"px"})),s.updateProgress(),void n("virtualUpdate");if(s.params.virtual.renderExternal)return s.params.virtual.renderExternal.call(s,{offset:M,from:S,to:T,slides:function(){const e=[];for(let t=S;t<=T;t+=1)e.push(g[t]);return e}()}),void(s.params.virtual.renderExternalUpdate?C():n("virtualUpdate"));const P=[],L=[],I=e=>{let t=e;return e<0?t=g.length+e:t>=g.length&&(t-=g.length),t};if(e)s.slides.filter((e=>e.matches(`.${s.params.slideClass}, swiper-slide`))).forEach((e=>{e.remove()}));else for(let e=m;e<=h;e+=1)if(e<S||e>T){const t=I(e);s.slides.filter((e=>e.matches(`.${s.params.slideClass}[data-swiper-slide-index="${t}"], swiper-slide[data-swiper-slide-index="${t}"]`))).forEach((e=>{e.remove()}))}const z=o?-g.length:0,A=o?2*g.length:g.length;for(let t=z;t<A;t+=1)if(t>=S&&t<=T){const s=I(t);void 0===h||e?L.push(s):(t>h&&L.push(s),t<m&&P.push(s))}if(L.forEach((e=>{s.slidesEl.append(d(g[e],e))})),o)for(let e=P.length-1;e>=0;e-=1){const t=P[e];s.slidesEl.prepend(d(g[t],t))}else P.sort(((e,t)=>t-e)),P.forEach((e=>{s.slidesEl.prepend(d(g[e],e))}));f(s.slidesEl,".swiper-slide, swiper-slide").forEach((e=>{e.style[y]=M-Math.abs(s.cssOverflowAdjustment())+"px"})),C()}r("beforeInit",(()=>{if(!s.params.virtual.enabled)return;let e;if(void 0===s.passedParams.virtual.slides){const t=[...s.slidesEl.children].filter((e=>e.matches(`.${s.params.slideClass}, swiper-slide`)));t&&t.length&&(s.virtual.slides=[...t],e=!0,t.forEach(((e,t)=>{e.setAttribute("data-swiper-slide-index",t),s.virtual.cache[t]=e,e.remove()})))}e||(s.virtual.slides=s.params.virtual.slides),s.classNames.push(`${s.params.containerModifierClass}virtual`),s.params.watchSlidesProgress=!0,s.originalParams.watchSlidesProgress=!0,c(!1,!0)})),r("setTranslate",(()=>{s.params.virtual.enabled&&(s.params.cssMode&&!s._immediateVirtual?(clearTimeout(t),t=setTimeout((()=>{c()}),100)):c())})),r("init update resize",(()=>{s.params.virtual.enabled&&s.params.cssMode&&u(s.wrapperEl,"--swiper-virtual-size",`${s.virtualSize}px`)})),Object.assign(s.virtual,{appendSlide:function(e){if("object"==typeof e&&"length"in e)for(let t=0;t<e.length;t+=1)e[t]&&s.virtual.slides.push(e[t]);else s.virtual.slides.push(e);c(!0)},prependSlide:function(e){const t=s.activeIndex;let a=t+1,i=1;if(Array.isArray(e)){for(let t=0;t<e.length;t+=1)e[t]&&s.virtual.slides.unshift(e[t]);a=t+e.length,i=e.length}else s.virtual.slides.unshift(e);if(s.params.virtual.cache){const e=s.virtual.cache,t={};Object.keys(e).forEach((s=>{const a=e[s],r=a.getAttribute("data-swiper-slide-index");r&&a.setAttribute("data-swiper-slide-index",parseInt(r,10)+i),t[parseInt(s,10)+i]=a})),s.virtual.cache=t}c(!0),s.slideTo(a,0)},removeSlide:function(e){if(null==e)return;let t=s.activeIndex;if(Array.isArray(e))for(let a=e.length-1;a>=0;a-=1)s.params.virtual.cache&&(delete s.virtual.cache[e[a]],Object.keys(s.virtual.cache).forEach((t=>{t>e&&(s.virtual.cache[t-1]=s.virtual.cache[t],s.virtual.cache[t-1].setAttribute("data-swiper-slide-index",t-1),delete s.virtual.cache[t])}))),s.virtual.slides.splice(e[a],1),e[a]<t&&(t-=1),t=Math.max(t,0);else s.params.virtual.cache&&(delete s.virtual.cache[e],Object.keys(s.virtual.cache).forEach((t=>{t>e&&(s.virtual.cache[t-1]=s.virtual.cache[t],s.virtual.cache[t-1].setAttribute("data-swiper-slide-index",t-1),delete s.virtual.cache[t])}))),s.virtual.slides.splice(e,1),e<t&&(t-=1),t=Math.max(t,0);c(!0),s.slideTo(t,0)},removeAllSlides:function(){s.virtual.slides=[],s.params.virtual.cache&&(s.virtual.cache={}),c(!0),s.slideTo(0,0)},update:c})},function(e){let{swiper:t,extendParams:s,on:i,emit:n}=e;const l=a(),o=r();function d(e){if(!t.enabled)return;const{rtlTranslate:s}=t;let a=e;a.originalEvent&&(a=a.originalEvent);const i=a.keyCode||a.charCode,r=t.params.keyboard.pageUpDown,d=r&&33===i,c=r&&34===i,p=37===i,u=39===i,m=38===i,h=40===i;if(!t.allowSlideNext&&(t.isHorizontal()&&u||t.isVertical()&&h||c))return!1;if(!t.allowSlidePrev&&(t.isHorizontal()&&p||t.isVertical()&&m||d))return!1;if(!(a.shiftKey||a.altKey||a.ctrlKey||a.metaKey||l.activeElement&&(l.activeElement.isContentEditable||l.activeElement.nodeName&&("input"===l.activeElement.nodeName.toLowerCase()||"textarea"===l.activeElement.nodeName.toLowerCase())))){if(t.params.keyboard.onlyInViewport&&(d||c||p||u||m||h)){let e=!1;if(E(t.el,`.${t.params.slideClass}, swiper-slide`).length>0&&0===E(t.el,`.${t.params.slideActiveClass}`).length)return;const a=t.el,i=a.clientWidth,r=a.clientHeight,n=o.innerWidth,l=o.innerHeight,d=w(a);s&&(d.left-=a.scrollLeft);const c=[[d.left,d.top],[d.left+i,d.top],[d.left,d.top+r],[d.left+i,d.top+r]];for(let t=0;t<c.length;t+=1){const s=c[t];if(s[0]>=0&&s[0]<=n&&s[1]>=0&&s[1]<=l){if(0===s[0]&&0===s[1])continue;e=!0}}if(!e)return}t.isHorizontal()?((d||c||p||u)&&(a.preventDefault?a.preventDefault():a.returnValue=!1),((c||u)&&!s||(d||p)&&s)&&t.slideNext(),((d||p)&&!s||(c||u)&&s)&&t.slidePrev()):((d||c||m||h)&&(a.preventDefault?a.preventDefault():a.returnValue=!1),(c||h)&&t.slideNext(),(d||m)&&t.slidePrev()),n("keyPress",i)}}function c(){t.keyboard.enabled||(l.addEventListener("keydown",d),t.keyboard.enabled=!0)}function p(){t.keyboard.enabled&&(l.removeEventListener("keydown",d),t.keyboard.enabled=!1)}t.keyboard={enabled:!1},s({keyboard:{enabled:!1,onlyInViewport:!0,pageUpDown:!0}}),i("init",(()=>{t.params.keyboard.enabled&&c()})),i("destroy",(()=>{t.keyboard.enabled&&p()})),Object.assign(t.keyboard,{enable:c,disable:p})},function(e){let{swiper:t,extendParams:s,on:a,emit:i}=e;const n=r();let d;s({mousewheel:{enabled:!1,releaseOnEdges:!1,invert:!1,forceToAxis:!1,sensitivity:1,eventsTarget:"container",thresholdDelta:null,thresholdTime:null,noMousewheelClass:"swiper-no-mousewheel"}}),t.mousewheel={enabled:!1};let c,p=o();const u=[];function m(){t.enabled&&(t.mouseEntered=!0)}function h(){t.enabled&&(t.mouseEntered=!1)}function f(e){return!(t.params.mousewheel.thresholdDelta&&e.delta<t.params.mousewheel.thresholdDelta)&&(!(t.params.mousewheel.thresholdTime&&o()-p<t.params.mousewheel.thresholdTime)&&(e.delta>=6&&o()-p<60||(e.direction<0?t.isEnd&&!t.params.loop||t.animating||(t.slideNext(),i("scroll",e.raw)):t.isBeginning&&!t.params.loop||t.animating||(t.slidePrev(),i("scroll",e.raw)),p=(new n.Date).getTime(),!1)))}function g(e){let s=e,a=!0;if(!t.enabled)return;if(e.target.closest(`.${t.params.mousewheel.noMousewheelClass}`))return;const r=t.params.mousewheel;t.params.cssMode&&s.preventDefault();let n=t.el;"container"!==t.params.mousewheel.eventsTarget&&(n=document.querySelector(t.params.mousewheel.eventsTarget));const p=n&&n.contains(s.target);if(!t.mouseEntered&&!p&&!r.releaseOnEdges)return!0;s.originalEvent&&(s=s.originalEvent);let m=0;const h=t.rtlTranslate?-1:1,g=function(e){let t=0,s=0,a=0,i=0;return"detail"in e&&(s=e.detail),"wheelDelta"in e&&(s=-e.wheelDelta/120),"wheelDeltaY"in e&&(s=-e.wheelDeltaY/120),"wheelDeltaX"in e&&(t=-e.wheelDeltaX/120),"axis"in e&&e.axis===e.HORIZONTAL_AXIS&&(t=s,s=0),a=10*t,i=10*s,"deltaY"in e&&(i=e.deltaY),"deltaX"in e&&(a=e.deltaX),e.shiftKey&&!a&&(a=i,i=0),(a||i)&&e.deltaMode&&(1===e.deltaMode?(a*=40,i*=40):(a*=800,i*=800)),a&&!t&&(t=a<1?-1:1),i&&!s&&(s=i<1?-1:1),{spinX:t,spinY:s,pixelX:a,pixelY:i}}(s);if(r.forceToAxis)if(t.isHorizontal()){if(!(Math.abs(g.pixelX)>Math.abs(g.pixelY)))return!0;m=-g.pixelX*h}else{if(!(Math.abs(g.pixelY)>Math.abs(g.pixelX)))return!0;m=-g.pixelY}else m=Math.abs(g.pixelX)>Math.abs(g.pixelY)?-g.pixelX*h:-g.pixelY;if(0===m)return!0;r.invert&&(m=-m);let v=t.getTranslate()+m*r.sensitivity;if(v>=t.minTranslate()&&(v=t.minTranslate()),v<=t.maxTranslate()&&(v=t.maxTranslate()),a=!!t.params.loop||!(v===t.minTranslate()||v===t.maxTranslate()),a&&t.params.nested&&s.stopPropagation(),t.params.freeMode&&t.params.freeMode.enabled){const e={time:o(),delta:Math.abs(m),direction:Math.sign(m)},a=c&&e.time<c.time+500&&e.delta<=c.delta&&e.direction===c.direction;if(!a){c=void 0;let n=t.getTranslate()+m*r.sensitivity;const o=t.isBeginning,p=t.isEnd;if(n>=t.minTranslate()&&(n=t.minTranslate()),n<=t.maxTranslate()&&(n=t.maxTranslate()),t.setTransition(0),t.setTranslate(n),t.updateProgress(),t.updateActiveIndex(),t.updateSlidesClasses(),(!o&&t.isBeginning||!p&&t.isEnd)&&t.updateSlidesClasses(),t.params.loop&&t.loopFix({direction:e.direction<0?"next":"prev",byMousewheel:!0}),t.params.freeMode.sticky){clearTimeout(d),d=void 0,u.length>=15&&u.shift();const s=u.length?u[u.length-1]:void 0,a=u[0];if(u.push(e),s&&(e.delta>s.delta||e.direction!==s.direction))u.splice(0);else if(u.length>=15&&e.time-a.time<500&&a.delta-e.delta>=1&&e.delta<=6){const s=m>0?.8:.2;c=e,u.splice(0),d=l((()=>{!t.destroyed&&t.params&&t.slideToClosest(t.params.speed,!0,void 0,s)}),0)}d||(d=l((()=>{if(t.destroyed||!t.params)return;c=e,u.splice(0),t.slideToClosest(t.params.speed,!0,void 0,.5)}),500))}if(a||i("scroll",s),t.params.autoplay&&t.params.autoplay.disableOnInteraction&&t.autoplay.stop(),r.releaseOnEdges&&(n===t.minTranslate()||n===t.maxTranslate()))return!0}}else{const s={time:o(),delta:Math.abs(m),direction:Math.sign(m),raw:e};u.length>=2&&u.shift();const a=u.length?u[u.length-1]:void 0;if(u.push(s),a?(s.direction!==a.direction||s.delta>a.delta||s.time>a.time+150)&&f(s):f(s),function(e){const s=t.params.mousewheel;if(e.direction<0){if(t.isEnd&&!t.params.loop&&s.releaseOnEdges)return!0}else if(t.isBeginning&&!t.params.loop&&s.releaseOnEdges)return!0;return!1}(s))return!0}return s.preventDefault?s.preventDefault():s.returnValue=!1,!1}function v(e){let s=t.el;"container"!==t.params.mousewheel.eventsTarget&&(s=document.querySelector(t.params.mousewheel.eventsTarget)),s[e]("mouseenter",m),s[e]("mouseleave",h),s[e]("wheel",g)}function w(){return t.params.cssMode?(t.wrapperEl.removeEventListener("wheel",g),!0):!t.mousewheel.enabled&&(v("addEventListener"),t.mousewheel.enabled=!0,!0)}function b(){return t.params.cssMode?(t.wrapperEl.addEventListener(event,g),!0):!!t.mousewheel.enabled&&(v("removeEventListener"),t.mousewheel.enabled=!1,!0)}a("init",(()=>{!t.params.mousewheel.enabled&&t.params.cssMode&&b(),t.params.mousewheel.enabled&&w()})),a("destroy",(()=>{t.params.cssMode&&w(),t.mousewheel.enabled&&b()})),Object.assign(t.mousewheel,{enable:w,disable:b})},function(e){let{swiper:t,extendParams:s,on:a,emit:i}=e;function r(e){let s;return e&&"string"==typeof e&&t.isElement&&(s=t.el.querySelector(e)||t.hostEl.querySelector(e),s)?s:(e&&("string"==typeof e&&(s=[...document.querySelectorAll(e)]),t.params.uniqueNavElements&&"string"==typeof e&&s&&s.length>1&&1===t.el.querySelectorAll(e).length?s=t.el.querySelector(e):s&&1===s.length&&(s=s[0])),e&&!s?e:s)}function n(e,s){const a=t.params.navigation;(e=T(e)).forEach((e=>{e&&(e.classList[s?"add":"remove"](...a.disabledClass.split(" ")),"BUTTON"===e.tagName&&(e.disabled=s),t.params.watchOverflow&&t.enabled&&e.classList[t.isLocked?"add":"remove"](a.lockClass))}))}function l(){const{nextEl:e,prevEl:s}=t.navigation;if(t.params.loop)return n(s,!1),void n(e,!1);n(s,t.isBeginning&&!t.params.rewind),n(e,t.isEnd&&!t.params.rewind)}function o(e){e.preventDefault(),(!t.isBeginning||t.params.loop||t.params.rewind)&&(t.slidePrev(),i("navigationPrev"))}function d(e){e.preventDefault(),(!t.isEnd||t.params.loop||t.params.rewind)&&(t.slideNext(),i("navigationNext"))}function c(){const e=t.params.navigation;if(t.params.navigation=ne(t,t.originalParams.navigation,t.params.navigation,{nextEl:"swiper-button-next",prevEl:"swiper-button-prev"}),!e.nextEl&&!e.prevEl)return;let s=r(e.nextEl),a=r(e.prevEl);Object.assign(t.navigation,{nextEl:s,prevEl:a}),s=T(s),a=T(a);const i=(s,a)=>{s&&s.addEventListener("click","next"===a?d:o),!t.enabled&&s&&s.classList.add(...e.lockClass.split(" "))};s.forEach((e=>i(e,"next"))),a.forEach((e=>i(e,"prev")))}function p(){let{nextEl:e,prevEl:s}=t.navigation;e=T(e),s=T(s);const a=(e,s)=>{e.removeEventListener("click","next"===s?d:o),e.classList.remove(...t.params.navigation.disabledClass.split(" "))};e.forEach((e=>a(e,"next"))),s.forEach((e=>a(e,"prev")))}s({navigation:{nextEl:null,prevEl:null,hideOnClick:!1,disabledClass:"swiper-button-disabled",hiddenClass:"swiper-button-hidden",lockClass:"swiper-button-lock",navigationDisabledClass:"swiper-navigation-disabled"}}),t.navigation={nextEl:null,prevEl:null},a("init",(()=>{!1===t.params.navigation.enabled?u():(c(),l())})),a("toEdge fromEdge lock unlock",(()=>{l()})),a("destroy",(()=>{p()})),a("enable disable",(()=>{let{nextEl:e,prevEl:s}=t.navigation;e=T(e),s=T(s),t.enabled?l():[...e,...s].filter((e=>!!e)).forEach((e=>e.classList.add(t.params.navigation.lockClass)))})),a("click",((e,s)=>{let{nextEl:a,prevEl:r}=t.navigation;a=T(a),r=T(r);const n=s.target;let l=r.includes(n)||a.includes(n);if(t.isElement&&!l){const e=s.path||s.composedPath&&s.composedPath();e&&(l=e.find((e=>a.includes(e)||r.includes(e))))}if(t.params.navigation.hideOnClick&&!l){if(t.pagination&&t.params.pagination&&t.params.pagination.clickable&&(t.pagination.el===n||t.pagination.el.contains(n)))return;let e;a.length?e=a[0].classList.contains(t.params.navigation.hiddenClass):r.length&&(e=r[0].classList.contains(t.params.navigation.hiddenClass)),i(!0===e?"navigationShow":"navigationHide"),[...a,...r].filter((e=>!!e)).forEach((e=>e.classList.toggle(t.params.navigation.hiddenClass)))}}));const u=()=>{t.el.classList.add(...t.params.navigation.navigationDisabledClass.split(" ")),p()};Object.assign(t.navigation,{enable:()=>{t.el.classList.remove(...t.params.navigation.navigationDisabledClass.split(" ")),c(),l()},disable:u,update:l,init:c,destroy:p})},function(e){let{swiper:t,extendParams:s,on:a,emit:i}=e;const r="swiper-pagination";let n;s({pagination:{el:null,bulletElement:"span",clickable:!1,hideOnClick:!1,renderBullet:null,renderProgressbar:null,renderFraction:null,renderCustom:null,progressbarOpposite:!1,type:"bullets",dynamicBullets:!1,dynamicMainBullets:1,formatFractionCurrent:e=>e,formatFractionTotal:e=>e,bulletClass:`${r}-bullet`,bulletActiveClass:`${r}-bullet-active`,modifierClass:`${r}-`,currentClass:`${r}-current`,totalClass:`${r}-total`,hiddenClass:`${r}-hidden`,progressbarFillClass:`${r}-progressbar-fill`,progressbarOppositeClass:`${r}-progressbar-opposite`,clickableClass:`${r}-clickable`,lockClass:`${r}-lock`,horizontalClass:`${r}-horizontal`,verticalClass:`${r}-vertical`,paginationDisabledClass:`${r}-disabled`}}),t.pagination={el:null,bullets:[]};let l=0;function o(){return!t.params.pagination.el||!t.pagination.el||Array.isArray(t.pagination.el)&&0===t.pagination.el.length}function d(e,s){const{bulletActiveClass:a}=t.params.pagination;e&&(e=e[("prev"===s?"previous":"next")+"ElementSibling"])&&(e.classList.add(`${a}-${s}`),(e=e[("prev"===s?"previous":"next")+"ElementSibling"])&&e.classList.add(`${a}-${s}-${s}`))}function c(e){const s=e.target.closest(le(t.params.pagination.bulletClass));if(!s)return;e.preventDefault();const a=y(s)*t.params.slidesPerGroup;if(t.params.loop){if(t.realIndex===a)return;const e=(i=t.realIndex,r=a,n=t.slides.length,(r%=n)==1+(i%=n)?"next":r===i-1?"previous":void 0);"next"===e?t.slideNext():"previous"===e?t.slidePrev():t.slideToLoop(a)}else t.slideTo(a);var i,r,n}function p(){const e=t.rtl,s=t.params.pagination;if(o())return;let a,r,c=t.pagination.el;c=T(c);const p=t.virtual&&t.params.virtual.enabled?t.virtual.slides.length:t.slides.length,u=t.params.loop?Math.ceil(p/t.params.slidesPerGroup):t.snapGrid.length;if(t.params.loop?(r=t.previousRealIndex||0,a=t.params.slidesPerGroup>1?Math.floor(t.realIndex/t.params.slidesPerGroup):t.realIndex):void 0!==t.snapIndex?(a=t.snapIndex,r=t.previousSnapIndex):(r=t.previousIndex||0,a=t.activeIndex||0),"bullets"===s.type&&t.pagination.bullets&&t.pagination.bullets.length>0){const i=t.pagination.bullets;let o,p,u;if(s.dynamicBullets&&(n=S(i[0],t.isHorizontal()?"width":"height",!0),c.forEach((e=>{e.style[t.isHorizontal()?"width":"height"]=n*(s.dynamicMainBullets+4)+"px"})),s.dynamicMainBullets>1&&void 0!==r&&(l+=a-(r||0),l>s.dynamicMainBullets-1?l=s.dynamicMainBullets-1:l<0&&(l=0)),o=Math.max(a-l,0),p=o+(Math.min(i.length,s.dynamicMainBullets)-1),u=(p+o)/2),i.forEach((e=>{const t=[...["","-next","-next-next","-prev","-prev-prev","-main"].map((e=>`${s.bulletActiveClass}${e}`))].map((e=>"string"==typeof e&&e.includes(" ")?e.split(" "):e)).flat();e.classList.remove(...t)})),c.length>1)i.forEach((e=>{const i=y(e);i===a?e.classList.add(...s.bulletActiveClass.split(" ")):t.isElement&&e.setAttribute("part","bullet"),s.dynamicBullets&&(i>=o&&i<=p&&e.classList.add(...`${s.bulletActiveClass}-main`.split(" ")),i===o&&d(e,"prev"),i===p&&d(e,"next"))}));else{const e=i[a];if(e&&e.classList.add(...s.bulletActiveClass.split(" ")),t.isElement&&i.forEach(((e,t)=>{e.setAttribute("part",t===a?"bullet-active":"bullet")})),s.dynamicBullets){const e=i[o],t=i[p];for(let e=o;e<=p;e+=1)i[e]&&i[e].classList.add(...`${s.bulletActiveClass}-main`.split(" "));d(e,"prev"),d(t,"next")}}if(s.dynamicBullets){const a=Math.min(i.length,s.dynamicMainBullets+4),r=(n*a-n)/2-u*n,l=e?"right":"left";i.forEach((e=>{e.style[t.isHorizontal()?l:"top"]=`${r}px`}))}}c.forEach(((e,r)=>{if("fraction"===s.type&&(e.querySelectorAll(le(s.currentClass)).forEach((e=>{e.textContent=s.formatFractionCurrent(a+1)})),e.querySelectorAll(le(s.totalClass)).forEach((e=>{e.textContent=s.formatFractionTotal(u)}))),"progressbar"===s.type){let i;i=s.progressbarOpposite?t.isHorizontal()?"vertical":"horizontal":t.isHorizontal()?"horizontal":"vertical";const r=(a+1)/u;let n=1,l=1;"horizontal"===i?n=r:l=r,e.querySelectorAll(le(s.progressbarFillClass)).forEach((e=>{e.style.transform=`translate3d(0,0,0) scaleX(${n}) scaleY(${l})`,e.style.transitionDuration=`${t.params.speed}ms`}))}"custom"===s.type&&s.renderCustom?(C(e,s.renderCustom(t,a+1,u)),0===r&&i("paginationRender",e)):(0===r&&i("paginationRender",e),i("paginationUpdate",e)),t.params.watchOverflow&&t.enabled&&e.classList[t.isLocked?"add":"remove"](s.lockClass)}))}function u(){const e=t.params.pagination;if(o())return;const s=t.virtual&&t.params.virtual.enabled?t.virtual.slides.length:t.grid&&t.params.grid.rows>1?t.slides.length/Math.ceil(t.params.grid.rows):t.slides.length;let a=t.pagination.el;a=T(a);let r="";if("bullets"===e.type){let a=t.params.loop?Math.ceil(s/t.params.slidesPerGroup):t.snapGrid.length;t.params.freeMode&&t.params.freeMode.enabled&&a>s&&(a=s);for(let s=0;s<a;s+=1)e.renderBullet?r+=e.renderBullet.call(t,s,e.bulletClass):r+=`<${e.bulletElement} ${t.isElement?'part="bullet"':""} class="${e.bulletClass}"></${e.bulletElement}>`}"fraction"===e.type&&(r=e.renderFraction?e.renderFraction.call(t,e.currentClass,e.totalClass):`<span class="${e.currentClass}"></span> / <span class="${e.totalClass}"></span>`),"progressbar"===e.type&&(r=e.renderProgressbar?e.renderProgressbar.call(t,e.progressbarFillClass):`<span class="${e.progressbarFillClass}"></span>`),t.pagination.bullets=[],a.forEach((s=>{"custom"!==e.type&&C(s,r||""),"bullets"===e.type&&t.pagination.bullets.push(...s.querySelectorAll(le(e.bulletClass)))})),"custom"!==e.type&&i("paginationRender",a[0])}function m(){t.params.pagination=ne(t,t.originalParams.pagination,t.params.pagination,{el:"swiper-pagination"});const e=t.params.pagination;if(!e.el)return;let s;"string"==typeof e.el&&t.isElement&&(s=t.el.querySelector(e.el)),s||"string"!=typeof e.el||(s=[...document.querySelectorAll(e.el)]),s||(s=e.el),s&&0!==s.length&&(t.params.uniqueNavElements&&"string"==typeof e.el&&Array.isArray(s)&&s.length>1&&(s=[...t.el.querySelectorAll(e.el)],s.length>1&&(s=s.find((e=>E(e,".swiper")[0]===t.el)))),Array.isArray(s)&&1===s.length&&(s=s[0]),Object.assign(t.pagination,{el:s}),s=T(s),s.forEach((s=>{"bullets"===e.type&&e.clickable&&s.classList.add(...(e.clickableClass||"").split(" ")),s.classList.add(e.modifierClass+e.type),s.classList.add(t.isHorizontal()?e.horizontalClass:e.verticalClass),"bullets"===e.type&&e.dynamicBullets&&(s.classList.add(`${e.modifierClass}${e.type}-dynamic`),l=0,e.dynamicMainBullets<1&&(e.dynamicMainBullets=1)),"progressbar"===e.type&&e.progressbarOpposite&&s.classList.add(e.progressbarOppositeClass),e.clickable&&s.addEventListener("click",c),t.enabled||s.classList.add(e.lockClass)})))}function h(){const e=t.params.pagination;if(o())return;let s=t.pagination.el;s&&(s=T(s),s.forEach((s=>{s.classList.remove(e.hiddenClass),s.classList.remove(e.modifierClass+e.type),s.classList.remove(t.isHorizontal()?e.horizontalClass:e.verticalClass),e.clickable&&(s.classList.remove(...(e.clickableClass||"").split(" ")),s.removeEventListener("click",c))}))),t.pagination.bullets&&t.pagination.bullets.forEach((t=>t.classList.remove(...e.bulletActiveClass.split(" "))))}a("changeDirection",(()=>{if(!t.pagination||!t.pagination.el)return;const e=t.params.pagination;let{el:s}=t.pagination;s=T(s),s.forEach((s=>{s.classList.remove(e.horizontalClass,e.verticalClass),s.classList.add(t.isHorizontal()?e.horizontalClass:e.verticalClass)}))})),a("init",(()=>{!1===t.params.pagination.enabled?f():(m(),u(),p())})),a("activeIndexChange",(()=>{void 0===t.snapIndex&&p()})),a("snapIndexChange",(()=>{p()})),a("snapGridLengthChange",(()=>{u(),p()})),a("destroy",(()=>{h()})),a("enable disable",(()=>{let{el:e}=t.pagination;e&&(e=T(e),e.forEach((e=>e.classList[t.enabled?"remove":"add"](t.params.pagination.lockClass))))})),a("lock unlock",(()=>{p()})),a("click",((e,s)=>{const a=s.target,r=T(t.pagination.el);if(t.params.pagination.el&&t.params.pagination.hideOnClick&&r&&r.length>0&&!a.classList.contains(t.params.pagination.bulletClass)){if(t.navigation&&(t.navigation.nextEl&&a===t.navigation.nextEl||t.navigation.prevEl&&a===t.navigation.prevEl))return;const e=r[0].classList.contains(t.params.pagination.hiddenClass);i(!0===e?"paginationShow":"paginationHide"),r.forEach((e=>e.classList.toggle(t.params.pagination.hiddenClass)))}}));const f=()=>{t.el.classList.add(t.params.pagination.paginationDisabledClass);let{el:e}=t.pagination;e&&(e=T(e),e.forEach((e=>e.classList.add(t.params.pagination.paginationDisabledClass)))),h()};Object.assign(t.pagination,{enable:()=>{t.el.classList.remove(t.params.pagination.paginationDisabledClass);let{el:e}=t.pagination;e&&(e=T(e),e.forEach((e=>e.classList.remove(t.params.pagination.paginationDisabledClass)))),m(),u(),p()},disable:f,render:u,update:p,init:m,destroy:h})},function(e){let{swiper:t,extendParams:s,on:i,emit:r}=e;const o=a();let d,c,p,u,m=!1,h=null,f=null;function g(){if(!t.params.scrollbar.el||!t.scrollbar.el)return;const{scrollbar:e,rtlTranslate:s}=t,{dragEl:a,el:i}=e,r=t.params.scrollbar,n=t.params.loop?t.progressLoop:t.progress;let l=c,o=(p-c)*n;s?(o=-o,o>0?(l=c-o,o=0):-o+c>p&&(l=p+o)):o<0?(l=c+o,o=0):o+c>p&&(l=p-o),t.isHorizontal()?(a.style.transform=`translate3d(${o}px, 0, 0)`,a.style.width=`${l}px`):(a.style.transform=`translate3d(0px, ${o}px, 0)`,a.style.height=`${l}px`),r.hide&&(clearTimeout(h),i.style.opacity=1,h=setTimeout((()=>{i.style.opacity=0,i.style.transitionDuration="400ms"}),1e3))}function b(){if(!t.params.scrollbar.el||!t.scrollbar.el)return;const{scrollbar:e}=t,{dragEl:s,el:a}=e;s.style.width="",s.style.height="",p=t.isHorizontal()?a.offsetWidth:a.offsetHeight,u=t.size/(t.virtualSize+t.params.slidesOffsetBefore-(t.params.centeredSlides?t.snapGrid[0]:0)),c="auto"===t.params.scrollbar.dragSize?p*u:parseInt(t.params.scrollbar.dragSize,10),t.isHorizontal()?s.style.width=`${c}px`:s.style.height=`${c}px`,a.style.display=u>=1?"none":"",t.params.scrollbar.hide&&(a.style.opacity=0),t.params.watchOverflow&&t.enabled&&e.el.classList[t.isLocked?"add":"remove"](t.params.scrollbar.lockClass)}function y(e){return t.isHorizontal()?e.clientX:e.clientY}function E(e){const{scrollbar:s,rtlTranslate:a}=t,{el:i}=s;let r;r=(y(e)-w(i)[t.isHorizontal()?"left":"top"]-(null!==d?d:c/2))/(p-c),r=Math.max(Math.min(r,1),0),a&&(r=1-r);const n=t.minTranslate()+(t.maxTranslate()-t.minTranslate())*r;t.updateProgress(n),t.setTranslate(n),t.updateActiveIndex(),t.updateSlidesClasses()}function x(e){const s=t.params.scrollbar,{scrollbar:a,wrapperEl:i}=t,{el:n,dragEl:l}=a;m=!0,d=e.target===l?y(e)-e.target.getBoundingClientRect()[t.isHorizontal()?"left":"top"]:null,e.preventDefault(),e.stopPropagation(),i.style.transitionDuration="100ms",l.style.transitionDuration="100ms",E(e),clearTimeout(f),n.style.transitionDuration="0ms",s.hide&&(n.style.opacity=1),t.params.cssMode&&(t.wrapperEl.style["scroll-snap-type"]="none"),r("scrollbarDragStart",e)}function S(e){const{scrollbar:s,wrapperEl:a}=t,{el:i,dragEl:n}=s;m&&(e.preventDefault&&e.cancelable?e.preventDefault():e.returnValue=!1,E(e),a.style.transitionDuration="0ms",i.style.transitionDuration="0ms",n.style.transitionDuration="0ms",r("scrollbarDragMove",e))}function M(e){const s=t.params.scrollbar,{scrollbar:a,wrapperEl:i}=t,{el:n}=a;m&&(m=!1,t.params.cssMode&&(t.wrapperEl.style["scroll-snap-type"]="",i.style.transitionDuration=""),s.hide&&(clearTimeout(f),f=l((()=>{n.style.opacity=0,n.style.transitionDuration="400ms"}),1e3)),r("scrollbarDragEnd",e),s.snapOnRelease&&t.slideToClosest())}function C(e){const{scrollbar:s,params:a}=t,i=s.el;if(!i)return;const r=i,n=!!a.passiveListeners&&{passive:!1,capture:!1},l=!!a.passiveListeners&&{passive:!0,capture:!1};if(!r)return;const d="on"===e?"addEventListener":"removeEventListener";r[d]("pointerdown",x,n),o[d]("pointermove",S,n),o[d]("pointerup",M,l)}function P(){const{scrollbar:e,el:s}=t;t.params.scrollbar=ne(t,t.originalParams.scrollbar,t.params.scrollbar,{el:"swiper-scrollbar"});const a=t.params.scrollbar;if(!a.el)return;let i,r;if("string"==typeof a.el&&t.isElement&&(i=t.el.querySelector(a.el)),i||"string"!=typeof a.el)i||(i=a.el);else if(i=o.querySelectorAll(a.el),!i.length)return;t.params.uniqueNavElements&&"string"==typeof a.el&&i.length>1&&1===s.querySelectorAll(a.el).length&&(i=s.querySelector(a.el)),i.length>0&&(i=i[0]),i.classList.add(t.isHorizontal()?a.horizontalClass:a.verticalClass),i&&(r=i.querySelector(le(t.params.scrollbar.dragClass)),r||(r=v("div",t.params.scrollbar.dragClass),i.append(r))),Object.assign(e,{el:i,dragEl:r}),a.draggable&&t.params.scrollbar.el&&t.scrollbar.el&&C("on"),i&&i.classList[t.enabled?"remove":"add"](...n(t.params.scrollbar.lockClass))}function L(){const e=t.params.scrollbar,s=t.scrollbar.el;s&&s.classList.remove(...n(t.isHorizontal()?e.horizontalClass:e.verticalClass)),t.params.scrollbar.el&&t.scrollbar.el&&C("off")}s({scrollbar:{el:null,dragSize:"auto",hide:!1,draggable:!1,snapOnRelease:!0,lockClass:"swiper-scrollbar-lock",dragClass:"swiper-scrollbar-drag",scrollbarDisabledClass:"swiper-scrollbar-disabled",horizontalClass:"swiper-scrollbar-horizontal",verticalClass:"swiper-scrollbar-vertical"}}),t.scrollbar={el:null,dragEl:null},i("changeDirection",(()=>{if(!t.scrollbar||!t.scrollbar.el)return;const e=t.params.scrollbar;let{el:s}=t.scrollbar;s=T(s),s.forEach((s=>{s.classList.remove(e.horizontalClass,e.verticalClass),s.classList.add(t.isHorizontal()?e.horizontalClass:e.verticalClass)}))})),i("init",(()=>{!1===t.params.scrollbar.enabled?I():(P(),b(),g())})),i("update resize observerUpdate lock unlock changeDirection",(()=>{b()})),i("setTranslate",(()=>{g()})),i("setTransition",((e,s)=>{!function(e){t.params.scrollbar.el&&t.scrollbar.el&&(t.scrollbar.dragEl.style.transitionDuration=`${e}ms`)}(s)})),i("enable disable",(()=>{const{el:e}=t.scrollbar;e&&e.classList[t.enabled?"remove":"add"](...n(t.params.scrollbar.lockClass))})),i("destroy",(()=>{L()}));const I=()=>{t.el.classList.add(...n(t.params.scrollbar.scrollbarDisabledClass)),t.scrollbar.el&&t.scrollbar.el.classList.add(...n(t.params.scrollbar.scrollbarDisabledClass)),L()};Object.assign(t.scrollbar,{enable:()=>{t.el.classList.remove(...n(t.params.scrollbar.scrollbarDisabledClass)),t.scrollbar.el&&t.scrollbar.el.classList.remove(...n(t.params.scrollbar.scrollbarDisabledClass)),P(),b(),g()},disable:I,updateSize:b,setTranslate:g,init:P,destroy:L})},function(e){let{swiper:t,extendParams:s,on:a}=e;s({parallax:{enabled:!1}});const i="[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y], [data-swiper-parallax-opacity], [data-swiper-parallax-scale]",r=(e,s)=>{const{rtl:a}=t,i=a?-1:1,r=e.getAttribute("data-swiper-parallax")||"0";let n=e.getAttribute("data-swiper-parallax-x"),l=e.getAttribute("data-swiper-parallax-y");const o=e.getAttribute("data-swiper-parallax-scale"),d=e.getAttribute("data-swiper-parallax-opacity"),c=e.getAttribute("data-swiper-parallax-rotate");if(n||l?(n=n||"0",l=l||"0"):t.isHorizontal()?(n=r,l="0"):(l=r,n="0"),n=n.indexOf("%")>=0?parseInt(n,10)*s*i+"%":n*s*i+"px",l=l.indexOf("%")>=0?parseInt(l,10)*s+"%":l*s+"px",null!=d){const t=d-(d-1)*(1-Math.abs(s));e.style.opacity=t}let p=`translate3d(${n}, ${l}, 0px)`;if(null!=o){p+=` scale(${o-(o-1)*(1-Math.abs(s))})`}if(c&&null!=c){p+=` rotate(${c*s*-1}deg)`}e.style.transform=p},n=()=>{const{el:e,slides:s,progress:a,snapGrid:n,isElement:l}=t,o=f(e,i);t.isElement&&o.push(...f(t.hostEl,i)),o.forEach((e=>{r(e,a)})),s.forEach(((e,s)=>{let l=e.progress;t.params.slidesPerGroup>1&&"auto"!==t.params.slidesPerView&&(l+=Math.ceil(s/2)-a*(n.length-1)),l=Math.min(Math.max(l,-1),1),e.querySelectorAll(`${i}, [data-swiper-parallax-rotate]`).forEach((e=>{r(e,l)}))}))};a("beforeInit",(()=>{t.params.parallax.enabled&&(t.params.watchSlidesProgress=!0,t.originalParams.watchSlidesProgress=!0)})),a("init",(()=>{t.params.parallax.enabled&&n()})),a("setTranslate",(()=>{t.params.parallax.enabled&&n()})),a("setTransition",((e,s)=>{t.params.parallax.enabled&&function(e){void 0===e&&(e=t.params.speed);const{el:s,hostEl:a}=t,r=[...s.querySelectorAll(i)];t.isElement&&r.push(...a.querySelectorAll(i)),r.forEach((t=>{let s=parseInt(t.getAttribute("data-swiper-parallax-duration"),10)||e;0===e&&(s=0),t.style.transitionDuration=`${s}ms`}))}(s)}))},function(e){let{swiper:t,extendParams:s,on:a,emit:i}=e;const n=r();s({zoom:{enabled:!1,limitToOriginalSize:!1,maxRatio:3,minRatio:1,panOnMouseMove:!1,toggle:!0,containerClass:"swiper-zoom-container",zoomedSlideClass:"swiper-slide-zoomed"}}),t.zoom={enabled:!1};let l=1,o=!1,c=!1,p={x:0,y:0};const u=-3;let m,h;const g=[],v={originX:0,originY:0,slideEl:void 0,slideWidth:void 0,slideHeight:void 0,imageEl:void 0,imageWrapEl:void 0,maxRatio:3},b={isTouched:void 0,isMoved:void 0,currentX:void 0,currentY:void 0,minX:void 0,minY:void 0,maxX:void 0,maxY:void 0,width:void 0,height:void 0,startX:void 0,startY:void 0,touchesStart:{},touchesCurrent:{}},y={x:void 0,y:void 0,prevPositionX:void 0,prevPositionY:void 0,prevTime:void 0};let x,S=1;function T(){if(g.length<2)return 1;const e=g[0].pageX,t=g[0].pageY,s=g[1].pageX,a=g[1].pageY;return Math.sqrt((s-e)**2+(a-t)**2)}function M(){const e=t.params.zoom,s=v.imageWrapEl.getAttribute("data-swiper-zoom")||e.maxRatio;if(e.limitToOriginalSize&&v.imageEl&&v.imageEl.naturalWidth){const e=v.imageEl.naturalWidth/v.imageEl.offsetWidth;return Math.min(e,s)}return s}function C(e){const s=t.isElement?"swiper-slide":`.${t.params.slideClass}`;return!!e.target.matches(s)||t.slides.filter((t=>t.contains(e.target))).length>0}function P(e){const s=`.${t.params.zoom.containerClass}`;return!!e.target.matches(s)||[...t.hostEl.querySelectorAll(s)].filter((t=>t.contains(e.target))).length>0}function L(e){if("mouse"===e.pointerType&&g.splice(0,g.length),!C(e))return;const s=t.params.zoom;if(m=!1,h=!1,g.push(e),!(g.length<2)){if(m=!0,v.scaleStart=T(),!v.slideEl){v.slideEl=e.target.closest(`.${t.params.slideClass}, swiper-slide`),v.slideEl||(v.slideEl=t.slides[t.activeIndex]);let a=v.slideEl.querySelector(`.${s.containerClass}`);if(a&&(a=a.querySelectorAll("picture, img, svg, canvas, .swiper-zoom-target")[0]),v.imageEl=a,v.imageWrapEl=a?E(v.imageEl,`.${s.containerClass}`)[0]:void 0,!v.imageWrapEl)return void(v.imageEl=void 0);v.maxRatio=M()}if(v.imageEl){const[e,t]=function(){if(g.length<2)return{x:null,y:null};const e=v.imageEl.getBoundingClientRect();return[(g[0].pageX+(g[1].pageX-g[0].pageX)/2-e.x-n.scrollX)/l,(g[0].pageY+(g[1].pageY-g[0].pageY)/2-e.y-n.scrollY)/l]}();v.originX=e,v.originY=t,v.imageEl.style.transitionDuration="0ms"}o=!0}}function I(e){if(!C(e))return;const s=t.params.zoom,a=t.zoom,i=g.findIndex((t=>t.pointerId===e.pointerId));i>=0&&(g[i]=e),g.length<2||(h=!0,v.scaleMove=T(),v.imageEl&&(a.scale=v.scaleMove/v.scaleStart*l,a.scale>v.maxRatio&&(a.scale=v.maxRatio-1+(a.scale-v.maxRatio+1)**.5),a.scale<s.minRatio&&(a.scale=s.minRatio+1-(s.minRatio-a.scale+1)**.5),v.imageEl.style.transform=`translate3d(0,0,0) scale(${a.scale})`))}function z(e){if(!C(e))return;if("mouse"===e.pointerType&&"pointerout"===e.type)return;const s=t.params.zoom,a=t.zoom,i=g.findIndex((t=>t.pointerId===e.pointerId));i>=0&&g.splice(i,1),m&&h&&(m=!1,h=!1,v.imageEl&&(a.scale=Math.max(Math.min(a.scale,v.maxRatio),s.minRatio),v.imageEl.style.transitionDuration=`${t.params.speed}ms`,v.imageEl.style.transform=`translate3d(0,0,0) scale(${a.scale})`,l=a.scale,o=!1,a.scale>1&&v.slideEl?v.slideEl.classList.add(`${s.zoomedSlideClass}`):a.scale<=1&&v.slideEl&&v.slideEl.classList.remove(`${s.zoomedSlideClass}`),1===a.scale&&(v.originX=0,v.originY=0,v.slideEl=void 0)))}function A(){t.touchEventsData.preventTouchMoveFromPointerMove=!1}function $(e){const s="mouse"===e.pointerType&&t.params.zoom.panOnMouseMove;if(!C(e)||!P(e))return;const a=t.zoom;if(!v.imageEl)return;if(!b.isTouched||!v.slideEl)return void(s&&O(e));if(s)return void O(e);b.isMoved||(b.width=v.imageEl.offsetWidth||v.imageEl.clientWidth,b.height=v.imageEl.offsetHeight||v.imageEl.clientHeight,b.startX=d(v.imageWrapEl,"x")||0,b.startY=d(v.imageWrapEl,"y")||0,v.slideWidth=v.slideEl.offsetWidth,v.slideHeight=v.slideEl.offsetHeight,v.imageWrapEl.style.transitionDuration="0ms");const i=b.width*a.scale,r=b.height*a.scale;b.minX=Math.min(v.slideWidth/2-i/2,0),b.maxX=-b.minX,b.minY=Math.min(v.slideHeight/2-r/2,0),b.maxY=-b.minY,b.touchesCurrent.x=g.length>0?g[0].pageX:e.pageX,b.touchesCurrent.y=g.length>0?g[0].pageY:e.pageY;if(Math.max(Math.abs(b.touchesCurrent.x-b.touchesStart.x),Math.abs(b.touchesCurrent.y-b.touchesStart.y))>5&&(t.allowClick=!1),!b.isMoved&&!o){if(t.isHorizontal()&&(Math.floor(b.minX)===Math.floor(b.startX)&&b.touchesCurrent.x<b.touchesStart.x||Math.floor(b.maxX)===Math.floor(b.startX)&&b.touchesCurrent.x>b.touchesStart.x))return b.isTouched=!1,void A();if(!t.isHorizontal()&&(Math.floor(b.minY)===Math.floor(b.startY)&&b.touchesCurrent.y<b.touchesStart.y||Math.floor(b.maxY)===Math.floor(b.startY)&&b.touchesCurrent.y>b.touchesStart.y))return b.isTouched=!1,void A()}e.cancelable&&e.preventDefault(),e.stopPropagation(),clearTimeout(x),t.touchEventsData.preventTouchMoveFromPointerMove=!0,x=setTimeout((()=>{t.destroyed||A()})),b.isMoved=!0;const n=(a.scale-l)/(v.maxRatio-t.params.zoom.minRatio),{originX:c,originY:p}=v;b.currentX=b.touchesCurrent.x-b.touchesStart.x+b.startX+n*(b.width-2*c),b.currentY=b.touchesCurrent.y-b.touchesStart.y+b.startY+n*(b.height-2*p),b.currentX<b.minX&&(b.currentX=b.minX+1-(b.minX-b.currentX+1)**.8),b.currentX>b.maxX&&(b.currentX=b.maxX-1+(b.currentX-b.maxX+1)**.8),b.currentY<b.minY&&(b.currentY=b.minY+1-(b.minY-b.currentY+1)**.8),b.currentY>b.maxY&&(b.currentY=b.maxY-1+(b.currentY-b.maxY+1)**.8),y.prevPositionX||(y.prevPositionX=b.touchesCurrent.x),y.prevPositionY||(y.prevPositionY=b.touchesCurrent.y),y.prevTime||(y.prevTime=Date.now()),y.x=(b.touchesCurrent.x-y.prevPositionX)/(Date.now()-y.prevTime)/2,y.y=(b.touchesCurrent.y-y.prevPositionY)/(Date.now()-y.prevTime)/2,Math.abs(b.touchesCurrent.x-y.prevPositionX)<2&&(y.x=0),Math.abs(b.touchesCurrent.y-y.prevPositionY)<2&&(y.y=0),y.prevPositionX=b.touchesCurrent.x,y.prevPositionY=b.touchesCurrent.y,y.prevTime=Date.now(),v.imageWrapEl.style.transform=`translate3d(${b.currentX}px, ${b.currentY}px,0)`}function k(){const e=t.zoom;v.slideEl&&t.activeIndex!==t.slides.indexOf(v.slideEl)&&(v.imageEl&&(v.imageEl.style.transform="translate3d(0,0,0) scale(1)"),v.imageWrapEl&&(v.imageWrapEl.style.transform="translate3d(0,0,0)"),v.slideEl.classList.remove(`${t.params.zoom.zoomedSlideClass}`),e.scale=1,l=1,v.slideEl=void 0,v.imageEl=void 0,v.imageWrapEl=void 0,v.originX=0,v.originY=0)}function O(e){if(l<=1||!v.imageWrapEl)return;if(!C(e)||!P(e))return;const t=n.getComputedStyle(v.imageWrapEl).transform,s=new n.DOMMatrix(t);if(!c)return c=!0,p.x=e.clientX,p.y=e.clientY,b.startX=s.e,b.startY=s.f,b.width=v.imageEl.offsetWidth||v.imageEl.clientWidth,b.height=v.imageEl.offsetHeight||v.imageEl.clientHeight,v.slideWidth=v.slideEl.offsetWidth,void(v.slideHeight=v.slideEl.offsetHeight);const a=(e.clientX-p.x)*u,i=(e.clientY-p.y)*u,r=b.width*l,o=b.height*l,d=v.slideWidth,m=v.slideHeight,h=Math.min(d/2-r/2,0),f=-h,g=Math.min(m/2-o/2,0),w=-g,y=Math.max(Math.min(b.startX+a,f),h),E=Math.max(Math.min(b.startY+i,w),g);v.imageWrapEl.style.transitionDuration="0ms",v.imageWrapEl.style.transform=`translate3d(${y}px, ${E}px, 0)`,p.x=e.clientX,p.y=e.clientY,b.startX=y,b.startY=E,b.currentX=y,b.currentY=E}function D(e){const s=t.zoom,a=t.params.zoom;if(!v.slideEl){e&&e.target&&(v.slideEl=e.target.closest(`.${t.params.slideClass}, swiper-slide`)),v.slideEl||(t.params.virtual&&t.params.virtual.enabled&&t.virtual?v.slideEl=f(t.slidesEl,`.${t.params.slideActiveClass}`)[0]:v.slideEl=t.slides[t.activeIndex]);let s=v.slideEl.querySelector(`.${a.containerClass}`);s&&(s=s.querySelectorAll("picture, img, svg, canvas, .swiper-zoom-target")[0]),v.imageEl=s,v.imageWrapEl=s?E(v.imageEl,`.${a.containerClass}`)[0]:void 0}if(!v.imageEl||!v.imageWrapEl)return;let i,r,o,d,c,p,u,m,h,g,y,x,S,T,C,P,L,I;t.params.cssMode&&(t.wrapperEl.style.overflow="hidden",t.wrapperEl.style.touchAction="none"),v.slideEl.classList.add(`${a.zoomedSlideClass}`),void 0===b.touchesStart.x&&e?(i=e.pageX,r=e.pageY):(i=b.touchesStart.x,r=b.touchesStart.y);const z=l,A="number"==typeof e?e:null;1===l&&A&&(i=void 0,r=void 0,b.touchesStart.x=void 0,b.touchesStart.y=void 0);const $=M();s.scale=A||$,l=A||$,!e||1===l&&A?(u=0,m=0):(L=v.slideEl.offsetWidth,I=v.slideEl.offsetHeight,o=w(v.slideEl).left+n.scrollX,d=w(v.slideEl).top+n.scrollY,c=o+L/2-i,p=d+I/2-r,h=v.imageEl.offsetWidth||v.imageEl.clientWidth,g=v.imageEl.offsetHeight||v.imageEl.clientHeight,y=h*s.scale,x=g*s.scale,S=Math.min(L/2-y/2,0),T=Math.min(I/2-x/2,0),C=-S,P=-T,z>0&&A&&"number"==typeof b.currentX&&"number"==typeof b.currentY?(u=b.currentX*s.scale/z,m=b.currentY*s.scale/z):(u=c*s.scale,m=p*s.scale),u<S&&(u=S),u>C&&(u=C),m<T&&(m=T),m>P&&(m=P)),A&&1===s.scale&&(v.originX=0,v.originY=0),b.currentX=u,b.currentY=m,v.imageWrapEl.style.transitionDuration="300ms",v.imageWrapEl.style.transform=`translate3d(${u}px, ${m}px,0)`,v.imageEl.style.transitionDuration="300ms",v.imageEl.style.transform=`translate3d(0,0,0) scale(${s.scale})`}function G(){const e=t.zoom,s=t.params.zoom;if(!v.slideEl){t.params.virtual&&t.params.virtual.enabled&&t.virtual?v.slideEl=f(t.slidesEl,`.${t.params.slideActiveClass}`)[0]:v.slideEl=t.slides[t.activeIndex];let e=v.slideEl.querySelector(`.${s.containerClass}`);e&&(e=e.querySelectorAll("picture, img, svg, canvas, .swiper-zoom-target")[0]),v.imageEl=e,v.imageWrapEl=e?E(v.imageEl,`.${s.containerClass}`)[0]:void 0}v.imageEl&&v.imageWrapEl&&(t.params.cssMode&&(t.wrapperEl.style.overflow="",t.wrapperEl.style.touchAction=""),e.scale=1,l=1,b.currentX=void 0,b.currentY=void 0,b.touchesStart.x=void 0,b.touchesStart.y=void 0,v.imageWrapEl.style.transitionDuration="300ms",v.imageWrapEl.style.transform="translate3d(0,0,0)",v.imageEl.style.transitionDuration="300ms",v.imageEl.style.transform="translate3d(0,0,0) scale(1)",v.slideEl.classList.remove(`${s.zoomedSlideClass}`),v.slideEl=void 0,v.originX=0,v.originY=0,t.params.zoom.panOnMouseMove&&(p={x:0,y:0},c&&(c=!1,b.startX=0,b.startY=0)))}function X(e){const s=t.zoom;s.scale&&1!==s.scale?G():D(e)}function Y(){return{passiveListener:!!t.params.passiveListeners&&{passive:!0,capture:!1},activeListenerWithCapture:!t.params.passiveListeners||{passive:!1,capture:!0}}}function B(){const e=t.zoom;if(e.enabled)return;e.enabled=!0;const{passiveListener:s,activeListenerWithCapture:a}=Y();t.wrapperEl.addEventListener("pointerdown",L,s),t.wrapperEl.addEventListener("pointermove",I,a),["pointerup","pointercancel","pointerout"].forEach((e=>{t.wrapperEl.addEventListener(e,z,s)})),t.wrapperEl.addEventListener("pointermove",$,a)}function H(){const e=t.zoom;if(!e.enabled)return;e.enabled=!1;const{passiveListener:s,activeListenerWithCapture:a}=Y();t.wrapperEl.removeEventListener("pointerdown",L,s),t.wrapperEl.removeEventListener("pointermove",I,a),["pointerup","pointercancel","pointerout"].forEach((e=>{t.wrapperEl.removeEventListener(e,z,s)})),t.wrapperEl.removeEventListener("pointermove",$,a)}Object.defineProperty(t.zoom,"scale",{get:()=>S,set(e){if(S!==e){const t=v.imageEl,s=v.slideEl;i("zoomChange",e,t,s)}S=e}}),a("init",(()=>{t.params.zoom.enabled&&B()})),a("destroy",(()=>{H()})),a("touchStart",((e,s)=>{t.zoom.enabled&&function(e){const s=t.device;if(!v.imageEl)return;if(b.isTouched)return;s.android&&e.cancelable&&e.preventDefault(),b.isTouched=!0;const a=g.length>0?g[0]:e;b.touchesStart.x=a.pageX,b.touchesStart.y=a.pageY}(s)})),a("touchEnd",((e,s)=>{t.zoom.enabled&&function(){const e=t.zoom;if(g.length=0,!v.imageEl)return;if(!b.isTouched||!b.isMoved)return b.isTouched=!1,void(b.isMoved=!1);b.isTouched=!1,b.isMoved=!1;let s=300,a=300;const i=y.x*s,r=b.currentX+i,n=y.y*a,l=b.currentY+n;0!==y.x&&(s=Math.abs((r-b.currentX)/y.x)),0!==y.y&&(a=Math.abs((l-b.currentY)/y.y));const o=Math.max(s,a);b.currentX=r,b.currentY=l;const d=b.width*e.scale,c=b.height*e.scale;b.minX=Math.min(v.slideWidth/2-d/2,0),b.maxX=-b.minX,b.minY=Math.min(v.slideHeight/2-c/2,0),b.maxY=-b.minY,b.currentX=Math.max(Math.min(b.currentX,b.maxX),b.minX),b.currentY=Math.max(Math.min(b.currentY,b.maxY),b.minY),v.imageWrapEl.style.transitionDuration=`${o}ms`,v.imageWrapEl.style.transform=`translate3d(${b.currentX}px, ${b.currentY}px,0)`}()})),a("doubleTap",((e,s)=>{!t.animating&&t.params.zoom.enabled&&t.zoom.enabled&&t.params.zoom.toggle&&X(s)})),a("transitionEnd",(()=>{t.zoom.enabled&&t.params.zoom.enabled&&k()})),a("slideChange",(()=>{t.zoom.enabled&&t.params.zoom.enabled&&t.params.cssMode&&k()})),Object.assign(t.zoom,{enable:B,disable:H,in:D,out:G,toggle:X})},function(e){let{swiper:t,extendParams:s,on:a}=e;function i(e,t){const s=function(){let e,t,s;return(a,i)=>{for(t=-1,e=a.length;e-t>1;)s=e+t>>1,a[s]<=i?t=s:e=s;return e}}();let a,i;return this.x=e,this.y=t,this.lastIndex=e.length-1,this.interpolate=function(e){return e?(i=s(this.x,e),a=i-1,(e-this.x[a])*(this.y[i]-this.y[a])/(this.x[i]-this.x[a])+this.y[a]):0},this}function r(){t.controller.control&&t.controller.spline&&(t.controller.spline=void 0,delete t.controller.spline)}s({controller:{control:void 0,inverse:!1,by:"slide"}}),t.controller={control:void 0},a("beforeInit",(()=>{if("undefined"!=typeof window&&("string"==typeof t.params.controller.control||t.params.controller.control instanceof HTMLElement)){("string"==typeof t.params.controller.control?[...document.querySelectorAll(t.params.controller.control)]:[t.params.controller.control]).forEach((e=>{if(t.controller.control||(t.controller.control=[]),e&&e.swiper)t.controller.control.push(e.swiper);else if(e){const s=`${t.params.eventsPrefix}init`,a=i=>{t.controller.control.push(i.detail[0]),t.update(),e.removeEventListener(s,a)};e.addEventListener(s,a)}}))}else t.controller.control=t.params.controller.control})),a("update",(()=>{r()})),a("resize",(()=>{r()})),a("observerUpdate",(()=>{r()})),a("setTranslate",((e,s,a)=>{t.controller.control&&!t.controller.control.destroyed&&t.controller.setTranslate(s,a)})),a("setTransition",((e,s,a)=>{t.controller.control&&!t.controller.control.destroyed&&t.controller.setTransition(s,a)})),Object.assign(t.controller,{setTranslate:function(e,s){const a=t.controller.control;let r,n;const l=t.constructor;function o(e){if(e.destroyed)return;const s=t.rtlTranslate?-t.translate:t.translate;"slide"===t.params.controller.by&&(!function(e){t.controller.spline=t.params.loop?new i(t.slidesGrid,e.slidesGrid):new i(t.snapGrid,e.snapGrid)}(e),n=-t.controller.spline.interpolate(-s)),n&&"container"!==t.params.controller.by||(r=(e.maxTranslate()-e.minTranslate())/(t.maxTranslate()-t.minTranslate()),!Number.isNaN(r)&&Number.isFinite(r)||(r=1),n=(s-t.minTranslate())*r+e.minTranslate()),t.params.controller.inverse&&(n=e.maxTranslate()-n),e.updateProgress(n),e.setTranslate(n,t),e.updateActiveIndex(),e.updateSlidesClasses()}if(Array.isArray(a))for(let e=0;e<a.length;e+=1)a[e]!==s&&a[e]instanceof l&&o(a[e]);else a instanceof l&&s!==a&&o(a)},setTransition:function(e,s){const a=t.constructor,i=t.controller.control;let r;function n(s){s.destroyed||(s.setTransition(e,t),0!==e&&(s.transitionStart(),s.params.autoHeight&&l((()=>{s.updateAutoHeight()})),x(s.wrapperEl,(()=>{i&&s.transitionEnd()}))))}if(Array.isArray(i))for(r=0;r<i.length;r+=1)i[r]!==s&&i[r]instanceof a&&n(i[r]);else i instanceof a&&s!==i&&n(i)}})},function(e){let{swiper:t,extendParams:s,on:i}=e;s({a11y:{enabled:!0,notificationClass:"swiper-notification",prevSlideMessage:"Previous slide",nextSlideMessage:"Next slide",firstSlideMessage:"This is the first slide",lastSlideMessage:"This is the last slide",paginationBulletMessage:"Go to slide {{index}}",slideLabelMessage:"{{index}} / {{slidesLength}}",containerMessage:null,containerRoleDescriptionMessage:null,containerRole:null,itemRoleDescriptionMessage:null,slideRole:"group",id:null,scrollOnFocus:!0}}),t.a11y={clicked:!1};let r,n,l=null,o=(new Date).getTime();function d(e){const t=l;0!==t.length&&C(t,e)}function c(e){(e=T(e)).forEach((e=>{e.setAttribute("tabIndex","0")}))}function p(e){(e=T(e)).forEach((e=>{e.setAttribute("tabIndex","-1")}))}function u(e,t){(e=T(e)).forEach((e=>{e.setAttribute("role",t)}))}function m(e,t){(e=T(e)).forEach((e=>{e.setAttribute("aria-roledescription",t)}))}function h(e,t){(e=T(e)).forEach((e=>{e.setAttribute("aria-label",t)}))}function f(e){(e=T(e)).forEach((e=>{e.setAttribute("aria-disabled",!0)}))}function g(e){(e=T(e)).forEach((e=>{e.setAttribute("aria-disabled",!1)}))}function w(e){if(13!==e.keyCode&&32!==e.keyCode)return;const s=t.params.a11y,a=e.target;if(!t.pagination||!t.pagination.el||a!==t.pagination.el&&!t.pagination.el.contains(e.target)||e.target.matches(le(t.params.pagination.bulletClass))){if(t.navigation&&t.navigation.prevEl&&t.navigation.nextEl){const e=T(t.navigation.prevEl);T(t.navigation.nextEl).includes(a)&&(t.isEnd&&!t.params.loop||t.slideNext(),t.isEnd?d(s.lastSlideMessage):d(s.nextSlideMessage)),e.includes(a)&&(t.isBeginning&&!t.params.loop||t.slidePrev(),t.isBeginning?d(s.firstSlideMessage):d(s.prevSlideMessage))}t.pagination&&a.matches(le(t.params.pagination.bulletClass))&&a.click()}}function b(){return t.pagination&&t.pagination.bullets&&t.pagination.bullets.length}function E(){return b()&&t.params.pagination.clickable}const x=(e,t,s)=>{c(e),"BUTTON"!==e.tagName&&(u(e,"button"),e.addEventListener("keydown",w)),h(e,s),function(e,t){(e=T(e)).forEach((e=>{e.setAttribute("aria-controls",t)}))}(e,t)},S=e=>{n&&n!==e.target&&!n.contains(e.target)&&(r=!0),t.a11y.clicked=!0},M=()=>{r=!1,requestAnimationFrame((()=>{requestAnimationFrame((()=>{t.destroyed||(t.a11y.clicked=!1)}))}))},P=e=>{o=(new Date).getTime()},L=e=>{if(t.a11y.clicked||!t.params.a11y.scrollOnFocus)return;if((new Date).getTime()-o<100)return;const s=e.target.closest(`.${t.params.slideClass}, swiper-slide`);if(!s||!t.slides.includes(s))return;n=s;const a=t.slides.indexOf(s)===t.activeIndex,i=t.params.watchSlidesProgress&&t.visibleSlides&&t.visibleSlides.includes(s);a||i||e.sourceCapabilities&&e.sourceCapabilities.firesTouchEvents||(t.isHorizontal()?t.el.scrollLeft=0:t.el.scrollTop=0,requestAnimationFrame((()=>{r||(t.params.loop?t.slideToLoop(t.getSlideIndexWhenGrid(parseInt(s.getAttribute("data-swiper-slide-index"))),0):t.slideTo(t.getSlideIndexWhenGrid(t.slides.indexOf(s)),0),r=!1)})))},I=()=>{const e=t.params.a11y;e.itemRoleDescriptionMessage&&m(t.slides,e.itemRoleDescriptionMessage),e.slideRole&&u(t.slides,e.slideRole);const s=t.slides.length;e.slideLabelMessage&&t.slides.forEach(((a,i)=>{const r=t.params.loop?parseInt(a.getAttribute("data-swiper-slide-index"),10):i;h(a,e.slideLabelMessage.replace(/\{\{index\}\}/,r+1).replace(/\{\{slidesLength\}\}/,s))}))},z=()=>{const e=t.params.a11y;t.el.append(l);const s=t.el;e.containerRoleDescriptionMessage&&m(s,e.containerRoleDescriptionMessage),e.containerMessage&&h(s,e.containerMessage),e.containerRole&&u(s,e.containerRole);const i=t.wrapperEl,r=e.id||i.getAttribute("id")||`swiper-wrapper-${n=16,void 0===n&&(n=16),"x".repeat(n).replace(/x/g,(()=>Math.round(16*Math.random()).toString(16)))}`;var n;const o=t.params.autoplay&&t.params.autoplay.enabled?"off":"polite";var d;d=r,T(i).forEach((e=>{e.setAttribute("id",d)})),function(e,t){(e=T(e)).forEach((e=>{e.setAttribute("aria-live",t)}))}(i,o),I();let{nextEl:c,prevEl:p}=t.navigation?t.navigation:{};if(c=T(c),p=T(p),c&&c.forEach((t=>x(t,r,e.nextSlideMessage))),p&&p.forEach((t=>x(t,r,e.prevSlideMessage))),E()){T(t.pagination.el).forEach((e=>{e.addEventListener("keydown",w)}))}a().addEventListener("visibilitychange",P),t.el.addEventListener("focus",L,!0),t.el.addEventListener("focus",L,!0),t.el.addEventListener("pointerdown",S,!0),t.el.addEventListener("pointerup",M,!0)};i("beforeInit",(()=>{l=v("span",t.params.a11y.notificationClass),l.setAttribute("aria-live","assertive"),l.setAttribute("aria-atomic","true")})),i("afterInit",(()=>{t.params.a11y.enabled&&z()})),i("slidesLengthChange snapGridLengthChange slidesGridLengthChange",(()=>{t.params.a11y.enabled&&I()})),i("fromEdge toEdge afterInit lock unlock",(()=>{t.params.a11y.enabled&&function(){if(t.params.loop||t.params.rewind||!t.navigation)return;const{nextEl:e,prevEl:s}=t.navigation;s&&(t.isBeginning?(f(s),p(s)):(g(s),c(s))),e&&(t.isEnd?(f(e),p(e)):(g(e),c(e)))}()})),i("paginationUpdate",(()=>{t.params.a11y.enabled&&function(){const e=t.params.a11y;b()&&t.pagination.bullets.forEach((s=>{t.params.pagination.clickable&&(c(s),t.params.pagination.renderBullet||(u(s,"button"),h(s,e.paginationBulletMessage.replace(/\{\{index\}\}/,y(s)+1)))),s.matches(le(t.params.pagination.bulletActiveClass))?s.setAttribute("aria-current","true"):s.removeAttribute("aria-current")}))}()})),i("destroy",(()=>{t.params.a11y.enabled&&function(){l&&l.remove();let{nextEl:e,prevEl:s}=t.navigation?t.navigation:{};e=T(e),s=T(s),e&&e.forEach((e=>e.removeEventListener("keydown",w))),s&&s.forEach((e=>e.removeEventListener("keydown",w))),E()&&T(t.pagination.el).forEach((e=>{e.removeEventListener("keydown",w)}));a().removeEventListener("visibilitychange",P),t.el&&"string"!=typeof t.el&&(t.el.removeEventListener("focus",L,!0),t.el.removeEventListener("pointerdown",S,!0),t.el.removeEventListener("pointerup",M,!0))}()}))},function(e){let{swiper:t,extendParams:s,on:a}=e;s({history:{enabled:!1,root:"",replaceState:!1,key:"slides",keepQuery:!1}});let i=!1,n={};const l=e=>e.toString().replace(/\s+/g,"-").replace(/[^\w-]+/g,"").replace(/--+/g,"-").replace(/^-+/,"").replace(/-+$/,""),o=e=>{const t=r();let s;s=e?new URL(e):t.location;const a=s.pathname.slice(1).split("/").filter((e=>""!==e)),i=a.length;return{key:a[i-2],value:a[i-1]}},d=(e,s)=>{const a=r();if(!i||!t.params.history.enabled)return;let n;n=t.params.url?new URL(t.params.url):a.location;const o=t.virtual&&t.params.virtual.enabled?t.slidesEl.querySelector(`[data-swiper-slide-index="${s}"]`):t.slides[s];let d=l(o.getAttribute("data-history"));if(t.params.history.root.length>0){let s=t.params.history.root;"/"===s[s.length-1]&&(s=s.slice(0,s.length-1)),d=`${s}/${e?`${e}/`:""}${d}`}else n.pathname.includes(e)||(d=`${e?`${e}/`:""}${d}`);t.params.history.keepQuery&&(d+=n.search);const c=a.history.state;c&&c.value===d||(t.params.history.replaceState?a.history.replaceState({value:d},null,d):a.history.pushState({value:d},null,d))},c=(e,s,a)=>{if(s)for(let i=0,r=t.slides.length;i<r;i+=1){const r=t.slides[i];if(l(r.getAttribute("data-history"))===s){const s=t.getSlideIndex(r);t.slideTo(s,e,a)}}else t.slideTo(0,e,a)},p=()=>{n=o(t.params.url),c(t.params.speed,n.value,!1)};a("init",(()=>{t.params.history.enabled&&(()=>{const e=r();if(t.params.history){if(!e.history||!e.history.pushState)return t.params.history.enabled=!1,void(t.params.hashNavigation.enabled=!0);i=!0,n=o(t.params.url),n.key||n.value?(c(0,n.value,t.params.runCallbacksOnInit),t.params.history.replaceState||e.addEventListener("popstate",p)):t.params.history.replaceState||e.addEventListener("popstate",p)}})()})),a("destroy",(()=>{t.params.history.enabled&&(()=>{const e=r();t.params.history.replaceState||e.removeEventListener("popstate",p)})()})),a("transitionEnd _freeModeNoMomentumRelease",(()=>{i&&d(t.params.history.key,t.activeIndex)})),a("slideChange",(()=>{i&&t.params.cssMode&&d(t.params.history.key,t.activeIndex)}))},function(e){let{swiper:t,extendParams:s,emit:i,on:n}=e,l=!1;const o=a(),d=r();s({hashNavigation:{enabled:!1,replaceState:!1,watchState:!1,getSlideIndex(e,s){if(t.virtual&&t.params.virtual.enabled){const e=t.slides.find((e=>e.getAttribute("data-hash")===s));if(!e)return 0;return parseInt(e.getAttribute("data-swiper-slide-index"),10)}return t.getSlideIndex(f(t.slidesEl,`.${t.params.slideClass}[data-hash="${s}"], swiper-slide[data-hash="${s}"]`)[0])}}});const c=()=>{i("hashChange");const e=o.location.hash.replace("#",""),s=t.virtual&&t.params.virtual.enabled?t.slidesEl.querySelector(`[data-swiper-slide-index="${t.activeIndex}"]`):t.slides[t.activeIndex];if(e!==(s?s.getAttribute("data-hash"):"")){const s=t.params.hashNavigation.getSlideIndex(t,e);if(void 0===s||Number.isNaN(s))return;t.slideTo(s)}},p=()=>{if(!l||!t.params.hashNavigation.enabled)return;const e=t.virtual&&t.params.virtual.enabled?t.slidesEl.querySelector(`[data-swiper-slide-index="${t.activeIndex}"]`):t.slides[t.activeIndex],s=e?e.getAttribute("data-hash")||e.getAttribute("data-history"):"";t.params.hashNavigation.replaceState&&d.history&&d.history.replaceState?(d.history.replaceState(null,null,`#${s}`||""),i("hashSet")):(o.location.hash=s||"",i("hashSet"))};n("init",(()=>{t.params.hashNavigation.enabled&&(()=>{if(!t.params.hashNavigation.enabled||t.params.history&&t.params.history.enabled)return;l=!0;const e=o.location.hash.replace("#","");if(e){const s=0,a=t.params.hashNavigation.getSlideIndex(t,e);t.slideTo(a||0,s,t.params.runCallbacksOnInit,!0)}t.params.hashNavigation.watchState&&d.addEventListener("hashchange",c)})()})),n("destroy",(()=>{t.params.hashNavigation.enabled&&t.params.hashNavigation.watchState&&d.removeEventListener("hashchange",c)})),n("transitionEnd _freeModeNoMomentumRelease",(()=>{l&&p()})),n("slideChange",(()=>{l&&t.params.cssMode&&p()}))},function(e){let t,s,{swiper:i,extendParams:r,on:n,emit:l,params:o}=e;i.autoplay={running:!1,paused:!1,timeLeft:0},r({autoplay:{enabled:!1,delay:3e3,waitForTransition:!0,disableOnInteraction:!1,stopOnLastSlide:!1,reverseDirection:!1,pauseOnMouseEnter:!1}});let d,c,p,u,m,h,f,g,v=o&&o.autoplay?o.autoplay.delay:3e3,w=o&&o.autoplay?o.autoplay.delay:3e3,b=(new Date).getTime();function y(e){i&&!i.destroyed&&i.wrapperEl&&e.target===i.wrapperEl&&(i.wrapperEl.removeEventListener("transitionend",y),g||e.detail&&e.detail.bySwiperTouchMove||C())}const E=()=>{if(i.destroyed||!i.autoplay.running)return;i.autoplay.paused?c=!0:c&&(w=d,c=!1);const e=i.autoplay.paused?d:b+w-(new Date).getTime();i.autoplay.timeLeft=e,l("autoplayTimeLeft",e,e/v),s=requestAnimationFrame((()=>{E()}))},x=e=>{if(i.destroyed||!i.autoplay.running)return;cancelAnimationFrame(s),E();let a=void 0===e?i.params.autoplay.delay:e;v=i.params.autoplay.delay,w=i.params.autoplay.delay;const r=(()=>{let e;if(e=i.virtual&&i.params.virtual.enabled?i.slides.find((e=>e.classList.contains("swiper-slide-active"))):i.slides[i.activeIndex],!e)return;return parseInt(e.getAttribute("data-swiper-autoplay"),10)})();!Number.isNaN(r)&&r>0&&void 0===e&&(a=r,v=r,w=r),d=a;const n=i.params.speed,o=()=>{i&&!i.destroyed&&(i.params.autoplay.reverseDirection?!i.isBeginning||i.params.loop||i.params.rewind?(i.slidePrev(n,!0,!0),l("autoplay")):i.params.autoplay.stopOnLastSlide||(i.slideTo(i.slides.length-1,n,!0,!0),l("autoplay")):!i.isEnd||i.params.loop||i.params.rewind?(i.slideNext(n,!0,!0),l("autoplay")):i.params.autoplay.stopOnLastSlide||(i.slideTo(0,n,!0,!0),l("autoplay")),i.params.cssMode&&(b=(new Date).getTime(),requestAnimationFrame((()=>{x()}))))};return a>0?(clearTimeout(t),t=setTimeout((()=>{o()}),a)):requestAnimationFrame((()=>{o()})),a},S=()=>{b=(new Date).getTime(),i.autoplay.running=!0,x(),l("autoplayStart")},T=()=>{i.autoplay.running=!1,clearTimeout(t),cancelAnimationFrame(s),l("autoplayStop")},M=(e,s)=>{if(i.destroyed||!i.autoplay.running)return;clearTimeout(t),e||(f=!0);const a=()=>{l("autoplayPause"),i.params.autoplay.waitForTransition?i.wrapperEl.addEventListener("transitionend",y):C()};if(i.autoplay.paused=!0,s)return h&&(d=i.params.autoplay.delay),h=!1,void a();const r=d||i.params.autoplay.delay;d=r-((new Date).getTime()-b),i.isEnd&&d<0&&!i.params.loop||(d<0&&(d=0),a())},C=()=>{i.isEnd&&d<0&&!i.params.loop||i.destroyed||!i.autoplay.running||(b=(new Date).getTime(),f?(f=!1,x(d)):x(),i.autoplay.paused=!1,l("autoplayResume"))},P=()=>{if(i.destroyed||!i.autoplay.running)return;const e=a();"hidden"===e.visibilityState&&(f=!0,M(!0)),"visible"===e.visibilityState&&C()},L=e=>{"mouse"===e.pointerType&&(f=!0,g=!0,i.animating||i.autoplay.paused||M(!0))},I=e=>{"mouse"===e.pointerType&&(g=!1,i.autoplay.paused&&C())};n("init",(()=>{i.params.autoplay.enabled&&(i.params.autoplay.pauseOnMouseEnter&&(i.el.addEventListener("pointerenter",L),i.el.addEventListener("pointerleave",I)),a().addEventListener("visibilitychange",P),S())})),n("destroy",(()=>{i.el&&"string"!=typeof i.el&&(i.el.removeEventListener("pointerenter",L),i.el.removeEventListener("pointerleave",I)),a().removeEventListener("visibilitychange",P),i.autoplay.running&&T()})),n("_freeModeStaticRelease",(()=>{(u||f)&&C()})),n("_freeModeNoMomentumRelease",(()=>{i.params.autoplay.disableOnInteraction?T():M(!0,!0)})),n("beforeTransitionStart",((e,t,s)=>{!i.destroyed&&i.autoplay.running&&(s||!i.params.autoplay.disableOnInteraction?M(!0,!0):T())})),n("sliderFirstMove",(()=>{!i.destroyed&&i.autoplay.running&&(i.params.autoplay.disableOnInteraction?T():(p=!0,u=!1,f=!1,m=setTimeout((()=>{f=!0,u=!0,M(!0)}),200)))})),n("touchEnd",(()=>{if(!i.destroyed&&i.autoplay.running&&p){if(clearTimeout(m),clearTimeout(t),i.params.autoplay.disableOnInteraction)return u=!1,void(p=!1);u&&i.params.cssMode&&C(),u=!1,p=!1}})),n("slideChange",(()=>{!i.destroyed&&i.autoplay.running&&(h=!0)})),Object.assign(i.autoplay,{start:S,stop:T,pause:M,resume:C})},function(e){let{swiper:t,extendParams:s,on:i}=e;s({thumbs:{swiper:null,multipleActiveThumbs:!0,autoScrollOffset:0,slideThumbActiveClass:"swiper-slide-thumb-active",thumbsContainerClass:"swiper-thumbs"}});let r=!1,n=!1;function l(){const e=t.thumbs.swiper;if(!e||e.destroyed)return;const s=e.clickedIndex,a=e.clickedSlide;if(a&&a.classList.contains(t.params.thumbs.slideThumbActiveClass))return;if(null==s)return;let i;i=e.params.loop?parseInt(e.clickedSlide.getAttribute("data-swiper-slide-index"),10):s,t.params.loop?t.slideToLoop(i):t.slideTo(i)}function o(){const{thumbs:e}=t.params;if(r)return!1;r=!0;const s=t.constructor;if(e.swiper instanceof s){if(e.swiper.destroyed)return r=!1,!1;t.thumbs.swiper=e.swiper,Object.assign(t.thumbs.swiper.originalParams,{watchSlidesProgress:!0,slideToClickedSlide:!1}),Object.assign(t.thumbs.swiper.params,{watchSlidesProgress:!0,slideToClickedSlide:!1}),t.thumbs.swiper.update()}else if(c(e.swiper)){const a=Object.assign({},e.swiper);Object.assign(a,{watchSlidesProgress:!0,slideToClickedSlide:!1}),t.thumbs.swiper=new s(a),n=!0}return t.thumbs.swiper.el.classList.add(t.params.thumbs.thumbsContainerClass),t.thumbs.swiper.on("tap",l),!0}function d(e){const s=t.thumbs.swiper;if(!s||s.destroyed)return;const a="auto"===s.params.slidesPerView?s.slidesPerViewDynamic():s.params.slidesPerView;let i=1;const r=t.params.thumbs.slideThumbActiveClass;if(t.params.slidesPerView>1&&!t.params.centeredSlides&&(i=t.params.slidesPerView),t.params.thumbs.multipleActiveThumbs||(i=1),i=Math.floor(i),s.slides.forEach((e=>e.classList.remove(r))),s.params.loop||s.params.virtual&&s.params.virtual.enabled)for(let e=0;e<i;e+=1)f(s.slidesEl,`[data-swiper-slide-index="${t.realIndex+e}"]`).forEach((e=>{e.classList.add(r)}));else for(let e=0;e<i;e+=1)s.slides[t.realIndex+e]&&s.slides[t.realIndex+e].classList.add(r);const n=t.params.thumbs.autoScrollOffset,l=n&&!s.params.loop;if(t.realIndex!==s.realIndex||l){const i=s.activeIndex;let r,o;if(s.params.loop){const e=s.slides.find((e=>e.getAttribute("data-swiper-slide-index")===`${t.realIndex}`));r=s.slides.indexOf(e),o=t.activeIndex>t.previousIndex?"next":"prev"}else r=t.realIndex,o=r>t.previousIndex?"next":"prev";l&&(r+="next"===o?n:-1*n),s.visibleSlidesIndexes&&s.visibleSlidesIndexes.indexOf(r)<0&&(s.params.centeredSlides?r=r>i?r-Math.floor(a/2)+1:r+Math.floor(a/2)-1:r>i&&s.params.slidesPerGroup,s.slideTo(r,e?0:void 0))}}t.thumbs={swiper:null},i("beforeInit",(()=>{const{thumbs:e}=t.params;if(e&&e.swiper)if("string"==typeof e.swiper||e.swiper instanceof HTMLElement){const s=a(),i=()=>{const a="string"==typeof e.swiper?s.querySelector(e.swiper):e.swiper;if(a&&a.swiper)e.swiper=a.swiper,o(),d(!0);else if(a){const s=`${t.params.eventsPrefix}init`,i=r=>{e.swiper=r.detail[0],a.removeEventListener(s,i),o(),d(!0),e.swiper.update(),t.update()};a.addEventListener(s,i)}return a},r=()=>{if(t.destroyed)return;i()||requestAnimationFrame(r)};requestAnimationFrame(r)}else o(),d(!0)})),i("slideChange update resize observerUpdate",(()=>{d()})),i("setTransition",((e,s)=>{const a=t.thumbs.swiper;a&&!a.destroyed&&a.setTransition(s)})),i("beforeDestroy",(()=>{const e=t.thumbs.swiper;e&&!e.destroyed&&n&&e.destroy()})),Object.assign(t.thumbs,{init:o,update:d})},function(e){let{swiper:t,extendParams:s,emit:a,once:i}=e;s({freeMode:{enabled:!1,momentum:!0,momentumRatio:1,momentumBounce:!0,momentumBounceRatio:1,momentumVelocityRatio:1,sticky:!1,minimumVelocity:.02}}),Object.assign(t,{freeMode:{onTouchStart:function(){if(t.params.cssMode)return;const e=t.getTranslate();t.setTranslate(e),t.setTransition(0),t.touchEventsData.velocities.length=0,t.freeMode.onTouchEnd({currentPos:t.rtl?t.translate:-t.translate})},onTouchMove:function(){if(t.params.cssMode)return;const{touchEventsData:e,touches:s}=t;0===e.velocities.length&&e.velocities.push({position:s[t.isHorizontal()?"startX":"startY"],time:e.touchStartTime}),e.velocities.push({position:s[t.isHorizontal()?"currentX":"currentY"],time:o()})},onTouchEnd:function(e){let{currentPos:s}=e;if(t.params.cssMode)return;const{params:r,wrapperEl:n,rtlTranslate:l,snapGrid:d,touchEventsData:c}=t,p=o()-c.touchStartTime;if(s<-t.minTranslate())t.slideTo(t.activeIndex);else if(s>-t.maxTranslate())t.slides.length<d.length?t.slideTo(d.length-1):t.slideTo(t.slides.length-1);else{if(r.freeMode.momentum){if(c.velocities.length>1){const e=c.velocities.pop(),s=c.velocities.pop(),a=e.position-s.position,i=e.time-s.time;t.velocity=a/i,t.velocity/=2,Math.abs(t.velocity)<r.freeMode.minimumVelocity&&(t.velocity=0),(i>150||o()-e.time>300)&&(t.velocity=0)}else t.velocity=0;t.velocity*=r.freeMode.momentumVelocityRatio,c.velocities.length=0;let e=1e3*r.freeMode.momentumRatio;const s=t.velocity*e;let p=t.translate+s;l&&(p=-p);let u,m=!1;const h=20*Math.abs(t.velocity)*r.freeMode.momentumBounceRatio;let f;if(p<t.maxTranslate())r.freeMode.momentumBounce?(p+t.maxTranslate()<-h&&(p=t.maxTranslate()-h),u=t.maxTranslate(),m=!0,c.allowMomentumBounce=!0):p=t.maxTranslate(),r.loop&&r.centeredSlides&&(f=!0);else if(p>t.minTranslate())r.freeMode.momentumBounce?(p-t.minTranslate()>h&&(p=t.minTranslate()+h),u=t.minTranslate(),m=!0,c.allowMomentumBounce=!0):p=t.minTranslate(),r.loop&&r.centeredSlides&&(f=!0);else if(r.freeMode.sticky){let e;for(let t=0;t<d.length;t+=1)if(d[t]>-p){e=t;break}p=Math.abs(d[e]-p)<Math.abs(d[e-1]-p)||"next"===t.swipeDirection?d[e]:d[e-1],p=-p}if(f&&i("transitionEnd",(()=>{t.loopFix()})),0!==t.velocity){if(e=l?Math.abs((-p-t.translate)/t.velocity):Math.abs((p-t.translate)/t.velocity),r.freeMode.sticky){const s=Math.abs((l?-p:p)-t.translate),a=t.slidesSizesGrid[t.activeIndex];e=s<a?r.speed:s<2*a?1.5*r.speed:2.5*r.speed}}else if(r.freeMode.sticky)return void t.slideToClosest();r.freeMode.momentumBounce&&m?(t.updateProgress(u),t.setTransition(e),t.setTranslate(p),t.transitionStart(!0,t.swipeDirection),t.animating=!0,x(n,(()=>{t&&!t.destroyed&&c.allowMomentumBounce&&(a("momentumBounce"),t.setTransition(r.speed),setTimeout((()=>{t.setTranslate(u),x(n,(()=>{t&&!t.destroyed&&t.transitionEnd()}))}),0))}))):t.velocity?(a("_freeModeNoMomentumRelease"),t.updateProgress(p),t.setTransition(e),t.setTranslate(p),t.transitionStart(!0,t.swipeDirection),t.animating||(t.animating=!0,x(n,(()=>{t&&!t.destroyed&&t.transitionEnd()})))):t.updateProgress(p),t.updateActiveIndex(),t.updateSlidesClasses()}else{if(r.freeMode.sticky)return void t.slideToClosest();r.freeMode&&a("_freeModeNoMomentumRelease")}(!r.freeMode.momentum||p>=r.longSwipesMs)&&(a("_freeModeStaticRelease"),t.updateProgress(),t.updateActiveIndex(),t.updateSlidesClasses())}}}})},function(e){let t,s,a,i,{swiper:r,extendParams:n,on:l}=e;n({grid:{rows:1,fill:"column"}});const o=()=>{let e=r.params.spaceBetween;return"string"==typeof e&&e.indexOf("%")>=0?e=parseFloat(e.replace("%",""))/100*r.size:"string"==typeof e&&(e=parseFloat(e)),e};l("init",(()=>{i=r.params.grid&&r.params.grid.rows>1})),l("update",(()=>{const{params:e,el:t}=r,s=e.grid&&e.grid.rows>1;i&&!s?(t.classList.remove(`${e.containerModifierClass}grid`,`${e.containerModifierClass}grid-column`),a=1,r.emitContainerClasses()):!i&&s&&(t.classList.add(`${e.containerModifierClass}grid`),"column"===e.grid.fill&&t.classList.add(`${e.containerModifierClass}grid-column`),r.emitContainerClasses()),i=s})),r.grid={initSlides:e=>{const{slidesPerView:i}=r.params,{rows:n,fill:l}=r.params.grid,o=r.virtual&&r.params.virtual.enabled?r.virtual.slides.length:e.length;a=Math.floor(o/n),t=Math.floor(o/n)===o/n?o:Math.ceil(o/n)*n,"auto"!==i&&"row"===l&&(t=Math.max(t,i*n)),s=t/n},unsetSlides:()=>{r.slides&&r.slides.forEach((e=>{e.swiperSlideGridSet&&(e.style.height="",e.style[r.getDirectionLabel("margin-top")]="")}))},updateSlide:(e,i,n)=>{const{slidesPerGroup:l}=r.params,d=o(),{rows:c,fill:p}=r.params.grid,u=r.virtual&&r.params.virtual.enabled?r.virtual.slides.length:n.length;let m,h,f;if("row"===p&&l>1){const s=Math.floor(e/(l*c)),a=e-c*l*s,r=0===s?l:Math.min(Math.ceil((u-s*c*l)/c),l);f=Math.floor(a/r),h=a-f*r+s*l,m=h+f*t/c,i.style.order=m}else"column"===p?(h=Math.floor(e/c),f=e-h*c,(h>a||h===a&&f===c-1)&&(f+=1,f>=c&&(f=0,h+=1))):(f=Math.floor(e/s),h=e-f*s);i.row=f,i.column=h,i.style.height=`calc((100% - ${(c-1)*d}px) / ${c})`,i.style[r.getDirectionLabel("margin-top")]=0!==f?d&&`${d}px`:"",i.swiperSlideGridSet=!0},updateWrapperSize:(e,s)=>{const{centeredSlides:a,roundLengths:i}=r.params,n=o(),{rows:l}=r.params.grid;if(r.virtualSize=(e+n)*t,r.virtualSize=Math.ceil(r.virtualSize/l)-n,r.params.cssMode||(r.wrapperEl.style[r.getDirectionLabel("width")]=`${r.virtualSize+n}px`),a){const e=[];for(let t=0;t<s.length;t+=1){let a=s[t];i&&(a=Math.floor(a)),s[t]<r.virtualSize+s[0]&&e.push(a)}s.splice(0,s.length),s.push(...e)}}}},function(e){let{swiper:t}=e;Object.assign(t,{appendSlide:oe.bind(t),prependSlide:de.bind(t),addSlide:ce.bind(t),removeSlide:pe.bind(t),removeAllSlides:ue.bind(t)})},function(e){let{swiper:t,extendParams:s,on:a}=e;s({fadeEffect:{crossFade:!1}}),me({effect:"fade",swiper:t,on:a,setTranslate:()=>{const{slides:e}=t;t.params.fadeEffect;for(let s=0;s<e.length;s+=1){const e=t.slides[s];let a=-e.swiperSlideOffset;t.params.virtualTranslate||(a-=t.translate);let i=0;t.isHorizontal()||(i=a,a=0);const r=t.params.fadeEffect.crossFade?Math.max(1-Math.abs(e.progress),0):1+Math.min(Math.max(e.progress,-1),0),n=he(0,e);n.style.opacity=r,n.style.transform=`translate3d(${a}px, ${i}px, 0px)`}},setTransition:e=>{const s=t.slides.map((e=>h(e)));s.forEach((t=>{t.style.transitionDuration=`${e}ms`})),fe({swiper:t,duration:e,transformElements:s,allSlides:!0})},overwriteParams:()=>({slidesPerView:1,slidesPerGroup:1,watchSlidesProgress:!0,spaceBetween:0,virtualTranslate:!t.params.cssMode})})},function(e){let{swiper:t,extendParams:s,on:a}=e;s({cubeEffect:{slideShadows:!0,shadow:!0,shadowOffset:20,shadowScale:.94}});const i=(e,t,s)=>{let a=s?e.querySelector(".swiper-slide-shadow-left"):e.querySelector(".swiper-slide-shadow-top"),i=s?e.querySelector(".swiper-slide-shadow-right"):e.querySelector(".swiper-slide-shadow-bottom");a||(a=v("div",("swiper-slide-shadow-cube swiper-slide-shadow-"+(s?"left":"top")).split(" ")),e.append(a)),i||(i=v("div",("swiper-slide-shadow-cube swiper-slide-shadow-"+(s?"right":"bottom")).split(" ")),e.append(i)),a&&(a.style.opacity=Math.max(-t,0)),i&&(i.style.opacity=Math.max(t,0))};me({effect:"cube",swiper:t,on:a,setTranslate:()=>{const{el:e,wrapperEl:s,slides:a,width:r,height:n,rtlTranslate:l,size:o,browser:d}=t,c=M(t),p=t.params.cubeEffect,u=t.isHorizontal(),m=t.virtual&&t.params.virtual.enabled;let h,f=0;p.shadow&&(u?(h=t.wrapperEl.querySelector(".swiper-cube-shadow"),h||(h=v("div","swiper-cube-shadow"),t.wrapperEl.append(h)),h.style.height=`${r}px`):(h=e.querySelector(".swiper-cube-shadow"),h||(h=v("div","swiper-cube-shadow"),e.append(h))));for(let e=0;e<a.length;e+=1){const t=a[e];let s=e;m&&(s=parseInt(t.getAttribute("data-swiper-slide-index"),10));let r=90*s,n=Math.floor(r/360);l&&(r=-r,n=Math.floor(-r/360));const d=Math.max(Math.min(t.progress,1),-1);let h=0,g=0,v=0;s%4==0?(h=4*-n*o,v=0):(s-1)%4==0?(h=0,v=4*-n*o):(s-2)%4==0?(h=o+4*n*o,v=o):(s-3)%4==0&&(h=-o,v=3*o+4*o*n),l&&(h=-h),u||(g=h,h=0);const w=`rotateX(${c(u?0:-r)}deg) rotateY(${c(u?r:0)}deg) translate3d(${h}px, ${g}px, ${v}px)`;d<=1&&d>-1&&(f=90*s+90*d,l&&(f=90*-s-90*d)),t.style.transform=w,p.slideShadows&&i(t,d,u)}if(s.style.transformOrigin=`50% 50% -${o/2}px`,s.style["-webkit-transform-origin"]=`50% 50% -${o/2}px`,p.shadow)if(u)h.style.transform=`translate3d(0px, ${r/2+p.shadowOffset}px, ${-r/2}px) rotateX(89.99deg) rotateZ(0deg) scale(${p.shadowScale})`;else{const e=Math.abs(f)-90*Math.floor(Math.abs(f)/90),t=1.5-(Math.sin(2*e*Math.PI/360)/2+Math.cos(2*e*Math.PI/360)/2),s=p.shadowScale,a=p.shadowScale/t,i=p.shadowOffset;h.style.transform=`scale3d(${s}, 1, ${a}) translate3d(0px, ${n/2+i}px, ${-n/2/a}px) rotateX(-89.99deg)`}const g=(d.isSafari||d.isWebView)&&d.needPerspectiveFix?-o/2:0;s.style.transform=`translate3d(0px,0,${g}px) rotateX(${c(t.isHorizontal()?0:f)}deg) rotateY(${c(t.isHorizontal()?-f:0)}deg)`,s.style.setProperty("--swiper-cube-translate-z",`${g}px`)},setTransition:e=>{const{el:s,slides:a}=t;if(a.forEach((t=>{t.style.transitionDuration=`${e}ms`,t.querySelectorAll(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").forEach((t=>{t.style.transitionDuration=`${e}ms`}))})),t.params.cubeEffect.shadow&&!t.isHorizontal()){const t=s.querySelector(".swiper-cube-shadow");t&&(t.style.transitionDuration=`${e}ms`)}},recreateShadows:()=>{const e=t.isHorizontal();t.slides.forEach((t=>{const s=Math.max(Math.min(t.progress,1),-1);i(t,s,e)}))},getEffectParams:()=>t.params.cubeEffect,perspective:()=>!0,overwriteParams:()=>({slidesPerView:1,slidesPerGroup:1,watchSlidesProgress:!0,resistanceRatio:0,spaceBetween:0,centeredSlides:!1,virtualTranslate:!0})})},function(e){let{swiper:t,extendParams:s,on:a}=e;s({flipEffect:{slideShadows:!0,limitRotation:!0}});const i=(e,s)=>{let a=t.isHorizontal()?e.querySelector(".swiper-slide-shadow-left"):e.querySelector(".swiper-slide-shadow-top"),i=t.isHorizontal()?e.querySelector(".swiper-slide-shadow-right"):e.querySelector(".swiper-slide-shadow-bottom");a||(a=ge("flip",e,t.isHorizontal()?"left":"top")),i||(i=ge("flip",e,t.isHorizontal()?"right":"bottom")),a&&(a.style.opacity=Math.max(-s,0)),i&&(i.style.opacity=Math.max(s,0))};me({effect:"flip",swiper:t,on:a,setTranslate:()=>{const{slides:e,rtlTranslate:s}=t,a=t.params.flipEffect,r=M(t);for(let n=0;n<e.length;n+=1){const l=e[n];let o=l.progress;t.params.flipEffect.limitRotation&&(o=Math.max(Math.min(l.progress,1),-1));const d=l.swiperSlideOffset;let c=-180*o,p=0,u=t.params.cssMode?-d-t.translate:-d,m=0;t.isHorizontal()?s&&(c=-c):(m=u,u=0,p=-c,c=0),l.style.zIndex=-Math.abs(Math.round(o))+e.length,a.slideShadows&&i(l,o);const h=`translate3d(${u}px, ${m}px, 0px) rotateX(${r(p)}deg) rotateY(${r(c)}deg)`;he(0,l).style.transform=h}},setTransition:e=>{const s=t.slides.map((e=>h(e)));s.forEach((t=>{t.style.transitionDuration=`${e}ms`,t.querySelectorAll(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").forEach((t=>{t.style.transitionDuration=`${e}ms`}))})),fe({swiper:t,duration:e,transformElements:s})},recreateShadows:()=>{t.params.flipEffect,t.slides.forEach((e=>{let s=e.progress;t.params.flipEffect.limitRotation&&(s=Math.max(Math.min(e.progress,1),-1)),i(e,s)}))},getEffectParams:()=>t.params.flipEffect,perspective:()=>!0,overwriteParams:()=>({slidesPerView:1,slidesPerGroup:1,watchSlidesProgress:!0,spaceBetween:0,virtualTranslate:!t.params.cssMode})})},function(e){let{swiper:t,extendParams:s,on:a}=e;s({coverflowEffect:{rotate:50,stretch:0,depth:100,scale:1,modifier:1,slideShadows:!0}}),me({effect:"coverflow",swiper:t,on:a,setTranslate:()=>{const{width:e,height:s,slides:a,slidesSizesGrid:i}=t,r=t.params.coverflowEffect,n=t.isHorizontal(),l=t.translate,o=n?e/2-l:s/2-l,d=n?r.rotate:-r.rotate,c=r.depth,p=M(t);for(let e=0,t=a.length;e<t;e+=1){const t=a[e],s=i[e],l=(o-t.swiperSlideOffset-s/2)/s,u="function"==typeof r.modifier?r.modifier(l):l*r.modifier;let m=n?d*u:0,h=n?0:d*u,f=-c*Math.abs(u),g=r.stretch;"string"==typeof g&&-1!==g.indexOf("%")&&(g=parseFloat(r.stretch)/100*s);let v=n?0:g*u,w=n?g*u:0,b=1-(1-r.scale)*Math.abs(u);Math.abs(w)<.001&&(w=0),Math.abs(v)<.001&&(v=0),Math.abs(f)<.001&&(f=0),Math.abs(m)<.001&&(m=0),Math.abs(h)<.001&&(h=0),Math.abs(b)<.001&&(b=0);const y=`translate3d(${w}px,${v}px,${f}px)  rotateX(${p(h)}deg) rotateY(${p(m)}deg) scale(${b})`;if(he(0,t).style.transform=y,t.style.zIndex=1-Math.abs(Math.round(u)),r.slideShadows){let e=n?t.querySelector(".swiper-slide-shadow-left"):t.querySelector(".swiper-slide-shadow-top"),s=n?t.querySelector(".swiper-slide-shadow-right"):t.querySelector(".swiper-slide-shadow-bottom");e||(e=ge("coverflow",t,n?"left":"top")),s||(s=ge("coverflow",t,n?"right":"bottom")),e&&(e.style.opacity=u>0?u:0),s&&(s.style.opacity=-u>0?-u:0)}}},setTransition:e=>{t.slides.map((e=>h(e))).forEach((t=>{t.style.transitionDuration=`${e}ms`,t.querySelectorAll(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").forEach((t=>{t.style.transitionDuration=`${e}ms`}))}))},perspective:()=>!0,overwriteParams:()=>({watchSlidesProgress:!0})})},function(e){let{swiper:t,extendParams:s,on:a}=e;s({creativeEffect:{limitProgress:1,shadowPerProgress:!1,progressMultiplier:1,perspective:!0,prev:{translate:[0,0,0],rotate:[0,0,0],opacity:1,scale:1},next:{translate:[0,0,0],rotate:[0,0,0],opacity:1,scale:1}}});const i=e=>"string"==typeof e?e:`${e}px`;me({effect:"creative",swiper:t,on:a,setTranslate:()=>{const{slides:e,wrapperEl:s,slidesSizesGrid:a}=t,r=t.params.creativeEffect,{progressMultiplier:n}=r,l=t.params.centeredSlides,o=M(t);if(l){const e=a[0]/2-t.params.slidesOffsetBefore||0;s.style.transform=`translateX(calc(50% - ${e}px))`}for(let s=0;s<e.length;s+=1){const a=e[s],d=a.progress,c=Math.min(Math.max(a.progress,-r.limitProgress),r.limitProgress);let p=c;l||(p=Math.min(Math.max(a.originalProgress,-r.limitProgress),r.limitProgress));const u=a.swiperSlideOffset,m=[t.params.cssMode?-u-t.translate:-u,0,0],h=[0,0,0];let f=!1;t.isHorizontal()||(m[1]=m[0],m[0]=0);let g={translate:[0,0,0],rotate:[0,0,0],scale:1,opacity:1};c<0?(g=r.next,f=!0):c>0&&(g=r.prev,f=!0),m.forEach(((e,t)=>{m[t]=`calc(${e}px + (${i(g.translate[t])} * ${Math.abs(c*n)}))`})),h.forEach(((e,t)=>{let s=g.rotate[t]*Math.abs(c*n);h[t]=s})),a.style.zIndex=-Math.abs(Math.round(d))+e.length;const v=m.join(", "),w=`rotateX(${o(h[0])}deg) rotateY(${o(h[1])}deg) rotateZ(${o(h[2])}deg)`,b=p<0?`scale(${1+(1-g.scale)*p*n})`:`scale(${1-(1-g.scale)*p*n})`,y=p<0?1+(1-g.opacity)*p*n:1-(1-g.opacity)*p*n,E=`translate3d(${v}) ${w} ${b}`;if(f&&g.shadow||!f){let e=a.querySelector(".swiper-slide-shadow");if(!e&&g.shadow&&(e=ge("creative",a)),e){const t=r.shadowPerProgress?c*(1/r.limitProgress):c;e.style.opacity=Math.min(Math.max(Math.abs(t),0),1)}}const x=he(0,a);x.style.transform=E,x.style.opacity=y,g.origin&&(x.style.transformOrigin=g.origin)}},setTransition:e=>{const s=t.slides.map((e=>h(e)));s.forEach((t=>{t.style.transitionDuration=`${e}ms`,t.querySelectorAll(".swiper-slide-shadow").forEach((t=>{t.style.transitionDuration=`${e}ms`}))})),fe({swiper:t,duration:e,transformElements:s,allSlides:!0})},perspective:()=>t.params.creativeEffect.perspective,overwriteParams:()=>({watchSlidesProgress:!0,virtualTranslate:!t.params.cssMode})})},function(e){let{swiper:t,extendParams:s,on:a}=e;s({cardsEffect:{slideShadows:!0,rotate:!0,perSlideRotate:2,perSlideOffset:8}}),me({effect:"cards",swiper:t,on:a,setTranslate:()=>{const{slides:e,activeIndex:s,rtlTranslate:a}=t,i=t.params.cardsEffect,{startTranslate:r,isTouched:n}=t.touchEventsData,l=a?-t.translate:t.translate;for(let o=0;o<e.length;o+=1){const d=e[o],c=d.progress,p=Math.min(Math.max(c,-4),4);let u=d.swiperSlideOffset;t.params.centeredSlides&&!t.params.cssMode&&(t.wrapperEl.style.transform=`translateX(${t.minTranslate()}px)`),t.params.centeredSlides&&t.params.cssMode&&(u-=e[0].swiperSlideOffset);let m=t.params.cssMode?-u-t.translate:-u,h=0;const f=-100*Math.abs(p);let g=1,v=-i.perSlideRotate*p,w=i.perSlideOffset-.75*Math.abs(p);const b=t.virtual&&t.params.virtual.enabled?t.virtual.from+o:o,y=(b===s||b===s-1)&&p>0&&p<1&&(n||t.params.cssMode)&&l<r,E=(b===s||b===s+1)&&p<0&&p>-1&&(n||t.params.cssMode)&&l>r;if(y||E){const e=(1-Math.abs((Math.abs(p)-.5)/.5))**.5;v+=-28*p*e,g+=-.5*e,w+=96*e,h=-25*e*Math.abs(p)+"%"}if(m=p<0?`calc(${m}px ${a?"-":"+"} (${w*Math.abs(p)}%))`:p>0?`calc(${m}px ${a?"-":"+"} (-${w*Math.abs(p)}%))`:`${m}px`,!t.isHorizontal()){const e=h;h=m,m=e}const x=p<0?""+(1+(1-g)*p):""+(1-(1-g)*p),S=`\n        translate3d(${m}, ${h}, ${f}px)\n        rotateZ(${i.rotate?a?-v:v:0}deg)\n        scale(${x})\n      `;if(i.slideShadows){let e=d.querySelector(".swiper-slide-shadow");e||(e=ge("cards",d)),e&&(e.style.opacity=Math.min(Math.max((Math.abs(p)-.5)/.5,0),1))}d.style.zIndex=-Math.abs(Math.round(c))+e.length;he(0,d).style.transform=S}},setTransition:e=>{const s=t.slides.map((e=>h(e)));s.forEach((t=>{t.style.transitionDuration=`${e}ms`,t.querySelectorAll(".swiper-slide-shadow").forEach((t=>{t.style.transitionDuration=`${e}ms`}))})),fe({swiper:t,duration:e,transformElements:s})},perspective:()=>!0,overwriteParams:()=>({_loopSwapReset:!1,watchSlidesProgress:!0,loopAdditionalSlides:t.params.cardsEffect.rotate?3:2,centeredSlides:!0,virtualTranslate:!t.params.cssMode})})}];return re.use(ve),re}();
// Swiper

// 封装事件绑定
$(document).find(".evt").click(function () {    
        let $dom = $(this);
        let $actionNameArr = $dom.attr("evt").split(";");
        if($actionNameArr.length >= 1){
            $actionNameArr.forEach(function ($action) {
                let $actionName = $action.split("=")[0];
                let $actionValue = $action.split("=")[1];
                $dom.on($actionName,function ($event) {
                        $event.stopPropagation();
                        $event.preventDefault();
                        eval($actionValue+"($dom)")
                })
            })
        }

});

// Video Modal (Global)
(function () {
    function getModalEls() {
        var modal = document.getElementById('videoModal');
        if (!modal) return null;
        return {
            modal: modal,
            iframe: document.getElementById('videoModalIframe'),
            video: document.getElementById('videoModalVideo'),
            backdrop: modal.querySelector('.video-modal-backdrop'),
            closeBtn: modal.querySelector('.video-modal-close')
        };
    }

    function isDirectVideoUrl(url) {
        if (!url) return false;
        url = String(url).trim();
        if (/\.(mp4|webm|ogg|mov)(\?|#|$)/i.test(url)) {
            return true;
        }
        return url.indexOf('/upload/') >= 0 || url.indexOf('/storage/') >= 0;
    }

    function normalizeVideoUrl(url) {
        if (!url) return '';
        url = String(url).trim();
        if (!url) return '';
        if (isDirectVideoUrl(url)) {
            return url;
        }

        function youtubeEmbedParams() {
            return 'autoplay=1&rel=0&modestbranding=1&playsinline=1&vq=hd1080&hd=1';
        }

        function extractYoutubeId(raw) {
            if (!raw) return '';
            raw = String(raw).trim();
            var m = raw.match(/(?:youtube\.com\/(?:watch\?(?:.*&)?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{6,})/i);
            if (m && m[1]) return m[1];
            try {
                var u = new URL(raw, window.location.origin);
                if (u.hostname.indexOf('youtu.be') >= 0) {
                    return u.pathname.replace(/^\//, '').split('/')[0] || '';
                }
                if (u.hostname.indexOf('youtube.com') >= 0) {
                    return u.searchParams.get('v') || '';
                }
            } catch (e) {}
            return '';
        }

        try {
            var vid = extractYoutubeId(url);
            if (vid) {
                return 'https://www.youtube.com/embed/' + encodeURIComponent(vid) + '?' + youtubeEmbedParams();
            }
        } catch (e) {}

        if (url.indexOf('youtube.com/embed/') >= 0) {
            if (url.indexOf('?') >= 0) {
                if (url.indexOf('vq=') < 0) url += '&vq=hd1080&hd=1';
                if (url.indexOf('autoplay=') < 0) url += '&autoplay=1';
                if (url.indexOf('rel=') < 0) url += '&rel=0';
                return url;
            }
            return url + '?' + youtubeEmbedParams();
        }

        if (url.indexOf('?') >= 0) {
            if (url.indexOf('autoplay=') < 0) {
                url += '&autoplay=1';
            }
            return url;
        }
        return url + '?autoplay=1';
    }

    function openVideoModal(url) {
        var els = getModalEls();
        if (!els) return;
        url = String(url || '').trim();
        if (!url) return;

        els.modal.classList.remove('hidden');
        els.modal.setAttribute('aria-hidden', 'false');
        document.documentElement.classList.add('overflow-hidden');
        document.body.classList.add('overflow-hidden');

        if (isDirectVideoUrl(url) && els.video) {
            if (els.iframe) {
                els.iframe.classList.add('hidden');
                els.iframe.setAttribute('src', '');
            }
            els.video.classList.remove('hidden');
            els.video.setAttribute('src', url);
            if (typeof els.video.play === 'function') {
                els.video.play().catch(function () {});
            }
            return;
        }

        var src = normalizeVideoUrl(url);
        if (!src) return;
        if (els.video) {
            els.video.classList.add('hidden');
            if (typeof els.video.pause === 'function') {
                els.video.pause();
            }
            els.video.removeAttribute('src');
        }
        if (els.iframe) {
            els.iframe.classList.remove('hidden');
            els.iframe.setAttribute('src', src);
        }
    }

    function closeVideoModal() {
        var els = getModalEls();
        if (!els) return;
        els.modal.classList.add('hidden');
        els.modal.setAttribute('aria-hidden', 'true');
        if (els.iframe) {
            els.iframe.setAttribute('src', '');
            els.iframe.classList.remove('hidden');
        }
        if (els.video) {
            if (typeof els.video.pause === 'function') {
                els.video.pause();
            }
            els.video.removeAttribute('src');
            els.video.classList.add('hidden');
        }
        document.documentElement.classList.remove('overflow-hidden');
        document.body.classList.remove('overflow-hidden');
    }

    document.addEventListener('click', function (e) {
        var target = e.target;
        var trigger = target && target.closest ? target.closest('.js-video-modal') : null;
        if (!trigger) return;

        var url = trigger.getAttribute('data-video-url') || trigger.getAttribute('href');
        if (!url || url === '#') return;
        e.preventDefault();
        e.stopPropagation();
        openVideoModal(url);
    });

    document.addEventListener('click', function (e) {
        var els = getModalEls();
        if (!els) return;
        if (els.modal.classList.contains('hidden')) return;

        var target = e.target;
        if (target === els.backdrop || (els.closeBtn && target.closest && target.closest('.video-modal-close'))) {
            e.preventDefault();
            closeVideoModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        var els = getModalEls();
        if (!els) return;
        if (els.modal.classList.contains('hidden')) return;
        closeVideoModal();
    });

    window.openVideoModal = openVideoModal;
    window.closeVideoModal = closeVideoModal;
})();
// 封装事件绑定

// Ajax请求封装
function ajax(options) {
    options = options || {};
    var method = (options.method || 'GET').toUpperCase();
    var url = options.url || '';
    var params = options.params || null;
    var data = options.data || null;
    var headers = options.headers || {};
    var timeout = typeof options.timeout === 'number' ? options.timeout : 15000;
    var responseType = options.responseType || 'json';
    var withCredentials = !!options.withCredentials;

    if (!url) {
        return Promise.reject(new Error('ajax: options.url is required'));
    }

    var buildQuery = function (obj) {
        if (!obj) return '';
        if (typeof obj === 'string') return obj;
        var parts = [];
        Object.keys(obj).forEach(function (k) {
            var v = obj[k];
            if (v === undefined || v === null) return;
            if (Array.isArray(v)) {
                v.forEach(function (item) {
                    if (item === undefined || item === null) return;
                    parts.push(encodeURIComponent(k) + '=' + encodeURIComponent(String(item)));
                });
            } else {
                parts.push(encodeURIComponent(k) + '=' + encodeURIComponent(String(v)));
            }
        });
        return parts.join('&');
    };

    var query = buildQuery(params);
    if (query) {
        url += (url.indexOf('?') >= 0 ? '&' : '?') + query;
    }

    return new Promise(function (resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open(method, url, true);
        xhr.timeout = timeout;
        xhr.withCredentials = withCredentials;

        Object.keys(headers).forEach(function (k) {
            xhr.setRequestHeader(k, headers[k]);
        });

        var body = null;
        if (method !== 'GET' && method !== 'HEAD') {
            if (data === undefined) data = null;
            if (data === null) {
                body = null;
            } else if (typeof data === 'string' || (typeof FormData !== 'undefined' && data instanceof FormData)) {
                body = data;
            } else {
                var contentTypeKey = Object.keys(headers).find(function (k) {
                    return k.toLowerCase() === 'content-type';
                });
                var contentType = contentTypeKey ? headers[contentTypeKey] : '';
                if (!contentType) {
                    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
                    body = JSON.stringify(data);
                } else if (String(contentType).toLowerCase().indexOf('application/json') >= 0) {
                    body = JSON.stringify(data);
                } else if (String(contentType).toLowerCase().indexOf('application/x-www-form-urlencoded') >= 0) {
                    body = buildQuery(data);
                } else {
                    body = data;
                }
            }
        }

        xhr.onreadystatechange = function () {
            if (xhr.readyState !== 4) return;

            var status = xhr.status;
            var raw = xhr.responseText;
            var res = raw;
            if (responseType === 'json') {
                try {
                    res = raw ? JSON.parse(raw) : null;
                } catch (e) {
                    reject({
                        message: 'Invalid JSON response',
                        status: status,
                        url: url,
                        raw: raw,
                        error: e
                    });
                    return;
                }
            }

            if (status >= 200 && status < 300) {
                resolve(res);
            } else {
                reject({
                    message: 'HTTP Error',
                    status: status,
                    url: url,
                    response: res,
                    raw: raw
                });
            }
        };

        xhr.onerror = function () {
            reject({ message: 'Network Error', status: xhr.status || 0, url: url });
        };

        xhr.ontimeout = function () {
            reject({ message: 'Timeout', status: xhr.status || 0, url: url });
        };

        xhr.send(body);
    });
}
ajax.get = function (url, params, options) {
    options = options || {};
    return ajax(Object.assign({}, options, { method: 'GET', url: url, params: params }));
};
ajax.post = function (url, data, options) {
    options = options || {};
    return ajax(Object.assign({}, options, { method: 'POST', url: url, data: data }));
};
// Ajax请求封装

// 消息弹框提示封装
// 类似 Element Plus Message：支持 info / success / warning / error
// 用法：showMessage({ type: 'success', message: 'Saved!', duration: 3000 });
;(function () {
    var MESSAGE_TYPES = ['info', 'success', 'warning', 'error'];
    var DEFAULT_DURATION = 3000;

    function createContainer() {
        var existing = document.querySelector('.global-message-container');
        if (existing) return existing;

        var container = document.createElement('div');
        container.className = 'global-message-container';
        container.style.position = 'fixed';
        container.style.zIndex = '9999';
        container.style.left = '50%';
        container.style.top = '20px';
        container.style.transform = 'translateX(-50%)';
        container.style.display = 'flex';
        container.style.flexDirection = 'column';
        container.style.alignItems = 'center';
        container.style.gap = '10px';
        container.style.pointerEvents = 'none';
        document.body.appendChild(container);
        return container;
    }

    function getBgColor(type) {
        switch (type) {
            case 'success':
                return 'rgba(34,197,94,0.96)'; // 绿色
            case 'warning':
                return 'rgba(245,158,11,0.96)'; // 橙色
            case 'error':
                return 'rgba(239,68,68,0.96)'; // 红色
            case 'info':
            default:
                return 'rgba(15,23,42,0.96)'; // 深色
        }
    }

    function showMessage(options) {
        if (!options) return;

        var type = (options.type || 'info').toLowerCase();
        if (MESSAGE_TYPES.indexOf(type) === -1) type = 'info';

        var message = options.message || '';
        var duration = typeof options.duration === 'number' ? options.duration : DEFAULT_DURATION;

        if (!message) return;

        var container = createContainer();

        var item = document.createElement('div');
        item.className = 'global-message-item';
        item.style.minWidth = '220px';
        item.style.maxWidth = '360px';
        item.style.padding = '10px 16px';
        item.style.borderRadius = '9999px';
        item.style.display = 'flex';
        item.style.alignItems = 'center';
        item.style.justifyContent = 'center';
        item.style.backgroundColor = getBgColor(type);
        item.style.color = '#ffffff';
        item.style.fontSize = '14px';
        item.style.fontFamily = '\'Poppins-Regular\', system-ui, -apple-system, BlinkMacSystemFont, \'Segoe UI\', sans-serif';
        item.style.boxShadow = '0 8px 24px rgba(15,23,42,0.35)';
        item.style.pointerEvents = 'auto';
        item.style.opacity = '0';
        item.style.transform = 'translateY(-6px)';
        item.style.transition = 'opacity 0.2s ease, transform 0.2s ease';

        // 简单图标
        var icon = document.createElement('span');
        icon.style.marginRight = '8px';
        icon.style.fontSize = '16px';
        icon.textContent =
            type === 'success' ? '✔' :
            type === 'warning' ? '!' :
            type === 'error'   ? '✖' : 'ℹ';

        var text = document.createElement('span');
        text.textContent = message;

        item.appendChild(icon);
        item.appendChild(text);
        container.appendChild(item);

        // 进入动画
        requestAnimationFrame(function () {
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        });

        var closed = false;
        function close() {
            if (closed) return;
            closed = true;
            item.style.opacity = '0';
            item.style.transform = 'translateY(-6px)';
            setTimeout(function () {
                if (item.parentNode === container) {
                    container.removeChild(item);
                }
                if (!container.children.length && container.parentNode) {
                    container.parentNode.removeChild(container);
                }
            }, 200);
        }

        // 点击立即关闭
        item.addEventListener('click', close);

        // 定时关闭
        if (duration > 0) {
            setTimeout(close, duration);
        }

        return { close: close };
    }

    // 暴露到全局：window.showMessage / window.$message
    window.showMessage = showMessage;
    window.$message = showMessage;
})();
// 消息弹框提示封装 end

// 消息确认弹框
(function() {
    function showConfirm(message, onConfirm, onCancel) {
        var overlay = $('<div class="fixed inset-0 bg-black/50 z-[9999] flex items-center justify-center"></div>');
        var dialog = $('<div class="bg-white rounded-lg shadow-xl p-6 min-w-[420px]"></div>');
        var content = $('<div class="text-f16 text-gray-800 mb-6">' + message + '</div>');
        var footer = $('<div class="flex justify-end gap-3"></div>');
        var cancelBtn = $('<button class="px-4 py-2 text-f14 border border-gray-300 rounded hover:bg-gray-50">取消</button>');
        var confirmBtn = $('<button class="px-4 py-2 text-f14 bg-blue-500 text-white rounded hover:bg-blue-600">确定</button>');

        footer.append(cancelBtn, confirmBtn);
        dialog.append(content, footer);
        overlay.append(dialog);
        $('body').append(overlay);

        cancelBtn.on('click', function() {
            overlay.remove();
            if (onCancel) onCancel();
        });

        confirmBtn.on('click', function() {
            overlay.remove();
            if (onConfirm) onConfirm();
        });

        overlay.on('click', function(e) {
            if (e.target === overlay[0]) {
                overlay.remove();
                if (onCancel) onCancel();
            }
        });
    }

    window.showConfirm = showConfirm;
    window.$confirm = showConfirm;
})();
// 消息确认弹框

// 图片预览弹框
(function() {
    function showImagePreview(images, initialIndex = 0) {
        var overlay = $('<div class="fixed inset-0 bg-black/90 z-[9999] flex items-center justify-center"></div>');
        var closeBtn = $('<button class="absolute top-4 right-4 z-10 text-white text-f32 w-10 h-10 flex items-center justify-center hover:bg-white/10 rounded">&times;</button>');
        var container = $('<div class="swiper w-full h-full max-w-[90vw] max-h-[90vh]"></div>');
        var wrapper = $('<div class="swiper-wrapper"></div>');

        images.forEach(function(img) {
            var slide = $('<div class="swiper-slide flex items-center justify-center"><img src="' + img + '" class="max-w-full max-h-full object-contain" /></div>');
            wrapper.append(slide);
        });

        var prevBtn = $('<div class="swiper-button-prev"></div>');
        var nextBtn = $('<div class="swiper-button-next"></div>');

        container.append(wrapper, prevBtn, nextBtn);
        overlay.append(closeBtn, container);
        $('body').append(overlay);

        var swiper = new Swiper(container[0], {
            initialSlide: initialIndex,
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            keyboard: true,
            loop: images.length > 1
        });

        closeBtn.on('click', function() { overlay.remove(); });
        overlay.on('click', function(e) { if (e.target === overlay[0]) overlay.remove(); });
    }

    window.showImagePreview = showImagePreview;
})();

$(document).on('click', '.preview-img', function() {
    var images = [$(this).attr('src')]
    showImagePreview(images, 0);
});

$(document).on('click', '.swiper-slide-preview img', function() {
    var container = $(this).closest('.swiper-container, .swiper');
    var images = container.find('.swiper-slide-preview img').map(function() { return $(this).attr('src'); }).get();
    var index = container.find('.swiper-slide-preview img').index(this);
    showImagePreview(images, index);
});
// 图片预览弹框


// 模态框
(function() {
    function showModal(content, width) {
        var maxWidth = 'calc(100vw - 30px)';
        var modalWidth = width ? (typeof width === 'number' ? width + 'px' : width) : '600px';

        var overlay = $('<div class="fixed inset-0 bg-black/50 z-[9999] flex items-center justify-center p-4"></div>');
        var modal = $('<div class="bg-white rounded-lg shadow-xl relative max-h-[90vh] overflow-auto"></div>');
        modal.css({ width: modalWidth, maxWidth: maxWidth });

        var closeBtn = $('<button class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-black/70 hover:bg-black/80 text-white text-f20 leading-none transition-transform hover:rotate-90">&times;</button>');
        var contentDiv = $('<div class="p-6"></div>').append(content);

        modal.append(closeBtn, contentDiv);
        overlay.append(modal);
        $('body').append(overlay);

        closeBtn.on('click', function() { overlay.remove(); });
        overlay.on('click', function(e) { if (e.target === overlay[0]) overlay.remove(); });

        return { close: function() { overlay.remove(); }, element: modal };
    }

    window.showModal = showModal;
})();
// 模态框


// 加载动画
(function() {
    var loadingInstance = null;

    function showLoading(text) {
        if (loadingInstance) return loadingInstance;

        text = text || 'Loading...';
        var overlay = $('<div class="fixed inset-0 bg-black/60 z-[10000] flex items-center justify-center"></div>');
        var container = $('<div class="flex flex-col items-center gap-4"></div>');

        var spinner = $('<div class="relative w-16 h-16 md:w-20 md:h-20"></div>');
        for (var i = 0; i < 3; i++) {
            var ring = $('<div class="absolute inset-0 border-4 border-transparent rounded-full animate-spin"></div>');
            ring.css({
                borderTopColor: '#D92B28',
                animationDuration: (1.5 + i * 0.3) + 's',
                animationDelay: (i * 0.2) + 's'
            });
            spinner.append(ring);
        }

        var textEl = $('<div class="text-white text-f16 md:text-f18 font-medium animate-pulse">' + text + '</div>');
        container.append(spinner, textEl);
        overlay.append(container);
        $('body').append(overlay);

        loadingInstance = {
            close: function() {
                overlay.remove();
                loadingInstance = null;
            },
            updateText: function(newText) {
                textEl.text(newText);
            }
        };

        return loadingInstance;
    }

    function hideLoading() {
        if (loadingInstance) {
            loadingInstance.close();
        }
    }

    window.showLoading = showLoading;
    window.hideLoading = hideLoading;
})();
// 加载动画


$(function () {
    /** 滚动固定头部 **/
    (function () {
        var $header = $('header.pointer-events-none');
        var stickyOffset = 100; // 滚动100px后固定
        var isSticky = false;

        if (!$header.length) return;

        function handleScroll() {
            var scrollTop = $(window).scrollTop();

            if (scrollTop > stickyOffset && !isSticky) {
                // 添加固定样式
                $header.addClass('!fixed !bg-white !shadow-[0_4px_12px_rgba(0,0,0,0.15)]');
                isSticky = true;
            } else if (scrollTop <= stickyOffset && isSticky) {
                // 移除固定样式
                $header.removeClass('!fixed !bg-white !shadow-[0_4px_12px_rgba(0,0,0,0.15)]');
                isSticky = false;
            }
        }

        // 监听滚动事件
        $(window).on('scroll', handleScroll);
        
        // 初始检查
        handleScroll();
    })();
    /** 滚动固定头部 **/

    /** 搜索功能 **/
    //  打开搜索框
    $(document).on('click', '.search-trigger', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('.search_popup').addClass('search_popup_active');
    });
    //  关闭搜索框
    $(document).on('click', '.search_popup button[aria-label="Close search"]', function (e) {
        e.preventDefault();
        $('.search_popup').removeClass('search_popup_active');
    });
    //  点击搜索框外部关闭搜索框
    $(document).on('click', '.search_popup > div[aria-hidden="true"]', function (e) {
        e.preventDefault();
        $('.search_popup').removeClass('search_popup_active');
    });
    // 点击搜索框内容区域不关闭
    $(document).on('click', '.search_main', function (e) {
        e.stopPropagation();
    });
    // 点击非 .search_main 且非 .search-trigger 的区域关闭
    $(document).on('click', function (e) {
        var $popup = $('.search_popup');
        if (!$popup.hasClass('search_popup_active')) return;
        var $target = $(e.target);
        if ($target.closest('.search_main').length) return;
        if ($target.closest('.search-trigger').length) return;
        $popup.removeClass('search_popup_active');
    });
    // 点击搜索快捷标签，跳转到搜索页
    $(document).on('click', '.search_popup .search_main a', function (e) {
        var $a = $(this);
        var text = $.trim($a.text());
        if (!text) return;
        e.preventDefault();
        e.stopPropagation();
        window.location.href = '/search?q=' + encodeURIComponent(text);
    });
     /** 搜索功能 **/

    (function () {
        function isMobile() {
            return window.matchMedia && window.matchMedia('(max-width: 767px)').matches;
        }

        function openPopup() {
            $('.inquiry_popup').addClass('inquiry_popup_active');
        }

        function closePopup() {
            $('.inquiry_popup').removeClass('inquiry_popup_active');
        }

        $(document).on('click', '.inquiry-entry a[aria-label="Leave a message"]', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var $popup = $('.inquiry_popup');
            if ($popup.hasClass('inquiry_popup_active')) {
                closePopup();
                return;
            }
            openPopup();
        });

        $(document).on('click', '.inquiry_popup .inquiry_popup_close', function (e) {
            e.preventDefault();
            closePopup();
        });

        $(document).on('click', '.inquiry_popup .inquiry_popup_backdrop', function (e) {
            e.preventDefault();
            closePopup();
        });

        $(document).on('click', '.inquiry_popup .inquiry_popup_panel', function (e) {
            e.stopPropagation();
        });

        $(document).on('click', function (e) {
            var $popup = $('.inquiry_popup');
            if (!$popup.hasClass('inquiry_popup_active')) return;
            var $target = $(e.target);
            if ($target.closest('.inquiry_popup_panel').length) return;
            if ($target.closest('.inquiry-entry').length) return;
            if (!isMobile()) {
                closePopup();
            }
        });

        $(window).on('resize', function () {
            var $popup = $('.inquiry_popup');
            if (!$popup.hasClass('inquiry_popup_active')) return;
            if (!isMobile()) {
                $popup.find('.inquiry_popup_backdrop').hide();
            } else {
                $popup.find('.inquiry_popup_backdrop').show();
            }
        });
    })();

    /** Footer Accordion ( < 1080px ) **/
    (function () {
        var $accordions = $('[data-footer-accordion]');
        if (!$accordions.length) return;

        var mq = window.matchMedia ? window.matchMedia('(min-width: 1081px)') : null;

        function setDesktopMode(isDesktop) {
            if (isDesktop) {
                $accordions.each(function () {
                    this.open = true;
                });
            } else {
                $accordions.each(function () {
                    this.open = false;
                });
            }
        }

        function handleSummaryClick(e) {
            if (mq && mq.matches) {
                e.preventDefault();
                e.stopPropagation();
            }
        }

        $accordions.each(function () {
            var $d = $(this);
            var $summary = $d.children('summary');
            if ($summary.length) {
                $summary.on('click', handleSummaryClick);
            }
        });

        function apply() {
            setDesktopMode(mq ? mq.matches : false);
        }

        apply();
        if (mq) {
            if (typeof mq.addEventListener === 'function') {
                mq.addEventListener('change', apply);
            } else if (typeof mq.addListener === 'function') {
                mq.addListener(apply);
            }
        } else {
            $(window).on('resize', apply);
        }
    })();
    /** Footer Accordion ( < 1080px ) **/

    /** Header 吸顶 **/
    (function () {
        var $header = $('.header-nav');
        if (!$header.length) return;
        var $logo = $header.find('img.header-logo');
        var defaultLogo = $logo.attr('data-default-src') || $logo.attr('src');
        var stickyLogo = $logo.attr('data-sticky-src') || defaultLogo;
        var stickyThreshold = 150;
        function setSticky(isSticky) {
            if (isSticky) {
                if (!$header.hasClass('is-sticky')) {
                    $header.addClass('is-sticky');
                    if ($logo.length) $logo.attr('src', stickyLogo);
                }
            } else {
                if ($header.hasClass('is-sticky')) {
                    $header.removeClass('is-sticky');
                    if ($logo.length) $logo.attr('src', defaultLogo);
                }
            }
        }
        function onScroll() {
            var y = window.pageYOffset || document.documentElement.scrollTop || 0;
            setSticky(y > stickyThreshold);
        }
        onScroll();
        $(window).on('scroll', onScroll);
        $(window).on('resize', function () {
            onScroll();
        });
    })();
    /** Header 吸顶 **/

    /** Back To Top **/
    (function () {
        var $btn = $('#backToTop, #backToTopBtn');
        if (!$btn.length) return;

        var showThreshold = 450;

        function setVisible(visible) {
            if (visible) {
                $btn.removeClass('opacity-0 translate-y-2 pointer-events-none');
                $btn.addClass('opacity-100 translate-y-0');
            } else {
                $btn.removeClass('opacity-100 translate-y-0');
                $btn.addClass('opacity-0 translate-y-2 pointer-events-none');
            }
        }

        function onBtnScroll() {
            var y = window.pageYOffset || document.documentElement.scrollTop || 0;
            setVisible(y > showThreshold);
        }

        $btn.on('click', function (e) {
            e.preventDefault();
            window.scrollTo(0, 0);
        });

        onBtnScroll();
        $(window).on('scroll', onBtnScroll);
        $(window).on('resize', onBtnScroll);
    })();
    /** Back To Top **/

    /** Mobile Nav ( < 992px ) **/   
    (function () {
        var $menu = $('#mobileMenu');
        var $panel = $('#mobileMenuPanel');
        var $backdrop = $('#mobileMenuBackdrop');
        var $openBtn = $(document).find('#mobileMenuBtn');
        var $closeBtn = $('#mobileMenuClose');

        function isMenuReady() {
            return $menu.length && $panel.length && $openBtn.length;
        }

        function openMenu() {
            if (!isMenuReady()) return;
            $menu.removeClass('pointer-events-none opacity-0').addClass('opacity-100').attr('aria-hidden', 'false');
            $panel.removeClass('-translate-x-full').addClass('translate-x-0');
            $('body').addClass('overflow-hidden');
        }

        function closeMenu() {
            if (!isMenuReady()) return;
            $menu.find('.mobile-menu-toggle').each(function () {
                var $t = $(this);
                $t.attr('aria-expanded', 'false');
                $t.find('svg').removeClass('rotate-180');
                var sel = $t.attr('data-target');
                if (sel) $(sel).addClass('hidden');
            });
            $panel.removeClass('translate-x-0').addClass('-translate-x-full');
            $menu.removeClass('opacity-100').addClass('opacity-0 pointer-events-none').attr('aria-hidden', 'true');
            $('body').removeClass('overflow-hidden');
        }   
        if (isMenuReady()) {
            $openBtn.on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                openMenu();
            });
        }

        if ($closeBtn.length) {
            $closeBtn.on('click', function (e) {
                e.preventDefault();
                closeMenu();
            });
        }

        if ($backdrop.length) {
            $backdrop.on('click', function (e) {
                e.preventDefault();
                closeMenu();
            });
        }

        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') closeMenu();
        });

        $menu.find('a').on('click', function () {
            closeMenu();
        });

        // 侧栏 Get In Touch：先关菜单，再打开与底部询盘图标相同的公共询盘弹框
        $menu.on('click', '.mobile-menu-get-in-touch', function (e) {
            e.preventDefault();
            e.stopPropagation();
            closeMenu();
            $('.wishlist_popup').removeClass('wishlist_popup_active');
            $('.inquiry_popup').addClass('inquiry_popup_active');
        });

        $panel.on('click', '.mobile-menu-toggle', function (e) {
            e.preventDefault();
            var $toggle = $(this);
            var target = $toggle.attr('data-target');
            if (!target) return;

            var $target = $(target);
            if (!$target.length) return;

            var isOpen = !$target.hasClass('hidden');
            if (isOpen) {
                $target.addClass('hidden');
                $toggle.attr('aria-expanded', 'false');
                $toggle.find('svg').removeClass('rotate-180');
            } else {
                $target.removeClass('hidden');
                $toggle.attr('aria-expanded', 'true');
                $toggle.find('svg').addClass('rotate-180');
            }
        });

        var $langBtn = $('#mobileLangBtn');
        var $langDropdown = $('#mobileLangDropdown');

        function closeLang() {
            if ($langDropdown.length) $langDropdown.addClass('hidden');
        }

        if ($langBtn.length && $langDropdown.length) {
            $langBtn.on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $langDropdown.toggleClass('hidden');
            });

            $langDropdown.on('click', function (e) {
                e.stopPropagation();
            });

            $(document).on('click', function () {
                closeLang();
            });
        }
    })();
    /** Mobile Nav ( < 992px ) **/

    // Close all popups
    function closeAll() {
        $('.inquiry_popup').removeClass('inquiry_popup_active');
        $('.wishlist_popup').removeClass('wishlist_popup_active');
    }

    // Inquiry popup toggle
    $('.inquiry-entry-btn').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $popup = $('.inquiry_popup');
        $('.wishlist_popup').removeClass('wishlist_popup_active');
        $popup.toggleClass('inquiry_popup_active');
    });

    // Wishlist popup toggle
    $('.wishlist-entry-btn').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $popup = $('.wishlist_popup');
        $('.inquiry_popup').removeClass('inquiry_popup_active');
        $popup.toggleClass('wishlist_popup_active');
    });

    // Prevent clicks inside panels from closing
    $('.inquiry_popup .inquiry_popup_panel').on('click', function (e) {
        e.stopPropagation();
    });
    $('.wishlist_popup .wishlist_popup_panel').on('click', function (e) {
        e.stopPropagation();
    });

    // Close button
    $('.inquiry_popup .inquiry_popup_close').on('click', function (e) {
        e.preventDefault();
        $('.inquiry_popup').removeClass('inquiry_popup_active');
    });
    $('.wishlist_popup .wishlist_popup_close').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('.wishlist_popup').removeClass('wishlist_popup_active');
    });

    // Backdrop clicks
    $('.inquiry_popup .inquiry_popup_backdrop').on('click', function () {
        $('.inquiry_popup').removeClass('inquiry_popup_active');
    });
    $('.wishlist_popup .wishlist_popup_backdrop').on('click', function () {
        $('.wishlist_popup').removeClass('wishlist_popup_active');
    });

    // Inquiry popup submit (source URL only — no attachments / product id)
    $(document).on('submit', '.inquiry_popup form', function (e) {
        e.preventDefault();
        var $form = $(this);
        var formEl = $form[0];
        if (!formEl) return;

        var email = ($form.find('input[name="email"]').val() || '').trim();
        var content = ($form.find('textarea[name="content"]').val() || '').trim();
        if (!email || !content) {
            if (typeof showMessage === 'function') {
                showMessage({ type: 'warning', message: 'Please fill in required fields.' });
            }
            return;
        }

        var fd = new FormData();
        fd.set('email', email);
        fd.set('tel', ($form.find('input[name="tel"]').val() || '').trim());
        fd.set('content', content);
        fd.set('source_url', window.location.href);

        var $btn = $form.find('button[type="submit"]');
        $btn.prop('disabled', true);

        ajax.post('/api/inquiry-popup', fd, { timeout: 60000 }).then(function (res) {
            if (res && res.success) {
                if (typeof showMessage === 'function') {
                    showMessage({ type: 'success', message: 'Message successfully!' });
                }
                formEl.reset();
                syncInquiryFormMeta();
                $('.inquiry_popup').removeClass('inquiry_popup_active');
                window.location.href = (res && res.redirect) ? res.redirect : '/inquirysuccess';
                return;
            }
            if (typeof showMessage === 'function') {
                showMessage({ type: 'error', message: (res && res.message) ? res.message : 'Submit failed' });
            }
        }).catch(function (err) {
            var msg = 'Submit failed';
            if (err && err.response) {
                if (err.response.message) msg = err.response.message;
                else if (err.response.errors) {
                    var first = Object.values(err.response.errors)[0];
                    if (Array.isArray(first) && first[0]) msg = first[0];
                }
            }
            if (typeof showMessage === 'function') {
                showMessage({ type: 'error', message: msg });
            }
        }).finally(function () {
            $btn.prop('disabled', false);
        });
    });

    function syncInquiryFormMeta() {
        var pageUrl = window.location.href;
        document.querySelectorAll('.js-inquiry-source-url').forEach(function (el) {
            el.value = pageUrl;
        });
        document.querySelectorAll('.js-inquiry-popup-source-url').forEach(function (el) {
            el.value = pageUrl;
        });

        var pidEl = document.getElementById('product_id');
        var productId = 0;
        if (pidEl) {
            var parsed = parseInt((pidEl.value || pidEl.textContent || '0'), 10);
            if (!isNaN(parsed) && parsed > 0) productId = parsed;
        }

        document.querySelectorAll('.ask_us form, .ask-us-form, .ask_us_form form').forEach(function (form) {
            var hidden = form.querySelector('input[name="product_id"]');
            if (productId > 0) {
                if (!hidden) {
                    hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'product_id';
                    hidden.className = 'js-inquiry-product-id';
                    form.insertBefore(hidden, form.firstChild);
                }
                hidden.value = String(productId);
            } else if (hidden) {
                hidden.remove();
            }
        });
    }

    syncInquiryFormMeta();
    window.addEventListener('popstate', syncInquiryFormMeta);

    // Ask Us / Contact inquiry forms (multipart with attachments)
    $(document).on('submit', '.ask_us form, .ask-us-form, .ask_us_form form', function (e) {
        e.preventDefault();
        var $form = $(this);
        var formEl = $form[0];
        if (!formEl) return;

        var name = ($form.find('[name="name"]').val() || '').trim();
        var email = ($form.find('[name="email"]').val() || '').trim();
        var $tel = $form.find('[name="tel"]');
        var tel = ($tel.val() || '').trim();
        // contact_us 等：input 无 required 时电话可选；ask_us 带 required 仍必填
        var telRequired = $tel.length > 0 && $tel.is('[required]');
        var content = ($form.find('[name="content"]').val() || '').trim();
        if (!name || !email || (telRequired && !tel) || !content) {
            if (typeof showMessage === 'function') {
                showMessage({ type: 'warning', message: 'Please fill in required fields.' });
            }
            return;
        }

        var productId = 0;
        var $pidField = $form.find('input[name="product_id"]');
        if ($pidField.length) {
            var pv = parseInt(($pidField.val() || '0'), 10);
            if (!isNaN(pv) && pv > 0) productId = pv;
        } else {
            var $pid = $('#product_id');
            if ($pid.length) {
                pv = parseInt(($pid.val ? $pid.val() : $pid.text()) || '0', 10);
                if (!isNaN(pv) && pv > 0) productId = pv;
            }
        }

        var fd = new FormData(formEl);
        fd.set('name', name);
        fd.set('email', email);
        fd.set('tel', tel);
        fd.set('content', content);
        fd.set('source_url', window.location.href);
        if (productId > 0) {
            fd.set('product_id', String(productId));
        } else {
            fd.delete('product_id');
        }
        if (!fd.has('quantity')) {
            fd.set('quantity', ($form.find('[name="quantity"]').val() || '').trim());
        }
        // 用附件区内存文件列表覆盖 FormData，保证回显删除后提交一致
        fd.delete('attachments[]');
        fd.delete('attachments');
        formEl.querySelectorAll('.js-inquiry-attachment').forEach(function (wrap) {
            var files = wrap._inquiryFiles || [];
            files.forEach(function (f) {
                fd.append('attachments[]', f, f.name);
            });
        });

        var $btn = $form.find('button[type="submit"]');
        $btn.prop('disabled', true);

        ajax.post('/api/ask-us-inquiry', fd, { timeout: 60000 }).then(function (res) {
            if (res && res.success) {
                if (typeof showMessage === 'function') {
                    showMessage({ type: 'success', message: 'Message successfully!' });
                }
                formEl.reset();
                if (typeof window.clearInquiryAttachments === 'function') { window.clearInquiryAttachments($form[0]); }
                syncInquiryFormMeta();
                window.location.href = (res && res.redirect) ? res.redirect : '/inquirysuccess';
                return;
            }
            if (typeof showMessage === 'function') {
                showMessage({ type: 'error', message: (res && res.message) ? res.message : 'Submit failed' });
            }
        }).catch(function (err) {
            var msg = 'Submit failed';
            if (err && err.response) {
                if (err.response.message) msg = err.response.message;
                else if (err.response.errors) {
                    var first = Object.values(err.response.errors)[0];
                    if (Array.isArray(first) && first[0]) msg = first[0];
                }
            }
            if (typeof showMessage === 'function') {
                showMessage({ type: 'error', message: msg });
            }
        }).finally(function () {
            $btn.prop('disabled', false);
        });
    });

    // Inquiry attachment: drag-drop + browse + removable list
    (function () {
        var ALLOWED_EXT = ['pdf','doc','docx','xls','xlsx','ppt','pptx','png','jpg','jpeg','gif','webp','bmp','zip','rar','7z','txt','csv'];

        function getStore(wrap) {
            if (!wrap._inquiryFiles) wrap._inquiryFiles = [];
            return wrap._inquiryFiles;
        }

        function formatSize(size) {
            if (size < 1024) return size + ' B';
            if (size < 1048576) return (Math.round(size / 102.4) / 10) + ' KB';
            return (Math.round(size / 104857.6) / 10) + ' MB';
        }

        function extOf(name) {
            var i = String(name || '').lastIndexOf('.');
            return i >= 0 ? String(name).slice(i + 1).toLowerCase() : '';
        }

        function syncInput(wrap) {
            var input = wrap.querySelector('.js-inquiry-attachment-input');
            if (!input || typeof DataTransfer === 'undefined') return;
            var dt = new DataTransfer();
            getStore(wrap).forEach(function (f) { dt.items.add(f); });
            input.files = dt.files;
        }

        function renderList(wrap) {
            var list = wrap.querySelector('.js-inquiry-attachment-list');
            if (!list) return;
            var files = getStore(wrap);
            if (!files.length) {
                list.innerHTML = '';
                return;
            }
            list.innerHTML = files.map(function (f, idx) {
                var safeName = String(f.name || 'file').replace(/[<>&"']/g, '');
                return '' +
                    '<li class="inquiry-attach__file" data-index="' + idx + '">' +
                      '<span class="inquiry-attach__file-icon" aria-hidden="true">' +
                        '<svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/><path d="M8 13h8"/><path d="M8 17h5"/></svg>' +
                      '</span>' +
                      '<span class="inquiry-attach__file-meta">' +
                        '<span class="inquiry-attach__file-name" title="' + safeName + '">' + safeName + '</span>' +
                        '<span class="inquiry-attach__file-size">' + formatSize(f.size || 0) + ' · ' + (extOf(f.name).toUpperCase() || 'FILE') + '</span>' +
                      '</span>' +
                      '<button type="button" class="inquiry-attach__file-remove js-inquiry-attach-remove" data-index="' + idx + '" aria-label="Remove">' +
                        '<svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>' +
                      '</button>' +
                    '</li>';
            }).join('');
        }

        function addFiles(wrap, fileList) {
            var maxFiles = parseInt(wrap.getAttribute('data-max-files') || '5', 10) || 5;
            var maxSize = parseInt(wrap.getAttribute('data-max-size') || '10485760', 10) || 10485760;
            var store = getStore(wrap);
            var incoming = Array.prototype.slice.call(fileList || []);
            var rejected = [];

            incoming.forEach(function (f) {
                if (store.length >= maxFiles) { rejected.push('limit'); return; }
                var ext = extOf(f.name);
                if (ALLOWED_EXT.indexOf(ext) < 0) { rejected.push('type'); return; }
                if ((f.size || 0) > maxSize) { rejected.push('size'); return; }
                var dup = store.some(function (x) {
                    return x.name === f.name && x.size === f.size && x.lastModified === f.lastModified;
                });
                if (dup) return;
                store.push(f);
            });

            if (rejected.indexOf('limit') >= 0 && typeof showMessage === 'function') {
                showMessage({ type: 'warning', message: 'You can upload up to ' + maxFiles + ' files.' });
            } else if (rejected.indexOf('size') >= 0 && typeof showMessage === 'function') {
                showMessage({ type: 'warning', message: 'Each file must be smaller than 10MB.' });
            } else if (rejected.indexOf('type') >= 0 && typeof showMessage === 'function') {
                showMessage({ type: 'warning', message: 'Unsupported file type.' });
            }

            syncInput(wrap);
            renderList(wrap);
        }

        function setDragState(zone, on) {
            if (!zone) return;
            zone.classList.toggle('is-dragover', !!on);
        }

        $(document).on('dragenter dragover', '.js-inquiry-attach-zone', function (e) {
            e.preventDefault();
            e.stopPropagation();
            setDragState(this, true);
        });
        $(document).on('dragleave', '.js-inquiry-attach-zone', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var related = e.relatedTarget;
            if (related && this.contains(related)) return;
            setDragState(this, false);
        });
        $(document).on('drop', '.js-inquiry-attach-zone', function (e) {
            e.preventDefault();
            e.stopPropagation();
            setDragState(this, false);
            var wrap = this.closest('.js-inquiry-attachment');
            if (!wrap) return;
            var files = e.originalEvent && e.originalEvent.dataTransfer ? e.originalEvent.dataTransfer.files : null;
            if (files && files.length) addFiles(wrap, files);
        });

        $(document).on('change', '.js-inquiry-attachment-input', function () {
            var wrap = this.closest('.js-inquiry-attachment');
            if (!wrap) return;
            addFiles(wrap, this.files);
        });

        $(document).on('click', '.js-inquiry-attach-remove', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var wrap = this.closest('.js-inquiry-attachment');
            if (!wrap) return;
            var idx = parseInt(this.getAttribute('data-index') || '-1', 10);
            var store = getStore(wrap);
            if (idx < 0 || idx >= store.length) return;
            store.splice(idx, 1);
            syncInput(wrap);
            renderList(wrap);
        });

        $(document).on('keydown', '.js-inquiry-attach-zone', function (e) {
            if (e.key !== 'Enter' && e.key !== ' ') return;
            e.preventDefault();
            var input = this.querySelector('.js-inquiry-attachment-input');
            if (input) input.click();
        });

        window.clearInquiryAttachments = function (root) {
            var nodes = root && root.querySelectorAll
                ? root.querySelectorAll('.js-inquiry-attachment')
                : document.querySelectorAll('.js-inquiry-attachment');
            Array.prototype.forEach.call(nodes, function (wrap) {
                wrap._inquiryFiles = [];
                syncInput(wrap);
                renderList(wrap);
            });
        };
    })();

    // Click anywhere else to close all    // Click anywhere else to close all
    $(document).on('click', function (e) {
        var $t = $(e.target);
        if ($t.closest('.inquiry_popup_panel').length) return;
        if ($t.closest('.wishlist_popup_panel').length) return;
        if ($t.closest('.inquiry-entry-btn').length) return;
        if ($t.closest('.wishlist-entry-btn').length) return;
        closeAll();
    });

    // Inquiry float list is owned by InquiryCart (Inquire Now checkboxes).
    // Keep refreshWishList as a no-op for any leftover callers.
    window.refreshWishList = function () {
        if (window.InquiryCart && typeof InquiryCart.syncFloatPopup === 'function') {
            InquiryCart.syncFloatPopup();
            InquiryCart.syncBadge();
        }
    };

    function getCustomerId() {
        var $cid = $('#customer_id');
        if (!$cid.length) return 0;
        var v = parseInt(($cid.val ? $cid.val() : $cid.text()) || '0', 10);
        return isNaN(v) ? 0 : v;
    }

    // Myinquirys page: remove single product from inquiry list (legacy prefer-backed UI)
    $(document).on('click', '.js-myinq-remove', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var $btn = $(this);
        if ($btn.data('loading') === 1) return;

        if (typeof showLoading === 'function') {
            showLoading('Removing...');
        }

        var customerId = getCustomerId();
        var pid = parseInt($btn.attr('data-product-id') || '0', 10);
        if (!customerId || !pid) return;

        $btn.data('loading', 1).prop('disabled', true);

        Promise.resolve(ajax.post('/api/prefer', {
            customer_id: customerId,
            product_ids: [pid],
            type: 0
        })).then(function (res) {
            if (res && res.success === true) {
                $btn.closest('.myinquiry_item').remove();

                var $hotBtn = $('.js-prefer-toggle[data-product-id="' + pid + '"]');
                if ($hotBtn.length) {
                    $hotBtn.attr('data-favorite', '0');
                    $hotBtn.find('.uncollect-icon').removeClass('hidden');
                    $hotBtn.find('.collect-icon').addClass('hidden');
                }
            }
        }).finally(function () {
            setTimeout(function() {
                if (typeof hideLoading === 'function') {
                    hideLoading();
                }
                $btn.data('loading', 0).prop('disabled', false);
            }, 1000);
        });
    });
    // Product prefer toggle (e.g. Hot Styles list)
    (function () {
        function setBtnFavorite($btn, fav) {
            $btn.attr('data-favorite', fav ? '1' : '0');
            $btn.find('.uncollect-icon').toggleClass('hidden', !!fav);
            $btn.find('.collect-icon').toggleClass('hidden', !fav);
        }

        $(document).on('click', '.js-prefer-toggle', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var $btn = $(this);
            if ($btn.data('loading') === 1) return;

            var customerId = getCustomerId();
            if (!customerId) {
                if (typeof showMessage === 'function') {
                    showMessage({ type: 'warning', message: 'Please refresh and try again.' });
                }
                return;
            }

            var pid = parseInt($btn.attr('data-product-id') || '0', 10);
            if (!pid) return;

            var currentFav = parseInt($btn.attr('data-favorite') || '0', 10) === 1;
            var nextFav = !currentFav;
            var type = nextFav ? 1 : 0;

            $btn.data('loading', 1);
            setBtnFavorite($btn, nextFav);

            Promise.resolve(ajax.post('/api/prefer', {
                customer_id: customerId,
                product_ids: [pid],
                type: type
            })).then(function (res) {
                if (res && res.success === true) {
                    if (typeof showMessage === 'function') {
                        showMessage({ type: 'success', message: nextFav ? 'Added to favorites.' : 'Removed from favorites.' });
                    }
                    return;
                }
                setBtnFavorite($btn, currentFav);
                if (typeof showMessage === 'function') {
                    showMessage({ type: 'error', message: (res && res.message) ? res.message : 'Action failed' });
                }
            }).catch(function () {
                setBtnFavorite($btn, currentFav);
                if (typeof showMessage === 'function') {
                    showMessage({ type: 'error', message: 'Action failed' });
                }
            }).finally(function () {
                $btn.data('loading', 0);
            });
        });
    })();


});
