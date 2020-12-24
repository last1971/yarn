import _ from 'lodash';

export default {
    data() {
        return {
            itemIds: [],
            total: 0,
            loading: false,
            previousOptions: this.options,
        }
    },
    computed: {
        MODEL() {
            return _.toUpper(this.model);
        },
        items() {
            return this.$store.getters[`${this.MODEL}/GET`](this.itemIds);
        },
        proxyOptions: {
            get() {
                return this.options;
            },
            set(options) {
                this.$emit('update:options', options);
            },
        },
    },
    watch: {
        options: {
            handler: _.debounce(async function () {
                if (!_.isEqual(this.options, this.previousOptions)) await this.reload();
                this.previousOptions = _.cloneDeep(this.options);
            }, 1000),
            deep: true
        }
    },
    async created() {
        await this.reload();
    },
    methods: {
        async reload() {
            const response = await this.$store.dispatch(`${this.MODEL}/ALL`, this.options);
            this.itemIds = response.itemIds;
            this.total = response.total;
        }
    }
}
