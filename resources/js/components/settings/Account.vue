<template>
    <div>
        <el-card class="box-card" shadow="never">
            <div slot="header" class="clearfix">
                <span>账户管理</span>
            </div>
            <div class="item">
                <div class="settings-form">
                    <div class="mobile-setting-form">
                        <h5>手机号码</h5>
                        <span class="tip">{{mobile}}</span>
                        <el-button class="control-button" size="mini" @click="mobileDialogVisible = true">更改</el-button>
                    </div>

                    <div class="email-setting-form">
                        <div class="form-split">
                            <h5>邮箱</h5>
                            <span class="tip">{{email}}</span>
                        </div>
                        <el-button class="control-button" size="mini" @click="emailDialogVisible = true">更改</el-button>
                    </div>

                    <div class="password-form form-split">
                        <h5><span>帐户密码</span></h5>
                        <span class="tip">已设置，可通过帐户密码登录</span>
                        <el-button class="control-button" size="mini" @click="passwordDialogVisible = true">更改
                        </el-button>
                    </div>

                    <div class="thirdAccount bind-form form-split">
                        <h5>绑定第三方帐号</h5>
                        <span class="tip">绑定后通过第三方应用快速扫码登录</span>
                        <div class="third-binding">
                            <el-row>
                                <el-col :xs="6" :sm="6">
                                    <span class="bindButton">
                                        <svg-icon icon="icon-alipay"></svg-icon>
                                        <el-link :underline="false" href="/auth/social/alipay"
                                                 target="_blank" :disabled="alipayBind" data-no-instant>绑定支付宝</el-link>
                                        <span class="unbindButton" v-if="alipayBind"
                                              @click="handleUNBindButton('alipay')">（解绑）</span>
                                    </span>
                                </el-col>
                                <el-col :xs="6" :sm="6">
                                    <span class="bindButton">
                                        <svg-icon icon="icon-social-wechat"></svg-icon>
                                        <el-link :underline="false" href="/auth/social/wechat_web"
                                                 target="_blank" :disabled="wechatBind" data-no-instant>绑定微信</el-link>
                                        <span class="unbindButton" v-if="wechatBind"
                                              @click="handleUNBindButton('wechat_web')">（解绑）</span>
                                    </span>
                                </el-col>
                                <el-col :xs="6" :sm="6">
                                    <span class="bindButton">
                                        <svg-icon icon="icon-social-qq"></svg-icon>
                                        <el-link :underline="false" href="/auth/social/qq"
                                                 target="_blank" :disabled="qqBind" data-no-instant>绑定QQ</el-link>
                                        <span class="unbindButton" v-if="qqBind"
                                              @click="handleUNBindButton('qq')">（解绑）</span>
                                    </span>
                                </el-col>
                                <el-col :xs="6" :sm="6">
                                    <span class="bindButton">
                                        <svg-icon icon="icon-social-weibo"></svg-icon>
                                        <el-link :underline="false" href="/auth/social/weibo"
                                                 target="_blank" :disabled="weiboBind" data-no-instant>绑定微博</el-link>
                                        <span class="unbindButton" v-if="weiboBind"
                                              @click="handleUNBindButton('weibo')">（解绑）</span>
                                    </span>
                                </el-col>
                            </el-row>
                        </div>
                    </div>
                </div>
            </div>
        </el-card>

        <!-- 修改手机 -->
        <el-dialog title="更改手机" :visible.sync="mobileDialogVisible" :before-close="handleClose" width="30%">
            <el-form :model="mobileRuleForm" status-icon :rules="mobileRules" ref="mobileRuleForm" label-width="100px">
                <el-form-item label="手机号码" prop="mobile" :error="mobileErrors.mobile">
                    <el-input type="text" v-model="mobileRuleForm.mobile" autocomplete="off" placeholder="请输入手机号码">
                        <template slot="prepend">+86</template>
                        <template slot="append">
                            <MobileVerifyCode :phone="mobileRuleForm.mobile"></MobileVerifyCode>
                        </template>
                    </el-input>
                </el-form-item>

                <el-form-item label="验证码" prop="verify_code" :error="mobileErrors.verify_code">
                    <el-input type="verify_code" v-model="mobileRuleForm.verify_code" autocomplete="off"></el-input>
                </el-form-item>

            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="mobileDialogVisible = false">取 消</el-button>
                <el-button :loading="mobileLoading" type="primary" @click="mobileSubmitForm('mobileRuleForm')">确 定
                </el-button>
            </div>
        </el-dialog>

        <!-- 修改邮箱 -->
        <el-dialog title="更改邮箱" :visible.sync="emailDialogVisible" :before-close="handleClose" width="30%">
            <el-form :model="emailRuleForm" status-icon :rules="emailRules" ref="emailRuleForm" label-width="100px">
                <el-form-item label="邮箱" prop="email" :error="emailErrors.email">
                    <el-input type="email" v-model="emailRuleForm.email" autocomplete="off">
                        <template slot="append">
                            <EmailVerifyCode :email="emailRuleForm.email"></EmailVerifyCode>
                        </template>
                    </el-input>
                </el-form-item>

                <el-form-item label="验证码" prop="verify_code" :error="emailErrors.verify_code">
                    <el-input type="text" v-model="emailRuleForm.verify_code" autocomplete="off"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="emailDialogVisible = false">取 消</el-button>
                <el-button :loading="emailLoading" type="primary" @click="emailSubmitForm('emailRuleForm')">确 定
                </el-button>
            </div>
        </el-dialog>

        <!-- 修改密码 -->
        <el-dialog title="修改密码" :visible.sync="passwordDialogVisible" :before-close="handleClose" width="30%">
            <el-form :model="passwordRuleForm" status-icon :rules="passwordRules" ref="passwordRuleForm"
                     label-width="100px">
                <el-form-item label="旧密码" prop="old_password" :error="passwordErrors.old_password">
                    <el-input type="password" v-model="passwordRuleForm.old_password" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="新密码" prop="password" :error="passwordErrors.password">
                    <el-input type="password" v-model="passwordRuleForm.password" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="确认密码" prop="checkPass">
                    <el-input type="password" v-model="passwordRuleForm.checkPass" autocomplete="off"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="passwordDialogVisible = false">取 消</el-button>
                <el-button :loading="passwordLoading" type="primary" @click="passwordSubmitForm('passwordRuleForm')">确 定
                </el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import {
        getProfile,
        editPassword,
        editEMail,
        editMobile,
        socialAccounts,
        deleteSocialAccount
    } from "../../api/user";
    import MobileVerifyCode from "../../components/forms/MobileVerifyCode";
    import EmailVerifyCode from "../../components/forms/EmailVerifyCode";
    import svgIcon from "../../widgets/SvgIcon";

    export default {
        data() {
            var validatePass2 = (rule, value, callback) => {
                if (value !== this.passwordRuleForm.password) {
                    callback(new Error('两次输入密码不一致!'));
                } else {
                    callback();
                }
            };
            return {
                mobile: '',
                email: '',
                mobileLoading: false,
                mobileDialogVisible: false,
                mobileErrors: {
                    mobile: "",
                    verify_code: ""
                },
                mobileRuleForm: {
                    mobile: '',
                    verify_code: '',
                },
                mobileRules: {
                    mobile: [
                        {required: true, message: '请输入手机号码', trigger: 'blur'},
                    ],
                    verify_code: [
                        {required: true, message: '请输入手机验证码', trigger: 'blur'},
                    ]
                },

                emailLoading: false,
                emailDialogVisible: false,
                emailErrors: {
                    email: "",
                    verify_code: "",
                },
                emailRuleForm: {
                    email: '',
                    verify_code: '',
                },
                emailRules: {
                    email: [
                        {type: 'email', required: true, message: '请输入正确的邮箱', trigger: 'blur'}
                    ],
                    verify_code: [
                        {required: true, message: '请输入邮件验证码', trigger: 'blur'},
                    ]
                },

                passwordLoading: false,
                passwordDialogVisible: false,
                passwordErrors: {
                    old_password: "",
                    password: ""
                },
                passwordRuleForm: {
                    old_password: '',
                    password: '',
                    checkPass: ''
                },
                passwordRules: {
                    old_password: [
                        {required: true, message: '请输入旧密码', trigger: 'blur'},
                    ],
                    password: [
                        {required: true, message: '请输入新密码', trigger: 'blur'},
                        {min: 6, max: 20, message: '长度在 6 到 30 个字符', trigger: 'blur'}
                    ],
                    checkPass: [
                        {required: true, message: '请再次输入新密码', trigger: 'blur'},
                        {min: 6, max: 20, message: '长度在 6 到 30 个字符', trigger: 'blur'},
                        {validator: validatePass2, trigger: 'blur'}
                    ]
                },
                alipayBind: false,
                wechatBind: false,
                qqBind: false,
                weiboBind: false,
            };
        },
        components: {
            MobileVerifyCode,
            EmailVerifyCode,
            'svg-icon': svgIcon,
        },
        mounted() {
            this.prepareComponent();
        },
        methods: {
            prepareComponent() {
                getProfile().then(response => {
                    this.mobile = response.mobile ? response.mobile : '未绑定';
                    this.email = response.email;
                });
                socialAccounts().then(response => {
                    response.forEach((item, index, array) => {
                        if (item.provider === 'qq') {
                            this.qqBind = true;
                        } else if (item.provider === 'weibo') {
                            this.weiboBind = true;
                        } else if (item.provider === 'wechat_web') {
                            this.wechatBind = true;
                        } else if (item.provider === 'alipay') {
                            this.alipayBind = true;
                        }
                    });
                });
            },
            mobileSubmitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.mobileLoading = true;
                        this.mobileErrors.mobile = '';
                        this.mobileErrors.verify_code = '';
                        editMobile(this.mobileRuleForm.mobile, this.mobileRuleForm.verify_code).then(response => {
                            this.mobileLoading = false;
                            this.mobileDialogVisible = false;
                            this.mobile = this.mobileRuleForm.mobile;
                            this.$message.success('手机修改成功！');
                            this.resetForm(formName);
                        }).catch(error => {
                            this.mobileLoading = false;
                            if (typeof error.response.data === 'object') {
                                for (let i in error.response.data.errors) {
                                    this.mobileErrors[i] = _.flatten(error.response.data.errors[i])[0];
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
            emailSubmitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.emailLoading = true;
                        this.emailErrors.email = '';
                        this.emailErrors.verify_code = '';
                        editEMail(this.emailRuleForm.email, this.emailRuleForm.verify_code).then(response => {
                            this.emailLoading = false;
                            this.emailDialogVisible = false;
                            this.email = this.emailRuleForm.email;
                            this.$message.success('邮箱修改成功！');
                            this.resetForm(formName);
                        }).catch(error => {
                            this.emailLoading = false;
                            if (typeof error.response.data === 'object') {
                                for (let i in error.response.data.errors) {
                                    this.emailErrors[i] = _.flatten(error.response.data.errors[i])[0];
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
            passwordSubmitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.passwordLoading = true;
                        this.passwordErrors.old_password = '';
                        this.passwordErrors.password = '';
                        editPassword(this.passwordRuleForm.old_password, this.passwordRuleForm.password).then(response => {
                            this.passwordLoading = false;
                            this.passwordDialogVisible = false;
                            this.$message.success('密码修改成功！');
                            this.resetForm(formName);
                        }).catch(error => {
                            this.passwordLoading = false;
                            if (typeof error.response.data === 'object') {
                                for (let i in error.response.data.errors) {
                                    this.passwordErrors[i] = _.flatten(error.response.data.errors[i])[0];
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
            },
            handleClose(done) {
                this.mobileLoading = false;
                this.emailLoading = false;
                this.passwordLoading = false;
                done();
            },
            handleUNBindButton(provider) {
                deleteSocialAccount(provider).then(response => {
                    if (provider === 'qq') {
                        this.qqBind = false;
                    } else if (provider === 'weibo') {
                        this.weiboBind = false;
                    } else if (provider === 'wechat_web') {
                        this.wechatBind = false;
                    } else if (provider === 'alipay') {
                        this.alipayBind = false;
                    }
                    this.$message.success('解绑成功！');
                });
            },
        }
    }
</script>

<style lang="scss" scoped>
    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }

    .clearfix:after {
        clear: both
    }

    .settings-form {
        .mobile-setting-form, .email-setting-form, .password-form, .bind-form {
            position: relative;
            border: 1px solid #e8e8e8;
            border-radius: 2px;
            padding: 24px;
            margin-top: 16px;
            margin-bottom: 0;

            .control-button {
                position: absolute;
                right: 24px;
                top: 50%;
                margin-top: -8px;
                cursor: pointer;
            }

            h5 {
                margin-top: 0;
                color: #262626;
                font-weight: 500;
            }

            .form-split h5 {
                margin-bottom: 8px;
            }

            .tip {
                color: #8c8c8c;
            }
        }

        .mobile-setting-form {
            margin-top: 0;
        }

        .action-link {
            margin-left: 8px;
            padding-left: 8px;
            border-left: 1px solid #e8e8e8
        }

        .third-binding {
            color: #000;
            margin-top: 16px
        }

        .thirdAccount {
            .bindButton {
                cursor: pointer;
            }

            .unbindButton {
                cursor: pointer;
                color: #8c8c8c;
            }
        }
    }
</style>
