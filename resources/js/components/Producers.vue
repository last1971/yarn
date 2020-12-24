<template>
    <v-data-iterator :items="items"
                     :items-per-page="10"
                     :loading="loading"
                     :options.sync="proxyOptions"
                     :server-items-length="total"
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
            default: () => {
                return {
                    page: 1,
                    itemsPerPage: 10,
                    mustSort: false,
                    multiSort: false,
                    groupBy: [],
                    groupDesc: [],
                    sortBy: [],
                    sortDesc: [],
                };
            }
        }
    },
    data() {
        return {
            addCategory: false,
            model: 'producer'
        }
    },
}
</script>

<style scoped>

</style>
