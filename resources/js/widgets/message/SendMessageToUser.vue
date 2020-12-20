<template>
    <div>
        <el-button @click="dialogVisible = true" size="medium" type="primary" class="btn-block" plain>发私信</el-button>
        <el-dialog
            title="发送私信"
            :visible.sync="dialogVisible" :before-close="handleClose"
            width="30%" append-to-body>

            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px">
                <el-form-item label="发给:">
                    {{username}}
                </el-form-item>

                <el-form-item label="内容" prop="content" :error="errors.content">
                    <el-input type="textarea" v-model="ruleForm.content" :rows="3" maxlength="191"
                              show-word-limit></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="submitForm('ruleForm')">发 送</el-button>
                    <el-button @click="handleClose()">取 消</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </div>
</template>

<script>
    import {sendMessage} from '../../api/user'

    export default {
        props: ['username', 'user_id'],

        data() {
            return {
                dialogVisible: false,
                loading: false,
                user_id: '',
                username: '',
                ruleForm: {
                    content: '',
                },
                rules: {
                    content: [
                        {required: true, message: '请输入消息内容', trigger: 'blur'}
                    ],
                },
                errors: {
                    content: '',
                },
            };
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        sendMessage({
                            to_user_id: this.user_id,
                            content: this.ruleForm.content,
                        }).then(response => {
                            this.handleClose();
                            this.$message.success('发送成功！');
                            window.location.reload();
                        }).catch((error) => {
                            this.loading = false;
                            if (typeof error.response.data === 'object') {
                                for (let i in error.response.data.errors) {
                                    this.errors[i] = _.flatten(error.response.data.errors[i])[0];
                                }
                            } else {
                                this.$message.error(error.message);
                            }
                        });
                    } else {
                        return false;
                    }
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },
            handleClose() {
                this.resetForm('ruleForm');
                this.dialogVisible = false;
            }
        }
    }
</script>
