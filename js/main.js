/* ============================================================
   TAQUERÍA EL COMPADRE — Main JavaScript
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

  'use strict';

  /* ==========================================================
     NAVBAR SCROLL EFFECT
     ========================================================== */
  const navbar = document.querySelector('.navbar');
  const navbarHeight = navbar ? navbar.offsetHeight : 80;

  function handleNavbarScroll() {
    if (window.scrollY > 60) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  }

  if (navbar) {
    window.addEventListener('scroll', handleNavbarScroll, { passive: true });
    handleNavbarScroll();
  }

  /* ==========================================================
     MOBILE MENU
     ========================================================== */
  const hamburger = document.querySelector('.hamburger');
  const navLinks = document.querySelector('.navbar-links');

  if (hamburger && navLinks) {
    hamburger.addEventListener('click', () => {
      hamburger.classList.toggle('active');
      navLinks.classList.toggle('open');
      document.body.style.overflow = navLinks.classList.contains('open') ? 'hidden' : '';
    });

    // Close menu on link click
    navLinks.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        hamburger.classList.remove('active');
        navLinks.classList.remove('open');
        document.body.style.overflow = '';
      });
    });
  }

  /* ==========================================================
     PARALLAX HERO
     ========================================================== */
  const heroBg = document.querySelector('.hero-bg');
  if (heroBg) {
    window.addEventListener('scroll', () => {
      const scrollY = window.scrollY;
      const translateY = scrollY * 0.4;
      heroBg.style.transform = `scale(1.05) translateY(${translateY}px)`;
    }, { passive: true });
  }

  /* ==========================================================
     SCROLL ANIMATIONS (Intersection Observer)
     ========================================================== */
  function initScrollAnimations() {
    const elements = document.querySelectorAll('[data-aos]');
    if (elements.length === 0) return;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const delay = entry.target.getAttribute('data-aos-delay') || 0;
          setTimeout(() => {
            entry.target.classList.add('aos-animate');
          }, parseInt(delay));
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    });

    elements.forEach(el => observer.observe(el));
  }

  initScrollAnimations();

  /* ==========================================================
     SMOOTH SCROLL FOR ANCHOR LINKS
     ========================================================== */
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        const offset = navbar ? navbar.offsetHeight : 80;
        const targetPos = target.getBoundingClientRect().top + window.pageYOffset - offset;
        window.scrollTo({
          top: targetPos,
          behavior: 'smooth'
        });
      }
    });
  });

  /* ==========================================================
     MENU CATEGORY FILTER (menu.html)
     ========================================================== */
  const categoryBtns = document.querySelectorAll('.menu-category-btn');
  const menuCards = document.querySelectorAll('.menu-card');

  if (categoryBtns.length > 0) {
    categoryBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        categoryBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const category = btn.dataset.category;

        menuCards.forEach(card => {
          if (category === 'all' || card.dataset.category === category) {
            card.style.display = '';
            card.style.opacity = '0';
            setTimeout(() => { card.style.opacity = '1'; }, 50);
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  }

  /* ==========================================================
     LIGHTBOX
     ========================================================== */
  const lightbox = document.querySelector('.lightbox');
  const lightboxImg = document.querySelector('.lightbox-img');
  const lightboxClose = document.querySelector('.lightbox-close');

  if (lightbox && lightboxImg) {
    // Open lightbox
    document.querySelectorAll('.gallery-item').forEach(item => {
      item.addEventListener('click', () => {
        const img = item.querySelector('img');
        if (img) {
          lightboxImg.src = img.src;
          lightboxImg.alt = img.alt;
          lightbox.classList.add('active');
          document.body.style.overflow = 'hidden';
        }
      });
    });

    // Close lightbox
    function closeLightbox() {
      lightbox.classList.remove('active');
      document.body.style.overflow = '';
    }

    if (lightboxClose) {
      lightboxClose.addEventListener('click', closeLightbox);
    }

    lightbox.addEventListener('click', (e) => {
      if (e.target === lightbox) {
        closeLightbox();
      }
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && lightbox.classList.contains('active')) {
        closeLightbox();
      }
    });
  }

  /* ==========================================================
     TESTIMONIAL CAROUSEL
     ========================================================== */
  const track = document.querySelector('.testimonials-track');
  const dots = document.querySelectorAll('.testimonial-dot');
  const prevBtn = document.querySelector('.testimonial-btn.prev');
  const nextBtn = document.querySelector('.testimonial-btn.next');

  if (track && dots.length > 0) {
    let currentIndex = 0;
    const totalSlides = dots.length;

    function goToSlide(index) {
      if (index < 0) index = totalSlides - 1;
      if (index >= totalSlides) index = 0;
      currentIndex = index;
      track.style.transform = `translateX(-${currentIndex * 100}%)`;
      dots.forEach(d => d.classList.remove('active'));
      dots[currentIndex].classList.add('active');
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', () => goToSlide(currentIndex - 1));
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', () => goToSlide(currentIndex + 1));
    }

    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => goToSlide(i));
    });

    // Auto-advance
    let autoplay = setInterval(() => goToSlide(currentIndex + 1), 5000);

    const carousel = document.querySelector('.testimonials-carousel');
    if (carousel) {
      carousel.addEventListener('mouseenter', () => clearInterval(autoplay));
      carousel.addEventListener('mouseleave', () => {
        autoplay = setInterval(() => goToSlide(currentIndex + 1), 5000);
      });
    }
  }

  /* ==========================================================
     FORM VALIDATION
     ========================================================== */
  const contactForm = document.querySelector('.contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      const name = this.querySelector('#nombre');
      const email = this.querySelector('#email');
      const message = this.querySelector('#mensaje');

      let valid = true;

      [name, email, message].forEach(field => {
        if (field) {
          field.style.borderColor = '';
          const errorEl = field.parentElement.querySelector('.form-error');
          if (errorEl) errorEl.remove();
        }
      });

      if (name && name.value.trim().length < 2) {
        valid = false;
        showError(name, 'Por favor ingresa tu nombre');
      }

      if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        valid = false;
        showError(email, 'Ingresa un correo válido');
      }

      if (message && message.value.trim().length < 5) {
        valid = false;
        showError(message, 'Escribe un mensaje');
      }

      if (!valid) {
        e.preventDefault();
      }
    });

    function showError(field, msg) {
      field.style.borderColor = 'var(--color-primary)';
      const error = document.createElement('small');
      error.className = 'form-error';
      error.style.cssText = 'color: var(--color-primary); font-size: 0.8rem; margin-top: 0.3rem; display: block;';
      error.textContent = msg;
      field.parentElement.appendChild(error);
    }
  }

  /* ==========================================================
     IMAGE FADE-IN ON LOAD
     ========================================================== */
  document.querySelectorAll('img').forEach(img => {
    if (!img.complete) {
      img.style.opacity = '0';
      img.style.transition = 'opacity 0.5s ease';
      img.addEventListener('load', () => {
        img.style.opacity = '1';
      });
    } else {
      img.style.opacity = '1';
    }
  });

  /* ==========================================================
     COUNTER ANIMATION (About section)
     ========================================================== */
  const aboutExp = document.querySelector('.about-experience span');
  if (aboutExp) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const target = parseInt(aboutExp.textContent);
          let current = 0;
          const increment = Math.ceil(target / 50);
          const counter = setInterval(() => {
            current += increment;
            if (current >= target) {
              current = target;
              clearInterval(counter);
            }
            aboutExp.textContent = current + (target >= 1000 ? '+' : '');
          }, 40);
          observer.unobserve(aboutExp);
        }
      });
    }, { threshold: 0.5 });
    observer.observe(aboutExp);
  }

  console.log('🌮 Taquería El Compadre — Buen provecho!');
});
