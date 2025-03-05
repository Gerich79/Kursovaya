document.addEventListener('DOMContentLoaded', () => {
    // Функции для работы бокового меню
    window.openNav = function() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    window.closeNav = function() {
        document.getElementById("mySidenav").style.width = "0";
    }
}); 