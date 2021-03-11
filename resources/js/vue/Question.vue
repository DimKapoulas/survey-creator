<template>
    <div>
        <h4>{{ question.question }}</h4>
                    <button>add new answer</button>
        <div v-for="answer in question.answers" :key="answer.id">
            <ul>
                <li class="list">

            <Answer :answer="answer"/>

                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import Answer from './Answer'
export default {
    components: {
        Answer,
    },
    props: {
        question: Object
    }
}
</script>

<style scoped>
.list {
    /* display: flex; */
    margin-left: 30px;
}
</style>