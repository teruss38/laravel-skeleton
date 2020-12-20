<template>
    <button :class="btnStyle" @click="sendSupport" :disabled="isDisabled">
        {{ num }} {{ buttonName }}
    </button>
</template>

<script>
import {support} from "../api/util";

export default {
    props: ['id', 'type', 'num', 'size', 'disabled'],
    data() {
        return {
            buttonName: "推荐",
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
            this.buttonName = '已推荐';
            this.isDisabled = true;
        }
    },
    methods: {
        sendSupport() {
            this.isDisabled = true;
            support(this.id, this.type).then(response => {
                this.buttonName = '已推荐';
                this.isDisabled = true;
            }).catch((error) => {
                this.isDisabled = false;
            });
        }
    }
}
</script>

<style scoped>

</style>
