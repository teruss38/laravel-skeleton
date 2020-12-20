<template>
    <div>
        <el-card class="box-card" shadow="never">
            <div slot="header" class="clearfix">
                <span>Personal Access Token</span>
                <el-link :underline="false" type="primary" style="color: #409eff;float: right; padding: 3px 0" @click="createDialogVisible = true">
                    新建令牌
                </el-link>
            </div>
            <div class="item">
                <!-- Current Clients -->
                <el-table :data="data" empty-text="你还没有创建个人访问令牌。" style="width: 100%">
                    <el-table-column label="应用名称" prop="name" width="180"></el-table-column>
                    <el-table-column label="应用ID" prop="id"></el-table-column>
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
            </div>
        </el-card>

        <!-- Create Token Modal -->
        <el-dialog title="创建令牌"
                   :visible.sync="createDialogVisible"
                   :close-on-click-modal="false"
                   :center="true"
                   width="30%" append-to-body>
            <el-form ref="createForm" :model="createForm" :rules="rules" label-width="100px">
                <el-form-item label="应用名称" prop="name" :error="errors.name">
                    <el-input v-model="createForm.name"></el-input>
                </el-form-item>

                <el-form-item label="授权作用域" v-if="scopes.length >0">
                    <el-checkbox-group v-model="createForm.scopes">
                        <el-checkbox v-for="scope in scopes" :label="scope.id" :key="scope.id">{{scope.description}}
                        </el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
            </el-form>

            <span slot="footer" class="dialog-footer">
                <el-button @click="createDialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="store('createForm')">确 定</el-button>
            </span>
        </el-dialog>

        <!-- Access Token Modal -->
        <el-dialog title="查看令牌"
                   :visible.sync="accessToken"
                   :close-on-click-modal="false"
                   :center="true"
                   width="30%" append-to-body>
            <el-input type="textarea" v-model="accessToken" :autosize="{ minRows: 5, maxRows: 8}"></el-input>
        </el-dialog>

    </div>
</template>

<script>
    import {
        getPersonalAccessTokens,
        createPersonalAccessTokens,
        deletePersonalAccessTokens,
        getScopes
    } from '../../api/oauth'

    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                data: [],
                createDialogVisible: false,
                accessToken: null,
                scopes: [],
                checkAll: false,
                isIndeterminate: true,
                createForm: {
                    name: '',
                    scopes: []
                },
                errors: {
                    name: ''
                },
                rules: {
                    name: [
                        {required: true, message: '请输入应用名称', trigger: 'blur'}
                    ]
                },
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
             * Prepare the component.
             */
            prepareComponent() {
                this.getTableData()
                this.getScopes();
            },
            getTableData() {
                getPersonalAccessTokens().then(response => {
                    this.data = response;
                });
            },
            getScopes() {
                getScopes().then(response => {
                    this.scopes = response;
                });
            },
            handleDelete(index, row) {
                deletePersonalAccessTokens(row.id).then(response => {
                    this.getTableData();
                    this.$message.success('删除成功！');
                });
            },

            /**
             * Create a new OAuth client for the user.
             */
            store(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        createPersonalAccessTokens(this.createForm).then(response => {
                            this.getTableData();
                            this.createDialogVisible = false;
                            this.accessToken = response.accessToken;
                            this.createForm.name = '';
                            this.$message.success('创建成功！');
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
            }
        }
    }
</script>
