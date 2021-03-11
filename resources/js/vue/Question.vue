<template>
    <div>
        <button type="button">Edit question</button>
        <i @click="removeQuestion" class="fas fa-times"></i>
        <h3>{{ question.question }}</h3>
        <button>add new answer</button>
        
        <div v-for="answer in question.answers" :key="answer.id">
            <ul>
                <li class="list">
                    <Answer :answer="answer"
                    @itemchanged="$emit('itemchanged')"/>
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
    },
    methods: {
        removeQuestion() {
            axios.delete('api/questionnaires/' + this.question.questionnaire_id + '/questions/' + this.question.id)
            .then( response => {
                if( response.status == 204 ) {
                    this.$emit('itemchanged');
                }
            })
            .catch( error => {
                console.log(error )
            })

        }
    }
}
</script>

<style scoped>
.list {
    margin-left: 30px;
}
</style>