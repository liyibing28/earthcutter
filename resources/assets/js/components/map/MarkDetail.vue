<template>
    <layout title="详情" :has_menu="false">
        <div class="">
            <mu-sub-header>{{marker.title}}</mu-sub-header>
            <mu-content-block>
                <p>{{marker.body}}</p>
            </mu-content-block>
        </div>
    </layout>
</template>

<script>
    import Layout from "../common/Layout";

    export default {
        components: {Layout},
        name: "mark-detail",
        data(){
            return{
                marker: {}
            }
        },
        mounted() {
            axios.get('/api/show-mark/' + this.$route.params.id).then(response => {
            this.marker = response.data[0];
            console.log(this.marker);
            });
        }
    }
</script>

<style scoped>

</style>