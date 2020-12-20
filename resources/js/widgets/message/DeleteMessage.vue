<template>
    <el-link :underline="false" class="el-link-a" @click="submitDelete()">删除</el-link>
</template>

<script>
    import {deleteMessage} from '../../api/message'

    export default {
        data() {
            return {
                session_id: 0,
            }
        },
        props:['session_id'],
        methods: {
            submitDelete() {
                deleteMessage(this.session_id).then(response => {
                    let child = window.document.getElementById("session_"+this.session_id);
                    child.parentNode.removeChild(child);
                    this.$message.success('删除成功！');
                });
            }
        }
    }
</script>
