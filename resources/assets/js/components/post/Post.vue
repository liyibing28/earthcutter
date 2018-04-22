<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header"><h4>{{ post.title }}</h4></div>

                    <div class="bs-callout bs-callout-danger">
                        <p> {{ post.body}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            axios.get('/api/posts/' + this.$route.params.id).then(response => {
                this.post = response.data

            });
        },
        data() {
            return {
                post : {}
            }
        }
    }
</script>
