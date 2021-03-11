<template>
    <div>
        <div class="survey">
            <h1>{{ survey.title }}</h1>
            
            <button id="show-modal" class="details" @click="showModal = !showModal">Details</button>
            <i @click="removeSurvey" class="fas fa-times"></i>


            <modal v-if="showModal" @click="showModal = false">
            <button>add new question</button>

             <div v-bind:key="question.id" v-for="question in survey.questions">
                <br>
                <Question :question="question"  
                @itemchanged="$emit('itemchanged')"/>
             </div>

            </modal>
        </div>
    </div>
</template>

<script>
import modal from './ModalComponent.vue'
import Question from './Question'

export default {
    props: {
        survey: Object,
    },
    components: {
        modal,
        Question
    },
    // Object's local memory (scoped)
    data () {
       return{
       showModal: false
        }
    },
        // Runs on component's instance rendering
    // mounted() {
    //     this.getQuestions();
    //     this.getAnswers(this.id);
    // },
    methods: {
        getQuestions() {
            axios.get('api/questionnaires/' + this.id + '/questions/')
            .then( response => {
                this.questions = response.data
            })


        },
        getAnswers(id) {
            axios.get('api/questions/' + id + '/answers/') 
            .then( response => {
                this.answers = response.data.data
            })

        },
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

    },
}

</script>

<style scope>
.fas {
  color: red;
}
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
</style>