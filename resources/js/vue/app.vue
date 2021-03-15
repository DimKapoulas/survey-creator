<template>
<div class="container">
    <Header @click-btn="toggleAddSurvey"
    title="Survey Creator" :addSurveyText="showAddSurvey"/>
    <!-- Toggle-able Add New Survey form -->
    <div v-if="showAddSurvey">
      <Add-Survey  @submit="storeSurvey"/>
    </div>
    <List-Surveys :surveys="surveys"
    @itemchanged="getSurveys()"/>
</div>
    
</template>

<script>
import Header from './Header'
import ListSurveys from './ListSurveys'
import AddSurvey from './AddSurvey'

export default {
    components: {
        Header,
        ListSurveys,
        AddSurvey
    },
    data() {
        return {
            surveys: [],
            showAddSurvey: false,
        }
    },
    methods: {
        getSurveys() {
            axios.get('/api/questionnaires/')
            .then( response => {
                this.surveys = response.data
                console.log(this.surveys);
                if(this.surveys.length === 0) {
                  window.alert('There are no available surveys!')
                }
            })
            .catch( error => {
                console.log( error );
            })
            
        },
        async storeSurvey(survey) {

            console.log("From inside App: ", survey)
            // Post request for survey creation
            let survey_res = await axios.post('/api/questionnaires/store', {
                title: this.new_title
            })
            console.log("New survey id is: ")
            let survey_id = survey_res.data.data.id

            // // Store each question for this survey
            // survey.forEach(async function(entry) {
            //     console.log("Survey_question: ", entry.question );
            //     // For of these questions related answers
            //     entry.answers.forEach(function(answer){
            //         // Parse Observer object into a string
            //     let parsedAnswer = JSON.parse(JSON.stringify(answer))
            //         console.log("This question answers are:", parsedAnswer)
            //     })
            // })
        },
        toggleAddSurvey() {
          this.showAddSurvey = !this.showAddSurvey
        } 

    },
    created() {
        this.getSurveys();
    }
    
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap');
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}
body {
  font-family: 'Poppins', sans-serif;
}
.container {
  max-width: 500px;
  margin: 30px auto;
  overflow: auto;
  min-height: 300px;
  background: rgb(150, 175, 223);
  border: 1px solid steelblue;
  padding: 30px;
  border-radius: 5px;
}
.btn {
  display: inline-block;
  background: #000;
  color: #fff;
  border: none;
  padding: 10px 20px;
  margin: 5px;
  border-radius: 5px;
  cursor: pointer;
  text-decoration: none;
  font-size: 15px;
  font-family: inherit;
}
.btn:focus {
  outline: none;
}
.btn:active {
  transform: scale(0.98);
}
.btn-block {
  display: block;
  width: 100%;
}
</style>