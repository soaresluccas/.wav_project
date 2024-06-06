document.addEventListener('DOMContentLoaded', () => {
    const nextBtn = document.querySelector('.next_btn');
    const prevBtn = document.querySelector('.prev_btn');
    const cardsContainer = document.querySelector('.cards_container');
    let currentIndex = 0;

    // Obter a largura de um card incluindo a margem
    const cardWidth = document.querySelector('.card_row').offsetWidth + 20; // 20 para incluir a margem

    nextBtn.addEventListener('click', () => {
        const maxIndex = cardsContainer.children.length - Math.floor(cardsContainer.offsetWidth / cardWidth);
        if (currentIndex < maxIndex) {
            currentIndex++;
            cardsContainer.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            cardsContainer.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
        }
    });
});