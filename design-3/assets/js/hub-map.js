/**
 * Operasyon / Hub bölümündeki gerçek harita (Leaflet + OpenStreetMap/CARTO karoları).
 *
 * #hub-map elementi yoksa veya Leaflet yüklenmediyse sessizce çıkar. Konum verisi
 * elementin data-locations attribute'unda JSON olarak taşınır (bkz. pages/about.php).
 * Açık/koyu tema geçişinde karo katmanını da değiştirir (bkz. main.js data-theme).
 */
(function () {
  'use strict';

  function escapeHtml(value) {
    return String(value).replace(/[&<>"']/g, function (ch) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ch];
    });
  }

  function init() {
    var el = document.getElementById('hub-map');
    if (!el || typeof L === 'undefined') {
      return;
    }

    var locations;
    try {
      locations = JSON.parse(el.getAttribute('data-locations') || '[]');
    } catch (err) {
      locations = [];
    }
    if (!locations.length) {
      return;
    }

    var TILE_LIGHT = 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';
    var TILE_DARK = 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png';
    var ATTRIBUTION =
      '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a> ' +
      '&copy; <a href="https://carto.com/attributions" target="_blank" rel="noopener">CARTO</a>';

    function currentTheme() {
      return document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
    }

    var map = L.map(el, {
      scrollWheelZoom: false,
      attributionControl: true,
    });

    var tileLayer = L.tileLayer(currentTheme() === 'dark' ? TILE_DARK : TILE_LIGHT, {
      attribution: ATTRIBUTION,
      maxZoom: 19,
    }).addTo(map);

    function markerIcon(isCenter) {
      return L.divIcon({
        className: 'hub-map-marker' + (isCenter ? ' hub-map-marker--center' : ''),
        html: '<span></span>',
        iconSize: isCenter ? [22, 22] : [14, 14],
        iconAnchor: isCenter ? [11, 11] : [7, 7],
      });
    }

    var bounds = [];
    locations.forEach(function (loc) {
      var lat = parseFloat(loc.lat);
      var lng = parseFloat(loc.lng);
      if (isNaN(lat) || isNaN(lng)) {
        return;
      }

      var marker = L.marker([lat, lng], { icon: markerIcon(!!loc.is_center) }).addTo(map);
      marker.bindTooltip(
        '<strong>' + escapeHtml(loc.area_name || '') + '</strong>' +
          (loc.region_label ? '<small>' + escapeHtml(loc.region_label) + '</small>' : ''),
        { permanent: true, direction: 'top', offset: [0, loc.is_center ? -14 : -10], className: 'hub-map__tooltip' }
      );
      bounds.push([lat, lng]);
    });

    if (bounds.length > 1) {
      map.fitBounds(bounds, { padding: [42, 56] });
    } else if (bounds.length === 1) {
      map.setView(bounds[0], 12);
    }

    // Sayfa kaydırmasını kilitlememesi için scroll-zoom yalnızca haritaya
    // tıklandığında/odaklanıldığında açılır.
    map.on('focus', function () { map.scrollWheelZoom.enable(); });
    map.on('blur', function () { map.scrollWheelZoom.disable(); });

    // Açık/koyu tema değiştiğinde karo katmanını canlı olarak güncelle.
    var observer = new MutationObserver(function () {
      tileLayer.setUrl(currentTheme() === 'dark' ? TILE_DARK : TILE_LIGHT);
    });
    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
