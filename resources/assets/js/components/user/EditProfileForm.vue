<template>
    <mu-content-block>
        <mu-text-field v-model="name" label="用户名"/>
        <mu-text-field v-model="email" label="邮箱"/>

        <mu-raised-button @click="updateProfile" primary>修改</mu-raised-button>
    </mu-content-block>
</template>

<script>
    import * as types from './../../store/mutation-type'
    export default {
        name: "edit-profile-form",
        created(){
            this.$store.dispatch('setAuthUser');
        },
        computed:{
            name:{
                get(){
                    return this.$store.state.AuthUser.name;
                },
                set(value){
                    this.$store.commit({
                        type : types.UPDATE_PROFILE_NAME,
                        value : value,
                    })
                }
            },
            email:{
                get(){
                    return this.$store.state.AuthUser.email;
                },
                set(value){
                    this.$store.commit({
                        type : types.UPDATE_PROFILE_EMAIL ,
                        value : value,
                    })
                }
            }
        },
        methods: {
            updateProfile(){
                const formData = {
                    name : this.name,
                    email : this.email
                };
                this.$store.dispatch('updateProfileRequest',formData).then(response =>{
                    this.$router.push({name:'profile'});
                }).catch(error =>{

                });
            }
        }
    }
</script>

<style scoped>

</style>