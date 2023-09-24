document.addEventListener("DOMContentLoaded", function () {
  // Mobile menu button
  const mobileMenuButton = document.querySelector(
    "button[aria-controls='mobile-menu']"
  );
  const mobileMenu = document.getElementById("mobile-menu");

  // User menu button and dropdown
  const userMenuButton = document.getElementById("user-menu-button");
  const userMenuDropdown = document.querySelector(
    "div[aria-labelledby='user-menu-button']"
  );

  // Toggle mobile menu
  mobileMenuButton.addEventListener("click", function () {
    mobileMenu.classList.toggle("hidden");
  });

  // Toggle user menu dropdown
  userMenuButton.addEventListener("click", function () {
    userMenuDropdown.classList.toggle("hidden");
  });
});
