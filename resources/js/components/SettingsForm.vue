<template>
    <form @submit.prevent="submit">
        <input type="text" class="form-text-custom" name="username" v-model="fields.username" placeholder="username"><br/>
        <p class="text-danger" v-if="errors && errors.username">{{ errors.username[0] }}</p>
        <p><input type="checkbox" name="change-password" v-model="fields.changePassword"> Change Password <br/></p>
        <p class="text-danger" v-if="errors && errors.changePassword">{{ errors.changePassword[0] }}</p>
        <input type="password" class="form-password-custom" name="old-password" placeholder="old password" v-model="fields.oldPassword" :disabled="fields.changePassword == false"><br/>
        <p class="text-danger" v-if="errors && errors.oldPassword && fields.changePassword">{{ errors.oldPassword[0] }}</p>
        <p class="text-danger" v-if="errors && errors.password">{{ errors.password[0] }}</p>
        <input type="password" class="form-password-custom" name="old-password" placeholder="new password" v-model="fields.newPassword" :disabled="fields.changePassword == false"><br/>
        <p class="text-danger" v-if="errors && errors.newPassword && fields.changePassword">{{ errors.newPassword[0] }}</p>
        <input type="password" class="form-password-custom" name="repassword" placeholder="re-password" v-model="fields.repassword" :disabled="fields.changePassword == false"><br/>
        <p class="text-danger" v-if="errors && errors.repassword && fields.changePassword">{{ errors.repassword[0] }}</p>
        <input type="submit" class="form-submit-custom" value="Save">
        <p class="text-success center-align" v-if="errors && errors.success">{{ errors.success }}</p>
    </form>
</template>

<script>
export default {
    props: ['user'],
    data() {
        return {
            fields: {
                username: this.user.name,
                changePassword: false,
            },
            errors: {},
        }
    },
    methods: {
        clearFields(){
            this.fields = {
                username: this.fields.username,
                changePassword: false,
            };
        },
        submit(){
            axios.post(route('save-settings'), this.fields)
            .then((response) => {
                if(response.data['status'] == 'success'){
                    this.clearFields();
                    this.errors = {
                        success: 'Changes has been saved!',
                    };
                }

            })
            .catch((error) => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                }
            });
        },
    },
}
</script>