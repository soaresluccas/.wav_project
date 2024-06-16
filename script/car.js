document.addEventListener('DOMContentLoaded', function(){
    const carButton = document.getElementById('car_button');
    const cardCart = document.getElementById('card_car');
    const closeCar = document.getElementById('close_car');

    carButton.addEventListener('click', function(){
        cardCart.classList.toggle('active_car');
        
    });

    closeCar.addEventListener('click', function(){
        cardCart.classList.remove('active_car');
    });
});