<template>
    <ol class="list-messages dark-bg">
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

        updated() {
        var element = document.querySelector('.list-messages').parentElement;
        element.scrollTop = element.scrollHeight;
    },
    }
</script>