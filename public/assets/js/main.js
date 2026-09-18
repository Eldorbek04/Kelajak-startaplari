/**
 * Template Name: sasico | Task-Management HTML Template
 * Description: Task-Management.
 * Version: 1.0.0
 * Author: ib-thems
 * Author https://themeforest.net/user/ib-themes
 * License: https://tinyurl.com/52b6y2rb
 */

document.addEventListener("DOMContentLoaded", function () {
  // ============================
  // Preloader
  // ============================
  var Preloader = {
    init: function () {
      var preloader = document.getElementById("preloader");
      if (!preloader) return;

      function hidePreloader() {
        preloader.style.transition = "opacity 0.5s ease";
        preloader.style.opacity = "0";
        setTimeout(function () {
          preloader.style.display = "none";
        }, 600);
      }

      setTimeout(function () {
        if (preloader.style.display !== "none") hidePreloader();
      }, 2000);

      window.addEventListener("load", hidePreloader);

      setTimeout(function () {
        if (preloader.style.display !== "none") hidePreloader();
      }, 5000);
    },
  };

  // ============================
  // Swiper Sliders
  // ============================
  var SwiperSliders = {
    init: function () {
      if (typeof Swiper === "undefined") return;

      // BRAND SLIDER
      if (document.querySelector(".brand")) {
        const brandEl = document.querySelector(".brand");
        const brandSlides = brandEl.querySelectorAll('.swiper-slide').length;

        new Swiper(".brand", {
          loop: brandSlides > 6,
          autoplay: { delay: 3000, disableOnInteraction: false },
          slidesPerView: 6,
          spaceBetween: 20,
          breakpoints: {
            1920: { slidesPerView: 6, spaceBetween: 30 },
            1440: { slidesPerView: 6, spaceBetween: 30 },
            1366: { slidesPerView: 6, spaceBetween: 30 },
            1201: { slidesPerView: 6, spaceBetween: 30 },
            1025: { slidesPerView: 5, spaceBetween: 30 },
            769: { slidesPerView: 4, spaceBetween: 30 },
            577: { slidesPerView: 3, spaceBetween: 30 },
            480: { slidesPerView: 2, spaceBetween: 20 },
            375: { slidesPerView: 2, spaceBetween: 20 },
          },
        });
      }

      // TAB SLIDERS
      if (document.querySelector(".tab-pane")) {
        document.querySelectorAll('.slider-area').forEach((area) => {

          const thumbEl = area.querySelector('.thumbSwiper');
          const mainEl  = area.querySelector('.mainSwiper');
          const nextEl  = area.querySelector('.swiper-button-next');
          const prevEl  = area.querySelector('.swiper-button-prev');

          if (!thumbEl || !mainEl) return;

          const thumbCount = thumbEl.querySelectorAll('.swiper-slide').length;
          const mainCount  = mainEl.querySelectorAll('.swiper-slide').length;

          const thumbSwiper = new Swiper(thumbEl, {
            spaceBetween: 10,
            slidesPerView: 5,
            freeMode: true,
            watchSlidesProgress: true,
            loop: thumbCount > 5,
          });

          const mainSwiper = new Swiper(mainEl, {
            spaceBetween: 10,
            loop: mainCount > 5,
            autoplay: {
              delay: 2500,
              disableOnInteraction: false,
            },
            navigation: {
              nextEl: nextEl,
              prevEl: prevEl,
            },
            thumbs: {
              swiper: thumbSwiper,
            },
          });

        });

        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
          tab.addEventListener('shown.bs.tab', () => {
            document.querySelectorAll('.swiper').forEach(sw => {
              if (sw.swiper) {
                sw.swiper.update();
                if (sw.swiper.autoplay) sw.swiper.autoplay.start();
              }
            });
          });
        });
      }
    },
  };


  // ============================
  // Scroll To Top
  // ============================
  var ScrollToTop = {
    init: function () {
      var btn = document.getElementById("scrollTopBtn");
      if (!btn) return;

      btn.addEventListener("click", function () {
        window.scrollTo({
          top: 0,
          behavior: "smooth",
        });
      });
    },
  };

  // ============================
  // Sticky Header
  // ============================
  var StickyHeader = {
    init: function () {
      var header = document.querySelector(".header-main");
      if (!header) return;

      window.addEventListener("scroll", function () {
        if (window.scrollY > 50) {
          header.classList.add("sticky");
        } else {
          header.classList.remove("sticky");
        }
      });
    },
  };

  // ============================
  // Smooth Scroll
  // ============================
  var MenuScroll = {
    init: function () {
      var menuLinks = document.querySelectorAll(
        ".main-menu11 a, .scrol-menu a"
      );
      var header =
        document.querySelector(".header-area") ||
        document.querySelector("header");
      var headerHeight = header ? header.offsetHeight : 120;
      var offset = headerHeight;
      menuLinks.forEach(function (link) {
        link.addEventListener("click", function (e) {
          var targetId = this.getAttribute("href");

          if (targetId && targetId.startsWith("#")) {
            e.preventDefault();

            var targetEl = document.querySelector(targetId);
            if (targetEl) {
              var scrollPos =
                targetEl.getBoundingClientRect().top + window.pageYOffset;

              window.scrollTo({
                top: scrollPos - offset,
                behavior: "smooth",
              });
            }
          }
        });
      });
      window.addEventListener("load", function () {
        if (window.location.hash) {
          var hash = window.location.hash;
          var targetEl = document.querySelector(hash);

          if (targetEl) {
            setTimeout(function () {
              var scrollPos =
                targetEl.getBoundingClientRect().top + window.pageYOffset;

              window.scrollTo({
                top: scrollPos - offset,
                behavior: "smooth",
              });
            }, 200);
          }
        }
      });
    },
  };

  // ============================
  // onepage menu
  // ============================
  var onePageMenu = {
    init: function () {
      if (typeof MenuSpy === "undefined") {
        console.error("MenuSpy is not loaded!");
        return;
      }

      var menus = document.querySelectorAll(".one_page_nav");

      if (!menus.length) return;

      menus.forEach(function (menu) {
        new MenuSpy(menu, {
          menuItemSelector: 'a[href^="#"]',
          activeClass: "active",
          threshold: 150,
          enableLocationHash: false,
        });
      });

      this.syncMenus();
      this.setInitialActive();
    },

    syncMenus: function () {
      document.addEventListener("click", function (e) {
        var link = e.target.closest('.one_page_nav a[href^="#"]');
        if (!link) return;

        var target = link.getAttribute("href");

        document
          .querySelectorAll('.one_page_nav a[href^="#"]')
          .forEach(function (item) {
            item.classList.remove("active");
            if (item.getAttribute("href") === target) {
              item.classList.add("active");
            }
          });
      });
    },

    setInitialActive: function () {
      window.addEventListener("load", function () {
        if (window.location.hash) return;

        document.querySelectorAll(".one_page_nav li").forEach(function (li) {
          li.classList.remove("active");
        });

        var firstLinks = document.querySelectorAll(
          ".one_page_nav li:first-child"
        );

        firstLinks.forEach(function (li) {
          li.classList.add("active");
        });
      });
    },
  };

  // ✅ ONLY RUN ON index-onepage.html
  if (window.location.pathname.includes("index-onepage.html")) {
    onePageMenu.init();
  }

  // ============================
  // Mobile Menu
  // ============================
  var MobileMenu = {
    init: function () {
      var hamBtn = document.querySelector(".hamburger-btn"),
        menu = document.querySelector(".mobile-menu"),
        overlay = document.querySelector(".menu-overlay"),
        closeBtn = document.querySelector(".close-btn");

      if (!hamBtn || !menu || !overlay) return;

      function openMenu() {
        menu.classList.add("active");
        overlay.classList.add("active");
      }

      function closeMenu() {
        menu.classList.remove("active");
        overlay.classList.remove("active");
      }

      hamBtn.onclick = openMenu;
      overlay.onclick = closeMenu;

      if (closeBtn) closeBtn.onclick = closeMenu;
    },
  };

  // ============================
  // SearchPopup
  // ============================
  var SearchPopup = {
    init: function () {
      var searchBtn = document.querySelector(".search-btn"),
        popup = document.querySelector(".search-popup"),
        overlay = document.querySelector(".search-overlay"),
        closeBtn = document.querySelector(".close-search");

      if (!searchBtn || !popup || !overlay) return;

      function openPopup(e) {
        e.preventDefault();
        popup.classList.add("active");
        overlay.classList.add("active");
      }

      function closePopup() {
        popup.classList.remove("active");
        overlay.classList.remove("active");
      }

      searchBtn.addEventListener("click", openPopup);
      closeBtn && closeBtn.addEventListener("click", closePopup);
      overlay.addEventListener("click", closePopup);
    },
  };

  // ============================
  // MenuActive
  // ============================
  var ActiveMenu = {
    init: function () {
      var currentPage = window.location.pathname.split("/").pop();

      // ---- DESKTOP ACTIVE SYSTEM ----
      function setActive(menuLi) {
        var links = menuLi.querySelectorAll(":scope > a");
        var found = false;

        links.forEach(function (link) {
          var linkPage = link.getAttribute("href").split("/").pop();
          if (linkPage === currentPage) {
            link.classList.add("active");
            found = true;
          } else {
            link.classList.remove("active");
          }
        });

        var nestedLinks = menuLi.querySelectorAll("li a");
        nestedLinks.forEach(function (link) {
          var linkPage = link.getAttribute("href").split("/").pop();
          if (linkPage === currentPage) {
            link.classList.add("active");
            found = true;

            var parentLi = link.closest("li");
            if (parentLi) parentLi.classList.add("active");
          } else {
            link.classList.remove("active");
          }
        });

        if (found) {
          menuLi.classList.add("active");
          var topLink = menuLi.querySelector(":scope > a");
          if (topLink) topLink.classList.add("active");
        } else {
          menuLi.classList.remove("active");
          var topLink = menuLi.querySelector(":scope > a");
          if (topLink) topLink.classList.remove("active");
        }

        return found;
      }

      var topMenuItems = document.querySelectorAll(
        " .main-menu10.menu-style10, .main-menu11.menu-style11 > ul > li"
      );
      topMenuItems.forEach(function (li) {
        setActive(li);
      });

      // ---- MOBILE MENU ACTIVE SYSTEM ----
      const mobileLinks = document.querySelectorAll(".mobile-menu ul li a");

      mobileLinks.forEach((link) => {
        const linkPage = link.getAttribute("href").split("/").pop();

        // Page match → active
        if (linkPage === currentPage) {
          link.classList.add("active");
        }

        // Click par active
        link.addEventListener("click", function () {
          mobileLinks.forEach((l) => l.classList.remove("active"));
          this.classList.add("active");
        });
      });
    },
  };

  // ============================
  // DarkModeToggle
  // ============================
  var DarkModeToggle = {
    init: function () {
      this.body = document.body;
      this.btn = document.getElementById("darkModeBtn");

      if (localStorage.getItem("darkMode") === "on") {
        this.enableDark();
      }

      this.btn.addEventListener("click", (e) => {
        e.preventDefault();
        this.toggleDark();
      });
    },

    enableDark: function () {
      this.body.classList.add("active");
      this.btn.classList.add("active");

      localStorage.setItem("darkMode", "on");
    },

    disableDark: function () {
      this.body.classList.remove("active");
      this.btn.classList.remove("active");

      localStorage.setItem("darkMode", "off");
    },

    toggleDark: function () {
      if (this.body.classList.contains("active")) {
        this.disableDark();
      } else {
        this.enableDark();
      }
    },
  };

  // ============================
  // AOS animation
  // ============================
  var AOSAnimation = {
    init: function () {
      window.addEventListener("load", function () {
        const preloader = document.querySelector(".preloader");
        if (preloader) {
          preloader.classList.add("hide");
          setTimeout(function () {
            AOS.init({
              duration: 1500,
              once: true,
              easing: "ease-out-cubic",
              offset: 10,
            });
          }, 300);
        } else {
          AOS.init({
            duration: 1500,
            once: true,
            easing: "ease-out-cubic",
            offset: 10,
          });
        }
      });
    },
  };

  // ============================
  // videoPopup
  // ============================
  var videoModalHandler = (function() {
      var videoModal = document.getElementById('videoModal');
      var videoFrame = document.getElementById('videoFrame2');
      var videoTriggers = document.querySelectorAll('.video-trigger');
      var closeBtn = document.querySelector('.video-close-btn');
      function init() {
          videoTriggers.forEach(function(trigger) {
              trigger.addEventListener('click', function(e) {
                  e.preventDefault();
                  var videoURL = this.getAttribute('data-video');
                  videoFrame.src = videoURL;
                  videoModal.style.display = 'block';
              });
          });
          closeBtn.addEventListener('click', function() {
              videoModal.style.display = 'none';
              videoFrame.src = '';
          });
      }
      return {
          init: init
      };
  })();

  // ============================
  // faqAccordionActive
  // ============================
  var FAQAccordion = {
      init: function () {
          document.querySelectorAll(".faq-accordin .accordion-item").forEach(function (item) {

              let collapse = item.querySelector(".accordion-collapse");

              collapse.addEventListener("show.bs.collapse", function () {
                  item.classList.add("active");
              });

              collapse.addEventListener("hide.bs.collapse", function () {
                  item.classList.remove("active");
              });
          });
      }
  };

  // ============================
  // Counter
  // ============================
  var Counter = {
    init: function() {
      var counters = document.querySelectorAll('.counter');
      if (!counters.length) return;

      for (var i = 0; i < counters.length; i++) {
        (function(counter) {
          var target = parseInt(counter.getAttribute('data-target'));
          var current = 0;
          var speed = target / 100;

          function updateCounter() {
            if (current < target) {
              current += speed;
              counter.innerText = Math.ceil(current);
              setTimeout(updateCounter, 20);
            } else {
              counter.innerText = target;
            }
          }

          updateCounter();
        })(counters[i]);
      }
    }
  };

  // ============================
  // StepCardManager
  // ============================
  var UIActiveManager = {
      stepCards: null,
      accordion: null,
      accordionItems: null,
      activeEl: null,
      accordionVS: null,
      accordionVSItems: null,

      init: function () {
          this.initStepCards();
          this.initAccordion();
          this.initAccordionVS();
      },

      initStepCards: function () {
          this.stepCards = document.querySelectorAll('.step-card');
          if (!this.stepCards.length) return;

          this.activeEl = document.querySelector('.step-card.active') || this.stepCards[0];
          this.activeEl.classList.add('active');

          this.stepCards.forEach(card => {
              card.addEventListener('mouseenter', () => {
                  this.stepCards.forEach(c => c.classList.remove('active'));
                  card.classList.add('active');
                  this.activeEl = card;
              });
          });
      },

      initAccordion: function () {
          this.accordion = document.querySelector('#accordionExample');
          if (!this.accordion) return;

          this.accordionItems = this.accordion.querySelectorAll('.accordion-item');

          this.accordionItems.forEach(item => {
              if (item.querySelector('.accordion-collapse.show')) {
                  item.classList.add('active');
              }
          });

          this.accordion.addEventListener('shown.bs.collapse', (e) => {
              this.accordionItems.forEach(i => i.classList.remove('active'));
              e.target.closest('.accordion-item').classList.add('active');
          });

          this.accordion.addEventListener('hidden.bs.collapse', (e) => {
              const item = e.target.closest('.accordion-item');
              if (item) item.classList.remove('active');
          });
      },

      initAccordionVS: function () {
          this.accordionVS = document.querySelector('#accordionVS');
          if (!this.accordionVS) return;
          this.accordionVSItems = this.accordionVS.querySelectorAll('.accordion-item');
          this.accordionVSItems.forEach(item => {
              if (item.querySelector('.accordion-collapse.show')) {
                  item.classList.add('active');
              }
          });
          this.accordionVS.addEventListener('shown.bs.collapse', (e) => {
              this.accordionVSItems.forEach(i => i.classList.remove('active'));
              e.target.closest('.accordion-item').classList.add('active');
          });
          this.accordionVS.addEventListener('hidden.bs.collapse', (e) => {
              const item = e.target.closest('.accordion-item');
              if (item) item.classList.remove('active');
          });
      }
  };

  // ============================
  // FaqScrollManager
  // ============================
  var FaqScrollManager = {
      faqContent: null,
      faqSection: null,
      sectionTop: 0,
      sectionHeight: 0,
      contentHeight: 0,

      init: function () {
          this.faqContent = document.querySelector('.faq-content');
          this.faqSection = document.querySelector('.faq-sec');

          if (!this.faqContent || !this.faqSection) return;

          this.sectionTop = this.faqSection.offsetTop;
          this.sectionHeight = this.faqSection.offsetHeight;
          this.contentHeight = this.faqContent.offsetHeight;

          window.addEventListener('scroll', this.onScroll.bind(this));

          window.addEventListener('resize', this.updateMeasurements.bind(this));
      },

      onScroll: function () {
          const scrollY = window.scrollY;

          if (scrollY > this.sectionTop && scrollY < this.sectionTop + this.sectionHeight - this.contentHeight - 120) {
              this.faqContent.classList.add('is-fixed');
              this.faqContent.classList.remove('is-absolute');
          } else if (scrollY >= this.sectionTop + this.sectionHeight - this.contentHeight - 120) {
              this.faqContent.classList.add('is-absolute');
              this.faqContent.classList.remove('is-fixed');
          } else {
              this.faqContent.classList.remove('is-fixed', 'is-absolute');
          }
      },

      updateMeasurements: function () {
          this.sectionTop = this.faqSection.offsetTop;
          this.sectionHeight = this.faqSection.offsetHeight;
          this.contentHeight = this.faqContent.offsetHeight;
      }
  };

  // ============================
  // smooth scroll
  // ============================
  var scrollToComments = function() {
      var commentLink = document.querySelector('a[href="#comments"]');
      var commentSection = document.querySelector('#comments');
      var header = document.querySelector('.header, .sticky-header, header');

      if ('scrollRestoration' in history) {
          history.scrollRestoration = 'manual';
      }

      if (commentLink && commentSection) {
          commentLink.addEventListener('click', function(e) {
              e.preventDefault();

              var headerHeight = header ? header.offsetHeight : 0;
              var elementPosition = commentSection.getBoundingClientRect().top;
              var offsetPosition = elementPosition + window.pageYOffset - headerHeight - 20;

              window.scrollTo({
                  top: offsetPosition,
                  behavior: "smooth"
              });
          });
      }
  };




  // ============================
  // INIT ALL SCRIPTS
  // ============================
  Preloader.init();
  SwiperSliders.init();
  ScrollToTop.init();
  StickyHeader.init();
  MenuScroll.init();
  MobileMenu.init();
  videoModalHandler.init();
  UIActiveManager.init();
  SearchPopup.init();
  ActiveMenu.init();
  DarkModeToggle.init();
  FAQAccordion.init();
  AOSAnimation.init();
  FaqScrollManager.init();
  scrollToComments();
  Counter.init();
  if (
    document.body.classList.contains("onepage") &&
    typeof MenuSpy !== "undefined"
  ) {
    onePageMenu.init();
  }
});
