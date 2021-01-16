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
        <v-col v-if="isAdding">
            <v-btn-toggle>
                <v-btn @click="add" :loading="loading">
                    <v-icon color="success">mdi-plus</v-icon>
                </v-btn>
            </v-btn-toggle>
        </v-col>
        <v-col v-else>
            <v-btn-toggle>
            <v-btn  :disabled="disabled" @click="save" :loading="loading">
                <v-icon color="success">mdi-content-save</v-icon>
            </v-btn>
            <v-btn  @click="remove" :loading="loading">
                <v-icon color="error">mdi-delete</v-icon>
            </v-btn>
            </v-btn-toggle>
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
        },
        isAdding() {
            return !this.value.id;
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
        async remove() {
            this.loading = true;
            try {
                await this.$store.dispatch('PARAMETER-VALUE/REMOVE', this.proxy.id);
                this.$emit('remove', this.proxy.id);
            } catch (e) {
                console.error(e)
            }
            this.loading = false;
        },
        async add() {
            this.loading = true;
            try {
                const parameter = await this.$store.dispatch('PARAMETER-VALUE/CREATE', this.proxy);
                this.proxy = _.cloneDeep(this.value);
                this.$emit('input', parameter);
            } catch (e) {
                console.error(e);
            }
            this.loading = false;
        }
    }
}
</script>

<style scoped>

</style>
