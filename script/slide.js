document.addEventListener('DOMContentLoaded', () => {
    const rowContainers = document.querySelectorAll('.row_container');

    rowContainers.forEach(container => {
        const nextBtn = container.querySelector('.btn_next');
        const prevBtn = container.querySelector('.btn_prev');
        const row = container.querySelector('.row');
        let currentIndex = 0;

        
        const cardWidth = row.querySelector('.card_row').offsetWidth + 20; 

        
        nextBtn.addEventListener('click', () => {
            moveToNextSlide(row, nextBtn, prevBtn, cardWidth, currentIndex);
        });

        prevBtn.addEventListener('click', () => {
            moveToPrevSlide(row, nextBtn, prevBtn, cardWidth, currentIndex);
        });

       
        let startX;
        let isDragging = false;

        
        function startDragging(e) {
            startX = e.type === 'touchstart' ? e.touches[0].clientX : e.clientX;
            isDragging = true;
            row.style.transition = 'none';
        }

       
        function onDrag(e) {
            if (isDragging) {
                const currentX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
                const deltaX = currentX - startX;
                row.style.transform = `translateX(${-currentIndex * cardWidth + deltaX}px)`;
            }
        }

       
        function endDragging(e) {
            if (!isDragging) return;
            isDragging = false;
            const endX = e.type === 'touchend' ? e.changedTouches[0].clientX : e.clientX;
            const deltaX = endX - startX;
            row.style.transition = 'transform 0.5s ease'; 

            
            if (deltaX < -50) {
                
                moveToNextSlide(row, nextBtn, prevBtn, cardWidth, currentIndex);
            } else if (deltaX > 50) {
                
                moveToPrevSlide(row, nextBtn, prevBtn, cardWidth, currentIndex);
            } else {
              
                row.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
            }
        }

       
        row.addEventListener('touchstart', startDragging);
        row.addEventListener('touchmove', onDrag);
        row.addEventListener('touchend', endDragging);

        row.addEventListener('mousedown', startDragging);
        row.addEventListener('mousemove', onDrag);
        row.addEventListener('mouseup', endDragging);
        row.addEventListener('mouseleave', endDragging);

        function moveToNextSlide(row, nextBtn, prevBtn, cardWidth, index) {
            const maxIndex = row.children.length - Math.floor(row.offsetWidth / cardWidth);
            if (index < maxIndex) {
                index++;
                row.style.transform = `translateX(-${index * cardWidth}px)`;
                prevBtn.style.display = 'block'; 
                setTimeout(() => { 
                    prevBtn.style.opacity = '1';
                }, 10);
            }
            
            if (index >= maxIndex) {
                nextBtn.style.opacity = '0';
                setTimeout(() => { 
                    nextBtn.style.display = 'none';
                }, 300);
            }
            currentIndex = index; 
        }

        function moveToPrevSlide(row, nextBtn, prevBtn, cardWidth, index) {
            if (index > 0) {
                index--;
                row.style.transform = `translateX(-${index * cardWidth}px)`;
                nextBtn.style.display = 'block'; 
                setTimeout(() => {
                    nextBtn.style.opacity = '1';
                }, 10);
            }
            
            if (index === 0) {
                prevBtn.style.opacity = '0';
                setTimeout(() => { 
                    prevBtn.style.display = 'none';
                }, 300);
            }
            currentIndex = index; 
        }
    });
});

