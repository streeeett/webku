document.querySelectorAll('.item').forEach(button => {
    button.addEventListener('click', function() {
        const link = this.getAttribute('data-link'); // Ambil URL dari atribut data-link
        window.location.href = link; // Arahkan pengguna ke URL
    });
});