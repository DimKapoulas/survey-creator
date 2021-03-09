<template>
    <div class="todoListContainer">
        <div class="heading">
            <h2 id="title">Survey Creator</h2>
            <add-item-form 
                v-on:reloadlist="getList()"
                />
        </div>
        <list-view
            :questionnaires="questionnaires"
            v-on:reloadlist="getList()" />
    </div>
</template>

<script>
import addItemForm from "./addItemForm"
import listView from "./listView"

export default {
    components: {
        addItemForm,
        listView
    },
    data: function () {
        return {
            questionnaires: []
        }
    },
    methods: {
        getList () {
            axios.get('api/questionnaires/')
            .then( response => {
                this.questionnaires = response.data
            })
            .catch( error => {
                console.log( error );
            })

        }
    },
    created() {
        this.getList();
    }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>