<template>
    <div class="survey">
        <h3 :key="item.id" v-for="item in survey">
            <h3>{{ item.title }}</h3>
            <!-- <h3>{{ survey.title }}<h3> -->

        <button @click="removeItem()" class="trashcan" >
            <font-awesome-icon icon="trash" />
        </button>
        </h3>
        
        
    </div>
</template>

<script>
export default {
    props: {
        survey: {
            type: Object
            
        }
    }
    
}
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
  align-items: center;
  justify-content: space-between;
}

.trashcan {
    background: #e6e6e6;
    border: none;
    color: #FF0000;
    outline: none;
}
</style>