<template>
    <el-button type="primary" @click="showCaptcha" :disabled="isDisabled">{{buttonName}}</el-button>
</template>
<script>
    import {getPhoneVerifyCode} from "../../api/util";

    export default {
        props: ['phone'],
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
                const reg = /^1[3|4|5|6|7|8|9][0-9]\d{8}$/
                if (!reg.test(this.phone)) {
                    this.$message.error('手机号不正确！');
                    return
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
                getPhoneVerifyCode(this.phone, this.ticket, this.randstr).then(response => {
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
