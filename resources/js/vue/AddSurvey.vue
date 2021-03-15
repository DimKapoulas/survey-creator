<template>
<div>
    <form  class="form-control">
        <h3>Create a new Survey</h3>
            <input type="text" v-model="new_title" class="form-control" name="survey" placeholder="Enter survey title">
        <!-- <button @click="num_questions += 1">Add question</button> -->
        <div>
        <label>How many questions?</label>
        <select type="number" v-model="num_questions"  @change="makeInt(); notDone()" id="num_questions" min=0 style="width: 15%">
            <option value=0>0</option>
            <option value=1>1</option>
            <option value=2>2</option>
            <option value=3>3</option>
            <option value=4>4</option>
            <option value=5>5</option>
        </select>
        </div>
        <small>Fill in the form and press "Compose" before submiting.</small>
 <p><small>Press "Compose" after changed made to questions/answers</small></p>
        <div class="form-group" v-for="(n,i) in num_questions" :key="i">
           <Add-Question ref="AddQuestion" @content-sent="makeSurvey" @answers-changed="notDone()">
           </Add-Question>
        </div>
        <input type="button"  @click="initSurveyArray(); getContent()"  value="Compose" class="btn btn-block">
            <div v-if="done">
                <p>Ready for submission!</p>
            </div>
            
        <input type="submit"  @click="storeSurvey"  value="Save Survey" class="btn btn-block">
    </form>
    {{ survey }}

</div>
</template>

<script>
import AddQuestion from './AddQuestion'
import Modal2 from './Modal2'


export default {
    name: 'AddSurvey',
    components: {
        AddQuestion,
        Modal2  
    },
    data() {
        return {
            done: false,
            i: 0,
            num_questions: 0,
            new_title: '',
            answer: '' ,
            new_survey: '',
            new_question: '',
            inputs: [
                {
                    answer: ''
                }
            ],
            survey: [],
        }
    },

    methods: {
        notDone(){
            this.done = false;
        },
        // Clean Survey before re-inputing question forms
        initSurveyArray() {
            this.survey = [];
        },
        // Custom event for init survey submission procedure
        submit() {
            this.$emit('submited')
        },
        // Parse HTML string into Int
        makeInt() {
            this.num_questions = parseInt(document.getElementById("num_questions").value)
        },
        // Add extra answer field
        add(index) {
            this.inputs.push({});
        },
        // Remove answer fields
        remove(index) {
            this.inputs.splice(index, 1);
        },
        makeSurvey(content) {
            // Make a survey out of  the content of all AddQuestion forms
            // let survey = [];
            // survey = [...survey, content];
            // console.log("Inside from makeSurvey(): ", survey);
            // if(!this.first_time) {
            //     this.survey = [];
            // }

            this.survey = [...this.survey, content];
            // console.log("Inside from makeSurvey(): ", this.survey);
            this.done = true;

            // Pass survey to Parent (Header.vue) for submission
            // this.$emit('submit', this.survey);
            // this.first_time = false;

        },
         async storeSurvey() {
            // console.log("Survey is: ", this.survey[0])
            // console.log("From inside storeSurvey(): ", this.survey)
            // Post request for survey creation
            let survey_res = await axios.post('/api/questionnaires/store', {
                title: this.new_title
            });

            let survey_id = survey_res.data.data.id
            console.log("New survey id is: ", survey_id)

            

            // this.survey.forEach(function(entry){
            //     console.log(entry.question)
            //     console.log(entry.answers)
            // })
            // Store each question for this survey
            let question_ids = [];
            this.survey.forEach(async entry => {
                // console.log("Survey_question: ", entry.question );
                let parsedQuestion = JSON.parse(JSON.stringify(entry.question))
                console.log("Parsed question: ", parsedQuestion );
                
                 question_ids = await axios.post('/api/questionnaires/' + survey_id + '/questions/store', {
                    question: parsedQuestion
                })
                .then( resp => {
                    return resp.data.data.id;
                })
                
                console.log("q_ids inside for each ", questions_ids)
                // let question_id = question_res.data.data.id

            })

                console.log("q_ids outeside for each ", questions_ids)


                // console.log("Que_id: ", question_res.data.data.id)
                // console.log("question id is: ", question_id)
            
                // For of these questions related answers
                // entry.answers.forEach(function(answers_entry){
                //     // Parse Observer object into a string
                //     let parsedAnswer = JSON.parse(JSON.stringify(answers_entry.answer))
                //     console.log("This question answers are:", parsedAnswer)
                //     axios.post('/api/questions/' + question_id + '/answers/store', 
                //     {
                //         answer: parsedAnswer
                //     })
                // })  
            
        },
        getContent(){
            var counter;
            // For each AddQuestion forms, ask for their content
            for(counter=0; counter < this.num_questions; counter++) {
                this.$refs.AddQuestion[counter].sendContent();
            }
        }
    }
}
</script>

<style scoped>
.add-form {
    margin-bottom: 40px;
}
.form-control {
    margin: 20px 0;
}
.form-control label {
    display: block;
}
.form-control input {
    width: 100%;
    height: 40px;
    margin: 5px;
    padding: 3px 7px;
}

</style>