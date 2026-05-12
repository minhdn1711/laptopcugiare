import Alpine from 'alpinejs';
import './main.css';

window.Alpine = Alpine;
Alpine.start();

// Ajax Search Logic
document.querySelector('input[name="s"]')?.addEventListener('input', debounce(function(e) {
    const query = e.target.value;
    if (query.length < 2) return;

    fetch(miliwebseo_data.ajax_url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=miliwebseo_search&query=${query}`
    })
    .then(res => res.json())
    .then(data => {
        console.log('Search Results:', data.data);
        // Here we would display the results in a dropdown
    });
}, 300));

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}
