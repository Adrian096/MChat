<template>
    <div class="room-expanded-list-box">
        <input v-model="search" type="text" class="form-text-custom" name="search" id="search-box" placeholder="Search your room...">
        <ul>
            <li v-for="room in filteredList" @click="changeRoom(room.name)">{{ room.name }}</li>
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
            return this.rooms.filter(room => {
                return room.name.toLowerCase().indexOf(this.search.toLowerCase()) >= 0
            })
        }
    },

    methods: {
        changeRoom(room){
            var url = route('room', room);
            axios.get(url).then((response) => {
                window.location.href = url;
            }).catch((error) => {
                if(error.response.status === 403){
                    this.selected = this.currentItem;
                    this.$root.$refs.auth_room.createAuthorizationForm(room);
                }
            })
        },
    },
}
</script>