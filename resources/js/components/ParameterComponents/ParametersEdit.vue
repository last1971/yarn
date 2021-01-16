<template>
    <v-container>
        <div v-for="(parameter, i) in parameterValues" :key="parameter.id">
            <parameter-edit v-model="parameterValues[i]" @input="save" @remove="remove" @add="add"/>
        </div>
        <parameter-add v-model="value"/>
    </v-container>
</template>

<script>
import ParameterEdit from "./ParameterEdit";
import ParameterAdd from "./ParameterAdd";
export default {
    name: "ParametersEdit",
    components: {ParameterAdd, ParameterEdit},
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
        },
        add(parameter) {
            const newValue = _.cloneDeep(this.value);
            newValue.parameter_values.push(parameter);
            this.$store.commit('PRODUCT/UPDATE', newValue);
        },
        remove(id) {
            const newValue = _.cloneDeep(this.value);
            const index = _.findIndex(newValue.parameter_values, { id });
            newValue.parameter_values.splice(index, 1);
            this.$store.commit('PRODUCT/UPDATE', newValue);
        }
    }
}
</script>

<style scoped>

</style>
