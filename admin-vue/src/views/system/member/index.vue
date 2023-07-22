<template>
	<div>
		<panle title='后台管理员' content="后台管理员列表"></panle>
		<div class="searchbar">
			<el-row class="pt20">
				<el-col :span="12">
					<el-button size="mini" @click="init()">刷新</el-button>
					<pers-button icon="el-icon-edit" size="mini" @click="add()" perms="sys:menu:add" type="primary" label="添加"></pers-button>
					<pers-button type="danger" size="mini" icon="el-icon-delete" @click="delAll()" perms="sys:role:del" label="批量删除"></pers-button>
				</el-col>
				<el-col :span="12" style="text-align: right;">
					<el-form :inline="true" :model="formInline" class="demo-form-inline">

						<el-form-item label="">
							<el-input v-model="formInline.keyword" size="mini" placeholder="请输入账号名称或者电话号码"></el-input>
						</el-form-item>

						<el-form-item>
							<el-button type="primary" size="mini" @click="serach">查询</el-button>
						</el-form-item>
					</el-form>
				</el-col>
			</el-row>
		</div>

		<el-table :data="tableData" style="width: 100%;margin-bottom: 20px;" row-key="id" border stripe default-expand-all
		 v-loading="loading" @selection-change="handleSelectionChange">
			<el-table-column type="selection" width="55">
			</el-table-column>
			<el-table-column prop="uid" label="ID" width="55"></el-table-column>
			<el-table-column prop="face" label="头像">
				<template slot-scope="scope">
					<el-image :src="scope.row.face" fit="fill" style="width: 60px;height: 60px;"></el-image>
				</template> 
			</el-table-column>
			<el-table-column prop="user_name" label="账号名称"></el-table-column>
			<el-table-column prop="nick_name" label="账号妮称"></el-table-column>

			<el-table-column prop="status" label="状态">
				<template slot-scope="scope">
					<el-switch v-model="scope.row.status" active-color="#13ce66" inactive-color="#ff4949" @change="changeSwitch(scope.row)"
					 :active-value="1" :inactive-value="0"></el-switch>
				</template>

			</el-table-column>
			<el-table-column prop="phone" label="联系电话"></el-table-column>


			<el-table-column prop="creat_time" label="创建时间"></el-table-column>
			<el-table-column prop="login_num" label="登录次数"></el-table-column>
			<el-table-column prop="uid" label="操作">
				<template slot-scope="scope">
					<PersButton type="text" size="mini" label="编辑" icon="fa  fa-pencil" perms="sys:role:edit" @click="edit(scope.row)"></PersButton>
					<PersButton type="text" size="mini" icon="el-icon-delete" perms="sys:role:del" label="删除" @click="del(scope.row)"></PersButton>
				</template>
			</el-table-column>
		</el-table>

		<div class="block">

			<el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange" :current-page="pageNumber"
			 :page-sizes="[10, 50, 100, 200]" :page-size="pageSize" background layout="total, sizes, prev, pager, next, jumper"
			 :total="total">
			</el-pagination>
		</div>
		<el-dialog v-dialogDrag :visible.sync="open" width="600px" append-to-body :title="!form.uid ? '新增管理员' : '修改管理员'">
			<el-form ref="form" :model="form" :rules="rules" label-width="80px">
				<el-row>



					<el-col :span="12">
						<el-form-item label="账号名称" prop="user_name">
							<el-input v-model="form.user_name" placeholder="请输入账号名称" size="small" />
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="账号密码" prop="password">
							<el-input type="password" show-password  v-model="form.password" placeholder="请输入账号密码" size="small" />
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="账号妮称" prop="password">
							<el-input v-model="form.nick_name" placeholder="请输入账号密码" size="small" />
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="所属角色" prop="role">
							<el-select v-model="form.role" multiple placeholder="请选择" size="small" style="width:100%">
								<el-option v-for="item in roleslist" :key="item.role_name" :label="item.role_name" :value="item.role_id">
								</el-option>
							</el-select>
						</el-form-item>
					</el-col>



					<el-col :span="12">
						<el-form-item label="是否启用" prop="status">
							<el-radio-group v-model="form.status">
								<el-radio :label="1">启用</el-radio>
								<el-radio :label="0">禁用</el-radio>
							</el-radio-group>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="联系电话" prop="phone">
							<el-input v-model="form.phone" placeholder="请输入联系电话" size="small" clearable />
						</el-form-item>
					</el-col>
					
					<el-col :span="24">
						<el-form-item label="用户头像">
							<div class="uploadcol">
								<div class="uploadborder">
									<img :src="form.face" width="100%" height="100%" />
								</div>
								<el-button type="primary" @click="openUploadDial()" size="mini" style="margin-top:10px">上传头像</el-button>
							</div>
						</el-form-item>
					</el-col>

					<el-col :span="24">
						<el-form-item label="显示排序" prop="order_by">
							<el-input-number v-model="form.order_by" controls-position="right" :min="0" :value="100" size="small" />
						</el-form-item>
					</el-col>
				</el-row>
			</el-form>
			<div slot="footer" class="dialog-footer">
				<el-button @click="open = false" size="small">取 消</el-button>
				<el-button type="primary" @click="!form.uid ? submitForm('form') : subEditForm('form') " size="small">确 定</el-button>
			</div>

		</el-dialog>
		<select-img :show="clickType" @update="cleanDiaglog" :selectType="imgnum" @selectSure="selectImgs" :type="0"></select-img>

	</div>
</template>

