/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./patterns/**/*.php",
    "./templates/**/*.php",
    "./parts/**/*.php",
    "./*.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          // Maasai red shades
          50: '#FFF5F5',
          100: '#FED7D7',
          200: '#FEB2B2',
          300: '#FC8181',
          400: '#F56565',
          500: '#E53E3E', // Primary Maasai red
          600: '#C53030',
          700: '#9B2C2C',
          800: '#822727',
          900: '#63171B',
        },
        shuka: {
          // Traditional Maasai shuka colors
          red: '#E53E3E',     // Primary red
          black: '#111827',   // Deep black
          blue: '#2563EB',    // Royal blue
          yellow: '#FBBF24',  // Vibrant yellow
          orange: '#F97316',  // Warm orange
          green: '#059669',   // Forest green
          beige: '#F3F4F6',   // Light background
          earth: '#92400E',   // Earth tone
        },
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
        display: ['Montserrat', 'sans-serif'],
      },
      backgroundImage: {
        'shuka-pattern': "repeating-linear-gradient(45deg, var(--tw-gradient-from) 0, var(--tw-gradient-from) 10px, var(--tw-gradient-to) 10px, var(--tw-gradient-to) 20px)",
        'shuka-vertical': "repeating-linear-gradient(90deg, var(--tw-gradient-from) 0, var(--tw-gradient-from) 10px, var(--tw-gradient-to) 10px, var(--tw-gradient-to) 20px)",
        'shuka-horizontal': "repeating-linear-gradient(0deg, var(--tw-gradient-from) 0, var(--tw-gradient-from) 10px, var(--tw-gradient-to) 10px, var(--tw-gradient-to) 20px)",
      },
      borderWidth: {
        '3': '3px',
        '6': '6px',
        '10': '10px',
      },
    },
  },
  plugins: [],
}
