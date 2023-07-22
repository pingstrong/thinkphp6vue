<template>
	<div>
		<panle title='文件管理' content="上传文件列表"></panle>
		<div class="searchbar">
			<el-row class="pt20">
				<el-col :span="12">

					<el-button size="mini" @click="init()" style="float: left; margin-right: 5px;">刷新</el-button>
					<el-upload class="upload-demo" :action="actions" multiple :on-success="uploadSuccess" ref="upload" :show-file-list="false"
					 :headers="uploadHeader" :on-error="uploadError">
						<PersButton icon="el-icon-edit" size="mini" perms="files:upload" type="primary" label="上传图片"></PersButton>
					</el-upload>


					<pers-button type="danger" size="mini" icon="el-icon-delete" @click="delAll()" perms="files:del" label="批量删除"></pers-button>
				</el-col>
				<el-col :span="12" style="text-align: right;">
					<el-form :inline="true" :model="formInline" class="demo-form-inline">

						<el-form-item label="">
							<el-input v-model="formInline.keyword" size="mini" placeholder="请输入文件名称"></el-input>
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
			<el-table-column prop="fid" label="ID" width="55"></el-table-column>
			<el-table-column prop="urls" label="缩略图">
				<template slot-scope="scope">
					<el-image style="width: 50px; height: 50px" :src="scope.row.http_urls" :preview-src-list="[scope.row.http_urls]"
					 v-if="scope.row.type==0">
					</el-image>
					<el-tag type="danger" :label="scope.row.f_type" effect="plain" size="small" v-if="scope.row.type==2">{{scope.row.f_type}}</el-tag>
					<el-tag type="success" :label="scope.row.f_type" effect="plain" size="small" v-if="scope.row.type==1">{{scope.row.f_type}}</el-tag>


				</template>

			</el-table-column>
			<el-table-column prop="name" label="文件名称"></el-table-column>

			<el-table-column prop="http_urls" label="访问地址"></el-table-column>


			<el-table-column prop="f_type" label="文件后缀"></el-table-column>
			<el-table-column prop="oss" label="存储位置"></el-table-column>
			<el-table-column prop="creat_by" label="上传者"></el-table-column>
			<el-table-column prop="creat_time" label="上传时间"></el-table-column>
			<el-table-column prop="fid" label="操作">
				<template slot-scope="scope">

					<PersButton type="text" size="mini" icon="el-icon-delete" perms="sys:role:del" label="删除" @click="delRole(scope.row)"></PersButton>
					<PersButton type="text" size="mini" label="复制链接" icon="fa  fa-pencil" perms="node:edit" @click="copy(scope.row)"></PersButton>
				</template>
			</el-table-column>
		</el-table>

		<div class="block">

			<el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange" :current-page="page"
			 :page-sizes="[10, 50, 100, 200]" :page-size="pageSize" background layout="total, sizes, prev, pager, next, jumper"
			 :total="total">
			</el-pagination>
		</div>



	</div>
</template>

<script>
	let _self;
	let uploads = process.env.VUE_APP_API;
	let imgUrl = process.env.VUE_APP_PUBLIC_PATH;
	import Panle from '@/components/Panle';
	import PersButton from '@/components/PersButton';
	import {listFiles,delFiles,batchRemove} from '@/api/files/files';

	import {
		getToken
	} from '@/common/token'
	export default {
		components: {
			Panle,
			PersButton
		},
		data() {
			return {
				loading: false,
				pageSize: 10, //一页显示多少条
				page: 1,
				total: 0, //总页数
				tableData: [],
				serachword: '',
				formInline: {},




				checkKey: [],
				multipleSelection: [],

				actions: uploads + "/uploads/index",
				uploadHeader: {
					"Authorization": "Bearer " + getToken()
				},
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
					"page": _self.page,
					"keyWord": _self.serachword,
					'type':3000
				}
				listFiles(param).then((res) => {
					console.log(res);
					if (res.code == 200) {
						_self.tableData = res.data.list;
						_self.total = res.data.total;
						_self.loading = false;
					}
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
				_self.page = e;
				_self.init();
			},
			handleSelectionChange: function(e) {
				console.log(e);
				let selectChang = []
				for (let item of e) {
					selectChang.push(item.fid)

				}
				_self.multipleSelection = selectChang;
				console.log(selectChang);
			},





			delRole: function(data) {
				_self.$confirm('确定删除【' + data.name + '】此文件', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {

					delFiles(data.fid).then((res) => {
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


			uploadSuccess: function(res) {
				console.log(res);
				if (res.code == 200) {
					_self.init();
					_self.msgSuccess(res.msg);
				} else {
					_self.msgError(res.msg);
				}
			},
			uploadError: function(res) {
				_self.msgError("后端错误，请联系管理员");
			},
			copy: function(data) {
				var oInput = document.createElement('input'); //创建一个隐藏input（重要！）
				oInput.value = data.http_urls; //赋值
				document.body.appendChild(oInput);
				oInput.select(); // 选择对象
				document.execCommand("Copy"); // 执行浏览器复制命令
				oInput.className = 'oInput';
				oInput.style.display = 'none';
				_self.msgSuccess("复制成功")
			},
			delAll: function() {
				if (_self.multipleSelection.length == 0) {
					_self.$alert('请选择要删除的数据', '系统提示', {
						confirmButtonText: '确定',
						type: 'error',
					});
					return false;
				}
				_self.$confirm('此操作将永久删除此数据, 是否继续?', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					let data = {
						ids: _self.multipleSelection
					}
					batchRemove(data).then((res) => {
						if (res.code == 200) {
							_self.msgSuccess(res.msg);
							_self.init();
						} else {
							_self.msgError(res.msg);
						}
					})





				}).catch(() => {
					this.$message({
						type: 'info',
						message: '已取消删除'
					});
					_self.$refs.multipleTable.clearSelection();
				});
			}
		}
	}
</script>

<style lang="scss">
	@import "@/assets/css/common.scss";

	.upload-demo {
		float: left;
		margin-right: 5px;
	}

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
</style>
