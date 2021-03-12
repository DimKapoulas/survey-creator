<template>
    <div>
        {{ test_id }}
        <div class="survey">
            <h1>{{ survey.title }}</h1>
            
            <button id="show-modal" class="details" @click="showModal = !showModal"
            >Details</button>
            <i @click="removeSurvey" class="fas fa-times" style="color: red"></i>
        </div>
            <!-- Show Details -->
            <Modal v-if="showModal" 
            @click="showModal = false"
            @close="showModal = !showModal" text="close-details">

                <!-- Add new Question -->
                <button type="button"
                @click="showAddQuestion = !showAddQuestion">
                Add new question</button>
                <Modal v-if="showAddQuestion" 
                    @click="showAddQuestion = false"
                    @close="showAddQuestion = !showAddQuestion" text="close">
                    <form>
                        <div class="form-control">
                            <form>
                                <!-- Question input -->
                            <input type="text" v-model="new_question" name="question" placeholder="Enter a question"/>
                                <!-- Dynamic multiple answer inputs -->
                            <div class="form-group" v-for="(input,k) in inputs" :key="k">
                                <input type="text" class="form-control" v-model="input.answer" placeholder="Enter answer for this question">
                                <span>
                                    <i class="fas fa-plus-circle" style="color:green" @click="add(k)" v-show="k == inputs.length-1"></i>
                                    <i class="fas fa-minus-circle" style="color:red" @click="remove(k)" v-show="k || ( !k && inputs.length > 1)"></i>

                                </span>
                                </div>
                            </form>
                        </div>

                        <input type="submit" value="Save"
                        @click="newQuestion()" class="btn"/>
                    </form>
                </Modal>

                <!-- List this Survey's questions -->
                <div v-bind:key="question.id" v-for="question in survey.questions">
                    <br>
                    <Question :question="question"  
                    @itemchanged="$emit('itemchanged')"/>
                    
                </div>

            </Modal>
    </div>
</template>

<script>
import Modal from './ModalComponent.vue'
import Question from './Question'

export default {
    props: {
        survey: Object,
    },
    components: {
        Modal,
        Question
    },
    // Object's local memory (scoped)
    data () {
    return{
            text: String,
            showModal: false,
            showAddQuestion: false,
            new_question:'',
            inputs: [
                {
                    answer: ''
                }
            ],
            test_id: ''
        }
    },
        // Runs on component's instance rendering
    // mounted() {
    //     this.getQuestions();
    //     this.getAnswers(this.id);
    // },
    methods: {
        // Add more input fields
        add(index) {
            this.inputs.push({ name: ''});
        },
        // Remove input fields
        remove(index) {
            this.inputs.splice(index, 1);
        },
        getQuestions() {
            axios.get('api/questionnaires/' + this.id + '/questions/')
            .then( response => {
                this.questions = response.data
            })
        },
        // Delete survey
        removeSurvey() {
            axios.delete('api/questionnaires/' + this.survey.id)
            .then( response => {
                if( response.status == 204 ){
                    this.$emit('itemchanged')
                }
            })
            .catch( error => {
                console.log( error )
            })
        },
        // Add a new question
        newQuestion() {
            axios.post('api/questionnaires/' + this.survey.id + '/questions/store',
            { 
                question: this.new_question
            })
            .then( response => {
                if( response.status == 201 ) {
                    // let test = response.data.data.id
                    let question_id = response.data.data.id;
                    console.log(question_id);
                    // this.$emit('itemchanged');
                }
            })
            .catch( error => {
                console.log( error )
            })
            // Then save answers
            for(var answer in this.inputs) {
                axios.post('api/questions/' + question_id + '/answers/store', {
                    answer: this.answer
                })
                .then( response => {
                if( response.status == 200 ) {
                    
                    this.$emit('itemchanged');
                }
                })
                .catch( error => {
                    console.log(error )
                }
                );
            }
        }

    },
}

</script>

<style scope>
/* .fas {
  color: red;
} */
.survey {
  background: #cac7c7;
  margin: 5px;
  padding: 10px 20px;
}
.task.reminder {
  border-left: 5px solid green;
}

.survey h3 {
  display: flex;
  align-items: right;
  /* justify-content: space-around; */
}
.button {
    color: #4661b8;
}
.trashcan {
    background: #faf6f6;
    margin-left: 5px;
    border: none;
    color: #FF0000;
    outline: none;
}
.fas i {
    columns: green;
}
</style>