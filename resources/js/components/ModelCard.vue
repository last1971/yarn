<template>
    <v-card :to="{ name: routeName, params: { id: value.id, slug: value.slug } }"
            :min-height="minHeight"
            :max-height="minHeight"
            class="d-flex flex-wrap"
            shaped
    >
        <v-card-title class="align-self-start">
            {{ value.name }}&nbsp;
        </v-card-title>
        <v-card-subtitle>
            <span>{{ getPartText(0) }}</span>
            <span v-for="i of 5" :key="i" :class="'blurry-text' + i + ' transparent--text'" style="display:inline-block;">
                {{ getPartText(i) }}&nbsp;
            </span>
        </v-card-subtitle>
        <v-card-text class="align-self-end">
            <v-img :src="'/picture/' + value.slug + '/' + value.id + '/' + ( value.picture ? value.picture.file : '1') "
                   :lazy-src="'/picture/' + value.slug + '/' + value.id + '/' + ( value.picture ? value.picture.file : '1') "
                   :min-height="minHeight / 2"

            />
        </v-card-text>
    </v-card>
</template>

<script>
//style="white-space: pre-line"
import screenMixin from "../mixins/screenMixin";

export default {
    name: "ModelCard",
    mixins: [screenMixin],
    props: {
        value: { type: Object, required: true },
        routeName: { type: String, required: true },
        maxDescriptionLength: { type: Number, default: 200 },
    },
    data() {
        return {
            maxLength: 200,
            stepLength: 15,
        }
    },
    methods: {
        getPartText(n) {
            const baseString = this.value.description || '';
            let returnString = baseString;
            let start = 0;
            let end = this.maxLength > baseString.length ? baseString.length : this.maxLength;
            // if (this.value.name === 'Dr. Davon Mertz II') debugger
            for (let i=0; i <= n; i++) {
                if (baseString.length + n * this.stepLength  <= end) {
                    // console.log(start,end);
                    return baseString.substring(start, end);
                }
                const spaceIndex = baseString.indexOf(' ', end);
                // console.log(start, end, spaceIndex, baseString.substr(0, 10), n, returnString.substr(0, 10));
                returnString = baseString.substring(start, spaceIndex > 0 ? spaceIndex : end);
                start = spaceIndex > 0 ? spaceIndex : end;
                end += this.stepLength;
            }
            return returnString;
        }
    }
}
</script>

<style scoped>
.blurry-text1 {
    text-shadow: 0 0 1px rgba(0,0,0,0.5);
}
.blurry-text2 {
    text-shadow: 0 0 2px rgba(0,0,0,0.5);
}
.blurry-text3 {
    text-shadow: 0 0 3px rgba(0,0,0,0.5);
}
.blurry-text4 {
    text-shadow: 0 0 4px rgba(0,0,0,0.5);
}
.blurry-text5 {
    text-shadow: 0 0 5px rgba(0,0,0,0.5);
}
</style>
