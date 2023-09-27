document.addEventListener("DOMContentLoaded", function () {
  const menuToggleButtons = document.querySelectorAll(".menu-toggle-button");
  const mobileMenu = document.querySelector("#mobile-menu");

  menuToggleButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      if (mobileMenu.classList.contains("hidden")) {
        mobileMenu.classList.remove("hidden");
      } else {
        mobileMenu.classList.add("hidden");
      }
    });
  });
});
