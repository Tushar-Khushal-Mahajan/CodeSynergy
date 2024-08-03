AOS.init();

ScrollReveal().reveal('.reveal', { duration: 1200 });
document.addEventListener('scroll', function() {
    const header = document.querySelector('.header');
    const heroSection = document.querySelector('#hero');

    const heroHeight = heroSection.offsetHeight;
    const scrollPosition = window.scrollY;

    if (scrollPosition < heroHeight) {
        header.classList.add('transparent');
    } else {
        header.classList.remove('transparent');
    }
});

window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.style.display === "block") {
          openDropdown.style.display = "none";
        }
      }
    }
  }
  