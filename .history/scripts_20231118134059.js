/*!
* Start Bootstrap - Grayscale v7.0.6 (https://startbootstrap.com/theme/grayscale)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-grayscale/blob/master/LICENSE)
*/
//
// Scripts
// 

var string = "We are Getting Married"; /* type your text here */
var array = string.split("");
var timer;

function frameLooper() {
    if (array.length > 0) {
        document.getElementById("text").innerHTML += array.shift();
    } else {
        clearTimeout(timer);
    }
    timer = setTimeout(frameLooper, 40); /* change 110 for the desired delay in milliseconds */
}

frameLooper();

window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink')
        } else {
            navbarCollapsible.classList.add('navbar-shrink')
        }

    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

});
// --------------------   hobby section ext back function  JS    ----------------------------


const contents = document.querySelectorAll('.contentA');
const nextButton = document.querySelector('.next');
const backButton = document.querySelector('.back');
let currentIndex = 0;

nextButton.addEventListener('click', () => {
  contents[currentIndex].style.opacity = 0;
  setTimeout(() => {
    contents[currentIndex].classList.remove('active');
    currentIndex = (currentIndex + 1) % contents.length;
    contents[currentIndex].classList.add('active');
    contents[currentIndex].style.opacity = 1;
  }, 500);
});

backButton.addEventListener('click', () => {
  contents[currentIndex].style.opacity = 0;
  setTimeout(() => {
    contents[currentIndex].classList.remove('active');
    currentIndex = (currentIndex - 1 + contents.length) % contents.length;
    contents[currentIndex].classList.add('active');
    contents[currentIndex].style.opacity = 1;
  }, 500);
});

// --------------------    TAB JS      -------------------------------