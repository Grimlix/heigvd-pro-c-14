/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';//
import '../css/simple-sidebar.css';//

require('../css/app.css');

import "../css/global.scss";

const $ = require('jquery');

require('bootstrap');

import '../js/custom.js';//
//require('../js/custom.js');


//import '../templates/style.css';
//import $ from 'jquery';
// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.

// create global $ and jQuery variables
global.$ = global.jQuery = $;

window.$ = window.jQuery = require('jquery');

//console.log('Hello Webpack Encore! Edit me in assets/js/app.js');