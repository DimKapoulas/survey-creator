<div v-for="(question,i) in content" :key="i" class="form-control">
                        <input type="text" class="form-control" v-model="content.question" placeholder="Enter question">
                        <span>
                            <i class="fas fa-plus-circle" style="color:green" @click="addQuestions(i)" v-show="i == content.length-1"></i>
                            <i class="fas fa-minus-circle" style="color:red" @click="removeQuestions(i)" v-show="i || ( !i && content.length > 1)"></i>
                        </span>