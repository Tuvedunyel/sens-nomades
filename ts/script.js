"use strict";
exports.__esModule = true;
var windowWidth = window.innerWidth;
var mainMenu = document.getElementById('main-menu');
var burgerBtn = document.getElementById('burger-btn');
var linkChildren = document.querySelectorAll('.menu-item-has-children > a');
var menuChildren = document.querySelectorAll(' .menu-item-has-children ');
var cart = document.getElementById('cart-perso');
var reserver = document.getElementById('reverver');
var productOptions = document.querySelectorAll('.options-container > label');
if (productOptions) {
    productOptions.forEach(function (option) {
        console.log(option.firstChild);
    });
}
if (burgerBtn && mainMenu) {
    burgerBtn.addEventListener('click', function () {
        burgerBtn.classList.toggle("open");
        mainMenu.classList.toggle('active');
    });
}
if (linkChildren) {
    linkChildren.forEach(function (item) {
        item.addEventListener('click', function () {
            menuChildren.forEach(function (menu) { return menu.classList.toggle('active'); });
        });
    });
}
if (reserver && cart) {
    reserver.addEventListener('click', function (e) {
        e.preventDefault();
        cart.classList.toggle('active');
    });
}
