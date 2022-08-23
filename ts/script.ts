const windowWidth = window.innerWidth;
const mainMenu = document.getElementById('main-menu');
const burgerBtn = document.getElementById('burger-btn');
const linkChildren = document.querySelectorAll('.menu-item-has-children > a');
const menuChildren = document.querySelectorAll(' .menu-item-has-children ')

if ( burgerBtn && mainMenu ) {
    burgerBtn.addEventListener('click', () => {
            burgerBtn.classList.toggle("open");
            mainMenu.classList.toggle('active');
    } );
}

if ( linkChildren ) {
    linkChildren.forEach( item => {
        item.addEventListener('click', () => {
            menuChildren.forEach( menu => menu.classList.toggle('active') )
        } );
    } );
}