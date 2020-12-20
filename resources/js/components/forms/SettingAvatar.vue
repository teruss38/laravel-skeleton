<template>
    <div class="text-center">
        <el-upload
            class="avatar-uploader"
            action="/api/v1/user/avatar"
            name="avatar"
            :show-file-list="false"
            :auto-upload="true"
            :with-credentials="true"
            :on-success="handleAvatarSuccess"
            :before-upload="beforeAvatarUpload">
            <img v-if="avatarUrl" :src="avatarUrl" class="avatar">
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
        <p class="text-muted">从电脑中选择图片上传, 图像大小不要超过 2 MB</p>

    </div>

</template>

<script>
    export default {
        data() {
            return {
               // avatarUrl: ''
            };
        },
        computed: {
            avatarUrl() {
                return this.$store.getters.avatar;
            },
        },
        methods: {
            handleAvatarSuccess(res, file) {
                this.$store.dispatch('user/init');
                this.avatarUrl = URL.createObjectURL(file.raw);
                this.$message.success('你的头像已经设置成功！');
            },
            beforeAvatarUpload(file) {
                if (file.type === 'image/jpeg' || file.type === 'image/png' || file.type === 'image/gif') {
                    if (file.size / 1024 / 1024 > 2) {
                        this.$message.error('上传头像图片大小不能超过 2MB!');
                        return false;
                    }
                    return true;
                } else {
                    this.$message.error('上传头像图片只能是 JPG、Png、Gif 格式!');
                    return false;
                }
            }
        }
    }
</script>

<style>
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }

    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }

    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>
