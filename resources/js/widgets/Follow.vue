<template>
    <button class="btn btn-success mr-3" @click="sendCollect" :disabled="isDisabled">
        {{ buttonName }}
    </button>
</template>

<script>
import {follow} from "../api/util";

export default {
    props: ['id', 'type', 'size'],
    data() {
        return {
            buttonName: "关注",
            isDisabled: false,
        };
    },
    mounted() {
    },
    methods: {
        sendCollect() {
            this.isDisabled = true;
            follow(this.id, this.type).then(response => {
                if (response.status === 'collected') {
                    this.buttonName = '已关注';
                } else {
                    this.buttonName = '关注';
                }
                this.isDisabled = false
            }).catch((error) => {
                alert(error.message)
                //this.$message.error(error.message);
                this.isDisabled = false
            });
        }
    }
}
</script>

<style scoped>

</style>
