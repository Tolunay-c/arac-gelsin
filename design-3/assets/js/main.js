/* ============================================================
   ARACIM GELSİN — main.js (bağımlılıksız)
   ============================================================ */

/* ---------- Açık / koyu tema anahtarı ---------- */
(function () {
  var STORAGE_KEY = 'aracimgelsin-theme';
  var toggle = document.getElementById('themeToggle');
  var metaThemeColor = document.querySelector('meta[name="theme-color"]');
  var COLORS = { dark: '#0A1420', light: '#F5F6FA' };

  function apply(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    if (metaThemeColor) metaThemeColor.setAttribute('content', COLORS[theme] || COLORS.dark);
    if (toggle) toggle.setAttribute('aria-label', theme === 'light' ? 'Koyu temaya geç' : 'Açık temaya geç');
  }

  // İlk boyamadan önce <head> içindeki blocking script zaten data-theme'i
  // ayarladı; burada sadece meta/etiketleri o değerle senkronlarız.
  apply(document.documentElement.getAttribute('data-theme') || 'dark');

  if (!toggle) return;
  toggle.addEventListener('click', function () {
    var current = document.documentElement.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
    var next = current === 'light' ? 'dark' : 'light';
    apply(next);
    try { localStorage.setItem(STORAGE_KEY, next); } catch (e) { /* gizli gezinti vb. — sorun değil */ }
  });
})();

/* ---------- Sticky header gölgesi ---------- */
(function () {
  var header = document.getElementById('siteHeader');
  if (!header) return;
  var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 8); };
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });
})();

/* ---------- Mobil menü ---------- */
(function () {
  var toggle = document.getElementById('navToggle');
  var nav = document.getElementById('mainNav');
  if (!toggle || !nav) return;

  toggle.addEventListener('click', function () {
    var open = nav.classList.toggle('is-open');
    document.body.classList.toggle('nav-open', open);
    toggle.setAttribute('aria-expanded', String(open));
  });

  nav.addEventListener('click', function (e) {
    if (e.target.closest('a')) {
      nav.classList.remove('is-open');
      document.body.classList.remove('nav-open');
      toggle.setAttribute('aria-expanded', 'false');
    }
  });
})();

/* ---------- Toast ---------- */
var Toast = (function () {
  var container = null;
  var ICONS = {
    success: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
    error: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>',
    info: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>',
    close: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>'
  };

  function getContainer() {
    if (!container) {
      container = document.createElement('div');
      container.className = 'toast-container';
      container.setAttribute('aria-live', 'polite');
      document.body.appendChild(container);
    }
    return container;
  }

  function dismiss(el) {
    el.classList.add('is-hiding');
    el.addEventListener('animationend', function () { el.remove(); }, { once: true });
  }

  function show(message, opts) {
    opts = opts || {};
    var type = opts.type || 'info';
    var title = opts.title || '';
    var duration = opts.duration === undefined ? 4500 : opts.duration;

    var el = document.createElement('div');
    el.className = 'toast toast--' + type;
    el.setAttribute('role', 'status');
    el.innerHTML =
      '<span class="toast__icon">' + (ICONS[type] || ICONS.info) + '</span>' +
      '<div class="toast__msg">' + (title ? '<strong></strong>' : '') + '<span></span></div>' +
      '<button class="toast__close" aria-label="Kapat">' + ICONS.close + '</button>';
    if (title) el.querySelector('strong').textContent = title;
    el.querySelector('.toast__msg span').textContent = message;
    el.querySelector('.toast__close').addEventListener('click', function () { dismiss(el); });
    getContainer().appendChild(el);
    if (duration > 0) setTimeout(function () { if (el.isConnected) dismiss(el); }, duration);
    return el;
  }

  return { show: show };
})();

