export default {
    computed: {
        instance() {
            return this.$store.getters[this.model + '/GET'](this.instanceId);
        },
    },
    watch: {
        instance(val) {
            this.proxy = _.cloneDeep(val);
        }
    },
    methods: {
        async save() {
            await this.$store.dispatch(this.model + '/UPDATE', this.proxy)
        }
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            vm.setInstanceId(to.params.id);
        });
    },
    beforeRouteUpdate (to, from, next) {
        this.setInstanceId(to.params.id);
        next();
    }
}
