(function () {
	// Mobile menu.
	var toggle = document.querySelector('[data-menu-toggle]');
	var mobile = document.getElementById('mobile-nav');
	if (toggle && mobile) {
		toggle.addEventListener('click', function () {
			var open = mobile.hidden;
			mobile.hidden = !open;
			toggle.setAttribute('aria-expanded', String(open));
			toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
			toggle.querySelector('[data-icon-open]').hidden = open;
			toggle.querySelector('[data-icon-close]').hidden = !open;
		});
	}

	// FAQ accordion: one answer open at a time.
	function swap(el, on, off, state) {
		on.split(' ').forEach(function (c) { el.classList.toggle(c, state); });
		off.split(' ').forEach(function (c) { el.classList.toggle(c, !state); });
	}
	function setFaq(li, open) {
		var btn = li.querySelector('button');
		var panel = li.querySelector('[role="region"]');
		btn.setAttribute('aria-expanded', String(open));
		swap(li, 'border-sea', 'border-sky/60 hover:border-sky', open);
		swap(btn.querySelector('[data-code]'), 'bg-sea text-white', 'bg-foam text-sea', open);
		btn.querySelector('svg').classList.toggle('rotate-45', open);
		swap(panel, 'grid-rows-[1fr]', 'grid-rows-[0fr]', open);
		panel.firstElementChild.inert = !open;
	}
	document.querySelectorAll('[data-faq]').forEach(function (list) {
		var items = Array.prototype.slice.call(list.children);
		items.forEach(function (li) {
			li.querySelector('button').addEventListener('click', function () {
				var wasOpen = this.getAttribute('aria-expanded') === 'true';
				items.forEach(function (other) { setFaq(other, false); });
				if (!wasOpen) setFaq(li, true);
			});
		});
	});

	// Booking boarding-pass summary.
	var booking = document.querySelector('[data-booking]');
	if (booking) {
		var f = booking.elements;
		var sum = function (key, value) { booking.querySelector('[data-sum="' + key + '"]').textContent = value || '—'; };
		var month = function (v) {
			if (!v) return '';
			var p = v.split('-');
			return new Date(+p[0], +p[1] - 1, 1).toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
		};
		var update = function () {
			var opt = f.destination.options[f.destination.selectedIndex];
			var chosen = f.destination.value;
			booking.querySelector('[data-sum="code"]').textContent = (opt && opt.dataset.code) || '???';
			booking.querySelector('[data-sum="dest"]').textContent = chosen === 'other' ? 'Somewhere new' : (chosen ? opt.textContent : 'Choose a destination');
			sum('name', f.name.value);
			sum('month', month(f.month.value));
			var guests = (+f.adults.value || 0) + (+f.children.value || 0);
			sum('guests', guests ? String(guests) : '');
			sum('nights', f.nights.value === 'Not sure yet' ? '' : f.nights.value);
			sum('cabin', f.cabin.value === 'Not sure yet' ? '' : f.cabin.value);
		};
		booking.addEventListener('input', update);
		booking.addEventListener('change', update);
		update();
	}

	// Ajax submit for contact and booking forms.
	document.querySelectorAll('[data-jet-form]').forEach(function (form) {
		var btn = form.querySelector('button[type="submit"]');
		var show = function (status) {
			form.querySelector('[data-status-box]').hidden = !status;
			form.querySelectorAll('[data-status]').forEach(function (el) { el.hidden = el.dataset.status !== status; });
		};
		var busy = function (on) {
			btn.disabled = on;
			btn.querySelector('[data-idle]').hidden = on;
			btn.querySelector('[data-busy]').hidden = !on;
		};
		form.addEventListener('submit', function (e) {
			e.preventDefault();
			show('');
			busy(true);
			fetch(window.jetstream.ajax, { method: 'POST', body: new FormData(form), credentials: 'same-origin' })
				.then(function (r) { return r.json(); })
				.then(function (res) {
					if (!res || !res.success) throw new Error('failed');
					show('success');
					var clear = form.dataset.reset;
					if (clear && form.elements[clear]) form.elements[clear].value = '';
				})
				.catch(function () { show('error'); })
				.then(function () { busy(false); });
		});
	});
})();
