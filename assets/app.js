/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

import { Popover } from 'bootstrap';

document.querySelectorAll('[data-bs-toggle="popover"]')
  .forEach(popover => {
    new Popover(popover)
  })

import './js/_home';
import './js/consultant/_main';
import './js/layouts/_navbar';
import './js/layouts/_main';

console.log('ok');

const $ = require('jquery');
