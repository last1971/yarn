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
                case 'xs': return 700
                case 'sm': return 600
                case 'md': return 625
                case 'lg': return 650
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
