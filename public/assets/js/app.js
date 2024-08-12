$(function () {
    $(".footer-links .category-title").click(function () {
        $(this).parent().toggleClass("footer-category-active")
    })
});
const pageHeader = document.querySelector(".page-header"), toggleMenu = pageHeader.querySelector(".toggle-menu"),
    toggleMenu2 = pageHeader.querySelector(".toggle-menu2"), menuWrapper = pageHeader.querySelector(".menu-wrapper"),
    menuBrands = pageHeader.querySelector(".menu-brands"),
    level1Links = pageHeader.querySelectorAll(".level-1 > li > a"),
    listWrapper2 = pageHeader.querySelector(".list-wrapper:nth-child(2)"),
    listWrapper3 = pageHeader.querySelector(".list-wrapper:nth-child(3)"),
    listBrands2 = pageHeader.querySelector(".list-brands:nth-child(2)"),
    listBrands3 = pageHeader.querySelector(".list-brands:nth-child(3)"),
    /*subMenuWrapper2 = listWrapper2.querySelector(".sub-menu-wrapper"),
    subMenuWrapper3 = listWrapper3.querySelector(".sub-menu-wrapper"),*/
    backOneLevelBtns = pageHeader.querySelectorAll(".back-one-level"), isVisibleClass = "is-visible",
    isActiveClass = "is-active";
for (const level1Link of (toggleMenu.addEventListener("click", function () {
    if (menuWrapper.classList.toggle(isVisibleClass), !this.classList.contains(isVisibleClass)) {
        menuBrands.classList.remove(isVisibleClass), listWrapper2.classList.remove(isVisibleClass), listWrapper3.classList.remove(isVisibleClass);
        let e = menuWrapper.querySelectorAll("a");
        for (let s of e) s.classList.remove(isActiveClass)
    }
}), toggleMenu2.addEventListener("click", function () {
    if (menuBrands.classList.toggle(isVisibleClass), !this.classList.contains(isVisibleClass)) {
        menuWrapper.classList.remove(isVisibleClass), listBrands3.classList.remove(isVisibleClass);
        let e = menuBrands.querySelectorAll("a");
        for (let s of e) s.classList.remove(isActiveClass)
    }
}), level1Links)) level1Link.addEventListener("click", function (e) {
    let s = level1Link.nextElementSibling;
    if (s) {
        e.preventDefault(), this.classList.add(isActiveClass);
        let l = s.cloneNode(!0);
        subMenuWrapper2.innerHTML = "", subMenuWrapper2.append(l), listWrapper2.classList.add(isVisibleClass)
    }
});
/*for (const backOneLevelBtn of (listWrapper2.addEventListener("click", function (e) {
    let s = e.target;
    if ("a" === s.tagName.toLowerCase() && s.nextElementSibling) {
        let l = s.nextElementSibling;
        e.preventDefault(), s.classList.add(isActiveClass);
        let i = l.cloneNode(!0);
        subMenuWrapper3.innerHTML = "", subMenuWrapper3.append(i), listWrapper3.classList.add(isVisibleClass)
    }
}), backOneLevelBtns)) backOneLevelBtn.addEventListener("click", function () {
    let e = this.closest(".list-wrapper");
    e.classList.remove(isVisibleClass), e.previousElementSibling.querySelector(".is-active").classList.remove(isActiveClass)
});*/
const input = document.querySelector("#searchInput"), el = document.querySelector(".navbar-bottom"),
    fixBtn = document.querySelector(".fix-input");
/*input.addEventListener("focus", function () {
    el.classList.add("is-full")
}), fixBtn.addEventListener("click", function () {
    el.classList.remove("is-full")
}), lazyload();*/
