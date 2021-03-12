<template>
    <div class="Modal is-active">
        <div class="Modal-background"></div>
            <div class="Modal-content">
                <div class="box">
                    <slot></slot>
                </div>
            </div>
        <button class="Modal-close" @click="$emit('close')">close</button>
            <br>
            <br>
    </div>
</template>