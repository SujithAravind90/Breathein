tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        brandTeal: "#1A7388",
        tickerDark: "#0D1418",
        badgeHazardous: "#7E1E29",
        badgeVeryUnhealthy: "#A85317",
        badgeUnhealthy: "#B28816",
        textMuted: "#8E989E",
      },
      fontFamily: {
        sans: ["Inter", "sans-serif"],
      },
    },
  },
};

if (
  localStorage.getItem("theme") === "dark" ||
  (!("theme" in localStorage) &&
    window.matchMedia("(prefers-color-scheme: dark)").matches)
) {
  document.documentElement.classList.add("dark");
} else {
  document.documentElement.classList.remove("dark");
}

// ==============================================================
// TOGGLE BUTTON LOGIC (Best placed at the bottom of the <body>)
// ==============================================================
document.addEventListener("DOMContentLoaded", () => {
  const themeToggleBtns = document.querySelectorAll("#themeToggle, #mobileThemeToggle");

  themeToggleBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      // 1. Toggle the class visually on the page
      document.documentElement.classList.toggle("dark");

      // 2. Save the user's new preference to localStorage
      if (document.documentElement.classList.contains("dark")) {
        localStorage.setItem("theme", "dark");
      } else {
        localStorage.setItem("theme", "light");
      }
    });
  });
});
