<template>
    <div id="search">
        <div id="search-form">
            <input v-model="search" type="text" name="search_text" id="search_text" placeholder="Search"/>
            <input type="button" name="search_button" id="search_button" value="OK">
        </div>
        <ul class="subnav clr-mg-pd">
            <li v-for="room in filteredList" @click="changeRoom(room.name)">{{room.name}}</li>
        </ul>
    </div>
</template>

<script>
export default {
    props: ['rooms'],
    data() {
        return {
            search: '',
        }
    },

    computed: {
        filteredList() {
            if(this.search != '')
                return this.rooms.filter( room => {
                    return room.name.toLowerCase().indexOf(this.search.toLowerCase()) >= 0
                });
        }
    },

    methods: {
        changeRoom(room) {
            var url = route('room', room);
            axios.get(url).then((response) => {
                window.location.href = url;
            }).catch((error) => {
                if(error.response.status === 403){
                    this.selected = this.currentItem;
                    this.$root.$refs.auth_room.createAuthorizationForm(room);
                }
            })
        }  
    },
}
</script>