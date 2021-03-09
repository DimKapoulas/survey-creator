<template>
    <div>
        <div :key="survey.id" v-for="survey in surveys">
            <Survey :survey="survey"/>
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