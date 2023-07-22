<template>
	<el-dialog title="选择文件" v-dialogDrag :visible.sync="uploadDialog" :show="show" @close="click" class="uploim" width="80%">
		<div class="btn-select">
			<div class="b-s-l">
				<el-tabs tab-position="left" style="height: 350px;" class="uploadTab" @tab-click="tabClick">
					<el-tab-pane label="图片" name="0"></el-tab-pane>
					<el-tab-pane label="文件" name="1"></el-tab-pane>
					<el-tab-pane label="视频" name="2"></el-tab-pane>
					<el-tab-pane label="其它" name="3"></el-tab-pane>
				</el-tabs>


			</div>
			<div class="b-s-r">
				<div>
					<el-row>
						<el-col :span="12">
							<el-form :inline="true" :model="formInline" class="demo-form-inline" style="margin-left: 10px;">
								<el-form-item>

									<el-input v-model="formInline.keyWord" size="mini" placeholder="关键字查询"></el-input>
								</el-form-item>

								<el-form-item>
									<el-button type="primary" size="mini">查询</el-button>
								</el-form-item>
							</el-form>

						</el-col>
						<el-col :span="12">
							<el-upload class="upload-demos" :action="_self.actions" multiple :on-success="uploadsuccess" :headers="uploadHeader"
							 :show-file-list="false">
								<el-button type="primary" size="mini">点击上传</el-button>

							</el-upload>
						</el-col>
					</el-row>

				</div>

				<!-- 展示数据 -->
				<div class="file-list">
					<el-row :gutter="20" class="el-roww" type="flex" align="middle" style="margin: 0;">
						<el-col class="el-cols" v-for="v in tableData" :key="v.fid" :span="6" style="position: relative;">
							<div class="zkw">
								<el-image :src="v.http_urls" fit="contain" v-if="v.type==0"></el-image>
							    <div v-if="v.type==1">{{v.name}}</div>
								<div v-if="v.type==2"> <video controls width="80%" height="80%">
																	<source :src="v.http_urls" type="video/mp4">
																	<source src="movie.ogg" type="video/ogg">
																	您的浏览器不支持 video 标签。
																</video></div>
							</div>
							<div class="zkw_hover">
								<i class="el-icon-delete-solid" @click="delRole(v)"></i>
								<i class="el-icon-check" @click="selectImg(v)"></i>
							</div>
							<div class="selectBj " :class="[v.show? 'showflex' : 'hide']" @click="selectImg(v)">
								<i class="fa fa-check"></i>
							</div>
						</el-col>
					</el-row>
					<el-pagination @size-change="handleSizeChanges" @current-change="handleCurrentChanges" :current-page="page"
					 :page-sizes="[10, 50, 100, 200]" :page-size="pageSize" layout="total, prev, pager, next, jumper" :total="total">
					</el-pagination>
				</div>

			</div>
		</div>
		<span slot="footer" class="dialog-footer">
			<el-button @click="uploadDialog = false" size="mini">取 消</el-button>
			<el-button type="primary" @click="sureSelect" size="mini">确 定</el-button>
		</span>
	</el-dialog>

</template>

