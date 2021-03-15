<template>
    <div>
        <!-- Edit question -->
        <button type="text"
        @click="showEditQuestion = !showEditQuestion">
            Edit question</button>
        
        <i @click="removeQuestion" class="fas fa-times" style="color: red"></i>

        <h3>{{ question.question }}</h3>
        
        <Modal v-if="showEditQuestion" 
                    @click="showEditQuestion = false"
                    @close="showEditQuestion = !showEditQuestion">
                    <form>
                        <div class="form-control">
                            <input type="text" v-model="edit_question" name="question" placeholder="Edit question" />
                        </div>
                        <input type="submit" value="Save"
                        @click="editQuestion()" class="btn"/>
                    </form>
        </Modal>

       <!-- Add new answer -->
        <button type="button"
        @click="showAddAnswer = !showAddAnswer">
            add new answer</button>
        <Modal v-if="showAddAnswer" 
            @click="showAddAnswer = false"
            @close="showAddAnswer = !showAddAnswer" text="close">
            <form>
                <div class="form-group" v-for="(input,k) in inputs" :key="k">
                        <input type="text" class="form-control" v-model="input.answer" placeholder="Enter answer for this question">
                        <span>
                            <i class="fas fa-plus-circle" style="color:green" @click="add(k)" v-show="k == inputs.length-1"></i>
                            <i class="fas fa-minus-circle" style="color:red" @click="remove(k)" v-show="k || ( !k && inputs.length > 1)"></i>

                        </span>
                    </div>
                <input type="submit" value="Save" @click="newAnswer()" class="btn"/>
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
            showAddAnswer: false,
            showEditQuestion: false,
            new_answer: '',
            edit_question: this.question.question,
            inputs: [
                {
                    answer: ''
                }
            ],
        }
    },  
    methods: {
        // Add more input fields
        add(index) {
            this.inputs.push({});
        },
        // Remove input fields
        remove(index) {
            this.inputs.splice(index, 1);
        },
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
        editQuestion() {
            axios.put('api/questionnaires/' + this.question.questionnaire_id + '/questions/' + this.question.id,
            {
                "question": this.edit_question
            })
            .then( response => {
                if( response.status == 200 ) {
                    this.$emit('itemchanged');
                }
            })
            .catch( error => {
                console.log(error )
            });

        },
        newAnswer() {
            this.inputs.forEach(entry => {
                axios.post('api/questions/' + this.question.id + '/answers/store',
                { 
                    answer: entry.answer
                })
                .then( response => {
                    if( response.status == 200 ) {
                        this.$emit('itemchanged');
                    }
                })
                .catch( error => {
                    console.log( error )
                });
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