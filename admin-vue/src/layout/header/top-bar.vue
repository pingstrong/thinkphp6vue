<template>
	
	<div class="top" :class="collapse?'position-left':'position-collapse-left'">
		<div class="top-bar">
			<i class="fa fa-indent coll" @click="ClickCollapse"></i>
			<bread-name id="breadcrumb-container" class="mbiao"></bread-name>
			<!-- <breadcrumb id="breadcrumb-container" class="mbiao" /> -->
			<span class="toolbar" v-if="device=='desktop'">
				<el-menu class="el-menu-demo"  text-color="#14889A" >
				<el-menu-item index="1">
					<!-- 用户信息 -->
					<span class="user-info">
						<el-dropdown>
							<span class="el-dropdown-link">
								<img :src="face" />{{ username }}
							</span>
							<el-dropdown-menu slot="dropdown">
								<el-dropdown-item @click.native="profileFormVisible = true"><i class="el-icon-user-solid"></i>编辑资料</el-dropdown-item>
								<el-dropdown-item @click.native="handlePassword()"><i class="fa fa-unlock-alt"></i>修改密码</el-dropdown-item>
								<el-dropdown-item @click.native="loginout()"><i class="fa fa-sign-out"></i>退出登录</el-dropdown-item>
							</el-dropdown-menu>
						</el-dropdown>
					</span>
				</el-menu-item>
				
				<!-- <el-menu-item><i class="fa fa-power-off"></i></el-menu-item> -->
				<!-- <el-menu-item><i class="fa fa-clone"></i></el-menu-item> -->
			</el-menu>
			</span>
		</div>
		
		<tab-bar></tab-bar>


		<el-dialog v-dialogDrag :visible.sync="profileFormVisible" width="600px" append-to-body title="修改资料">
			<el-form ref="profileForm" :model="profileForm" label-width="80px">
				<el-row>
					<el-col :span="12">
						<el-form-item label="账号昵称" prop="nickName">
							<el-input v-model="profileForm.nickName"   placeholder="请输入昵称" maxlength="10" show-word-limit size="small" />
						</el-form-item>
					</el-col>
					</el-col>
					<el-col :span="12">
						<el-form-item label="联系电话" prop="phone">
							<el-input v-model="profileForm.phone"   placeholder="请输入联系电话" size="small"  maxlength="11" show-word-limit clearable />
						</el-form-item>
					</el-col>
					<el-col :span="24">
						<el-form-item label="用户头像">
							<div class="uploadcol">
								<div class="uploadborder">
									<ImagesUpload size="small"  uploadType="2" fileType="image" :image.sync="profileForm.headerImg"></ImagesUpload>
								</div>
							</div>
						</el-form-item>
					</el-col>
					<!-- <el-col :span="24">
						<el-form-item label="显示排序" prop="order_by">
							<el-input-number v-model="form.order_by" controls-position="right" :min="0" :value="100" size="small" />
						</el-form-item>
					</el-col> -->
				</el-row>
			</el-form>
			<div slot="footer" class="dialog-footer">
				<el-button @click="profileFormVisible = false" size="small">取 消</el-button>
				<el-button type="primary" @click="subProfile()" size="small">确 定</el-button>
			</div>

		</el-dialog>
		<el-dialog title="修改密码" :visible.sync="dialogFormVisible" append-to-body >
			<el-form ref="form" :model="form" :rules="rules">
				<el-form-item label="旧密码" prop="old_pwd" :label-width="formLabelWidth">
				<el-input v-model="form.old_pwd" autocomplete="off"></el-input>
				</el-form-item>
				<el-form-item label="新密码" prop="new_pwd" :label-width="formLabelWidth">
				<el-input v-model="form.new_pwd" autocomplete="off"></el-input>
				</el-form-item>
			</el-form>
			<div slot="footer" class="dialog-footer">
				<el-button @click="dialogFormVisible = false">取 消</el-button>
				<el-button type="primary" @click="confirmPwd()">确 定</el-button>
			</div>
		</el-dialog>


	</div>
	
</template>

<script>
	import {mapState} from 'vuex';
	import BreadName from './bread-name';
	import TabBar from './tab-bar'

	import {getInfo, changePwd, updateProfile} from '@/api/system/member'
    import ImagesUpload from '@/components/common/ImagesUpload.vue'

	export default{
		data(){
			return {
				dialogFormVisible: false,
				profileFormVisible: false,
				form: {
					old_pwd: "",
					new_pwd: "",
				},
				profileForm: {
					nickName: "",
					phone: "",
					headerImg: "",
				},
				rules: {
					old_pwd: [
					{ required: true, message: "旧密码不能为空", trigger: "blur" },
					],
					new_pwd: [
					{ required: true, message: "新密码不能为空", trigger: "blur" },
					],
				},
				formLabelWidth: "120px",
				face:"",
				username:"",
			}
		},
		components:{
			BreadName,
			TabBar,
			ImagesUpload
		},
		computed: {
			...mapState({
				collapse: state => state.app.collapse,
				device: state => state.app.device
			})
		},
		created(){
			getInfo().then(res => {
				console.log(res, "getInfogetInfo")
				this.face = this.profileForm.headerImg = res.data.userInfo.face
				this.username = res.data.userInfo.username
				this.profileForm.phone =  res.data.userInfo.phone
				this.profileForm.nickName =  res.data.userInfo.nick_name
				 
			})
		},
		methods: {
			handlePassword: async function () {
				this.dialogFormVisible = true;
			},
			confirmPwd: async function () {
				console.log(this.form);
				this.$refs["form"].validate((valid) => {
					if (valid) {
					changePwd(this.form).then((res) => {
						this.$message({
						message: res.msg,
						type: "success",
						});
						this.dialogFormVisible = false;
						this.$refs["form"].resetFields();
					});
					} else {
					return false;
					}
				});
			},
			subProfile: async function () {
				updateProfile(this.profileForm).then((res) => {
					this.$message({
					message: res.msg,
					type: "success",
					});
					this.profileFormVisible = false;
					this.$store.dispatch("GetInfo");
				});
			},
			ClickCollapse() {
				this.$store.dispatch('app/changeCollapse')
			},
			loginout:function(){
				
				this.$confirm('确定注销并退出系统吗？', '提示', {
				  confirmButtonText: '确定',
				  cancelButtonText: '取消',
				  type: 'warning'
				}).then(() => {
				  this.$store.dispatch('loginOut').then(() => {
					  this.msgSuccess("退出成功")
				    location.href = '/index';
				  })
				})
				
				
			}
		}
	}
</script>

<style lang="scss">
	.top {
		position: fixed;
		top: 0;
		right: 0;
		z-index: 1030;
		height: 91px;
		box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
	
		.top-bar {
			height: 50px;
			line-height: 50px;
			background: #FFFFFF;
			border-bottom: #f7f7f7 solid 1px;
	
			.coll {
				padding: 15px;
				float: left;
	
				&:hover {
					background: #f9fafc;
	
				}
			}
	
			.toolbar {
				float: right;
	
				.el-menu-item,
				.el-submenu__title {
					height: 50px;
					line-height: 50px;
					float: left;
				}
	
				.el-badge__content.is-fixed {
					top: 15px;
				}
	
				.user-info img {
					width: 30px;
					height: 30px;
					border-radius: 15px;
				}
			}
		}
	}
	
	.mbiao {
		line-height: 45px !important;
		font-size: 12px !important;
		float: left;
	}
</style>
