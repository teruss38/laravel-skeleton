<template>
    <div>
        <el-card class="box-card" shadow="never">
            <div slot="header" class="clearfix">
                <span>积分管理</span>
            </div>
            <div class="item">
                <div class="coin-show">
                    <span>共有积分 <b>{{ current_integral }}</b> 个</span>
                    <el-button type="primary" @click="rechargeDialogVisible = true" :loading="rechargeLoading"
                               size="mini" plain>充值
                    </el-button>
                    <el-button type="primary" @click="withdrawDialogVisible = true" :loading="withdrawLoading"
                               size="mini" plain>提现
                    </el-button>
                </div>
                <el-table :data="data" style="width: 100%">
                    <el-table-column prop="id" label="序号"></el-table-column>
                    <el-table-column prop="typeName" label="类型"></el-table-column>
                    <el-table-column prop="integral" label="积分"></el-table-column>
                    <el-table-column prop="current_integral" label="余额"></el-table-column>
                    <el-table-column prop="description" label="描述"></el-table-column>
                    <el-table-column prop="client_ip" label="交易IP"></el-table-column>
                    <el-table-column prop="created_at" label="交易时间" width="180"></el-table-column>
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
import {getTransactions} from '../../api/integral'
import Recharge from '../../widgets/integral/Recharge'
import Withdrawals from '../../widgets/integral/Withdrawals'

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
    computed: {
        current_integral() {
            return this.$store.getters.integral;
        },
    },
    components: {
        Recharge, Withdrawals
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
        getSettleAccounts() {

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
.coin-show {
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
