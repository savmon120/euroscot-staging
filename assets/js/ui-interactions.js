// EuroScot | Air Scotland UI Interactions

document.addEventListener('DOMContentLoaded', () => {
  console.log("✅ ui-interations.js loaded");

  const dropdowns = document.querySelectorAll('.dropdown-box');
  dropdowns.forEach(box => {
    box.addEventListener('click', () => {
      box.classList.toggle('active');
      const content = box.nextElementSibling;
      if (content && content.classList.contains('dropdown-content')) {
        content.classList.toggle('open');
      }
    });
  });

  // Future interactions can be added below
});