<script>
	let _self;
	let uploads = process.env.VUE_APP_API;
	import {
		listFiles,
		delFiles,
		batchRemove
	} from '@/api/files/files';
	import {
		getToken
	} from '@/common/token'
	export default {
		name: 'select-img',
		data() {
			return {
				uploadDialog: false,
				formInline: {},
				pageSize: 8, //一页显示多少条
				page: 1, //当前多少页
				keyWord: '',
				total: 0, //总页数
				fileType: this.type,
				tableData: [],
				selectDate: [],
				actions: uploads + '/uploads/index',
				uploadHeader: {
					"Authorization": "Bearer " + getToken()
				},
			}
		},
		props: {
			show: {
				type: Boolean,
				default: false
			},
			selectType: {
				type: Number,
				default: 1
			},
			type: {
				type: Number,
				default: 0
			},
			shotype: {
				type: Number,
				default: 0
			}

		},
		watch: {
			show() {
				this.uploadDialog = this.show;
			}
		},
		created() {
			_self = this;
			_self.init();
		},
		methods: {
			click() {
				this.$emit('update', this.show)
				this.selectDate = [];
			},
			sureSelect: function() {

				this.$emit('selectSure', this.selectDate);

				this.click();
				this.selectDate = [];
				this.init();

			},
			init: function() {
				let param = {
					"pageSize": _self.pageSize,
					"page": _self.page,
					"keyWord": _self.keyWord,
					"type": _self.fileType
				}
				listFiles(param).then((res) => {
					console.log(res);
					_self.tableData = res.data.list;
					_self.total = res.data.total;
				})
			},
			handleSizeChanges: function(e) {
				//console.log(e);
				_self.pageSize = e;
				_self.init();
			},
			handleCurrentChanges: function(e) {
				console.log(e);
				_self.page = e;
				_self.init();
			},
			uploadsuccess(res) {
				//this.init();
				if (res.code == 200) {
					_self.init();
					_self.msgSuccess(res.msg);
				} else {
					_self.msgError(res.msg);
				}
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
			selectImg: function(item) {

				let selectnum = _self.selectDate.length;
				if (item.show == true) {
					_self.$set(item, 'show', false);

					_self.selectDate.forEach(function(its) {
						if (its.id == item.fid) {
							var index = _self.selectDate.indexOf(its);
							if (index > -1) {
								_self.selectDate.splice(index, 1);
							}
						}
					});


				} else {


					if (_self.selectType == 1) {

						_self.tableData.forEach(function(its) {

							if (its.fid != item.fid) {
								_self.$set(its, 'show', false);
							}
						});
						_self.selectDate = [];
						_self.selectDate.push({
							id: item.fid,
							urls: item.http_urls
						});
						_self.$set(item, 'show', true);
					} else {

						if (selectnum < _self.selectType) {
							_self.$set(item, 'show', true);
							_self.selectDate.push({
								id: item.fid,
								urls: item.http_urls
							});
						}


					}

				}
			},
			tabClick: function(tab, event) {
				_self.fileType = Number(tab.name);
				_self.selectDate = [];
				_self.init();
			},
		}

	}
</script>

<style lang="scss">
	.uploim {
		.el-dialog__body {
			padding: 0 !important;
		}
	}

	.btn-select {
		width: 100%;
		height: 100%;
		display: flex;

	}

	.b-s-l {
		width: 70px;
	}

	.b-s-r {
		flex: 1;
	}

	.upload-demos {
		display: flex;
		padding: 7px;
	}

	.el-roww {
		margin-bottom: 20px;
		display: flex;
		flex-wrap: wrap
	}

	.zkw {
		width: 100%;
		background: #f1f1f1;
		margin-bottom: 10px;
		height: 150px;
		display: flex;
		justify-content: center;
		align-items: center;

		.el-image {
			width: calc(100% - 20px);
			height: calc(100% - 20px);
			margin: 10px;

		}

	}

	.el-cols:hover .zkw_hover {
		display: flex !important;
	}

	.zkw_hover {
		background-color: rgba(0, 0, 0, 0.4);
		width: calc(100% - 20px);
		height: 150px;
		position: absolute;
		top: 0;

		display: none;
		justify-content: center;
		align-items: center;

		i {
			font-size: 20px;
			color: #ffffff;
			margin-right: 10px;
		}
	}

	.selectBjs {
		/* background-color: rgba(0,0,0,0.4); */

		position: absolute;
		top: 0;
		/* left: 50%; */
		right: 0;
		/* transform:translate3d(-50%,0,0); */
		display: none;
		border-top: 30px solid #67c23a;
		border-left: 30px solid transparent;
	}

	.selectBjs i {
		position: absolute;
		/* top: 0;
	    top: -40px;
	    left: -25px; */
		font-size: 10px;
		color: #fff;
		top: -25px;
		left: -15px;
	}

	.showflex {
		display: flex !important;
		justify-content: center;
	}

	.selectBj {
		background-color: rgba(0, 0, 0, 0.4);
		width: calc(100% - 20px);
		height: 150px;
		position: absolute;
		top: 0;
		left: 50%;
		transform: translate3d(-50%, 0, 0);
		display: none;
		justify-content: center;
		align-items: center;
	}

	.selectBj i {
		font-size: 30px;
		line-height: 100px;
		color: #fff;
	}
</style>
