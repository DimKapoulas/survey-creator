<template>
    <div>
        <div :key="item.id" v-for="item in survey" class="survey">
                <h4>{{ item.title }}</h4>
                <h3>
                <button @click="editSurvey" class="details">details</button>
                <i @click="removeItem" class="fas fa-times"></i>
                </h3>
                <!-- <h3>{{ survey.title }}<h3> -->
                

        </div>   
        <div>
            <button id="show-modal" @click="showModal = true">Show Modal</button>
            <!-- use the modal component, pass in the prop -->
            <modal v-if="showModal" @close="showModal = false">
                <!--
                you can use custom content here to overwrite
                default content
                -->
                <h3 slot="header">custom header</h3>
            </modal>
        </div>
    </div>
</template>

<script>
import modal from './ModalComponent.vue'

export default {
    props: ['survey', 'showModal'],
    components: {
        modal
    },

    methods: {
        removeItem() {
            axios.delete('api/questionnaires/' +  this.survey[0].id)
            .then( response => {
                if( response.status == 204 ){
                    this.$emit('itemchanged')
                }
            })
            .catch( error => {
                console.log( error )
            })
        }
    },

    
}
// var showModal = false;
</script>

<style scope>
.fas {
  color: red;
}
.survey {
  background: #e4dede;
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