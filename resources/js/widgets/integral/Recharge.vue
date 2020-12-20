<template>
    <div>
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="80px">
            <el-form-item label="金额" prop="amount">
                <el-radio-group v-model="ruleForm.amount">
                    <el-radio label="1">1 元/1积分</el-radio>
                    <el-radio label="50">50 元/50积分</el-radio>
                    <el-radio label="100">100 元/100积分再送10个</el-radio>
                    <el-radio label="200">200 元/200积分再送10个</el-radio>
                    <el-radio label="500">500 元/500积分再送10个</el-radio>
                </el-radio-group>
            </el-form-item>

            <el-form-item label="付款方式" prop="channel">
                <el-radio-group v-model="ruleForm.channel">
                    <el-radio label="alipay">支付宝</el-radio>
                    <el-radio label="wechat">微信</el-radio>
                </el-radio-group>
            </el-form-item>

            <el-form-item>
                <el-button type="primary" :loading="loading"  @click="submitForm('ruleForm')">立即支付</el-button>
            </el-form-item>

            <el-form-item>
            <div class="recharge-tip">订单支付完成后，积分将自动加入到您的账号。付款是快速获取积分的方式之一，付款后是不能退款的。</div>
            </el-form-item>
        </el-form>

        <el-dialog title="扫码支付"
                   :visible.sync="qrCodeDialogVisible"
                   :close-on-click-modal="false"
                   width="25%" @opened="openDialog" :before-close="handleClose" append-to-body>
            <div class="qrcodeContainer">
                <div class="qrcodeTitleCon">
                    <p class="qrcodeTitleDesc">扫一扫付款</p>
                    <p class="qrcodeTitleValue">{{charge.amount/100}}元</p>
                </div>
                <div class="qrcodeImageCon">
                    <div class="qrcodeCon">
                        <qrcode-vue :value="qrUrl" :level="Q" :size="260" class="qrcodeImage"></qrcode-vue>
                    </div>
                </div>
                <div class="desc1">打开手机{{payDesc}}，扫一扫付款</div>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import {recharge} from '../../api/integral'
    import {getCharge} from '../../api/transaction'
    import qrcodeVue from 'qrcode.vue'

    export default {
        data() {
            return {
                loading: false,
                ruleForm: {
                    amount: '100',
                    channel: 'alipay',
                },
                rules: {
                    amount: [
                        {required: true, message: '请选择要充值的金额', trigger: 'change'}
                    ],
                    channel: [
                        {required: true, message: '请选择支付方式', trigger: 'change'}
                    ]
                },
                charge: {},
                credential: {},
                qrCodeDialogVisible: false,
                qrUrl: '',
                chargeId: '',
                paid: false,
                updater: null,
                payDesc: ''
            };
        },
        components: {
            qrcodeVue,
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        recharge(this.ruleForm.channel, this.ruleForm.amount, 'scan').then(response => {
                            this.charge = response;
                            this.chargeId = response.id;
                            this.credential = response.credential;
                            this.qrCodeDialogVisible = true;
                            this.loading = true;
                            if (this.charge.channel === 'alipay') {
                                this.payDesc = '支付宝'
                            } else if (this.charge.channel === 'wechat') {
                                this.payDesc = '微信'
                            }
                            //console.info(response);
                        });
                    } else {
                        return false;
                    }
                });
            },
            queryCharge() {
                getCharge(this.chargeId).then(response => {
                    this.paid = response.paid;
                    if (response.paid === true) {
                        clearInterval(this.updater);
                        this.updater = null;
                        this.$store.dispatch('user/init');
                        this.$message.success('充值成功！');
                        this.$emit('func','success');
                        this.qrCodeDialogVisible = false;
                    }
                });
            },
            openDialog() {
                if (this.ruleForm.channel === 'alipay') {
                    this.qrUrl = this.credential.qr_code;
                } else if (this.ruleForm.channel === 'wechat') {
                    this.qrUrl = this.credential.code_url
                }
                this.updater = setInterval(() => {
                    this.queryCharge();
                }, 3000);
            },
            handleClose(done) {
                this.loading = false;
                if (this.paid === false) {
                    clearInterval(this.updater);
                    this.updater = null;
                    this.$message.warning('充值已取消！');
                }
                done();
            }
        }
    }
</script>

<style  lang="scss" scoped>
    .recharge-tip {
        color: #888;
    }
    .qrcodeContainer {
        min-height: 444px;
        text-align: center;

        .qrcodeTitleCon {
            .qrcodeTitleDesc {
                font-size: 16px;
            }

            .qrcodeTitleValue {
                color: #e96a30;
                font-size: 28px;
                margin: 5px 10px;
                font-weight: 600;
            }
        }

        .qrcodeImageCon {
            position: relative;
            min-height: 260px;

            .qrcodeCon {
                width: 260px;
                height: 260px;
                margin: 0 auto;
                border: 1px solid #efefef;
                border-radius: 1px;
                overflow: hidden;

                .qrcodeImage {
                    width: 100%;
                }
            }
        }

        .desc1 {
            color: #595959;
            font-size: 14px;
            margin-top: 24px;
        }
    }
</style>
