<template>
	<div>
		<panle title='数据管理' content="系统数据库管理,请不要随意改动"></panle>
		<div class="searchbar">
			<el-row class="pt20">
				<el-col :span="12">
					<el-button size="mini" @click="init()">刷新</el-button>
					<pers-button icon="el-icon-edit" size="mini" @click="add()" perms="sys:menu:add" type="primary" label="备份"></pers-button>
					<pers-button type="danger" size="mini" icon="el-icon-success" @click="delAll()" perms="sys:role:del" label="优化"></pers-button>
					<pers-button type="success" size="mini" icon="el-icon-info" @click="delAll()" perms="sys:role:del" label="修改"></pers-button>
				</el-col>
				
			</el-row>
		</div>
		<el-table :data="tableData" style="width: 100%;margin-bottom: 20px;" row-key="id" border stripe default-expand-all
		 v-loading="loading" @selection-change="handleSelectionChange">
			<el-table-column type="selection" width="55">
			</el-table-column>
			
			<el-table-column prop="name" label="表名称"></el-table-column>
			<el-table-column prop="engine" label="类型"></el-table-column>
			<el-table-column prop="create_time" label="创建时间"></el-table-column>
			<el-table-column prop="data_length" label="长度"></el-table-column>
			<el-table-column prop="rows" label="记录数"></el-table-column>
			<el-table-column prop="comment" label="描述"></el-table-column>
			
		
		
			
			<el-table-column prop="role_id" label="操作">
				<template slot-scope="scope">
					<PersButton type="text" size="mini" label="优化" icon="el-icon-success" perms="sys:role:edit" @click="editRole(scope.row)"></PersButton>
					<PersButton type="text" size="mini" icon="el-icon-info" perms="sys:role:del" label="修复" @click="delRole(scope.row)"></PersButton>
				</template>
			</el-table-column>
		</el-table>
		<div class="block">
		
			<el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange" :current-page="pageNumber"
			 :page-sizes="[10, 50, 100, 200]" :page-size="pageSize" background layout="total, sizes, prev, pager, next, jumper"
			 :total="total">
			</el-pagination>
		</div>
	</div>
</template>

<script>
	let _self;
	import Panle from '@/components/Panle';
	import PersButton from '@/components/PersButton';
	import {listDatas} from '@/api/datas/datas';
	export default {
		components: {
			Panle,
			PersButton
		},
		data(){
			return {
				tableData:[],
				loading: false,
				pageSize: 10, //一页显示多少条
				pageNumber: 1,
				total: 0, //总页数
			}
		},
		created() {
			_self = this;
			_self.init();
		},
		methods:{
			init:function(){
				_self.loading = true;
				let param = {
					"pageSize": _self.pageSize,
					"pageNumber": _self.pageNumber,
					"keyword": _self.serachword
				}
				listDatas(param).then((res)=>{
					console.log(res);
					if (res.code == 200) {
						_self.tableData = res.data.list;
						_self.total = res.data.total;
						_self.loading = false;
					}
				})
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
		}
		
		}
</script>

<style lang="scss">
	@import "@/assets/css/common.scss";
</style>
