<template>
    <v-data-iterator :items="items"
                     :items-per-page="itemsPerPage"
                     :loading="loading"
                     :options.sync="proxyOptions"
                     :server-items-length="total"
                     :footer-props="{
                         itemsPerPageOptions: [
                             itemsPerPage,
                             -1
                         ],
                         showCurrentPage: true,
                         showFirstLastPage: true,
                     }"
    >
        <template v-slot:header v-if="editMode">
            <v-container>
                <new-category :parent_id="parentId"
                              @reload="$emit('reload')"
                              v-if="items.length === 0 && parentId"
                />
                <new-product :category-id="parentId" @reload="reload" v-if="parentId" />
            </v-container>
        </template>
        <template v-slot:header v-else>
            <parameters-select v-model="proxyOptions"/>
        </template>
        <template v-slot:default="props">
            <v-container>
                <v-row>
                    <v-col v-for="item in props.items" :key="item.id" :cols="cols">
                        <model-card :value="item" :route-name="model"></model-card>
                    </v-col>
                </v-row>
            </v-container>
        </template>
    </v-data-iterator>
</template>

<script>
import ModelCard from "./ModelCard";
import isAdmin from "../mixins/isAdmin";
import screenMixin from "../mixins/screenMixin";
import tableMixins from "../mixins/tableMixins";
import ParametersSelect from "./ParameterComponents/ParametersSelect";
import NewCategory from "./NewCategory";
import NewProduct from "./NewProduct";

export default {
    name: "Products",
    components: {NewProduct, NewCategory, ParametersSelect, ModelCard},
    mixins: [isAdmin, screenMixin, tableMixins],
    props: {
        options: {
            type: Object,
            default: () => { return {}}
        },
        parentId: {
            type: String,
        }
    },
    data() {
        return {
            model: 'product',
            havingOptions: {
                havingAttributes: ['warehouse_balances_sum_balance'],
                havingOperators: ['>'],
                havingValues: [0],
            }
        }
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
                sortBy: ['name'],
                sortDesc: [false]
            },
            this.options,
            this.havingOptions,
        );
        // this.$emit('options:update', this.proxyOptions);
        // this.previousOptions = _.cloneDeep(this.proxyOptions);
        // await this.reload();
    },
    watch: {
        editMode(v) {
            const copy = _.cloneDeep(this.proxyOptions);
            if (!v) {
                this.$set(this, 'proxyOptions', _.assign(copy, this.havingOptions));
            } else {
                this.$delete(this.proxyOptions, 'havingAttributes');
                this.$delete(this.proxyOptions, 'havingOperators');
                this.$delete(this.proxyOptions, 'havingValues');
            }
            this.reload();
        }
    }
}
</script>

<style scoped>

</style>
