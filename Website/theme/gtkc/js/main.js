/* Get To Know Claude — main.js */

document.addEventListener('DOMContentLoaded', function () {

  // ── Email Signup Form ─────────────────────────────────────
  const form = document.getElementById('gtkc-signup-form');
  if (form) {
    const successMsg = document.getElementById('signup-success');
    const errorMsg   = document.getElementById('signup-error');
    const submitBtn  = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', async function (e) {
      e.preventDefault();

      const email = form.querySelector('#signup-email').value.trim();
      if (!email) {
        showMessage(errorMsg, 'Please enter your email address.');
        return;
      }

      submitBtn.textContent = 'Subscribing…';
      submitBtn.disabled = true;

      const data = new FormData(form);
      data.append('action', 'gtkc_signup');
      data.append('nonce', gtkcAjax.nonce);

      try {
        const res  = await fetch(gtkcAjax.ajaxurl, { method: 'POST', body: data });
        const json = await res.json();

        if (json.success) {
          form.reset();
          showMessage(successMsg, json.data.message);
          hideMessage(errorMsg);
          submitBtn.textContent = '✓ Check your inbox';
        } else {
          showMessage(errorMsg, json.data.message || 'Something went wrong. Please try again.');
          hideMessage(successMsg);
          submitBtn.textContent = 'Subscribe — it\'s free';
          submitBtn.disabled = false;
        }
      } catch (err) {
        showMessage(errorMsg, 'Network error. Please try again.');
        submitBtn.textContent = 'Subscribe — it\'s free';
        submitBtn.disabled = false;
      }
    });
  }

  // ── Subscribed confirmation banner ───────────────────────
  const params = new URLSearchParams(window.location.search);
  if (params.get('subscribed') === '1') {
    const banner = document.createElement('div');
    banner.style.cssText = 'position:fixed;top:76px;left:50%;transform:translateX(-50%);background:#1e7e4a;color:#fff;font-family:sans-serif;font-size:14px;padding:12px 24px;border-radius:99px;z-index:999;box-shadow:0 4px 16px rgba(0,0,0,0.2);';
    banner.textContent = '✓ You\'re subscribed! Welcome to GetToKnowClaude.com.';
    document.body.appendChild(banner);
    setTimeout(() => banner.remove(), 6000);
  }

  // ── Smooth scroll for anchor links ───────────────────────
  document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // ── Helpers ───────────────────────────────────────────────
  function showMessage(el, msg) {
    el.textContent = msg;
    el.style.display = 'block';
  }
  function hideMessage(el) {
    el.style.display = 'none';
  }

});
