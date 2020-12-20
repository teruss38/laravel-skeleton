<template>
    <div>
        <el-card class="box-card" shadow="never">
            <div slot="header" class="clearfix">
                <span>OAuth 应用</span>
                <el-link :underline="false" type="primary" style="color: #409eff;float: right; padding: 3px 0" @click="createDialogVisible = true">
                    新建应用
                </el-link>
            </div>
            <div class="item">
                <!-- Current Clients -->
                <el-table :data="data" empty-text="你还没有创建 OAuth 应用。" style="width: 100%">
                    <el-table-column label="ID" prop="id" width="100"></el-table-column>
                    <el-table-column label="应用名称" prop="name" width="180"></el-table-column>
                    <el-table-column label="应用密钥" prop="secret"></el-table-column>
                    <el-table-column
                        align="right">
                        <template slot-scope="scope">
                            <el-button
                                size="mini"
                                @click="handleEdit(scope.$index, scope.row)">修改
                            </el-button>
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

        <!-- Create Client Modal -->
        <el-dialog title="创建应用"
                   :visible.sync="createDialogVisible"
                   :close-on-click-modal="false"
                   :center="true"
                   width="30%" append-to-body>

            <el-form ref="createForm" :model="createForm" :rules="rules" label-width="100px">
                <el-form-item label="应用名称" prop="name" :error="errors.createForm.name">
                    <el-input v-model="createForm.name"></el-input>
                </el-form-item>
                <el-form-item label="回调地址" prop="redirect" :error="errors.createForm.redirect">
                    <el-input v-model="createForm.redirect"></el-input>
                </el-form-item>

                <el-form-item label="Confidential" :error="errors.createForm.confidential">
                    <el-switch
                        v-model="createForm.confidential"
                        active-color="#13ce66"
                        inactive-color="#ff4949">
                    </el-switch>
                </el-form-item>

            </el-form>

            <span slot="footer" class="dialog-footer">
                <el-button @click="createDialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="store('createForm')">确 定</el-button>
            </span>
        </el-dialog>

        <!-- Edit Client Modal -->
        <el-dialog title="修改应用"
                   :visible.sync="editDialogVisible"
                   :close-on-click-modal="false"
                   :center="true"
                   width="30%" append-to-body>

            <el-form ref="editForm" :model="editForm" :rules="rules" label-width="100px">
                <el-form-item label="应用名称" prop="name" :error="errors.editForm.name">
                    <el-input v-model="editForm.name"></el-input>
                </el-form-item>
                <el-form-item label="回调地址" prop="redirect" :error="errors.editForm.redirect">
                    <el-input v-model="editForm.redirect"></el-input>
                </el-form-item>

            </el-form>

            <span slot="footer" class="dialog-footer">
                <el-button @click="editDialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="update('editForm')">确 定</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    import {getClients, createClient, updateClient, deleteClient} from '../../api/oauth'

    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                data: [],
                createDialogVisible: false,
                editDialogVisible: false,
                createForm: {
                    name: '',
                    redirect: '',
                    confidential: true
                },
                editForm: {
                    name: '',
                    redirect: ''
                },
                errors: {
                    createForm: {
                        name: '',
                        redirect: '',
                        confidential: ''
                    },
                    editForm: {
                        name: '',
                        redirect: '',
                    }
                },
                rules: {
                    name: [
                        {required: true, message: '请输入应用名称', trigger: 'blur'}
                    ],
                    redirect: [
                        {required: true, message: '请输入回调地址', trigger: 'blur'}
                    ],
                }
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
                this.getTableData();
            },

            handleEdit(index, row) {
                this.editForm.id = row.id;
                this.editForm.name = row.name;
                this.editForm.redirect = row.redirect;
                this.editDialogVisible = true;
            },
            handleDelete(index, row) {
                deleteClient(row.id).then(response => {
                    this.getTableData();
                    this.$message.success('删除成功！');
                });
            },

            /**
             * Get all of the OAuth clients for the user.
             */
            getTableData() {
                getClients().then(response => {
                    this.data = response;
                });
            },

            /**
             * Create a new OAuth client for the user.
             */
            store(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        createClient(this.createForm).then(response => {
                            this.getTableData();
                            this.createDialogVisible = false;
                            this.createForm.name = '';
                            this.createForm.redirect = '';
                            this.createForm.confidential = true;
                            this.$message.success('创建成功！');
                        }).catch((error) => {
                            if (typeof error.response.data === 'object') {
                                for (let i in error.response.data.errors) {
                                    this.errors.createForm[i] = _.flatten(error.response.data.errors[i])[0];
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

            /**
             * Update the client being edited.
             */
            update(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        updateClient(this.editForm.id, this.editForm).then(response => {
                            this.getTableData();
                            this.editDialogVisible = false;
                            this.$message.success('修改成功！');
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
