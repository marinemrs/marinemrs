// ****menu****

let navbar = document.querySelector('.header .navbar')

document.querySelector('#menu').onclick = () =>{
  navbar.classList.add('active');
}

document.querySelector('#close').onclick = () =>{
  navbar.classList.remove('active');
}


// mouvement souris landing page

document.addEventListener('mousemove', move);
function move(e){
  this.querySelectorAll('.move').forEach(layer =>{
    const speed = layer.getAttribute('data-speed')

    const x = (window.innerWidth - e.pageX*speed)/120
    const y = (window.innerWidth - e.pageY*speed)/120

    layer.style.transform = `translateX(${x}px) translateY(${y}px)`

  })
}
// *************************

// animation chargement des pages
gsap.from('.logo', {opacity: 0, duration: 1, delay: 2, y:10})
gsap.from('.navbar .nav_item', {opacity: 0, duration: 1, delay: 2.1, y:30, stagger: 0.2})
gsap.from('.title', {opacity: 0, duration: 1, delay: 1.6, y:30})
gsap.from('.description', {opacity: 0, duration: 1, delay: 1.8, y:30})
gsap.from('.btn', {opacity: 0, duration: 1, delay: 2.1, y:30})
gsap.from('.image', {opacity: 0, duration: 1, delay: 2.6, y:30})
gsap.from('.wrapper', {opacity: 0, duration: 1.5, delay: 2.1, y:30})

// ****PAGE Inscription****
document.addEventListener("DOMContentLoaded", function() {
  const loginWrapper = document.getElementById('login-wrapper');
  const perspective = 500; // Distance à partir de laquelle les éléments s'inclineront
  
  // Fonction pour mettre à jour l'inclinaison de la div en fonction de la position de la souris
  function tiltWrapper(event) {
      if (!loginWrapper.contains(event.target)) {
          const wrapperRect = loginWrapper.getBoundingClientRect();
          const wrapperWidth = wrapperRect.width;
          const wrapperHeight = wrapperRect.height;
          const mouseX = event.clientX - wrapperRect.left;
          const mouseY = event.clientY - wrapperRect.top;
          const tiltX = (mouseX - wrapperWidth / 2) / (wrapperWidth / 2);
          const tiltY = (mouseY - wrapperHeight / 2) / (wrapperHeight / 2);
          
          loginWrapper.style.transform = `perspective(${perspective}px) rotateY(${tiltX * 10}deg) rotateX(${tiltY * -10}deg)`;
      } else {
          loginWrapper.style.transform = 'none';
      }
  }
// Fonction pour mettre à jour l'ombre de la div en fonction de la position de la souris
  function updateShadow(event) {
    const wrapperRect = loginWrapper.getBoundingClientRect();
    const wrapperWidth = wrapperRect.width;
    const wrapperHeight = wrapperRect.height;
    const mouseX = event.clientX - wrapperRect.left;
    const mouseY = event.clientY - wrapperRect.top;
    const shadowX = -(mouseX - wrapperWidth / 2) / (wrapperWidth / 2) * 35; // Valeur d'ombre en fonction de la position X de la souris
    const shadowY = -(mouseY - wrapperHeight / 2) / (wrapperHeight / 2) * 35; // Valeur d'ombre en fonction de la position Y de la souris
    
    loginWrapper.style.boxShadow = `${shadowX}px ${shadowY}px 20px rgba(0, 0, 0, 0.3)`;
}
  
  // Événement pour détecter les mouvements de la souris
  document.addEventListener('mousemove', function(event) {
      tiltWrapper(event);
      updateShadow(event);
  });
});

// Fonction pour déplacer les places orders quand on clique sur l'un des champs du formulaire
document.addEventListener("DOMContentLoaded", function() {
    const emailInput = document.querySelector('input[name="mailconnect"]');
    const mdpInput = document.querySelector('input[name="mdpconnect"]');

    if (emailInput && mdpInput) {
        const emailLabel = emailInput.nextElementSibling;
        const mdpLabel = mdpInput.nextElementSibling;

        emailInput.addEventListener('focus', function() {
            if (emailLabel) emailLabel.classList.add('focused');
            if (mdpLabel) mdpLabel.classList.add('focused');
        });

        emailInput.addEventListener('blur', function() {
            if (emailInput.value === '' && emailLabel) {
                emailLabel.classList.remove('focused');
            }
        });

        mdpInput.addEventListener('blur', function() {
            if (mdpInput.value === '' && mdpLabel) {
                mdpLabel.classList.remove('focused');
            }
        });
    }
});




document.addEventListener("DOMContentLoaded", function() {
  const passwordInput = document.querySelector('input[name="mdpconnect"]');
  const togglePassword = document.getElementById('togglePassword');
  const toggleLock = document.getElementById('toggleLock');

  // Fonction pour afficher ou masquer l'icône du cadenas et de l'œil en fonction du texte du champ de mot de passe
  function toggleIcons() {
      if (passwordInput.value === '') {
          toggleLock.style.opacity = '1';
          togglePassword.style.opacity = '0';
      } else {
          toggleLock.style.opacity = '0';
          togglePassword.style.opacity = '1';
      }
  }

  // Événement pour détecter les changements dans le champ de mot de passe
  passwordInput.addEventListener('input', toggleIcons);

  // Événement pour basculer entre l'affichage du mot de passe et son masquage
  togglePassword.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);

      // Change l'icône de l'œil en fonction de l'état du mot de passe
      togglePassword.classList.toggle('bx-hide');
      togglePassword.classList.toggle('bx-show');
  });

  // Au chargement de la page, vérifie l'état initial du champ de mot de passe
  toggleIcons();
});
// ************************* 
