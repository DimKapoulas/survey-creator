<template>
    <div>
        <!-- Answer info and controls -->
        <div class="answers">
            <h6>{{ answer.answer }}</h6>
            <button type="text"
            @click="showModal = !showModal">Edit Answer</button>
            <i @click="removeAnswer" class="fas fa-times" style="color: red"></i>
        </div>

        <Modal v-if="showModal" 
            @click="showModal = false"
            @close="showModal = !showModal" text="close">
            <form>
                <!-- Answer Update section -->
                <div class="form-control">
                    <input type="text" v-model="edit_answer" name="answer" placeholder="Edit this answer"/>
                </div>
                <input type="submit" value="Save"
                @click="updateAnswer()" class="btn"/>
            </form>
        </Modal>
    </div>
</template>

<script>
import Button from './Button'
import Modal from './ModalComponent'

export default {
    props: {
        answer: Object,
    },
    components: {
        Button,
        Modal
    },
    data() {
        return {
            showModal: false,
            edit_answer: this.answer.answer, 
        }
    },
    methods: {
        // Delete answer
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

        },
        // Edit answer
        updateAnswer() {
            axios.put('api/questions/' + this.answer.question_id + '/answers/' + this.answer.id,
            { 
                answer: this.edit_answer
            })
            .then( response => {
                if( response.status == 200 ) {
                    this.$emit('itemchanged');
                }
            })
            .catch( error => { 
                console.log(error )
            });
        }
    }
}
</script>

<style scoped>
.answers {
    display: right;
}
.btn {
    display: flex;
    width: 15%;
    justify-content: center;
}
</style>