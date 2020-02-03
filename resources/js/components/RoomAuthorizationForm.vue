<template>
    <div class="alert wrapper" v-if="this.createAuthForm">
        <div class="fadeInDown dark-bg" id="formContent">
            <button type="button" class="btn close" @click="toggleAuthForm">
                <i class="material-icons close-icon">close</i>
            </button>
            <br/>
            <br/>
            <form @submit.prevent="submit">
                <input type="password" class="form-password-custom dark-bg fadeIn first" name="password" placeholder="password" v-model="fields.password"><br/>
                    <p class="text-danger" v-if="errors && errors.password">{{ errors.password[0] }}</p>
                    <p class="text-danger" v-if="errors && errors.roomname">{{ errors.roomname[0] }}</p>
                <input type="submit" class="form-submit-custom fadeIn second" value="Auth">
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            createAuthForm: false,
            fields: {
                password: '',
            },
            errors: {},
        }
    },
    methods: {
        clearFields(){
            this.fields = {
                password: '',
            };
            this.errors = {};
        },
        toggleAuthForm(){
            this.createAuthForm = !this.createAuthForm;
            this.clearFields();
        },
        submit() {
            if(this.createAuthForm){
                axios.post(route('room-auth'), this.fields)
                .then((response) => {
                    this.clearFields();
                    if(this.createAuthForm){
                        this.toggleAuthForm();
                    }
                    if(response.data['status'] == 'success'){
                        window.location.href = response.data['url'];
                    }
                })
                .catch((error) => {
                    if(error.response.status === 422){
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        },
        createAuthorizationForm(roomname){
            this.createAuthForm = true;
            this.fields.roomname = roomname;
        },
    },
}
</script>