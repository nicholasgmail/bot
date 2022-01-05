const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            black: '#000',
            rose: colors.rose,
            white: colors.white,
            indigo: colors.indigo,
            gray: colors.gray,
            red: colors.red,
            yellow: colors.yellow,
            green: colors.green,
            amber: colors.amber,
            cyan: colors.cyan,
            brown: '#3f3939',
            blue: '#507383',
        }, animation: {
            none: 'none',
            spin: 'spin 1s linear infinite',
            ping: 'ping 1s cubic-bezier(0, 0, 0.2, 1) infinite',
            pulse: 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            bounce: 'bounce 1s infinite',
        },
        backdropBlur: (theme) => theme('blur'),
        backdropBrightness: (theme) => theme('brightness'),
        backdropContrast: (theme) => theme('contrast'),
        backdropGrayscale: (theme) => theme('grayscale'),
        backdropHueRotate: (theme) => theme('hueRotate'),
        backdropInvert: (theme) => theme('invert'),
        backdropOpacity: (theme) => theme('opacity'),
        backdropSaturate: (theme) => theme('saturate'),
        backdropSepia: (theme) => theme('sepia'),
        backgroundColor: (theme) => theme('colors'),
        backgroundImage: {
            none: 'none',
            'gradient-to-t': 'linear-gradient(to top, var(--tw-gradient-stops))',
            'gradient-to-tr': 'linear-gradient(to top right, var(--tw-gradient-stops))',
            'gradient-to-r': 'linear-gradient(to right, var(--tw-gradient-stops))',
            'gradient-to-br': 'linear-gradient(to bottom right, var(--tw-gradient-stops))',
            'gradient-to-b': 'linear-gradient(to bottom, var(--tw-gradient-stops))',
            'gradient-to-bl': 'linear-gradient(to bottom left, var(--tw-gradient-stops))',
            'gradient-to-l': 'linear-gradient(to left, var(--tw-gradient-stops))',
            'gradient-to-tl': 'linear-gradient(to top left, var(--tw-gradient-stops))',
        },
        backgroundOpacity: (theme) => theme('opacity'),
        backgroundPosition: {
            bottom: 'bottom',
            center: 'center',
            left: 'left',
            'left-bottom': 'left bottom',
            'left-top': 'left top',
            right: 'right',
            'right-bottom': 'right bottom',
            'right-top': 'right top',
            top: 'top',
        },
        backgroundSize: {
            auto: 'auto',
            cover: 'cover',
            contain: 'contain',
        },
        extend: {
            backgroundImage: theme => ({'welcome': "url('/storage/images/bg_welcome.jpg')"}),
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/typography'),
    ],
};
