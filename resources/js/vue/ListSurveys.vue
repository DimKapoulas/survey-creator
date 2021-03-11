<template>
    <div>
        <div v-for="survey in surveys" v-bind:key="survey.id" >
            <Survey :survey="survey"
            @itemchanged="$emit('reloadlist')"/>
        </div>
    </div>
</template>

<script>
import Survey from './Survey'

export default {
    props: {
        surveys: Array
    },
    components: {
        Survey
    }
}
</script>

<style scoped>
.item {
    background: #e6e6e6;
    padding: 5px;
    margin-top: 5px;
}
</style>