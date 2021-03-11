<template>
    <div class="answers">
        <h6>{{ answer.answer }}</h6>
                            <button>Edit answer</button>

    </div>
</template>

<script>
export default {
    props: {
        answer: Object,
    }
}
</script>

<style scoped>
.answers {
    display: right;

}
</style>