document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.slider').forEach(slider => {

        const track = slider.querySelector('.slider-track');
        const left = slider.querySelector('.slider-arrow.left');
        const right = slider.querySelector('.slider-arrow.right');

        const cardWidth = 218; // карточка + gap (важно)

        right.addEventListener('click', () => {
            track.scrollBy({
                left: cardWidth * 2,
                behavior: 'smooth'
            });
        });

        left.addEventListener('click', () => {
            track.scrollBy({
                left: -cardWidth * 2,
                behavior: 'smooth'
            });
        });

    });

});