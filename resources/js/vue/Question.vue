<template>
    <div>
        <button type="button">Edit question</button>
        <i @click="removeQuestion" class="fas fa-times"></i>
        <h3>{{ question.question }}</h3>
        <button type="text"
        @click="showModal = !showModal">
            add new answer</button>
        <Modal v-if="showModal" 
            @click="showModal = false"
            @close="showModal = !showModal">
            <form>
                <div class="form-control">
                    <input type="text" v-model="new_answer" name="answer" placeholder="Add new answer for question"/>
                </div>
                <input type="submit" value="Save"
                @click="newAnswer()" class="btn"/>
            </form>
        </Modal>
        
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
import Modal from './ModalComponent'

export default {
    components: {
        Answer,
        Modal,
    },
    props: {
        question: Object
    },
    data () {
        return {
            showModal: false,
            new_answer: '',
        }
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

        },
        newAnswer() {
            axios.post('api/questions/' + this.question.id + '/answers/store',
            { 
                answer: this.new_answer
            })
            .then( response => {
                if( response.status == 200 ) {
                    this.$emit('itemchanged');
                }
            })
            .catch( error => {
                console.log(error )
            });
        }
            
    }
}
</script>

<style scoped>
.list {
    margin-left: 30px;
}
</style>