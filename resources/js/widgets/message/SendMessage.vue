<template>
    <div>
        <el-button size="mini" type="primary" @click="dialogVisible = true">写消息</el-button>
        <el-dialog
            title="发送私信"
            :visible.sync="dialogVisible" :before-close="handleClose"
            width="40%" append-to-body>

            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px">
                <el-form-item label="发给:" prop="to_user_id" :error="errors.to_user_id">
                    <el-select v-model="ruleForm.to_user_id" filterable remote reserve-keyword no-match-text="无匹配用户" placeholder="请输入收件人名称"
                               :remote-method="remoteMethod" :loading="loading">
                        <el-option v-for="item in users" :key="item.id" :label="item.username" :value="item.id">
                            <span style="float: left">
                                <el-avatar icon="el-icon-user-solid" size="small" :src="item.avatar" :alt="item.username"
                                       fit="scale-down"></el-avatar>
                            </span>
                            <span style="float: right;">{{ item.username }}</span>
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="内容" prop="content" :error="errors.content">
                    <el-input type="textarea" v-model="ruleForm.content" :rows="2" maxlength="191"
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
    import {search, sendMessage} from '../../api/user'

    export default {

        data() {
            return {
                dialogVisible: false,
                loading: false,
                users: [],
                ruleForm: {
                    to_user_id: '',
                    content: '',
                },
                rules: {
                    to_user_id: [
                        {required: true, message: '请输入收件人名称', trigger: 'change'}
                    ],
                    content: [
                        {required: true, message: '请输入消息内容', trigger: 'blur'}
                    ],
                },
                errors: {
                    to_user_id: '',
                    content: '',
                },
            };
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        sendMessage(this.ruleForm).then(response => {
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
            remoteMethod(query) {
                if (query !== '') {
                    this.loading = true;
                    search(query).then(response => {
                        this.loading = false;
                        this.users = response.data;
                    });
                } else {
                    this.users = [];
                }
            },
            handleClose() {
                this.resetForm('ruleForm');
                this.dialogVisible = false;
            }
        }
    }
</script>

<style scoped>

</style>
