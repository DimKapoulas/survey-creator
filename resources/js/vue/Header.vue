<template>
    <header>
        <h3 class="header">{{ title }}</h3>
        <Button text="Add Survey"/>
    </header>
</template>

<script>
import Button from './Button'

export default {
    name: 'Header',
    props: {
        'title': String
    },
    components: {
        Button
    }
    
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