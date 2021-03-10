<template>
    <div>
        <div class="survey">
            <!-- <h3>{{ title }}</h3> -->
            
            <button id="show-modal" class="details" @click="showModal = !showModal">Details</button>
            <i @click="removeItem" class="fas fa-times"></i>
            <h3>{{ survey.title }}</h3>
            


            <!-- use the modal component, pass in the prop -->
            <!-- <modal v-if="showModal" @click="showModal = false">
                <div v-for="question in questions" :key="question.id">
                {{ question.question }}
                </div>
            </modal> -->
        </div>
    </div>
</template>

<script>
import modal from './ModalComponent.vue'

export default {
    props: {
        survey: Object
    },
    components: {
        modal
    },
    // Object's local memory (scoped)
    data() {
        return {
            id: Number,
            title: String
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
                this.questions = response.data.data
            })


        },
        getAnswers(id) {
            axios.get('api/questions/' + id + '/answers/') 
            .then( response => {
                this.answers = response.data.data
            })

        },
        removeItem() {
            axios.delete('api/questionnaires/' +  this.id)
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
// var showModal = false;
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
.details {
    /* display: flex; */
}
.trashcan {
    background: #faf6f6;
    margin-left: 5px;
    border: none;
    color: #FF0000;
    outline: none;
}
</style>