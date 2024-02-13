import preset from "../../../../vendor/filament/filament/tailwind.config.preset";
import colors from "tailwindcss/colors";
/** @type {import('tailwindcss').Config} */

export default {
    presets: [preset],
    content: [
        "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
    ],
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                danger: colors.rose,
                primary: colors.emerald,
                success: colors.green,
                warning: colors.purple,
            },
        },
    },
};
