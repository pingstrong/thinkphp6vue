<template>
	<div>
		<panle title='生成配置' content="后台功能模块快速生成，一键生成控制层，模型层，视图层"></panle>
		<div class="topform">
			
					<el-form ref="form" :model="form" label-width="80px" :inline="true">
					 <el-form-item label="数据表">
					    <el-select v-model="form.tables" placeholder="请选择活数据表" size="mini" @change="selectChang">
					      <el-option
					            v-for="item in tableList"
					            :key="item"
					            :label="item"
					            :value="item">
					          </el-option>
					    </el-select>
					  </el-form-item>
					  <el-form-item label="统一名称">
					    <el-input v-model="form.name" size="mini"></el-input>
					  </el-form-item>
					  <el-form-item label="视图展示">
					   <el-radio-group v-model="form.type">
					       <el-radio :label="1">列表</el-radio>
					       <el-radio :label="2">分类</el-radio>
					       <el-radio :label="3">单页</el-radio>
					     </el-radio-group>
					  </el-form-item>
					  <el-form-item label="节点配置">
					   <el-radio-group v-model="form.menu">
					       <el-radio :label="1">是</el-radio>
					       <el-radio :label="0">否</el-radio>
					       
					     </el-radio-group>
					  </el-form-item>
					  </el-form>
			
			
			
		</div>
		<div v-if="form.tables">
		<el-table  :data="tableData" style="width: 100%;margin-bottom: 20px;" row-key="id" border stripe default-expand-all
		 v-loading="loading" >
			<el-table-column prop="Field" label="字段名称"></el-table-column>
			<el-table-column prop="Type" label="类型"></el-table-column>
			<el-table-column prop="Comment" label="描述"></el-table-column>
			<el-table-column prop="data_length" label="是否验证">
				<template slot-scope="scope">
					<el-switch v-model="scope.row.val" active-color="#13ce66" inactive-color="#ff4949"  :active-value="0" :inactive-value="1"></el-switch>
					<!-- <el-radio-group v-model="scope.row.val">
					    <el-radio :label="1">是</el-radio>
					    <el-radio :label="0">否</el-radio>
					    
					  </el-radio-group> -->
				</template>
				
			</el-table-column>
			<el-table-column prop="rows" label="视图展示">
				<template slot-scope="scope">
					<el-select v-model="scope.row.type" placeholder="请选择字段类型" size="mini" >
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
		<pers-button icon="el-icon-edit" size="mini"  perms="sys:menu:add" type="primary" label="一键生成"></pers-button>
		<pers-button icon="el-icon-edit" size="mini" @click="eyeshow()"  perms="sys:menu:add" type="primary" label="预览"></pers-button>
	 </div>
	 
	 
	 <el-dialog :visible.sync="open" width="80%" append-to-body title="预览"  >
		 <el-tabs v-model="activeName" >
		     <el-tab-pane label="Model" name="1">
				 <pre><code v-html="model"></code></pre>
			 </el-tab-pane>
		     <el-tab-pane label="Controller" name="2">
				 <pre><code v-html="controller"></code></pre>
			 </el-tab-pane>
		     <el-tab-pane label="Validate" name="3">
				 <pre><code v-html="service"></code></pre>
			 </el-tab-pane>
		     <el-tab-pane label="Service" name="4">
				 <pre><code v-html="service"></code></pre>
			 </el-tab-pane>
			 <el-tab-pane label="Router" name="5">定时任务补偿</el-tab-pane>
			 <el-tab-pane label="Api" name="6">定时任务补偿</el-tab-pane>
			  <el-tab-pane label="View" name="7">定时任务补偿</el-tab-pane>
		   </el-tabs>
	 </el-dialog>
	 
	 
	 
	</div>
</template>

<script>
	let _self;
	import Panle from '@/components/Panle';
	import PersButton from '@/components/PersButton';
	import {listGen,listCloums,generateData} from'@/api/generate/generate';
	export default {
		components: {
			Panle,
			PersButton
		},
		data(){
			return{
				form:{
					type:1
				},
				tableData:[],
				loading: false,
				pageSize: 10, //一页显示多少条
				pageNumber: 1,
				total: 0, //总页数
				open:false,
				activeName: '1',
				names:undefined,
				tableList:[],
				model:'',
				controller:'',
				service:''
			}
		},
		created() {
			_self = this;
			_self.init();
		},
		methods:{
			init:function(){
				listGen().then((res)=>{
					console.log(res);
					_self.tableList = res.data;
				})
			},
			selectChang:function(e){
				let data = {'name':e};
				listCloums(data).then((res)=>{
					console.log(res);
					_self.tableData = Object.values(res.data);
				})
			},
			
			 handleClick(tab, event) {
			        console.log(tab, event);
			      },
				  eyeshow:function(){
					  let data={"formdata":_self.form,"tableData":_self.tableData}
					  generateData(data).then((res)=>{
					  	console.log(res);
						_self.model = res.data.model;
						_self.controller = res.data.controller;
						_self.service = res.data.service;
						_self.open=true;
					  })
				  }
			},
			
		}
</script>

<style lang="scss">
	@import "@/assets/css/common.scss";
	.el-dialog__body{
		padding: 10px 20px;
	}
	.topform{
		margin: 20px;
	}
	pre{
		background-color: #f1f1f1;
		    padding: 0px 20px;
		border-radius: 5px;	
	}
</style>
