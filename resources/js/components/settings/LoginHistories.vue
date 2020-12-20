<template>
    <el-card class="box-card" shadow="never">
        <div slot="header" class="clearfix">
            <span>账户安全</span>
        </div>
        <div class="item">
            <el-table :data="data" style="width: 100%">
                <el-table-column prop="created_at" label="登录时间" width="180"></el-table-column>
                <el-table-column prop="ip" label="IP"></el-table-column>
                <el-table-column prop="browser" label="浏览器"></el-table-column>
                <el-table-column prop="address" label="地址"></el-table-column>
            </el-table>
            <el-pagination background
                           @current-change="handleCurrentChange"
                           :page-size="meta.per_page" layout="prev, pager, next,  ->, total"
                           :total="meta.total"></el-pagination>
        </div>
    </el-card>
</template>

<script>
    import {loginHistories} from '../../api/user'

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
                loading: false
            }
        },
        mounted() {
            this.getTableData();
        },
        methods: {
            handleCurrentChange(val) {
                this.meta.current_page = val;
                this.loading = true;
                this.getTableData();
            },
            getTableData() {
                loginHistories(this.meta.current_page).then(response => {
                    this.data = response.data;
                    this.meta = response.meta;
                });
                this.loading = false;
            }
        }
    }
</script>
