<template>
	<div>
		<panle title='部门管理' content="部门管理列表"></panle>
		<div class="searchbar">
		  <el-row class="pt20">
		    <el-button size="mini" @click="init()">刷新</el-button>
		    <pers-button icon="el-icon-edit" size="mini" @click="add()" perms="sys:menu:add" type="primary" label="添加"></pers-button>
		  </el-row>
		  <el-table :data="tableData" default-expand-all style="width: 100%;margin-bottom: 20px;" row-key="id" border stripe  :tree-props="{children: 'children', hasChildren: 'hasChildren'} " v-loading="loading">
		   
			<el-table-column prop="name" label="部门名称" ></el-table-column>
		   <el-table-column prop="order_by" label="排序" width="100">
		      <template slot-scope="scope">
		        <el-input v-model="scope.row.order_by" placeholder="请输入内容" size="mini" @input="changInput(scope.row)"></el-input>
		      </template>
		    </el-table-column>
		    <el-table-column fixed="right" label="操作">
		      <template slot-scope="scope">
		        <PersButton type="text" size="mini" label="添加子部门"  icon="fa fa-plus" perms="sys:menu:add" @click="add(scope.row)"></PersButton>
		        <PersButton type="text" size="mini" label="编辑" icon="fa fa-pencil" perms="sys:menu:edit" @click="editNode(scope.row)"></PersButton>
		        <PersButton type="text" size="mini" label="删除"  icon="fa fa-trash" perms="sys:menu:del"  @click="delNode(scope.row)"></PersButton>
		      </template>
		    </el-table-column>
		  </el-table>
		</div>
		
		
		<el-dialog :visible.sync="open" width="600px" append-to-body :title="!form.dept_id ? '新增' : '修改'"  >
				   <el-form ref="form" :model="form" :rules="rules" label-width="80px">
				     <el-row>
						 
					   <el-col :span="24">
					     <el-form-item label="上级菜单" prop="parent_id">
							 <div style="height: 30px; line-height: 30px;">
								 <treeselect
								   v-model="form.parent_id"
								   :options="parentDate"
								   :normalizer="normalizer"
								   :show-count="true"
								   placeholder="选择上级菜单"
								 					 
								 />
							 </div>
					       
					     </el-form-item>
					   </el-col>
					  
					   <el-col :span="12">
					     <el-form-item label="部门名称" prop="dept_name">
					       <el-input v-model="form.dept_name" placeholder="请输入菜单名称" size="small" clearable />
					     </el-form-item>
					   </el-col>
					  
					  
					   
					  
					 
					  
					 
					   <el-col :span="24">
					     <el-form-item label="显示排序" prop="order_by">
					       <el-input-number v-model="form.order_by" controls-position="right" :min="0"  size="small"/>
					     </el-form-item>
					   </el-col>
				     </el-row>
					</el-form>
					<div slot="footer" class="dialog-footer">
					  <el-button @click="open = false" size="small">取 消</el-button>
					  <el-button type="primary"  @click="!form.dept_id ? submitForm('form') : subEditForm('form') " size="small">确 定</el-button>
					</div>
					
		</el-dialog>
		
		
	</div>
</template>

