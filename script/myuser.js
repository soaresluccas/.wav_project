const myUser = document.querySelector('.perfil_icon');
const userScreenMenu = document.querySelector(".user_screem_menu");

// Função para fechar o menu se o usuário clicar fora dele
function fecharMenuFora(e) {
    if (!userScreenMenu.contains(e.target) && !myUser.contains(e.target)) {
        myUser.classList.remove("active_user");
        userScreenMenu.classList.remove("active_user");
    }
}

// Event listener para o clique no ícone de perfil
myUser.addEventListener("click", () => {
    myUser.classList.toggle("active_user");
    userScreenMenu.classList.toggle("active_user");
});

// Event listener para verificar o clique fora do menu
document.addEventListener("click", fecharMenuFora);
