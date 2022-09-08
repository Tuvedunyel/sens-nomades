const windowWidth = window.innerWidth;
const mainMenu = document.getElementById( 'main-menu' );
const burgerBtn = document.getElementById( 'burger-btn' );
const linkChildren = document.querySelectorAll( '.menu-item-has-children > a' );
const menuChildren = document.querySelectorAll( ' .menu-item-has-children ' );
const cart = document.getElementById( 'cart-perso' );
const reserver = document.getElementById( 'reverver' );

if (burgerBtn && mainMenu) {
    burgerBtn.addEventListener( 'click', () => {
        burgerBtn.classList.toggle( "open" );
        mainMenu.classList.toggle( 'active' );
    } );
}

if (linkChildren) {
    linkChildren.forEach( item => {
        item.addEventListener( 'click', () => {
            menuChildren.forEach( menu => menu.classList.toggle( 'active' ) )
        } );
    } );
}

if (reserver && cart) {
    reserver.addEventListener( 'click', ( e ) => {
        e.preventDefault();
        cart.classList.toggle( 'active' );
    } );
}