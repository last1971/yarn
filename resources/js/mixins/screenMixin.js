export default {
    computed: {
        cols() {
            switch (this.$vuetify.breakpoint.name) {
                case 'xs': return 12
                case 'sm': return 6
                case 'md': return 4
                case 'lg': return 3
                case 'xl': return 2
            }
        },
        minHeight () {
            switch (this.$vuetify.breakpoint.name) {
                case 'xs': return 300
                case 'sm': return 400
                case 'md': return 500
                case 'lg': return 600
                case 'xl': return 700
            }
        },
        itemsPerPage() {
            switch (this.$vuetify.breakpoint.name) {
                case 'xs': return 3
                case 'sm': return 6
                case 'md': return 9
                case 'lg': return 12
                case 'xl': return 18
            }
        }
    },
}
