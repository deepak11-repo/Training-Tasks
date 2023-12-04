let list = document.querySelector('.parentContainer .wrapper');
let items = document.querySelectorAll('.parentContainer .wrapper .item'); 
let dots = document.querySelectorAll('.parentContainer .dots li');
let prev = document.getElementById('prev');
let next = document.getElementById('next');
let active = 0;
let itemLength = items.length - 1;
// let refreshInterval;

next.addEventListener('click', function() {
    active = active + 1 <= itemLength ? active + 1 : 0;
    reloadSlider();
});

prev.addEventListener('click', function() {
    active = active - 1 >= 0 ? active - 1 : itemLength;
    reloadSlider();
});

function reloadSlider() {
    list.style.left = -active * 100 + '%'; 
    let last_active_dot = document.querySelector('.parentContainer .dots li.active');
    last_active_dot.classList.remove('active');
    dots[active].classList.add('active');
    // clearInterval(refreshInterval);
    // refreshInterval = setInterval(() => { next.click() }, 3000);
}

dots.forEach((li, key) => {
    li.addEventListener('click', () => {
        active = key;
        reloadSlider();
    });
});

window.onresize = function(event) {
    reloadSlider();
};

// Initial setup
reloadSlider();
