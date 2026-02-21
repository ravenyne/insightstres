export default {
    darkMode: 'class', // Enable dark mode with class strategy
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
    ],
    safelist: [
        // Tips & Articles category colors
        'bg-blue-500/20',
        'bg-purple-500/20',
        'bg-green-500/20',
        'bg-teal-500/20',
        'bg-orange-500/20',
        'bg-gray-500/20',
        'text-blue-400',
        'text-purple-400',
        'text-green-400',
        'text-teal-400',
        'text-orange-400',
        'text-gray-400',
        'text-slate-400',

        // Dynamic Badge Colors
        {
            pattern: /(bg|text|border|from|to)-(blue|purple|orange|yellow|green|teal|indigo|cyan|slate)-(50|100|200|300|400|500|600|700|800|900)/,
            variants: ['dark', 'hover'],
        },
        {
            pattern: /(bg|text|border)-(blue|purple|orange|yellow|green|teal|indigo|cyan|slate)-(50|100|200|300|400|500|600|700|800|900)\/([0-9]+)/,
            variants: ['dark', 'hover'],
        },
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}