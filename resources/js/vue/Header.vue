<template>
    <header>
        <h3 class="header">{{ title }}</h3>
        <Button @click-btn="$emit('click-btn')"
        :text="addSurveyText ? 'Close' : 'Add Survey'"
        :color="addSurveyText ? 'red' : 'green'"/>
    </header>
</template>

<script>
import Button from './Button'

export default {
    name: 'Header',
    props: {
        title: String,
        addSurveyText: Boolean
    },
    components: {
        Button
    },
    
}
</script>

<style scoped>
header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}
</style>