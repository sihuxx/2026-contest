const $ = (e) => document.querySelector(e)
const $$ = (e) => [...document.querySelectorAll(e)]
const newEl = (e,t) => Object.assign(document.createElement(e), t)