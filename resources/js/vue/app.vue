<template>
<div class="container">
    <Header  title="Survey Creator"/>
    <!--TODO: toggleable add form  -->

    <List-Surveys :surveys="surveys"
    @reloadlist="getSurveys()"/>
</div>
    
</template>

<script>
import Header from './Header'
import ListSurveys from './ListSurveys'

export default {
    components: {
        Header,
        ListSurveys
    },
    data() {
        return {
            surveys: []
        }
    },
    methods: {
        getSurveys() {
            axios.get('/api/questionnaires/')
            .then( response => {
                this.surveys = response.data.data
                if(this.surveys.length === 0) {
                  window.alert('There are no available surveys!')
                }
            })
            .catch( error => {
                console.log( error );
            })
            
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
  background: cornsilk;
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