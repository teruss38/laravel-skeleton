<template>
    <button :class="btnStyle" @click="sendCollect" :disabled="isDisabled">
        {{ buttonName }}
    </button>
</template>

<script>
import {follow} from "../api/util";

export default {
    props: ['id', 'type', 'size', 'disabled'],
    data() {
        return {
            buttonName: "关注",
            isDisabled: false,
            btnStyle: ''
        };
    },
    mounted() {
        if (this.size === 'sm') {
            this.btnStyle = 'btn btn-success btn-sm'
        } else if (this.size === 'lg') {
            this.btnStyle = 'btn btn-success btn-lg'
        } else {
            this.btnStyle = 'btn btn-success'
        }
        if (this.disabled === '1') {
            this.buttonName = '已关注';
        }
    },
    methods: {
        sendCollect() {
            this.isDisabled = true;
            follow(this.id, this.type).then(response => {
                if (response.status === 'followed') {
                    this.buttonName = '已关注';
                } else {
                    this.buttonName = '关注';
                }
                this.isDisabled = false
            }).catch((error) => {
                this.isDisabled = false
            });
        }
    }
}
</script>

<style scoped>

</style>
