<template>
    <el-form ref="ruleForm" :model="ruleForm" :rules="rules" label-width="100px">
        <el-form-item label="账号类型" prop="channel" :error="errors.channel">
            <el-radio-group v-model="ruleForm.channel">
                <el-radio label="alipay">支付宝</el-radio>
                <el-radio label="weixin" disabled >微信</el-radio>
            </el-radio-group>
        </el-form-item>

        <el-form-item label="账号姓名" prop="name" :error="errors.name">
            <el-input v-model="ruleForm.name"></el-input>
        </el-form-item>

        <el-form-item label="账号" prop="account" :error="errors.account">
            <el-input v-model="ruleForm.account"></el-input>
        </el-form-item>

        <el-form-item label="账号类型" prop="type" :error="errors.type">
            <el-select v-model="ruleForm.type" placeholder="请选择账号类型">
                <el-option label="个人账户" value="b2c"></el-option>
                <el-option label="企业账户" value="b2b"></el-option>
            </el-select>
        </el-form-item>

        <el-form-item>
            <el-button type="primary" @click="submitForm('ruleForm')">添加</el-button>
        </el-form-item>
    </el-form>
</template>
<script>
    import {addAccount} from "../../api/settle";

    export default {
        data() {
            return {
                errors: {
                    name: '',
                    account: '',
                    channel: '',
                    type: ''
                },
                ruleForm: {
                    name: '',
                    account: '',
                    channel: 'alipay',
                    type: 'b2c'
                },
                rules: {
                    name: [
                        {required: true, message: '账号姓名不能为空', trigger: 'blur'}
                    ],
                    account: [
                        {required: true, message: '账号不能为空', trigger: 'blur'}
                    ],
                    channel: [
                        {required: true, message: '请选择提现账号类型', trigger: 'change'}
                    ],
                    type: [
                        {required: true, message: '请选择账户类型', trigger: 'change'}
                    ],
                }
            }
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        addAccount(this.ruleForm).then(response => {
                            this.resetForm(formName);
                            this.$emit('func','success');
                        }).catch((error) => {
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
            }
        }
    }
</script>
