document.addEventListener('DOMContentLoaded', function() {
    // Inicializa el sistema de partículas y animaciones al cargar la página.
    initParticles();
    initScrollAnimations();
});

// Configura y muestra partículas animadas en el fondo.
function initParticles() {
    const container = document.getElementById('particles-container');
    if (!container) return;
    
    // Define la cantidad de partículas según el dispositivo.
    const particleCount = isMobile() ? 30 : 60;
    const colors = ['#ff0000', '#ff3333', '#ff6666'];
    
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        
        // Asigna propiedades aleatorias a cada partícula.
        const size = Math.random() * 3 + 1; 
        const color = colors[Math.floor(Math.random() * colors.length)];
        
        particle.style.position = 'absolute';
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.backgroundColor = color;
        particle.style.borderRadius = '50%';
        particle.style.opacity = Math.random() * 0.3 + 0.1; 
        
        // Posición inicial aleatoria.
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;
        
        // Aplica animación CSS.
        particle.style.animation = `floatParticle ${Math.random() * 8 + 5}s linear infinite`;
        
        container.appendChild(particle);
    }
    
    // Define keyframes para la animación de las partículas.
    const style = document.createElement('style');
    style.innerHTML = `
        @keyframes floatParticle {
            0% {
                transform: translate(0, 0);
            }
            25% {
                transform: translate(${Math.random() * 15 - 7}px, ${Math.random() * 15 - 7}px);
            }
            50% {
                transform: translate(${Math.random() * 30 - 15}px, ${Math.random() * 30 - 15}px);
            }
            75% {
                transform: translate(${Math.random() * 15 - 7}px, ${Math.random() * 15 - 7}px);
            }
            100% {
                transform: translate(0, 0);
            }
        }
    `;
    document.head.appendChild(style);
}

// Comprueba si el dispositivo es móvil.
function isMobile() {
    return window.innerWidth <= 768;
}

// Anima las tarjetas de beneficios al hacer scroll.
function initScrollAnimations() {
    const benefitCards = document.querySelectorAll('.benefit-card');
    
    // Crea un IntersectionObserver para detectar la visibilidad de las tarjetas.
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Añade un retraso para un efecto escalonado.
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, Array.from(benefitCards).indexOf(entry.target) * 100);
                
                // Deja de observar la tarjeta después de animarla.
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    // Observa cada tarjeta de beneficio.
    benefitCards.forEach(card => {
        observer.observe(card);
    });
}

// Aplica un efecto de glitch a textos específicos.
function initGlitchEffect() {
    const glitchTexts = document.querySelectorAll('.glitch-text');
    
    glitchTexts.forEach(text => {
        // Ejecuta el efecto de glitch periódicamente.
        setInterval(() => {
            text.style.textShadow = `
                ${Math.random() * 3}px ${Math.random() * 3}px ${Math.random() * 3}px rgba(220, 38, 38, 0.7),
                ${Math.random() * -3}px ${Math.random() * 3}px ${Math.random() * 3}px rgba(255, 255, 255, 0.7)
            `;
            
            setTimeout(() => {
                text.style.textShadow = 'none';
            }, 50);
        }, 5000); // Frecuencia reducida para mejor rendimiento.
    });
}

// Inicializa el efecto de glitch al cargar el DOM.
document.addEventListener('DOMContentLoaded', initGlitchEffect);

// Habilita el scroll suave para enlaces internos.
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === "#") return;
            
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                // Calcula la posición de desplazamiento con un offset para el encabezado.
                const headerOffset = 80;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                // Realiza el scroll suave.
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
});