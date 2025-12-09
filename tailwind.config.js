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
    darkMode: ["class", 'class'],

    theme: {
    	extend: {
    		container: {
    			center: true,
    			padding: '1rem',
    			screens: {
    				'2xl': '1400px'
    			}
    		},
    		colors: {
    			primary: {
    				DEFAULT: 'hsl(var(--primary))',
    				dark: '#4E0018',
    				light: '#B3123D',
    				foreground: 'hsl(var(--primary-foreground))'
    			},
    			secondary: {
    				DEFAULT: 'hsl(var(--secondary))',
    				light: '#FAF3E8',
    				dark: '#D9C2A8',
    				foreground: 'hsl(var(--secondary-foreground))'
    			},
    			dark: {
    				DEFAULT: '#3b3f5c',
    				light: '#eaeaec',
    				'dark-light': 'rgba(59,63,92,.15)'
    			},
    			neutral: {
    				DEFAULT: '#E5E5E5',
    				light: '#F2F2F2',
    				dark: '#C2C2C2'
    			},
    			success: {
    				DEFAULT: '#16A34A',
    				light: '#DCFCE7'
    			},
    			danger: {
    				DEFAULT: '#DC2626',
    				light: '#FEE2E2'
    			},
    			warning: {
    				DEFAULT: '#EAB308',
    				light: '#FEF9C3'
    			},
    			info: {
    				DEFAULT: '#2563EB',
    				light: '#DBEAFE'
    			},
    			black: {
    				DEFAULT: '#0e1726',
    				light: '#e3e4eb',
    				'dark-light': 'rgba(14,23,38,.15)'
    			},
    			white: {
    				DEFAULT: '#ffffff',
    				light: '#e0e6ed',
    				dark: '#888ea8'
    			},
    			background: 'hsl(var(--background))',
    			foreground: 'hsl(var(--foreground))',
    			card: {
    				DEFAULT: 'hsl(var(--card))',
    				foreground: 'hsl(var(--card-foreground))'
    			},
    			popover: {
    				DEFAULT: 'hsl(var(--popover))',
    				foreground: 'hsl(var(--popover-foreground))'
    			},
    			muted: {
    				DEFAULT: 'hsl(var(--muted))',
    				foreground: 'hsl(var(--muted-foreground))'
    			},
    			accent: {
    				DEFAULT: 'hsl(var(--accent))',
    				foreground: 'hsl(var(--accent-foreground))'
    			},
    			destructive: {
    				DEFAULT: 'hsl(var(--destructive))',
    				foreground: 'hsl(var(--destructive-foreground))'
    			},
    			border: 'hsl(var(--border))',
    			input: 'hsl(var(--input))',
    			ring: 'hsl(var(--ring))',
    			chart: {
    				'1': 'hsl(var(--chart-1))',
    				'2': 'hsl(var(--chart-2))',
    				'3': 'hsl(var(--chart-3))',
    				'4': 'hsl(var(--chart-4))',
    				'5': 'hsl(var(--chart-5))'
    			}
    		},
    		fontFamily: {
    			nunito: [
    				'Nunito',
    				'sans-serif'
    			],
    			poppins: [
    				'Poppins',
    				'sans-serif'
    			],
    			sans: [
    				'Figtree',
                    ...defaultTheme.fontFamily.sans
                ]
    		},
    		borderRadius: {
    			lg: 'var(--radius)',
    			md: 'calc(var(--radius) - 2px)',
    			sm: 'calc(var(--radius) - 4px)'
    		}
    	}
    },

    plugins: [forms, require("tailwindcss-animate")],
    presets: [
    require('./tailwind.react.config.js')
  ],
};
