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
                TO DO
            </v-container>
        </template>
        <template v-slot:header v-else="editMode">
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

export default {
    name: "Products",
    components: {ParametersSelect, ModelCard},
    mixins: [isAdmin, screenMixin, tableMixins],
    props: {
        options: {
            type: Object,
            default: () => { return {}}
        }
    },
    data() {
        return {
            model: 'product'
        }
    },
}
</script>

<style scoped>

</style>
