(() => {
  'use strict';

  const filterButtons = document.querySelectorAll('[data-order-filter]');
  const orderItems = document.querySelectorAll('[data-order-status]');
  const noMatches = document.querySelector('[data-order-filter-empty]');

  if (filterButtons.length && orderItems.length) {
    const activeClasses = ['bg-[#156E8A]', 'dark:bg-[#2094B6]', 'text-white', 'border-[#156E8A]'];
    const inactiveClasses = ['bg-white', 'dark:bg-[#111a20]', 'text-gray-400', 'border-gray-200', 'dark:border-gray-700'];

    filterButtons.forEach((button) => {
      button.addEventListener('click', () => {
        const filter = button.dataset.orderFilter || 'all';
        let visibleItems = 0;

        filterButtons.forEach((filterButton) => {
          const isActive = filterButton === button;
          filterButton.classList.toggle('active', isActive);
          filterButton.setAttribute('aria-pressed', isActive ? 'true' : 'false');
          filterButton.classList.remove(...activeClasses, ...inactiveClasses);
          filterButton.classList.add(...(isActive ? activeClasses : inactiveClasses));
        });

        orderItems.forEach((item) => {
          const isVisible = filter === 'all' || item.dataset.orderStatus === filter;
          item.classList.toggle('hidden', !isVisible);
          item.setAttribute('aria-hidden', isVisible ? 'false' : 'true');

          if (isVisible) {
            visibleItems += 1;
          }
        });

        if (noMatches) {
          noMatches.classList.toggle('hidden', visibleItems > 0);
        }
      });
    });
  }

  const settingsToggles = document.querySelectorAll('[data-settings-toggle]');

  settingsToggles.forEach((toggle) => {
    toggle.addEventListener('click', (event) => {
      const targetId = toggle.dataset.settingsTarget;
      const target = targetId ? document.getElementById(targetId) : null;

      if (!target) {
        return;
      }

      event.preventDefault();
      target.classList.toggle('hidden');
      target.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });
  });
})();
