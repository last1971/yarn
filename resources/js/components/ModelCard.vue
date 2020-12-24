<template>
    <v-card :to="{ name: routeName, params: { id: value.id, slug: value.slug } }"
            :minHeight="minHeight"
            shaped
    >
        <v-card-title>
            {{ value.name }}
        </v-card-title>
        <v-card-subtitle>
            {{ value.description }}
        </v-card-subtitle>
        <v-card-text>
            <v-img :src="'/picture/' + value.slug + '/' + value.id + '/' + ( value.picture ? value.picture.file : '1') "
                   :min-height="minHeight / 2"

            />
        </v-card-text>
    </v-card>
</template>

<script>
import screenMixin from "../mixins/screenMixin";

export default {
    name: "ModelCard",
    mixins: [screenMixin],
    props: {
        value: { type: Object, required: true },
        routeName: { type: String, required: true }
    },
}
</script>

<style scoped>

</style>
