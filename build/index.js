(()=>{"use strict";var e,t={336:(e,t,o)=>{const l=window.wp.blocks,r=window.React,n=window.wp.i18n,a=window.wp.blockEditor,c=window.wp.serverSideRender;var s=o.n(c);const i=window.wp.components;(0,l.registerBlockType)("t3/faq",{edit:function({attributes:e,setAttributes:t}){const[o,l]=(0,r.useState)();return(0,r.createElement)("div",{...(0,a.useBlockProps)()},(0,r.createElement)(a.InspectorControls,{key:"setting"},(0,r.createElement)(i.PanelBody,{title:(0,n.__)("Colors","t3-schema"),initialOpen:!0},(0,r.createElement)("fieldset",null,(0,r.createElement)("legend",{className:"blocks-base-control__label"},(0,n.__)("Button Background Color","t3-schema")),(0,r.createElement)(a.ColorPalette,{value:e.button__background_color,onChange:e=>{l(e),t({button__background_color:e})}})),(0,r.createElement)("fieldset",null,(0,r.createElement)("legend",{className:"blocks-base-control__label"},(0,n.__)("Active Button Background Color","t3-schema")),(0,r.createElement)(a.ColorPalette,{value:e.button__background_color__active,onChange:e=>{l(e),t({button__background_color__active:e})}})),(0,r.createElement)("fieldset",null,(0,r.createElement)("legend",{className:"blocks-base-control__label"},(0,n.__)("Body Color","t3-schema")),(0,r.createElement)(a.ColorPalette,{value:e.body__color,onChange:e=>{l(e),t({body__color:e})}})),(0,r.createElement)("fieldset",null,(0,r.createElement)("legend",{className:"blocks-base-control__label"},(0,n.__)("Body Background Color","t3-schema")),(0,r.createElement)(a.ColorPalette,{value:e.body__background_color,onChange:e=>{l(e),t({body__background_color:e})}})))),(0,r.createElement)(s(),{block:"t3/faq",attributes:e}))}})}},o={};function l(e){var r=o[e];if(void 0!==r)return r.exports;var n=o[e]={exports:{}};return t[e](n,n.exports,l),n.exports}l.m=t,e=[],l.O=(t,o,r,n)=>{if(!o){var a=1/0;for(_=0;_<e.length;_++){for(var[o,r,n]=e[_],c=!0,s=0;s<o.length;s++)(!1&n||a>=n)&&Object.keys(l.O).every((e=>l.O[e](o[s])))?o.splice(s--,1):(c=!1,n<a&&(a=n));if(c){e.splice(_--,1);var i=r();void 0!==i&&(t=i)}}return t}n=n||0;for(var _=e.length;_>0&&e[_-1][2]>n;_--)e[_]=e[_-1];e[_]=[o,r,n]},l.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return l.d(t,{a:t}),t},l.d=(e,t)=>{for(var o in t)l.o(t,o)&&!l.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:t[o]})},l.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={826:0,431:0};l.O.j=t=>0===e[t];var t=(t,o)=>{var r,n,[a,c,s]=o,i=0;if(a.some((t=>0!==e[t]))){for(r in c)l.o(c,r)&&(l.m[r]=c[r]);if(s)var _=s(l)}for(t&&t(o);i<a.length;i++)n=a[i],l.o(e,n)&&e[n]&&e[n][0](),e[n]=0;return l.O(_)},o=globalThis.webpackChunkt3_schema=globalThis.webpackChunkt3_schema||[];o.forEach(t.bind(null,0)),o.push=t.bind(null,o.push.bind(o))})();var r=l.O(void 0,[431],(()=>l(336)));r=l.O(r)})();