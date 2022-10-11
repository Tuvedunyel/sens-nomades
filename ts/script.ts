const windowWidth = window.innerWidth;
const mainMenu = document.getElementById( 'main-menu' );
const burgerBtn = document.getElementById( 'burger-btn' );
const linkChildren = document.querySelectorAll( '.menu-item-has-children > a' );
const menuChildren = document.querySelectorAll( ' .menu-item-has-children ' );
const cart = document.getElementById( 'cart-perso' );
const reserver = document.getElementById( 'reverver' );
const reserverContainer = document.querySelector( '.reservation' );
const coachs = <HTMLDivElement[]> <unknown> document.querySelectorAll( '.coachs' );
const coachsBtn = document.querySelectorAll( '.coachs-btn' );
const border = <HTMLDivElement[]> <unknown> document.querySelectorAll( '.coach-border' );
const longDescription = <HTMLDivElement[]> <unknown> document.querySelectorAll( '.long-description' );
const containerPos = document.querySelector( '.coachs-list__container-inter' );
const minus = <HTMLDivElement> <unknown> document.getElementById( 'minus' );
const plus = <HTMLDivElement> <unknown> document.getElementById( 'plus' );
const quantity = <HTMLInputElement> <unknown> document.querySelector( '[name="quantity"]' );
let y: null | number = null;
let x: null | number = null;

const input = <HTMLInputElement[]> <unknown> document.querySelectorAll( '.variable-item-radio-input' );
const optionsContainer = document.querySelectorAll( '.variable-item.radio-variable-item' );
const reververBtn = document.getElementById( 'reverver' );
const typeChambre = document.getElementById( 'pa_type_de_chambre' );

if (input && reververBtn) {
    reververBtn.addEventListener( 'click', e => {
        e.preventDefault();
        for ( let i = 0; i < input.length; i++ ) {
            for ( let j = 0; j < optionsContainer.length; j++ ) {
                optionsContainer[ j ].classList.add( 'checkout' );
                if (input[ i ].checked && i === j) {
                    optionsContainer[ j ].classList.add( 'active' )
                }
            }
        }
    } )
}

if (coachs && coachsBtn && longDescription && containerPos) {

    document.addEventListener( 'click', e => {
        longDescription.forEach( item => {
            item.classList.remove('active');
        });
        coachs.forEach( coach => coach.style['pointer-events'] = 'all' );
    } )

    containerPos.addEventListener( 'mousemove', e => {
        let rect = containerPos.getBoundingClientRect();
        x = e.clientX - rect.left - 28;
        y = (e.clientY - rect.top) + 49;
        for ( let i = 0; i < coachs.length; i++ ) {
            coachs[ i ].addEventListener( 'click', e => {
                e.stopPropagation();

                longDescription[ i ].style.top = y + 'px';
                border[ i ].style.left = x + 'px';
                border[ i ].style.right = 'unset';
                coachs.forEach( coach => coach.style[ 'pointer-events' ] = 'none' );
                longDescription.forEach( item => item.classList.remove( 'active' ) )
                longDescription[ i ].classList.add( 'active' );
            } );
        }
    } )

    for ( let i = 0; i < coachsBtn.length; i++ ) {
        coachsBtn[ i ].addEventListener( 'click', e => {
            e.stopPropagation();
            coachs.forEach( coach => coach.style[ 'pointer-events' ] = 'all' );
            longDescription[ i ].classList.toggle( 'active' );
        } );
    }
}

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

if (reserver && cart && typeChambre) {
    reserver.addEventListener( 'click', ( e ) => {
        e.preventDefault();
        typeChambre.classList.toggle( 'active' );
        cart.classList.toggle( 'active' );
        reserverContainer.classList.toggle( 'inactive' );
    } );
}

if (minus && plus && quantity) {
    minus.addEventListener( 'click', () => {
        if (quantity.value > 1) {
            quantity.value = Number( quantity.value ) - 1;
        }
    } )

    plus.addEventListener( 'click', () => {
        let inStock = <HTMLDivElement> <unknown> document.querySelector( '.in-stock' );
        let currentStock = inStock.textContent.slice( 0, 1 );
        if (Number( quantity.value ) < Number( currentStock )) {
            quantity.value = Number( quantity.value ) + 1;
        }
    } )
}