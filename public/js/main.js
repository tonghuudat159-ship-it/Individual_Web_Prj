/**
 * Main JavaScript File
 * Global functionality, utilities, and initialization code
 */

console.log("DatEdu main.js loaded");

/**
 * Responsive Navbar Toggle
 * Handle hamburger menu for mobile devices
 */
document.addEventListener("DOMContentLoaded", function () {
  const navbarToggle = document.getElementById("navbar-toggle");
  const navbarLinks = document.getElementById("navbar-links");

  if (navbarToggle && navbarLinks) {
    navbarToggle.addEventListener("click", function () {
      navbarLinks.classList.toggle("open");
    });

    // Close menu when a link is clicked
    const navLinks = navbarLinks.querySelectorAll("a");
    navLinks.forEach(function (link) {
      link.addEventListener("click", function () {
        navbarLinks.classList.remove("open");
      });
    });

    // Close menu when clicking outside
    document.addEventListener("click", function (event) {
      if (
        !event.target.closest(".header") &&
        navbarLinks.classList.contains("open")
      ) {
        navbarLinks.classList.remove("open");
      }
    });
  }
});
