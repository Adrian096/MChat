<template>
    <select class="minimal" id="room-selection"  @change="changeRoom" v-model="selected">
        <option :value="null" disabled hidden>Choose...</option>
        <option v-for="room in items" 
            :selected="selected"
            :value="room.name">{{room.name}}
        </option>
    </select>

</template>

<script>
export default {
    props: ['items', 'currentItem'],
    data() {
        return {
            selected: null,
        }
    },
    mounted() {
        if(this.currentItem != '')
            this.selected = this.currentItem;
    },
    methods: {
        changeRoom(event){
            var url = route('room', event.target.value);
            axios.get(url).then((response) => {
                window.location.href = url;
            }).catch((error) => {
                if(error.response.status === 403){
                    this.selected = this.currentItem;
                    this.$root.$refs.auth_room.createAuthorizationForm(event.target.value);
                }
            })
        },
    },
}
</script>