require("bootstrap");
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */



import "../css/app.scss";
import "../css/style.css";
import "../css/styles/layout.css"





import "../css/Loading.css";

import Filter from "./modules/Filter";
new Filter(document.querySelector(".js-filter"));

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
  });
const $ = require("jquery");


require("select2");

$("select").select2();

let $contactButton = $("#contactButton");
$contactButton.click((e) => {
  e.preventDefault();
  $("#contactForm").slideDown();
  $contactButton.slideUp();
});

$("#categorieannule").click((e) => {
    $("#contactForm").slideUp();
    $("#contactButton").slideDown();
  });
  $("#dechetannule2").click((e) => {
    $("#contactForm").slideUp();
    $("#contactButton").slideDown();
  });