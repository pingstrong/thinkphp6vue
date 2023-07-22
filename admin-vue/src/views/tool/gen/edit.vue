<template>
	<div>
		<panle :title="'['+tables+']生成配置'" content="后台功能模块快速生成，一键生成控制层，模型层，视图层"></panle>
		<el-tabs v-model="activeName" @tab-click="handleClick">
			<el-tab-pane label="生成配置" name="1">

				<el-form ref="form" :model="form" :rules="rules" label-width="120px">
					<el-row :gutter="20">
						<el-col :span="10">
							<el-form-item label="表名称" prop="tables">
								<el-input v-model="form.tables" :disabled="true" size="mini"></el-input>
							</el-form-item>
						</el-col>
						<el-col :span="10">
							<el-form-item label="实体名称" prop="models">
						
								<el-input v-model="form.models" size="mini"></el-input>
							</el-form-item>
						</el-col>
					<!-- 	<el-col :span="10">
							<el-form-item label="表描述">
								<el-input v-model="form.remks" size="mini"></el-input>
							</el-form-item>
						</el-col> -->

					</el-row>
					<!-- <el-row :gutter="20">
						<el-col :span="10">
							<el-form-item label="实体名称" prop="models">

								<el-input v-model="form.models" size="mini"></el-input>
							</el-form-item>
						</el-col>
					</el-row> -->
				
					<el-row :gutter="20">
						<el-col :span="10">
							<el-form-item label="模块类型" prop="type">
								<el-select v-model="form.type" placeholder="请选择活动区域" size="mini">
									<el-option label="列表(增删改查)" :value="0"></el-option>
									<el-option label="树表(增删改查)" :value="1"></el-option>
									<el-option label="单页(增删改查)" :value="2"></el-option>
								</el-select>
							</el-form-item>
						</el-col>

						<el-col :span="10">
							<el-form-item label="生成模块名" prop="pagepack">

								<el-input v-model="form.pagepack" size="mini"></el-input>
							</el-form-item>
						</el-col>

					</el-row>
					<el-row :gutter="20">

						<el-col :span="10">
							<el-form-item label="生成功能名">

								<el-input v-model="form.rname" size="mini"></el-input>
							</el-form-item>
						</el-col>
					</el-row>
					<el-row :gutter="20">
						<el-col :span="10">
							<el-form-item label="备注">
								<el-input v-model="form.content" size="mini" type="textarea" :rows="4"></el-input>
							</el-form-item>
						</el-col>
					</el-row>
				</el-form>
				<div class="footer">

					<el-button type="primary" @click="submitForm('form')" size="small">确 定</el-button>

				</div>

			</el-tab-pane>
			<el-tab-pane label="字段配置" name="2">
				<el-table :data="tableData" style="width: 100%;margin-bottom: 20px;" row-key="glid" v-loading="loading">
					<el-table-column label="序号" type="index" min-width="5%" class-name="allowDrag" />
					<el-table-column prop="name" label="字段名称"></el-table-column>
					<el-table-column prop="is_type" label="类型"></el-table-column>
					<el-table-column prop="remks" label="描述">
						<template slot-scope="scope">
							<el-input v-model="scope.row.remks" size="mini"></el-input>
						</template>

					</el-table-column>
					<el-table-column prop="data_length" label="是否验证">
						<template slot-scope="scope">
							<el-switch v-model="scope.row.is_val" active-color="#13ce66" inactive-color="#ff4949" :active-value="0"
							 :inactive-value="1"></el-switch>
							<!-- <el-radio-group v-model="scope.row.val">
							    <el-radio :label="1">是</el-radio>
							    <el-radio :label="0">否</el-radio>
							    
							  </el-radio-group> -->
						</template>

					</el-table-column>
					<el-table-column label="插入">
						<template slot-scope="scope">
							<el-checkbox :true-label="1" v-model="scope.row.is_add"></el-checkbox>
						</template>
					</el-table-column>
					<el-table-column label="编辑">
						<template slot-scope="scope">
							<el-checkbox :true-label="1" v-model="scope.row.is_edit"></el-checkbox>
						</template>
					</el-table-column>
					<el-table-column label="列表">
						<template slot-scope="scope">
							<el-checkbox :true-label="1" v-model="scope.row.is_list"></el-checkbox>
						</template>
					</el-table-column>

					<el-table-column prop="rows" label="视图展示">
						<template slot-scope="scope">
							<el-select v-model="scope.row.is_view" placeholder="请选择字段类型" size="mini">
								<el-option label="文本框" :value="0"></el-option>
								<el-option label="多行文本" :value="1"></el-option>
								<el-option label="多选框" :value="2"></el-option>
								<el-option label="编辑器" :value="3"></el-option>
								<el-option label="时间" :value="4"></el-option>
								<el-option label="上传图片" :value="5"></el-option>
							</el-select>
						</template>

					</el-table-column>
				</el-table>


			</el-tab-pane>


		</el-tabs>
	</div>
</template>

<script>
	let _self;
	import Panle from '@/components/Panle';
	import {
		
		genEdit,
		addGenerate
	} from '@/api/generate/generate';
	export default {
		components: {
			Panle
		},
		data() {
			return {
				activeName: '1',
				tables: '',
				form: {
					gid:0
				},
				tableData: [],
				loading: false,
				rules: {
					tables: [{
						required: true,
						message: "表名称不能为空",
						trigger: "blur"
					}],
					models: [{
						required: true,
						message: "实体名称不能为空",
						trigger: "blur"
					}],
					type: [{
						required: true,
						message: "模块类型不能为空",
						trigger: "blur"
					}],
					pagepack: [{
						required: true,
						message: "生成包名不能为空",
						trigger: "blur"
					}],
				}
			}
		},
		created() {
			_self = this;
			const tableId = _self.$route.params && _self.$route.params.tableId;
			console.log(tableId);
			_self.tables = tableId;
			_self.init();
		},
		methods: {

			init: function() {
				let data = {
					'name': _self.tables
				};
				genEdit(data).then((res) => {
					console.log(res);
					_self.form = res.data.geninfo;
					_self.tableData = res.data.genlist;
				})
			},
			handleClick: function(e) {

			},
			submitForm: function(data) {
				_self.$refs[data].validate((valid, callback) => {
					if (valid) {
						_self.add();
					} else {
						return false;
					}
				});
			},
			add:function(){
				
				_self.form.list = _self.tableData;
				
				addGenerate(_self.form).then((res)=>{
					console.log(res);
					if(res.code==200){
						_self.msgSuccess(res.msg);
						_self.init();
					}
				 })
			}
		}
	}
</script>

<style lang="scss">
	@import "@/assets/css/common.scss";

	.el-tabs__item {
		font-size: 12px;
	}

	.footer {
		display: flex;
		justify-content: center;
	}
</style>
