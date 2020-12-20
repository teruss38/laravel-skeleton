<template>
    <div class="float-left">
        <a class="btn btn-danger rechargeBtn" href="#" role="button" @click="rechargeDialogVisible = true" :loading="rechargeLoading">积分充值</a>

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
    </div>
</template>

<script>
import Recharge from '../widgets/integral/Recharge'

export default {
    data() {
        return {
            rechargeLoading: false,
            rechargeDialogVisible: false,
        };
    },
    components: {
        Recharge,
    },
    methods: {
        openRechargeDialog() {
            this.rechargeLoading = true;
        },
        handleRechargeClose(done) {
            this.rechargeLoading = false;
            done();
        },
        handleRechargeMsg(msg) {
            if (msg === 'success') {
                this.rechargeLoading = false;
                this.rechargeDialogVisible = false;
            }
        },
    }
}
</script>

<style scoped>
.rechargeBtn {
   margin-left: .5rem;
}
</style>
