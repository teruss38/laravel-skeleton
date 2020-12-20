<template>
    <div>
        <el-card class="box-card" shadow="never">
            <div slot="header" class="clearfix">
                <span>结算账户</span>
                <el-link :underline="false" type="primary" style="color: #409eff;float: right; padding: 3px 0"
                         @click="addSettleAccountsDialogVisible = true">
                    添加账户
                </el-link>
            </div>
            <div class="item">
                <el-table :data="accounts" empty-text="你还没有创建结算账户。" style="width: 100%">
                    <el-table-column prop="channel" label="账户类型"></el-table-column>
                    <el-table-column prop="name" label="开户名"></el-table-column>
                    <el-table-column prop="account" label="结算账户" width="180"></el-table-column>
                    <el-table-column prop="created_at" label="添加时间"></el-table-column>
                    <el-table-column align="right">
                        <template slot-scope="scope">
                            <el-button
                                size="mini"
                                type="danger"
                                @click="handleDelete(scope.$index, scope.row)">删除
                            </el-button>
                        </template>
                    </el-table-column>
                </el-table>
                <el-pagination background
                               @current-change="handleCurrentChange"
                               :page-size="meta.per_page" layout="prev, pager, next,  ->, total"
                               :total="meta.total"></el-pagination>
            </div>
        </el-card>

        <el-dialog title="添加提现账户"
                   :visible.sync="addSettleAccountsDialogVisible"
                   :close-on-click-modal="false"
                   :center="true"
                   width="30%" :before-close="handleClose" append-to-body>
            <CreateAccount @func="handleAddAccount"></CreateAccount>
        </el-dialog>
    </div>
</template>

<script>
    import {getAccounts, deleteAccount} from "../../api/settle";
    import CreateAccount from "../../widgets/settle/CreateAccount";

    export default {
        data() {
            return {
                //表格数据
                accounts: [],
                //属性
                meta: {
                    current_page: 1,// 当前页码
                    per_page: 15,// 每页的数据条数
                    total: 0,// 总条数
                },
                addSettleAccountsDialogVisible: false,
            }
        },
        components: {
            CreateAccount
        },
        mounted() {
            this.getTableData();
        },
        methods: {
            getTableData() {
                getAccounts(this.meta.current_page).then(response => {
                    this.accounts = response.data;
                    this.meta = response.meta;
                });
            },
            handleCurrentChange(val) {
                this.meta.current_page = val;
                this.loading = true;
                this.getTableData();
            },
            handleAddAccount(msg) {
                if (msg === 'success') {
                    this.$message.success('添加成功！');
                    this.addSettleAccountsDialogVisible = false;
                    this.getTableData();
                }
            },
            handleDelete(index, row) {
                deleteAccount(row.id).then(response => {
                    this.getTableData();
                    this.$message.success('删除成功！');
                });
            },
            handleClose(done) {
                this.getTableData();
                done();
            }
        }
    }
</script>
