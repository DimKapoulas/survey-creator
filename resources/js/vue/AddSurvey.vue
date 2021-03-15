<template>
<div>
    <form  class="form-control">
        <h3>Create a new Survey</h3>
            <input type="text" v-model="new_title" class="form-control" name="survey" placeholder="Enter survey title">
        <div>
        <!-- Selection of num of Question forms -->
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
        
        <!-- Question Forms -->
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
</div>
</template>

<script>
import AddQuestion from './AddQuestion'


export default {
    name: 'AddSurvey',
    components: {
        AddQuestion,
    },
    data() {
        return {
            done: false,
            i: 0,
            num_questions: 0,
            new_title: '',
            inputs: [
                {
                    answer: ''
                }
            ],
            survey: [],
        }
    },

    methods: {
        // Upon question update --> Compose again
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
            this.survey = [...this.survey, content];
            this.done = true;
        },
        // Send survey to api
         async storeSurvey() {
            let survey_res = await axios.post('/api/questionnaires/store', {
                title: this.new_title
            });

            let survey_id = survey_res.data.data.id

            await axios.post('/api/questionnaires/' + survey_id + '/questions/store/bulk', this.survey)  
            
        },
        getContent(){
            var counter;
            // For each AddQuestion forms, Parent to Child method call
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