document.addEventListener('DOMContentLoaded', () => {
    const nextBtn = document.querySelector('.btn_next');
    const prevBtn = document.querySelector('.btn_prev');
    const row = document.querySelector('#row1');
    let currentIndex = 0;

  
    const cardWidth = document.querySelector('.card_row').offsetWidth + 20; 

    nextBtn.addEventListener('click', () => {
        const maxIndex = row.children.length - Math.floor(row.offsetWidth / cardWidth);
        if (currentIndex < maxIndex) {
            currentIndex++;
            row.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            row.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
        }
        
    });

    
    window.addEventListener('resize', () => {
        row.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
    });
});

