<template>
    <div class="marker-list">
        <ul>
            <li @click="selectItem(marker,index)" v-for="(marker,index) in markers" :key="index" class="item">
                <div class="content">
                    <h2 class="name">{{marker.title}}</h2>
                    <p class="desc">{{marker.created_at}}</p>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            markers: {
                type: Array,
                default: []
            },
        },
        methods: {
            // 点击歌曲, 向父组件派发事件
            selectItem(item, index) {
                this.$emit('select', item, index);
            },
        }
    };
</script>

<style lang="scss" scoped>
    @import "./../../../sass/mixin";
    @import "./../../../sass/variables";

    .item {
        display: flex;
        align-items: center;
        box-sizing: border-box;
        height: 72px;
        font-size: $font-size-medium;
        background-color: $color-background;
        margin-bottom: 10px;
        padding: 30px 20px;
    }
    .rank {
        flex: 0 0 25px;
        width: 25px;
        margin-right: 30px;
        text-align: center;
        .icon {
            display: inline-block;
            width: 25px;
            height: 24px;
            background-size: 25px 24px;
        }
        .text {
            color: $color-text;
            font-size: $font-size-large;
        }
    }
    .content {
        flex: 1;
        line-height: 20px;
        overflow: hidden;
        .name {
            @include no-wrap;
            color: $color-text;
        }
        .desc {
            @include no-wrap;
            margin-top: 4px;
            color: $color-text-d;
        }
    }
</style>
