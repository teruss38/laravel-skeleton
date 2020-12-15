<template>
    <button class="btn btn-success btn-lg mr-2" @click="sendSupport" :disabled="isDisabled">
        {{ num }} {{ buttonName }}
    </button>
</template>

<script>
import {support} from "../api/util";

export default {
    props: ['id', 'type', 'num'],
    data() {
        return {
            buttonName: "推荐",
            isDisabled: false,
        };
    },
    mounted() {
    },
    methods: {
        sendSupport() {
            this.isDisabled = true;
            support(this.id, this.type).then(response => {
                this.buttonName = '已推荐';
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
