import _ from 'lodash';

export default {
    data() {
        return {
            itemIds: [],
            total: 0,
            loading: false,
            previousOptions: null,
            proxyOptions: null,
        }
    },
    computed: {
        MODEL() {
            return _.toUpper(this.model);
        },
        items() {
            return this.$store.getters[`${this.MODEL}/GET`](this.itemIds);
        },
    },
    watch: {
        proxyOptions: {
            handler: _.debounce(async function () {
                if (!_.isEqual(this.proxyOptions, this.previousOptions)) await this.reload();
                this.previousOptions = _.cloneDeep(this.proxyOptions);
                this.$emit('update:options', this.proxyOptions);
            }, 1000),
            deep: true
        },
        options: {
            handler: function(val) {
                if (!_.isEqual(val, this.previousOptions)) {
                    this.proxyOptions = val;
                }
            },
            deep: true,
        },
        itemsPerPage(val) {
            this.proxyOptions.itemsPerPage = val;
        },
    },
    async created() {
        this.proxyOptions = Object.assign(
            {
                page: 1,
                itemsPerPage: this.itemsPerPage,
                mustSort: false,
                multiSort: false,
                groupBy: [],
                groupDesc: [],
                sortBy: [],
                sortDesc: [],
            },
            this.options,
        );
        // this.$emit('options:update', this.proxyOptions);
        // this.previousOptions = _.cloneDeep(this.proxyOptions);
        // await this.reload();
    },
    methods: {
        async reload() {
            this.loading = true;
            try {
                const response = await this.$store.dispatch(`${this.MODEL}/ALL`, this.proxyOptions);
                this.itemIds = response.itemIds;
                this.total = response.total;
            } catch (e) {
                console.error(e);
            }
            this.loading = false;
        }
    }
}
