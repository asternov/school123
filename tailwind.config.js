module.exports = {
    theme: {
        screens: {
            'sm': '640px',
            'md': '768px',
            'lg': '1024px',
            'xl': '1280px',
            'smmax': {'max': '640px'},
        }
    },
    variants: {},
    plugins: [
        require('tailwindcss'),
        require('autoprefixer'),
    ]
}
