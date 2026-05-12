/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./inc/**/*.php",
    "./templates/**/*.php",
    "./woocommerce/**/*.php",
    "./src/**/*.{js,css}",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#f59e0b', // Gold/Yellow from laptop88
          dark: '#d97706',
        },
        secondary: '#000000',
      }
    },
  },
  plugins: [],
}
