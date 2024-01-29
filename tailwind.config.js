/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./index.html",
        "./**/*.{vue,js,ts,jsx,tsx}",
    ],
    theme: {
        colors: {
            'primary': '#194E92',
            'secondary': '#cb3234',
            'tertiary': '#1e5945',
            'background': '#fcefd8',
            'black': '#000000',
            'white': '#fffffc',
        },
        extend: {},
    },
    plugins: [],
}
