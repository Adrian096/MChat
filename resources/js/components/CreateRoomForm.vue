<template>
    <div class="wrapper" v-if="createRoomWindow">
        <div class="fadeInDown" id="formContent">
            <button type="button" class="close" aria-label="Close" @click="toggleCreateRoomWindow">
                <span aria-hidden="true">&times;</span>
            </button><br/>
            <form @submit.prevent="submit">
                <input type="text" class="form-text-custom fadeIn first" name="roomname" id="roomname" placeholder="Room Name" v-model="fields.roomname"><br/>
                <p class="text-danger" v-if="errors && errors.roomname">{{ errors.roomname[0] }}</p>
                <select class="form-text-custom" name="tag" v-model="fields.tag">
                    <option :value="null" disabled hidden>Category...</option>
                    <option v-for="tag in tags" :value="tag.name">{{ tag.name }}</option>
                    <option value="test">test</option>
                </select>
                <p class="text-danger" v-if="errors && errors.tag">{{ errors.tag[0] }}</p>
                <input type="checkbox" class="form-check-input" name="private" v-model="fields.private"/> Private Room<br/>
                <p class="text-danger" v-if="errors && errors.private">{{ errors.private[0] }}</p>
                <input type="password" class="form-password-custom" name="password" placeholder="password" v-model="fields.password" v-if="fields.private"><br v-if="fields.private"/>
                <p class="text-danger" v-if="errors && errors.password && fields.private">{{ errors.password[0] }}</p>
                <input type="password" class="form-password-custom" name="repassword" placeholder="re-password" v-model="fields.repassword" v-if="fields.private"><br v-if="fields.private"/>
                <p class="text-danger" v-if="errors && errors.repassword && fields.private">{{ errors.repassword[0] }}</p>
                <p class="text-danger" v-if="errors && errors.unauthorized">{{errors.unauthorized}}</p>
                <input type="submit" class="form-submit-custom fadeIn third" value="Create">
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            createRoomWindow: false,
            fields: {
                roomname: '',
                private: false,
                tag: null,
            },
            errors: {},
        }
    },
    props: ['tags'],
    methods: {
        clearFields(){
            this.fields = {
                roomname: '',
                private: false,
                tag: null,
            };
        },
        toggleCreateRoomWindow(){
            this.createRoomWindow = !this.createRoomWindow;
            this.clearFields();
        },
        submit(){
            if(this.createRoomWindow){
                axios.post(route('room-create'), this.fields)
                .then((response) => {
                    if(response.data['status'] == 'success'){
                        this.clearFields();
                        if(this.createRoomWindow)
                            this.toggleCreateRoomWindow();
                        location.reload();
                    }
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }else if(error.response.status === 401){
                        this.errors = {
                            unauthorized: 'You are not logged in!',
                        };
                    }
                });
            }
        },
    },
}
</script>