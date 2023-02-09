/** @type {import('tailwindcss').Config} */
module.exports = {
  presets: [
    require('./vendor/wireui/wireui/tailwind.config.js')
  ],
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",

    "./vendor/wireui/wireui/resources/**/*.blade.php",
    "./vendor/wireui/wireui/ts/**/*.ts",
    "./vendor/wireui/wireui/src/View/**/*.php"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
