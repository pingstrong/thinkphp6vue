<template>
	<div class="login-page">
		<div id="particles"></div>
		<div class="login-form">


			

			<el-form :model="loginForm" class="login-elform" ref="loginForm" label-position="left" label-width="0px">
				<div class="login-img">
					<img src="../assets/img/logo1.png" />
				</div>

				<el-form-item prop="user_name">
					<el-input v-model="loginForm.user_name" prefix-icon="el-icon-user-solid" placeholder="登录账号"></el-input>
				</el-form-item>
				<el-form-item prop="password">
					<el-input v-model="loginForm.password" type="password" prefix-icon="fa fa-lock" placeholder="登录密码"></el-input>
				</el-form-item>
				<el-form-item prop="code">
					<el-row>
						<el-col :span="14">
							<el-input v-model="loginForm.code" @keyup.enter.native="login" prefix-icon="fa fa-lock" placeholder="验证码"></el-input>
						</el-col>
						<el-col :span="9" style="float: right;line-height: 0;">
							<img style="width: 100%; height: 40px;border-radius: 5px;" class="pointer" :src="loginForm.src" @click="refreshCaptcha()" />
						</el-col>
					</el-row>

				</el-form-item>
				<el-form-item>

					<el-button type="primary" style="width:100%;" @click.native.prevent="login('loginForm')" :loading="loading">登 录</el-button>
				</el-form-item>
			</el-form>



		</div>
	</div>
</template>

<script>
	var _self;
	const baseUrl = process.env.VUE_APP_API;
	import particles from 'particles.js'
	import particlesJson from '@/assets/particles/particles.json'
	import {getcode} from '@/api/login'


	export default {
		data() {
			return {
				loginForm: {
					user_name: "admins",
					src: '',
					password: "he201391",
					code: "",
					codekey: "",
				},
				redirect: undefined,
				loading:false,
			}
		},
		mounted: function() {
			particlesJS('particles', particlesJson);
		},
		created() {
			_self = this;
			_self.refreshCaptcha()
		},
		methods: {
			refreshCaptcha: function() {
				getcode().then(res => {
					_self.loginForm.src = res.value
					_self.loginForm.codekey = res.key
				})
			},

			login: function() {
				_self.loading = true;
				_self.$store.dispatch("Login", _self.loginForm).then(() => {
					_self.$router.push({
						path: _self.redirect || "/"
					})
				}).catch(() => {
					_self.refreshCaptcha();
                   _self.loading = false;
				})


			}
		}
	}
</script>

<style lang="scss">
	.login-page {
		position: fixed;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		background: url(../assets/bj.png);
		background-size: 100% 100%;

		#particles {
			position: absolute;
			width: 100%;
			height: 100%;
			background-repeat: no-repeat;
			background-size: cover;
			background-position: 50% 50%;
			z-index: 2;
		}

		.login-form {
			position: absolute;
			width: 100%;
			height: 100%;
			z-index: 3;
			display: flex;
			align-items: center;
			justify-content: center;

			.login-elform {
				width: 300px;
				padding: 20px;
				
				background: rgba(255, 255, 255, 1);
				border-radius: 5px;
			}

			.login-img {
				width: 150px;
				border-radius: 50px;
				height: 50px;
				position: relative;
				// background: #007aff;
				left: 70px;
				top: -40px;
				text-align: center;
				line-height: 50px;

				img {
					width: 100%;
					margin-top: 0px;
				}

				
			}

			
		}
	}
</style>
