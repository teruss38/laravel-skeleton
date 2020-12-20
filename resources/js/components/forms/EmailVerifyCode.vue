<template>
    <el-button type="primary" @click="showCaptcha" :disabled="isDisabled">{{buttonName}}</el-button>
</template>
<script>
    import {getEmailVerifyCode} from "../../api/util";

    export default {
        props: ['email'],
        data() {
            return {
                buttonName: "发送验证码",
                isDisabled: false,
                time: 120,
                ticket: null,
                randstr: null,
            };
        },
        methods: {
            showCaptcha() {
                if (this.email === '') {
                    this.$message.error('邮箱不能为空！');
                    return;
                }
                let captcha = new TencentCaptcha(
                    process.env.MIX_CAPTCHA_ID_VERIFY_CODE,
                    res => {
                        if (res.ret === 0) {
                            this.ticket = res.ticket;
                            this.randstr = res.randstr;
                            this.getVerifyCode();
                        } else {
                            return this.$message.error('请先完成验证！')
                        }
                    }
                );
                captcha.show()
            },
            getVerifyCode() {

                getEmailVerifyCode(this.email, this.ticket, this.randstr).then(response => {
                    this.time = response.waitTime;
                }).catch((error) => {
                    this.$message.error(error.message);
                });
                let vm = this;
                vm.isDisabled = true;

                function timeDone() {
                    vm.buttonName = '' + vm.time + '秒后重新发送';
                    --vm.time;
                    if (vm.time < 0) {
                        vm.buttonName = "重新发送";
                        vm.time = 120;
                        vm.isDisabled = false;
                        window.clearInterval(interval);
                    }
                }

                timeDone();
                let interval = window.setInterval(timeDone, 1000);
            }
        }
    }
</script>
