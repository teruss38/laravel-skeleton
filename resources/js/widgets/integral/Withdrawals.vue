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

                <el-form-item label="积分" prop="credit" :error="errors.coin">
                    <el-radio-group v-model="ruleForm.coin">
                        <el-radio label="100">100</el-radio>
                        <el-radio label="200">200</el-radio>
                        <el-radio label="500">500</el-radio>
                    </el-radio-group>
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
    import CreateAccount from "../../widgets/settle/CreateAccount";
    import {withdrawals} from "../../api/integral";

    export default {
        data() {
            return {
                //表格数据
                accounts: [],
                ruleForm: {
                    recipient: '',
                    coin: '100',
                },
                loading: false,
                rules: {
                    coin: [
                        {required: true, message: '请选择要提现的积分数', trigger: 'change'},
                    ],
                    recipient: [
                        {required: true, message: '请选择提现账户', trigger: 'change'}
                    ]
                },
                errors: {
                    coin: '',
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
                        withdrawals(this.ruleForm.coin, this.ruleForm.recipient).then(response => {
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
