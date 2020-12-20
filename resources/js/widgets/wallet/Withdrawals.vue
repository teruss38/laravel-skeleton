<template>
    <el-row :gutter="20">
        <el-col :span="24">
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px">
                <el-form-item label="提现账户" prop="recipient" :error="errors.recipient">
                    <el-select v-model="ruleForm.recipient" filterable clearable placeholder="请选择提现账户">
                        <el-option
                            v-for="item in accounts" :key="item.id" :label="item.name" :value="item.id">
                            <span style="float: left">{{ item.name }}</span>
                            <span style="float: right; color: #8492a6; font-size: 13px">{{ item.channel }}</span>
                        </el-option>
                    </el-select>
                    <el-link type="primary" :underline="false" @click="addSettleAccountsDialogVisible = true">添加
                    </el-link>
                </el-form-item>

                <el-form-item label="提现金额" prop="amount" :error="errors.amount">
                    <el-input type="number" v-model.number="ruleForm.amount" autocomplete="off" placeholder="请输入要提现的金额">
                        <template slot="append">元</template>
                    </el-input>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" :loading="loading" @click="submitForm('ruleForm')">提现</el-button>
                </el-form-item>
            </el-form>

            <!-- 添加提现账户-->
            <el-dialog title="添加提现账户"
                       :visible.sync="addSettleAccountsDialogVisible"
                       :close-on-click-modal="false"
                       :center="true"
                       width="30%" append-to-body>
                <CreateAccount @func="handleAddAccount"></CreateAccount>
            </el-dialog>
        </el-col>
    </el-row>
</template>

<script>
    import {getAccounts} from "../../api/settle"
    import {withdrawals} from "../../api/wallet";
    import CreateAccount from "../../widgets/settle/CreateAccount";

    export default {
        data() {
            return {
                //表格数据
                accounts: [],
                ruleForm: {
                    recipient: '',
                    amount: '',
                },
                loading: false,
                rules: {
                    amount: [
                        {required: true, message: '金额不能为空', trigger: 'blur'},
                        {type: 'number', message: '金额必须为数字值', trigger: 'blur'}
                    ],
                    recipient: [
                        {required: true, message: '请选择提现账户', trigger: 'change'}
                    ]
                },
                errors: {
                    amount: '',
                    recipient: '',
                },
                addSettleAccountsDialogVisible: false,
            };
        },
        mounted() {
            this.getTableData();
        },
        components: {
            CreateAccount
        },
        methods: {
            getTableData() {//获取前10个可提现的账户
                getAccounts(1).then(response => {
                    this.accounts = response.data;
                });
            },
            submitForm(formName) {//提交提现请求
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        withdrawals(this.ruleForm.amount * 100, this.ruleForm.recipient).then(response => {
                            this.data = response.data;
                            this.resetForm(formName);
                            this.$store.dispatch('user/init');
                            this.$message.success('提现成功！');
                            this.$emit('func', 'success');
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
            handleAddAccount(msg) {
                if (msg === 'success') {
                    this.$message.success('添加结算账户成功！');
                    this.addSettleAccountsDialogVisible = false;
                    this.getTableData();
                }
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            }
        }
    }
</script>

<style scoped>

</style>
