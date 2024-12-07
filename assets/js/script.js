document.addEventListener("click", function (event) {
  const isClickInside = document
    .querySelector(".navbar")
    .contains(event.target);
  const navbarToggler = document.querySelector(".navbar-toggler");
  const navbarCollapse = document.querySelector(".navbar-collapse");

  if (!isClickInside && navbarCollapse.classList.contains("show")) {
    navbarToggler.click();
  }
});

window.addEventListener("scroll", function () {
  const navbar = document.getElementById("navbar");
  if (window.scrollY > 50) {
    navbar.classList.add("scrolled");
  } else {
    navbar.classList.remove("scrolled");
  }
});

document.getElementById("current-year").textContent = new Date().getFullYear();

window.onload = function () {
  document.getElementById("preloader").style.display = "none";
};

const currentPage = window.location.pathname;
const links = document.querySelectorAll('.nav-link');

links.forEach(link => {
  if (link.href.includes(currentPage) && currentPage !== '/') {
    link.style.color = "#1da1f2";
  }
});