<template>
    <v-container>
        <v-alert v-if="parameters.length" color="primary" class="text-center">Параметры</v-alert>
        <v-row v-for="parameter in parameters" :key="parameter.id">
            <v-col>
                {{ parameter.parameter_name.name }}:
            </v-col>
            <v-col>
                <parameter-show :parameter-name="parameter.parameter_name" :value="parameter" />
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import ParameterShow from "./ParameterShow";
export default {
    name: "ParametersShow",
    components: {ParameterShow},
    props: {
        value: {
            type: Object,
            required: true,
        }
    },
    computed: {
        parameters() {
            return this.value.parameter_values || [];
        }
    }
}
</script>

<style scoped>

</style>
