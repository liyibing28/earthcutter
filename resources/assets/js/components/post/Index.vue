<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">文章首页列表</div>

                <div v-for="post in posts" :key="post.id" class="bs-callout bs-callout-danger">
                    <h4><router-link :to="{ name: 'posts', params:{id : post.id }}"> {{ post.title }}</router-link></h4>
                    <p> {{ post.body}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            axios.get('/api/posts').then(response => {
                this.posts = response.data.data //两个data是因为后端有分页

            });
        },
        data() {
            return {
                posts : []
            }
        }
    }
</script>
