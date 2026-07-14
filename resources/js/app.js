import './bootstrap';
import './admin';
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Chart = Chart;

Alpine.start();

// Session flash → toast after Alpine boots
document.addEventListener('DOMContentLoaded', () => {
    const flash = document.getElementById('flash-success');
    if (flash && window.Alpine) {
        Alpine.store('toasts').push(flash.dataset.message, 'success');
    }
});
