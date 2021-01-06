<template>
    <v-container>
        <div v-for="(parameter, i) in parameterValues" :key="parameter.id">
            <parameter-edit v-model="parameterValues[i]" @input="save"/>
        </div>
    </v-container>
</template>

<script>
import ParameterEdit from "./ParameterEdit";
export default {
    name: "ParametersEdit",
    components: {ParameterEdit},
    props: {
        value: { type: Object, required: true },
    },
    data() {
        return {
            parameterValues: _.cloneDeep(this.value.parameter_values) || [],
        }
    },
    watch: {
        value: {
            handler() {
                this.parameterValues = _.cloneDeep(this.value.parameter_values) || [];
            },
            deep: true,
        }
    },
    async created() {
        if (_.isEmpty(this.$store.getters['PARAMETER-NAME/ALL'])) {
            await this.$store.dispatch(
                'PARAMETER-NAME/ALL',
                { sortBy: ['name'], sortDesc: [false], with: ['parameterUnit.parameterUnits']}
            );
        }
    },
    methods: {
        save() {
            const newValue = _.cloneDeep(this.value);
            newValue.parameter_values = this.parameterValues;
            this.$store.commit('PRODUCT/UPDATE', newValue);
        }
    }
}
</script>

<style scoped>

</style>
