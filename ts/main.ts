(() => {
  const buttonToggle = document.querySelectorAll(".menu-toggle");
  buttonToggle.forEach((button) => {
    button.addEventListener("click", () => {
      const targetId = button.getAttribute("aria-controls");
      if (targetId) {
        const target = document.getElementById(targetId);
        if (target) {
          if (["", "none"].includes(target.style.display)) {
            target.style.display = "block";
          } else {
            target.style.display = "none";
          }
        }
      }
    });
  });
})();
