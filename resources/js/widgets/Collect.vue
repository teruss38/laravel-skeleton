<template>
    <button class="btn btn-lg btn-light" @click="sendCollect" :disabled="isDisabled">
        {{ buttonName }}
    </button>
</template>

<script>
import {collect} from "../api/util";

export default {
    props: ['id', 'type', 'size'],
    data() {
        return {
            buttonName: "收藏",
            isDisabled: false,
        };
    },
    mounted() {
    },
    methods: {
        sendCollect() {
            this.isDisabled = true;
            collect(this.id, this.type).then(response => {

                if (response.status === 'collected') {
                    this.buttonName = '已收藏';
                } else {
                    this.buttonName = '收藏';
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