/* ---------- Lead modal ---------- */
(function () {
  var modal = document.getElementById('leadModal');
  if (!modal) return;

  function openModal(e) {
    if (e) e.preventDefault();
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }
  function closeModal() {
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  document.querySelectorAll('[data-open-lead-modal]').forEach(function (btn) {
    btn.addEventListener('click', openModal);
  });
  document.querySelectorAll('[data-close-lead-modal]').forEach(function (btn) {
    btn.addEventListener('click', closeModal);
  });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeModal(); });
})();

/* ---------- Form validasyonu + gönderim (kurumsal teklif formları) ---------- */
(function () {
  var RULES = {
    required: function (v) { return v.trim().length > 0; },
    email: function (v) { return v.trim() === '' || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()); },
    phone: function (v) { return v.replace(/\D/g, '').length >= 10; }
  };

  document.querySelectorAll('form[data-validate]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var ok = true;

      form.querySelectorAll('[data-rule]').forEach(function (el) {
        var valid = el.dataset.rule.split('|').every(function (r) { return RULES[r] ? RULES[r](el.value) : true; });
        var group = el.closest('.form-group');
        if (group) group.classList.toggle('has-error', !valid);
        el.classList.toggle('is-invalid', !valid);
        if (!valid) ok = false;
      });

      if (!ok) {
        Toast.show('Lütfen işaretli alanları kontrol edin.', { type: 'error', title: 'Form eksik' });
        var first = form.querySelector('.is-invalid');
        if (first) first.focus();
        return;
      }

      var submitBtn = form.querySelector('[type="submit"]');
      var originalLabel = submitBtn ? submitBtn.textContent : '';
      if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = 'Gönderiliyor…'; }

      fetch('/lead-submit', {
        method: 'POST',
        body: new FormData(form),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (data && data.ok) {
            Toast.show(data.message || 'Talebiniz alındı.', { type: 'success', title: 'Teşekkürler!' });
            form.reset();
            var modal = form.closest('.lead-modal');
            if (modal) setTimeout(function () { modal.classList.remove('is-open'); document.body.style.overflow = ''; }, 1200);
          } else {
            var firstMsg = data && data.errors ? Object.values(data.errors)[0] : 'Bir şeyler ters gitti, lütfen tekrar deneyin.';
            Toast.show(firstMsg, { type: 'error', title: 'Gönderilemedi' });
          }
        })
        .catch(function () {
          Toast.show('Bağlantı hatası. Lütfen tekrar deneyin.', { type: 'error', title: 'Gönderilemedi' });
        })
        .finally(function () {
          if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = originalLabel; }
        });
    });

    form.addEventListener('input', function (e) {
      var el = e.target;
      if (!el.dataset.rule) return;
      el.classList.remove('is-invalid');
      var group = el.closest('.form-group');
      if (group) group.classList.remove('has-error');
    });
  });
})();

/* ---------- Telefon input maskesi: 0xxx xxx xx xx ---------- */
(function () {
  document.querySelectorAll('input[type="tel"]').forEach(function (el) {
    el.setAttribute('placeholder', '05xx xxx xx xx');
    el.addEventListener('input', function () {
      var d = el.value.replace(/\D/g, '');
      if (d && d[0] !== '0') d = '0' + d;
      d = d.slice(0, 11);
      var parts = [d.slice(0, 4), d.slice(4, 7), d.slice(7, 9), d.slice(9, 11)];
      el.value = parts.filter(Boolean).join(' ');
    });
  });
})();

/* ---------- Sayaç animasyonu (stats) ---------- */
(function () {
  var nums = document.querySelectorAll('[data-count]');
  if (!nums.length || !('IntersectionObserver' in window)) return;

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (!entry.isIntersecting) return;
      var el = entry.target;
      io.unobserve(el);

      var target = parseInt(el.dataset.count, 10);
      var suffix = el.dataset.suffix || '';
      var dur = 1200;
      var t0 = performance.now();

      function tick(t) {
        var p = Math.min((t - t0) / dur, 1);
        var eased = 1 - Math.pow(1 - p, 3);
        el.firstChild.textContent = Math.round(target * eased).toLocaleString('tr-TR');
        if (p < 1) requestAnimationFrame(tick);
        else el.firstChild.textContent = target.toLocaleString('tr-TR');
      }
      el.innerHTML = '0<em>' + suffix + '</em>';
      requestAnimationFrame(tick);
    });
  }, { threshold: 0.4 });

  nums.forEach(function (n) { io.observe(n); });
})();

