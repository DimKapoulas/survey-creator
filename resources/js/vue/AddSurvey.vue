<template>
    <form  class="form-control">
        <h3>Create a new Survey</h3>
            <input type="text" class="form-control" name="survey" placeholder="Enter survey title">
        <!-- <button @click="questions += 1">Add question</button> -->
        <label>How many questions?</label>
        <select type="number" v-model="questions"  @change="makeInt" id="num_questions" min=0 style="width: 15%">
            <option value=0>0</option>
            <option value=1>1</option>
            <option value=2>2</option>
            <option value=4>4</option>
            <option value=5>5</option>
        </select>
        <div class="form-group" v-for="(n,i) in questions" :key="i">
            <div class="form-control">
                <br><br>
                <!-- Question input -->
                    New Question
            <form>
                <input type="text" v-model="new_question" name="question" placeholder="Enter question"/>
                
                    <!-- Dynamic multiple answer inputs -->
                    <div  v-for="(input,k) in inputs" :key="k" class="form-group">
                        <input type="text" class="form-control" v-model="input.answer" placeholder="Enter answer for this question">
                        <span>
                            <i class="fas fa-plus-circle" style="color:green" @click="add(k)" v-show="k == inputs.length-1"></i>
                            <i class="fas fa-minus-circle" style="color:red" @click="remove(k)" v-show="k || ( !k && inputs.length > 1)"></i>
                        </span>
                    </div>
            </form>
            </div>
        </div>
        <input type="submit" value="Save Survey" class="btn btn-block">
    </form>
</template>

<script>
import AddQuestion from './AddQuestion'


export default {
    name: 'AddSurvey',
    components: {
        AddQuestion
    },
    data() {
        return {
            questions: 0,
            title: '',
            answer: '' ,
            new_survey: '',
            new_question: '',
            inputs: [
                {
                    answer: ''
                }
            ],
            content: []
        }
    },

    methods: {
        makeInt() {
            console.log('changer triggered')
            this.questions = parseInt(document.getElementById("num_questions").value)
        },
        // Add more input fields
        addQuestions(index) {
            this.content.push(AddQuestion);
        },
        // Remove input fields
        removeQuestions(index) {
            this.content.splice(index, 1);
        },
        // Add more input fields
        add(index) {
            this.inputs.push({ name: ''});
        },
        // Remove input fields
        remove(index) {
            this.inputs.splice(index, 1);
        },
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