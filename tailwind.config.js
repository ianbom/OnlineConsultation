import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.tsx',
    ],
    darkMode: "class",

    theme: {
        extend: {
            container: {
      center: true,
      padding: "1rem",
      screens: {
        "2xl": "1400px",
      },
    },
        colors: {
          primary: {
                    DEFAULT: "#7A0026",   // maroon utama
                    dark: "#4E0018",      // maroon gelap
                    light: "#B3123D",     // maroon terang
                },

                /** SECONDARY – CREAM / BEIGE **/
                secondary: {
                    DEFAULT: "#F5E6D3",   // cream utama
                    light: "#FAF3E8",      // cream lebih lembut
                    dark: "#D9C2A8",       // beige gelap
                },

                /** DARK / TEXT **/
                dark: {
                    DEFAULT: "#1A1A1A",
                    light: "#333333",
                    black: "#000000",
                },

                /** NEUTRAL GRAYS **/
                neutral: {
                    DEFAULT: "#E5E5E5",
                    light: "#F2F2F2",
                    dark: "#C2C2C2",
                },

                /** STATUS COLORS (optional UI) **/
                success: {
                    DEFAULT: "#16A34A",
                    light: "#DCFCE7",
                },
                danger: {
                    DEFAULT: "#DC2626",
                    light: "#FEE2E2",
                },
                warning: {
                    DEFAULT: "#EAB308",
                    light: "#FEF9C3",
                },
                info: {
                    DEFAULT: "#2563EB",
                    light: "#DBEAFE",
                },
          dark: {
            DEFAULT: "#3b3f5c",
            light: "#eaeaec",
            "dark-light": "rgba(59,63,92,.15)",
          },
          black: {
            DEFAULT: "#0e1726",
            light: "#e3e4eb",
            "dark-light": "rgba(14,23,38,.15)",
          },
          white: {
            DEFAULT: "#ffffff",
            light: "#e0e6ed",
            dark: "#888ea8",
          },

        },
        fontFamily: {
          nunito: ["Nunito", 'sans-serif'],
          poppins: ["Poppins", 'sans-serif'],
          sans: ['Figtree', ...defaultTheme.fontFamily.sans],
        },
        },
    },

    plugins: [forms],
    presets: [
    require('./tailwind.react.config.js')
  ],
};