/* ---------- Hero slider (Design 3 — eski split-hero filo geçişi) ----------
   Anasayfa hero'su artık tek panel/bilgi alanı; [data-hero-slider]
   işaretli bir eleman kalmadığı için bu blok artık hiç çalışmıyor
   (aşağıdaki guard sayesinde no-op). Slider markup'ı ileride geri
   gelirse kod olduğu gibi çalışmaya devam eder. */
(function () {
  var slider = document.querySelector('[data-hero-slider]');
  if (!slider) return;

  var slides = slider.querySelectorAll('.hero-slider__slide');
  var dots = slider.querySelectorAll('.hero-slider__dot');
  var prevBtn = slider.querySelector('[data-slide-prev]');
  var nextBtn = slider.querySelector('[data-slide-next]');
  if (slides.length < 2) return;

  var AUTOPLAY_MS = 5200;
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var current = 0;
  var timer = null;

  function setDotFill(index, fraction, animate) {
    var fill = dots[index] && dots[index].querySelector('.hero-slider__dot-fill');
    if (!fill) return;
    fill.style.transition = animate ? 'transform ' + AUTOPLAY_MS + 'ms linear' : 'none';
    fill.style.transform = 'scaleX(' + fraction + ')';
  }

  function render(animateProgress) {
    slides.forEach(function (slide, i) { slide.classList.toggle('is-active', i === current); });
    dots.forEach(function (dot, i) {
      dot.classList.toggle('is-active', i === current);
      if (i < current) setDotFill(i, 1, false);
      else if (i > current) setDotFill(i, 0, false);
    });
    if (animateProgress) {
      setDotFill(current, 0, false);
      // Bir sonraki frame'de geçişi başlat ki tarayıcı "transition: none"ı uygulasın.
      requestAnimationFrame(function () { requestAnimationFrame(function () { setDotFill(current, 1, true); }); });
    } else {
      setDotFill(current, 1, false);
    }
  }

  function goTo(index) {
    current = (index + slides.length) % slides.length;
    render(!reduceMotion);
  }

  function startAutoplay() {
    if (reduceMotion) return;
    stopAutoplay();
    timer = setInterval(function () { goTo(current + 1); }, AUTOPLAY_MS);
  }
  function stopAutoplay() { if (timer) { clearInterval(timer); timer = null; } }

  dots.forEach(function (dot, i) {
    dot.addEventListener('click', function () { goTo(i); startAutoplay(); });
  });
  if (prevBtn) prevBtn.addEventListener('click', function () { goTo(current - 1); startAutoplay(); });
  if (nextBtn) nextBtn.addEventListener('click', function () { goTo(current + 1); startAutoplay(); });

  slider.addEventListener('mouseenter', stopAutoplay);
  slider.addEventListener('mouseleave', startAutoplay);
  slider.addEventListener('focusin', stopAutoplay);
  slider.addEventListener('focusout', startAutoplay);

  render(false);
  startAutoplay();
})();

/* ---------- Scroll reveal ---------- */
(function () {
  var els = document.querySelectorAll('.reveal');
  if (!els.length) return;
  if (!('IntersectionObserver' in window)) {
    els.forEach(function (el) { el.classList.add('in'); });
    return;
  }
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (e.isIntersecting) {
        e.target.classList.add('in');
        io.unobserve(e.target);
      }
    });
  }, { threshold: 0.12 });
  els.forEach(function (el, i) {
    el.style.transitionDelay = Math.min(i % 6, 3) * 60 + 'ms';
    io.observe(el);
  });
})();
