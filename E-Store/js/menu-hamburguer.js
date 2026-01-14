document.addEventListener("DOMContentLoaded", function () {
  const hamburger = document.getElementById("hamburger");
  const navMenu = document.getElementById("nav-menu");

  hamburger.addEventListener("click", () => {
    navMenu.classList.toggle("open");
  });
      // Mobile menu toggle
      document.getElementById('nav-menu').addEventListener('click', function() {
      document.getElementById('mobile-menu').classList.toggle('hidden');
  });
  
});
