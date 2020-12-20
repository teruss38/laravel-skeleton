<template>
    <el-card class="box-card" style="border-radius: 0px" shadow="never">
        <div slot="header" class="clearfix">
            <div class="el-page-header__content">详情页面</div>
        </div>
        <div class="item">
            <el-row :gutter="20">
                <el-col :span="16">
                    <el-form ref="form" :model="form" :rules="rules" label-width="100px">
                        <el-form-item label="昵称" prop="username" :error="errors.username">
                            <el-input v-model="form.username"></el-input>
                        </el-form-item>

                        <el-form-item label="生日" prop="birthday" :error="errors.birthday">
                            <el-date-picker
                                v-model="form.birthday"
                                type="date"
                                format="yyyy-MM-dd"
                                value-format="yyyy-MM-dd"
                                placeholder="选择日期">
                            </el-date-picker>
                        </el-form-item>

                        <el-form-item label="性别" prop="gender" :error="errors.gender">
                            <el-radio-group v-model="form.gender">
                                <el-radio :label="0">保密</el-radio>
                                <el-radio :label="1">男</el-radio>
                                <el-radio :label="2">女</el-radio>
                            </el-radio-group>
                        </el-form-item>

                        <el-form-item label="国家" prop="country_code">
                            <el-select v-model="form.country_code" filterable clearable placeholder="国家">
                                <el-option
                                    v-for="item in countries"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="地址" prop="address" :error="errors.address">
                            <el-input v-model="form.address"></el-input>
                        </el-form-item>

                        <el-form-item label="个人网站" prop="website" :error="errors.website">
                            <el-input v-model="form.website"></el-input>
                        </el-form-item>

                        <el-form-item label="个人简介" prop="introduction" :error="errors.introduction">
                            <el-input
                                type="textarea"
                                :rows="2"
                                placeholder="请输入个人简介"
                                v-model="form.introduction">
                            </el-input>
                        </el-form-item>

                        <el-form-item label="个性签名" prop="bio" :error="errors.bio">
                            <el-input
                                type="textarea"
                                :rows="2"
                                placeholder="请输入个性签名"
                                v-model="form.bio">
                            </el-input>
                        </el-form-item>

                        <el-form-item>
                            <el-button :loading="loading" type="primary" @click="store('form')">提交</el-button>
                        </el-form-item>
                    </el-form>
                </el-col>
                <el-col :span="8">
                    <SettingAvatar></SettingAvatar>
                </el-col>
            </el-row>
        </div>
    </el-card>
</template>

<script>
    import {getProfile, editProfile} from "../../api/user";
    import {getCountry} from '../../api/util'
    import SettingAvatar from '../../components/forms/SettingAvatar'

    export default {
        data() {
            return {
                loading: false,
                countries: [],//国家列表
                form: {
                    username: '',
                    birthday: '',
                    country_code: '',
                    gender: 0,
                    address: '',
                    website: '',
                    introduction: '',
                    bio: ''
                },
                rules: {
                    username: [
                        {required: true, message: '请输入昵称', trigger: 'blur'},
                        {min: 2, max: 50, message: '长度在 2 到 50 个字符', trigger: 'blur'}
                    ],
                    birthday: [
                        {required: true, message: '请选择日期', trigger: 'change'}
                    ],
                    country_code: [
                        {required: true, message: '请选择国家', trigger: 'change'}
                    ],
                    gender: [
                        {required: true, message: '请选择性别', trigger: 'change'}
                    ],
                    address: [
                        {message: '请输入地址', trigger: 'blur'}
                    ],
                    website: [
                        {type: 'url', message: '请输入你的个人网站地址', trigger: 'blur'}
                    ],
                    introduction: [
                        {message: '请输入个人简介', trigger: 'blur'}
                    ],
                    bio: [
                        {message: '请输入个性签名', trigger: 'blur'}
                    ],
                },
                errors: {
                    username: '',
                    birthday: '',
                    country_code: '',
                    gender: '',
                    address: '',
                    website: '',
                    introduction: '',
                    bio: '',
                },
            }
        },
        components: {
            SettingAvatar
        },
        mounted() {
            this.prepareComponent();
        },
        methods: {

            /**
             * Prepare the component (Vue 2.x).
             */
            prepareComponent() {
                getCountry().then(response => {
                    this.countries = response
                });
                getProfile().then(response => {
                    this.setProfile(response)
                });
            },

            /**
             * 保存用户资料
             */
            store(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.loading = true;
                        editProfile(this.form).then(response => {
                            this.loading = false;
                            this.setProfile(response);
                            this.$message.success('你的个人资料已经保存成功！');
                        }).catch((error) => {
                            this.loading = false;
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
            },
            setProfile(response) {
                this.form.username = response.username;
                this.form.birthday = response.birthday;
                this.form.gender = response.gender;
                this.form.country_code = response.country_code;
                this.form.address = response.address;
                this.form.website = response.website;
                this.form.introduction = response.introduction;
                this.form.bio = response.bio;
            }
        }
    }
</script>

<style scoped>
    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }

    .clearfix:after {
        clear: both
    }
</style>