<script>
	let _self;
	import Panle from '@/components/Panle';
	import PersButton from '@/components/PersButton'
	import {getDeptList,addDept,editDept,delDept,changeOrder} from '@/api/system/dept'
	import Treeselect from '@riophae/vue-treeselect'
	import '@riophae/vue-treeselect/dist/vue-treeselect.css'
	import fontjson from '@/common/font.json'
	export default{
		components:{
			Panle,
			PersButton,
			Treeselect
		},
		data(){
			return{
				tableData:[],
				loading:false,
				form:{
					"dept_id":undefined,
					"parent_id":0,
					"dept_name":undefined,
					"order_by":100,
					
				},
				open: false,//弹窗
				parentDate:[],
				
				
				rules:{
					dept_name: [
					  { required: true, message: "部门名称不能为空", trigger: "blur" }
					],
					parent_id:[
						{ required: true, message: "上级部门名称不能为空", trigger: "blur" }
					],
					
				}
			}
		},
		created() {
			_self = this;
			_self.init();
		},
		methods:{
			init:function(){
				_self.loading = true;
				_self.parentDate=[];
				getDeptList().then((res)=>{
					_self.loading = false;
					if(res.code==200){
						console.log(res);
						_self.tableData=res.data.deptTree;
						const menu = { id: 0, name: '主部门', children: [] };
						 menu.children = res.data.deptTree;
						 _self.parentDate.push(menu);
					}
				})
			},
			normalizer:function(node) {
				
			  if (node.children && !node.children.length) {
			    delete node.children;
			  }
			  return {
			    id: node.id,
			    label: node.name,
			    children: node.children
			  };
			},
			add:function(data){
				_self.form= {
					"dept_id":undefined,
					"parent_id":0,
					"dept_name":undefined,
					"order_by":100,
				}
				if (data != null) {
					_self.form.parent_id = data.id;
				}else{
					_self.form.parent_id = 0;
				}
				_self.open=true;
			},
			
			submitForm:function(data){
				this.$refs[data].validate((valid) =>{
				  if (valid) {
				    _self.addmenu();
				  } else {
				    return false;
				  }
				});
			},
			addmenu:function(){
				console.log(_self.form);
				addDept(_self.form).then((res)=>{
					console.log(res);
					if(res.code==200){
						_self.msgSuccess(res.msg)
						_self.open=false;
						_self.init();
					}else{
						_self.msgError(res.msg);
					}
				})
			},
			editNode:function(data){
				_self.open=true;
				console.log(data);
				_self.form.parent_id = data.parentId;
				_self.form.dept_id = data.id;
				let editForm ={
					"dept_id":data.id,
					
					"parent_id":data.parentId,
					"dept_name":data.name,
					
					"order_by":data.order_by,
					
				}
				Object.assign(_self.form, editForm);
			},
			subEditForm:function(){
				editDept(_self.form).then((res)=>{
					if(res.code==200){
						_self.msgSuccess(res.msg)
						_self.open=false;
						_self.init();
					}else{
						_self.msgError(res.msg);
					}
				})
			},
			delNode:function(data) {
			  _self.$confirm('确定删除【' + data.name + '】此规则', '提示', {
			    confirmButtonText: '确定',
			    cancelButtonText: '取消',
			    type: 'warning'
			  }).then(() => {
			    
				delDept(data.id).then((res)=>{
					if(res.code==200){
						_self.msgSuccess(res.msg);
						_self.init();
					}else{
						_self.msgError(res.msg);
					}
				})
			
				
			  }).catch(() =>{
			    _self.$message({
			      type: 'info',
			      message: '已取消删除'
			    });
			  });
			},
			
			changInput:function(data){
				console.log(data);
				let datas={
					'id':data.id,
					'num':data.order_by
				}
				changeOrder(datas).then((res)=>{
					if(res.code==200){
						_self.msgSuccess(res.msg);
						_self.init();
					}else{
						_self.msgError(res.msg);
					}
				})
			}
			
		}
	}
</script>

<style lang="scss">
	@import "@/assets/css/common.scss";
	.pt20{
		padding-top: 10px;
	}
	.el-dialog__header{
		background: #2f353f;
		padding: 10px 20px 10px;
	}
	
	.el-dialog__title{
		font-size: 14px;
		color: #FFFFFF !important;
	}
	.el-dialog__headerbtn{
		top: 12px;
	}
	.el-form-item__label{
		font-size: 12px;
	}
	.el-radio__label{
		font-size: 12px;
	}
	.el-input-number--small{
		width: 100%;
	}
	.icon-select{
	  display: flex;
	  justify-content: center;
	  align-items: center;
	  
	}
	.icon-select:hover{
	  background: #409EFF;
	  color: #fff;
	}
	.icon-select i{
	  font-size: 16px;
	  padding: 20px;
	}
	
	.icon-body .el-dialog__body{
	max-height: 500px;
	  overflow: auto;
	}
	.vue-treeselect__control{
		height: 32px;
		
	}
	.vue-treeselect{
		top: 6px;
		font-size: 12px !important;
	}
</style>
