<template>
    <el-card class="box-card" shadow="never">
        <div slot="header" class="clearfix">
            <span>授权</span>
        </div>
        <div class="item">
            <!-- Current Clients -->
            <el-table :data="data" empty-text="还没有授权应用。" style="width: 100%">
                <el-table-column label="ID" prop="id" width="100"></el-table-column>
                <el-table-column label="应用名称" prop="name" width="180"></el-table-column>
                <el-table-column label="授权范围" prop="scopes">
                    <template slot-scope="scope">
                        <span v-if="scope.row.length > 0">{{ scope.row.join(', ') }}</span>
                    </template>
                </el-table-column>
                <el-table-column prop="created_at" label="授权时间" width="180"></el-table-column>
                <el-table-column
                    align="right">
                    <template slot-scope="scope">
                        <el-button
                            size="mini"
                            type="danger"
                            @click="handleDelete(scope.$index, scope.row)">撤销
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>
    </el-card>


</template>

<script>
    import {getTokens, deleteToken} from '../../api/oauth'
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                data: []
            };
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component (Vue 2.x).
             */
            prepareComponent() {
                this.getTableData();
            },

            /**
             * Get all of the authorized tokens for the user.
             */
            getTableData() {
                getTokens().then(response => {
                    this.data = response;
                });
            },

            handleDelete(index, row) {
                deleteToken(row.id).then(response => {
                    this.getTableData();
                    this.$message.success('撤销成功！');
                });
            },
        }
    }
</script>
