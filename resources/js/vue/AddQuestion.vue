<template>
    <div class="form-control">
        <br>
        <!-- Question input -->
        New Question
        <form>
            <input type="text" v-model="new_question" name="question" placeholder="Enter question"/>
            
                <!-- Dynamic multiple answer inputs -->
                <div  v-for="(input,k) in inputs" :key="k" class="form-group">
                    <input type="text" class="form-control" v-model="input.answer" placeholder="Enter answer for this question">
                    <span>
                        <i class="fas fa-plus-circle" style="color:green" @click="add(k);" v-show="k == inputs.length-1"></i>
                        <i class="fas fa-minus-circle" style="color:red" @click="remove(k);" v-show="k || ( !k && inputs.length > 1)"></i>
                    </span>
                </div>
        </form>
    </div>
</template>

<script>
export default {
    name: 'AddQuestion',
    props: {
        send: Boolean

    },
    data() {
        return {
            new_question: '',
            inputs :[
                {
                    answer:'',
                }
            ],
        }
    },
    methods: {
        // Add more input fields
        add(index) {
            this.inputs.push({});
            this.$emit('answers-changed')
        },
        // Remove input fields
        remove(index) {
            this.inputs.splice(index, 1);
            this.$emit('answers-changed')
        },
        // Send question object to parent survey
        sendContent() {
            let content = {
                question: this.new_question,
                answers: this.inputs
                };

            this.$emit('content-sent', content)
        }
    },
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