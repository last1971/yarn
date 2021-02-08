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
                <new-category :parent_id="parentId" @reload="reload"/>
            </v-container>
        </template>
        <template v-slot:default="props">
            <v-container>
                <v-row>
                    <v-col v-for="item in props.items" :key="item.id" :cols="cols">
                        <model-card :value="item"
                                    :route-name="model"
                                    :max-description-length="maxDescriptionLength(props)"
                        />
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
import NewCategory from "./NewCategory";
import tableMixins from "../mixins/tableMixins";

export default {
    name: "Categories",
    components: {NewCategory, ModelCard},
    mixins: [isAdmin, screenMixin, tableMixins],
    props: {
        options: {
            type: Object,
            default: () => {
                return {
                    nullAttributes: ['parent_id'],
                    sortBy: ['name'],
                    sortDesc: [false]
                };
            }
        }
    },
    data() {
        return {
            addCategory: false,
            model: 'category'
        }
    },
    computed: {
        parentId() {
            const index = this.options.whereAttributes ? this.options.whereAttributes.indexOf('parent_id') : -1;
            return index >= 0 ? this.options.whereValues[index] : null;
        }
    },
    methods: {
        maxDescriptionLength(v) {
            return _.max(v.items.map((item) => item.description ? item.description.length : 0));
        }
    }
}
</script>

<style scoped>

</style>
