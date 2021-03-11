<template>
    <div>
        <h5>{{ question.question }}</h5>
        <div v-for="answer in questions.answers" :key="answer.id">
            <Answer :answer="answer" />
        </div>
    </div>
</template>

import Answer from '.Answer'

expor