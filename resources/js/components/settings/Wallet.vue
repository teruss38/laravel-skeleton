<template>
    <div>
        <el-card class="box-card" shadow="never">
            <div slot="header" class="clearfix">
                <span>余额管理</span>
            </div>
            <div class="item">
                <div class="balance-show">
                    <span>账户余额 <b>{{current_balance/100}}</b> 元</span>
                    <el-button type="primary" @click="rechargeDialogVisible = true" size="mini"
                               :loading="rechargeLoading"
                               plain>充值
                    </el-button>
                    <el-button type="primary" @click="withdrawDialogVisible = true" size="mini"
                               :loading="withdrawLoading"
                               plain>提现
                    </el-button>
                </div>
                <el-table :data="data" style="width: 100%">
                    <el-table-column prop="id" label="序号"></el-table-column>
                    <el-table-column prop="typeName" label="类型"></el-table-column>
                    <el-table-column prop="amount" label="金额">
                        <template slot-scope="scope">
                            {{scope.row.amount/100}} 元
                        </template>
                    </el-table-column>
                    <el-table-column prop="current_balance" label="余额">
                        <template slot-scope="scope">
                            {{scope.row.available_amount/100}} 元
                        </template>
                    </el-table-column>
                    <el-table-column prop="description" label="描述"></el-table-column>
                    <el-table-column prop="created_at" label="交易时间"></el-table-column>
                </el-table>
                <el-pagination background
                               @current-change="handleCurrentChange"
                               :page-size="meta.per_page" layout="prev, pager, next,  ->, total"
                               :total="meta.total"></el-pagination>
            </div>
        </el-card>

        <!-- 充值 -->
        <el-dialog title="充值"
                   :visible.sync="rechargeDialogVisible"
                   :close-on-click-modal="false"
                   :center="true"
                   width="30%" @opened="openRechargeDialog" :before-close="handleRechargeClose">
            <div class="d-flex justify-content-center">
                <Recharge @func="handleRechargeMsg"></Recharge>
            </div>
        </el-dialog>

        <!-- 提现 -->
        <el-dialog title="提现"
                   :visible.sync="withdrawDialogVisible"
                   :close-on-click-modal="false"
                   :center="true"
                   width="30%" @opened="openWithdrawDialog" :before-close="handleWithdrawClose">
            <div class="d-flex justify-content-center">
                <Withdrawals @func="handleWithdrawMsg"></Withdrawals>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import Recharge from "../../widgets/wallet/Recharge";
    import Withdrawals from "../../widgets/wallet/Withdrawals";
    import {getTransactions} from "../../api/wallet";

    export default {
        data() {
            return {
                //表格数据
                data: [],
                //属性
                meta: {
                    current_page: 1,// 当前页码
                    per_page: 15,// 每页的数据条数
                    total: 0,// 总条数
                },
                rechargeLoading: false,
                withdrawLoading: false,
                rechargeDialogVisible: false,
                withdrawDialogVisible: false,
            }
        },
        mounted() {
            this.getTableData();
        },
        components: {
            Recharge,
            Withdrawals
        },
        computed: {
            current_balance() {
                return this.$store.getters.profile.balance;
            },
        },
        methods: {
            handleCurrentChange(val) {
                this.meta.current_page = val;
                this.getTableData();
            },
            getTableData() {
                getTransactions(this.meta.current_page).then(response => {
                    this.data = response.data;
                    this.meta = response.meta;
                });
            },
            openRechargeDialog() {
                this.rechargeLoading = true;
            },
            handleRechargeClose(done) {
                this.getTableData();
                this.rechargeLoading = false;
                done();
            },
            openWithdrawDialog() {
                this.withdrawLoading = true;
            },
            handleWithdrawClose(done) {
                this.getTableData();
                this.withdrawLoading = false;
                done();
            },
            handleRechargeMsg(msg) {
                if (msg === 'success') {
                    this.rechargeLoading = false;
                    this.rechargeDialogVisible = false;
                    this.getTableData();
                }
            },
            handleWithdrawMsg(msg) {
                if (msg === 'success') {
                    this.withdrawDialogVisible = false;
                    this.withdrawLoading = false;
                    this.getTableData();
                }
            },
        }
    }
</script>

<style lang="scss" scoped>
    .balance-show {
        margin-bottom: 10px;
        padding: 10px 0;
        color: #212A5F;
        font-size: 16px;

        b {
            color: #f40;
            font-size: 18px;
        }
    }
</style>
