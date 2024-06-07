document.addEventListener('DOMContentLoaded', () => {
    const rowContainers = document.querySelectorAll('.row_container');

    rowContainers.forEach(container => {
        const nextBtn = container.querySelector('.btn_next');
        const prevBtn = container.querySelector('.btn_prev');
        const row = container.querySelector('.row');
        let currentIndex = 0;

    
        const cardWidth = row.querySelector('.card_row').offsetWidth + 20; 

        nextBtn.addEventListener('click', () => {
            const maxIndex = row.children.length - Math.floor(row.offsetWidth / cardWidth);
            if (currentIndex < maxIndex) {
                currentIndex++;
                row.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
                prevBtn.style.display = 'block'; 
                setTimeout(() => { 
                    prevBtn.style.opacity = '1';
                }, 10);
            }
            
            if (currentIndex >= maxIndex) {
                nextBtn.style.opacity = '0';
                setTimeout(() => { 
                    nextBtn.style.display = 'none';
                }, 300);
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                row.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
                nextBtn.style.display = 'block';
                setTimeout(() => { 
                    nextBtn.style.opacity = '1';
                }, 10);
            }
       
            if (currentIndex === 0) {
                prevBtn.style.opacity = '0';
                setTimeout(() => {
                    prevBtn.style.display = 'none';
                }, 300);
            }
        });

       
        container.addEventListener('mouseenter', () => {
            nextBtn.style.display = 'block';
            nextBtn.style.opacity = '1';
            if (currentIndex > 0) {
                prevBtn.style.display = 'block';
                prevBtn.style.opacity = '1';
            }
        });

        container.addEventListener('mouseleave', () => {
            if (currentIndex === 0) {
                prevBtn.style.opacity = '0';
                setTimeout(() => {
                    prevBtn.style.display = 'none';
                }, 300);
            }
            if (currentIndex >= row.children.length - Math.floor(row.offsetWidth / cardWidth)) {
                nextBtn.style.opacity = '0';
                setTimeout(() => {
                    nextBtn.style.display = 'none';
                }, 300);
            }
        });
    });
});
