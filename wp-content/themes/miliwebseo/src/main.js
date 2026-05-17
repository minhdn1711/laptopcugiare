import './main.css';

// Alpine.js được load qua CDN trong <head> với defer
// Không import ở đây để tránh double-initialization

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}
