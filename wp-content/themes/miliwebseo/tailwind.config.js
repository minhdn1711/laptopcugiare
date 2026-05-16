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
      fontFamily: {
        'sans': ['Outfit', 'sans-serif'],
      },
      colors: {
        primary: {
          DEFAULT: '#10B981', // New Brand Green
          dark: '#059669',
          light: '#F0FDF4',
        },
        secondary: '#1a1a1a', // Rich Black
        accent: '#3b82f6', // Professional Blue
      },
      borderRadius: {
        'xl': '1rem',
        '2xl': '1.5rem',
      },
      boxShadow: {
        'premium': '0 10px 30px -10px rgba(0, 0, 0, 0.1)',
        'premium-hover': '0 20px 40px -15px rgba(0, 0, 0, 0.15)',
      }
    },
  },
  plugins: [],
}
