// assets/js/nav.js

document.addEventListener("DOMContentLoaded", () => {
  const menuToggle = document.getElementById("mobile-menu");
  const navLinks = document.querySelector(".eus-nav-links");

  if (menuToggle && navLinks) {
    menuToggle.addEventListener("click", () => {
      navLinks.classList.toggle("active");
    });
  }
});
