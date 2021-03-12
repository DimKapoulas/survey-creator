<template>
    <form @submit="onSubmit" class="add-form">
        <h3>Create a new Survey</h3>
        <div class="form-control">
            <label>Survey Title</label>
            <input type="text" v-model="title" name="title" placeholder="Enter a survey title"/>
        </div>
        <div class="form-control">
            <label>Question</label>
            <input type="text" v-model="question" name="question" placeholder="Enter a questions"/>
        </div>
        <div class="form-control">
            <label>answer</label>
            <input type="text" v-model="answer" name="answer" placeholder="Enter a answers"/>
        </div>
        <input type="submit" value="Save Survey" class="btn btn-block">

        
    </form>
</template>

<script>
export default {
    name: 'AddSurvey',
    data() {
        return {
            title: '',
            question: '',
            answer: ''  
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