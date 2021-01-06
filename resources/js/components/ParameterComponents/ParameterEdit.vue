<template>
    <v-row>
        <v-col>
            <parameter-name-select v-model="parameterNameId"/>
            <parameter-unit-select v-if="proxy.parameter_name.type !== 'string'"
                                   v-model="proxy.parameter_unit_id"
                                   :parameter-name-id="parameterNameId"
             />
        </v-col>
        <v-col v-if="proxy.parameter_name.type === 'string'">
            <v-text-field label="Значение" v-model="proxy.string_value"/>
        </v-col>
        <v-col v-if="proxy.parameter_name.type === 'numeric'">
            <v-text-field label="Значение" v-model="proxy.numeric_value"/>
            <v-text-field label="Дробь" v-model="proxy.fraction"/>
        </v-col>
        <v-col v-if="proxy.parameter_name.type === 'complex'">
            <v-text-field label="Текст" v-model="proxy.string_value"/>
            <v-text-field label="Число" v-model="proxy.numeric_value"/>
            <v-text-field label="Дробь" v-model="proxy.fraction"/>
        </v-col>
        <v-col>
            <v-btn fab :disabled="disabled" @click="save" :loading="loading">
                <v-icon color="success">mdi-content-save</v-icon>
            </v-btn>
        </v-col>
    </v-row>
</template>

<script>
import ParameterNameSelect from "./ParameterNameSelect";
import ParameterUnitSelect from "./ParameterUnitSelect";
export default {
    name: "ParameterEdit",
    components: {ParameterUnitSelect, ParameterNameSelect},
    props: {
        value: { type: Object, required: true },
    },
    data() {
        return {
            proxy: _.cloneDeep(this.value),
            loading: false,
        };
    },
    computed: {
        parameterNameId: {
            get() {
                return this.proxy.parameter_name_id;
            },
            set(v) {
                this.proxy.parameter_name_id = v;
                this.proxy.parameter_name = this.$store.getters['PARAMETER-NAME/GET'](v);
            }
        },
        disabled() {
            return _.isEqual(this.value, this.proxy);
        }
    },
    watch: {
        value(v) {
            this.proxy = _.cloneDeep(v);
        }
    },
    methods: {
        async save() {
            this.loading = true;
            try {
                const parameter = await this.$store.dispatch('PARAMETER-VALUE/UPDATE', this.proxy);
                this.$emit('input', parameter);
            } catch (e) {
                console.error(e)
            }
            this.loading = false;
        },
    }
}
</script>

<style scoped>

</style>