<script>
	let _self;
	import Panle from '@/components/Panle';
	import PersButton from '@/components/PersButton';
	import {
		getMemberList,addMember,editMember,delMember
	} from '@/api/system/member';
	import SelectImg from '@/components/select-img';
	import {selectRole} from '@/api/system/role';
	export default {
		components: {
			Panle,
			PersButton,
			SelectImg
		},
		data() {
			return {
				loading: false,
				pageSize: 10, //一页显示多少条
				pageNumber: 1,
				total: 0, //总页数
				tableData: [],
				serachword: '',
				formInline: {},
				open: false,
				form: {
					"uid": '',
					"user_name": "",
					"password": "",
					"status": 1,
					"order_by": 100,
					"role": []
				},
				rules: {
					user_name: [{
						required: true,
						message: "账号不能为空",
						trigger: "blur"
					}, { min: 5, message: '至少5个字符', trigger: 'blur' }],
					password: [{
						required: true,
						message: "密码不能为空",
						trigger: "blur"
					}],
					status: [{
						required: true,
						message: "请选择是否启用",
						trigger: "blur"
					}],
					role: [{
						type: 'array',
						required: true,
						message: "至少要选择一个角色",
						trigger: "change"
					}]
				},
				parentDate: [],
				props: {
					// 配置项（必选）
					value: "id",
					label: "name",
					children: "children"

				},
				checkKey: [],
				multipleSelection: [],
				roleslist: [],
				clickType: false,
				imgnum: 1, //选择图片数量
			}
		},
		created() {
			_self = this;
			_self.init();
		},
		methods: {
			init: function() {
				_self.loading = true;
				let param = {
					"pageSize": _self.pageSize,
					"pageNumber": _self.pageNumber,
					"keyword": _self.serachword
				}
				getMemberList(param).then((res) => {
					console.log(res);
					if (res.code == 200) {
						_self.tableData = res.data.list;
						_self.total = res.data.total;
						_self.loading = false;
					}
				})
                selectRole().then((res)=>{
                	_self.roleslist = res.data;
                })


			},
			serach: function() {
				_self.serachword = _self.formInline.keyword;
				_self.init();
			},
			handleSizeChange: function(e) {
				console.log(e);
				_self.pageSize = e;
				_self.init();
			},
			handleCurrentChange: function(e) {
				console.log(e);
				_self.pageNumber = e;
				_self.init();
			},
			handleSelectionChange: function(e) {
				console.log(e);
				let selectChang = []
				for (let item of e) {
					selectChang.push(item.role_id)

				}
				_self.multipleSelection = selectChang;
				console.log(selectChang);
			},

			add: function() {
				
				
				
				_self.form = {
					"uid": '',
					"user_name": "",
					"password": "",
					"status": 1,
					"order_by": 100,
					"role": []
				};

				_self.open = true;
			},


			submitForm: function(data) {
				console.log(_self.form.role);
				
				_self.$refs[data].validate((valid) => {
					if (valid) {
						addMember(_self.form).then((res) => {
							console.log(res)
							if (res.code == 200) {
								_self.msgSuccess(res.msg);
								_self.init();
								_self.open = false;
							} else {
								_self.msgError(res.msg);
							}
						})
					} else {
						return false;
					}
				})
			},
			del: function(data) {
				_self.$confirm('确定删除【' + data.user_name + '】此规则', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {

					delMember(data.uid).then((res) => {
						if (res.code == 200) {
							_self.msgSuccess(res.msg);
							_self.init();
						} else {
							_self.msgError(res.msg);
						}
					})


				}).catch(() => {
					_self.$message({
						type: 'info',
						message: '已取消删除'
					});
				});
			},
			edit: function(data) {

				_self.form.uid = data.uid;
				let roles=[];
				data.roles.forEach((it)=>{
					roles.push(it.role_id);
				})
				let editForm = {
					"uid": data.uid,
					"user_name": data.user_name,
					"password": data.password,
					"status": data.status,
					"order_by": data.order_by,
					"nick_name":data.nick_name,
					"phone":data.phone,
					"face":data.face,
					"role": roles
					
				}
				Object.assign(_self.form, editForm);
				_self.open = true;
			},
			subEditForm: function(data) {
                 _self.$refs[data].validate((valid) => {
					if (valid) {
						editMember(_self.form).then((res) => {
							if (res.code == 200) {
								_self.msgSuccess(res.msg);
								_self.init();
								_self.open = false;

							} else {
								_self.msgError(res.msg);
							}
						})
					} else {
						return false;
					}
				})

			},
			cleanDiaglog: function(shows) {

				_self.clickType = false;
			},
			openUploadDial: function() {

				_self.clickType = true;
			},
			selectImgs: function(res) {
			                  console.log(res);
							_self.clickType = true;
							_self.form.face =  res[0].urls
			
			
						},
		}
	}
</script>

<style lang="scss">
	@import "@/assets/css/common.scss";

	.demo-form-inline {
		.el-form-item {
			margin-bottom: 0;
		}
	}

	.el-tree {
		max-height: 200px;
		overflow: auto;
		background: #f7f7f7;
	}

	.el-tree-node__label,
	.el-textarea__inner {
		font-size: 12px;
	}

	.groupmenu .el-tree-node__children .el-tree-node__children .el-tree-node__children .el-tree-node__content {
		float: left;
		width: 100px;
	}

	.el-checkbox__label {
		font-size: 12px !important;
	}
	.uploadcol {
		display: flex;
			flex-flow: column;
			width: 100px;
		}
	
		.uploadborder {
			border: 1px dashed #d9d9d9;
			border-radius: 6px;
			/* cursor: pointer;
		    position: relative;
		    overflow: hidden; */
			width: 100px;
			height: 100px;
		}
</style>
