/**
 * @link https://tailwindcss.com/docs/customizing-colors
 * @link https://tailwindcss.com/docs/presets
 */

const colors = require('tailwindcss/colors');

module.exports = {
    presets: [
        require('./tailwind-preset')
    ],

    // This configuration will be merged
    theme: {
        extend: {
            colors: {
                padrao: colors.blue,
                escuro: colors.slate
            }
        },
    },
};
