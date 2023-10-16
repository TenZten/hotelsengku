document.addEventListener("DOMContentLoaded", function () {
    let navLinks = document.querySelectorAll(".nav-link");
  
    for (let navLink of navLinks) {
      navLink.addEventListener("click", function (event) {
        event.preventDefault();
  
        let targetId = this.getAttribute("href").substring(1);
        let targetElement = document.getElementById(targetId);
  
        if (targetElement) {
          window.scrollTo({
            top: targetElement.offsetTop,
            behavior: "smooth",
          });
        }
      });
    }
  });