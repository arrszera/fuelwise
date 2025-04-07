function onMenuToggle(){
    let menu = document.getElementById("mobile-menu-list")
    let menuIcon = document.getElementById("menu-icon")
    
    if (menuIcon.classList.contains('active')){
        menuIcon.classList.remove("active")
        menu.classList.remove("active")
        return
    }
    menuIcon.classList.toggle("active")
    menu.classList.toggle("active")
}