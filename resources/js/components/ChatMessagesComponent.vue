<template>
    <ol class="list-messages">
        <li v-for="message in messages">
            <div class="message-card">
                <div class="message-header"><p class="card-text">{{message.user}}</p></div>
                <div class="message-text"><p class="card-text">{{message.message}}</p></div>
            </div>
        </li>
    </ol>
</template>

<script>
    export default {
        props: ['messages'],
        
        mounted () {
            this.$emit('fetchmessage');
            this.$emit('joinchannel');
        },
    }
</script>