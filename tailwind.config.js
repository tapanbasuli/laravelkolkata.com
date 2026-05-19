/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.html",
    "./service/**/*.html",
    "./industry/**/*.html",
    "./technology/**/*.html",
    "./ai/**/*.html"
  ],
  theme: {
    extend: {
      colors: {
        'laravel-red': '#FF2D20',
        'laravel-orange': '#FF6B35',
        'laravel-dark': '#1A202C',
      }
    },
  },
  plugins: [],
}
