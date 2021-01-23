import _ from "lodash";

export default {
    props: {
        value: {type: [Array, Number, String]},
    },
    data() {
        return {
            isLoading: false,
            search: '',
            itemIds: [],
        }
    },
    computed: {
        proxy: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        },
        MODEL() {
            return _.toUpper(this.model)
        },
        items() {
            return this.$store.getters[this.MODEL + '/GET'](this.itemIds);
        },
    },
    watch: {
        search: _.debounce(async function (val) {
            // case when not need update data from server
            if (!val || this.isLoading) return;
            this.$emit('search', val);
            await this.getItems(val);
        }, process.env.MIX_DEBOUNCE),
        async value(val) {
            if (val) await this.getItem(val);
        }
    },
    created() {
        if (this.value) this.getItem(this.value);
    },
    methods: {
        async getItems(name = '') {
            this.isLoading = true;
            try {
                const response = await this.$store.dispatch(
                    this.MODEL + '/ALL',
                    {
                        whereAttributes: ['name'],
                        whereOperators: ['LIKE'],
                        whereValues: [ '%' + name + '%' ],
                    }
                );
                this.itemIds = response.itemIds;
            } catch (e) {
                console.error(e);
            }
            this.isLoading = false;
        },
        async getItem(id) {
            this.isLoading = true;
            try{
                await this.$store.dispatch(this.MODEL + '/CACHE', id);
                this.itemIds.push(id);
            } catch (e) {
                console.error(e);
            }
            this.isLoading = false;
        },
    }
}
