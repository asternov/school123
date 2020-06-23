module.exports = {
    theme: {
        screens: {
            'sm': '639px',
            'md': '768px',
            'lg': '1024px',
            'xl': '1280px',
            'smmax': {'max': '641px'},
        }
    },
    variants: {},
    plugins: [
        require('tailwindcss'),
        require('autoprefixer'),
    ]
}
