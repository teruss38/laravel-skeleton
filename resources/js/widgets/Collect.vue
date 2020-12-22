<template>
    <button :class="btnStyle" @click="sendCollect" :disabled="isDisabled">
        {{ buttonName }}
    </button>
</template>

<script>
import {collect} from "../api/util";

export default {
    props: ['id', 'type', 'size', 'disabled'],
    data() {
        return {
            buttonName: "收藏",
            isDisabled: false,
            btnStyle: ''
        };
    },
    mounted() {
        if (this.size === 'sm') {
            this.btnStyle = 'btn btn-light btn-sm'
        } else if (this.size === 'lg') {
            this.btnStyle = 'btn btn-light btn-lg'
        } else {
            this.btnStyle = 'btn btn-light'
        }
        if (this.disabled === '1') {
            this.buttonName = '已收藏';
        }
    },
    methods: {
        sendCollect() {
            collect(this.id, this.type).then(response => {
                if (response.status === 'collected') {
                    this.buttonName = '已收藏';
                } else {
                    this.buttonName = '收藏';
                }
            }).catch((error) => {
            });
        }
    }
}
</script>

<style scoped>

</style>
