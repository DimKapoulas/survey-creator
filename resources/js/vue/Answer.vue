<template>
    <div class="answers">
        <h6>{{ answer.answer }}</h6>
        <button>Edit answer</button>
        <i @click="removeAnswer" class="fas fa-times"></i>

    </div>
</template>

<script>
export default {
    props: {
        answer: Object,
    },
    data() {
        return {
            id: Number
        }
    },
    methods: {
        removeAnswer() {
            axios.delete('api/questions/' + this.answer.question_id + '/answers/' + this.answer.id)
            .then( response => {
                if( response.status == 204 ) {
                    this.$emit('itemchanged');
                }
            })
            .catch( error => {
                console.log(error )
            })

        }
    }
}
</script>

<style scoped>
.answers {
    display: right;

}
</style>