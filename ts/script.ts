const windowWidth = window.innerWidth;
const mainMenu = document.getElementById('main-menu');
const burgerBtn = document.getElementById('burger-btn');

const commerceBtn = document.getElementById('show-commerce');
const commerce = document.getElementById('commerce-links');
const arrow = document.getElementById('arrow');

if ( commerceBtn && commerce ) {
    commerceBtn.addEventListener('click', () => {
        commerce.classList.toggle('active');
        arrow.classList.toggle('active');
    } );
}