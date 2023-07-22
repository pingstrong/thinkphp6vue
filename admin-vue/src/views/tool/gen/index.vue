<template>
	<div>
	<panle title='生成配置' content="后台功能模块快速生成，一键生成控制层，模型层，视图层"></panle>
	<el-table :data="tableData" style="width: 100%;margin-bottom: 20px;" row-key="id" border stripe default-expand-all
	 v-loading="loading" >
		
		
		<el-table-column prop="name" label="表名称"></el-table-column>
		<el-table-column prop="engine" label="类型"></el-table-column>
		<el-table-column prop="create_time" label="创建时间"></el-table-column>
		<el-table-column prop="data_length" label="长度"></el-table-column>
		<el-table-column prop="rows" label="记录数"></el-table-column>
		
		
	
	
		
		<el-table-column prop="role_id" label="操作">
			<template slot-scope="scope">
				<PersButton type="text" size="mini" label="生成配置" icon="el-icon-info" perms="sys:role:edit" @click="gen(scope.row)"></PersButton>
				<PersButton type="text" size="mini" label="预览" icon="el-icon-view" perms="sys:role:edit" @click="editRole(scope.row)"></PersButton>
				<PersButton type="text" size="mini" icon="el-icon-bottom" perms="sys:role:del" label="生成代码" @click="delRole(scope.row)"></PersButton>
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
	// import {listGen,listCloums,generateData} from'@/api/generate/generate';
	import {listDatas} from '@/api/datas/datas';
	export default {
		components: {
			Panle,
			PersButton
		},
		data(){
			return{
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
			gen:function(data){
				
				let tableId= data.name;
				_self.$router.push("/gen/edit/"+ tableId);
				
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
		}
		
		}
</script>

<style lang="scss">
	@import "@/assets/css/common.scss";
</style>
