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
                <new-producer @reload="reload"/>
            </v-container>
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
import NewProducer from "./NewProducer";

export default {
    name: "Producers",
    components: {NewProducer, ModelCard},
    mixins: [isAdmin, screenMixin, tableMixins],
    props: {
        options: {
            type: Object,
        }
    },
    data() {
        return {
            model: 'producer'
        }
    },
}
</script>

<style scoped>

</style>
