<template>
	<div>
		<panle title='菜单管理' content="非必要的情况请不要随意修改"></panle>
		<div class="searchbar">
		  <el-row class="pt20">
		    <el-button size="mini" @click="init()">刷新</el-button>
		    <pers-button icon="el-icon-edit" size="mini" @click="add()" perms="sys:menu:add" type="primary" label="添加"></pers-button>
		  </el-row>
		  <el-table :data="tableData" style="width: 100%;margin-bottom: 20px;" row-key="id" border stripe  :tree-props="{children: 'children', hasChildren: 'hasChildren'} " v-loading="loading">
		    <el-table-column prop="name" label="名称" sortable></el-table-column>
		    <el-table-column prop="icon" label="图标" width="80">
		      <template slot-scope="scope">
		        <i :class="scope.row.icon"></i>
		      </template>
		    </el-table-column>
		    <el-table-column prop="path" label="路由标识"></el-table-column>
		    <el-table-column prop="component" label="组件路径"></el-table-column>
		    <el-table-column prop="perms" label="权限标识"></el-table-column>
		    <el-table-column prop="menu_type" label="菜单类型" width="80">
					  <template slot-scope="scope">
						  <el-tag effect="plain" type="info"  size="small" v-if="scope.row.type==0">目录</el-tag>
						  <el-tag effect="plain" type="success" size="small" v-if="scope.row.type==1">菜单</el-tag>
						  <el-tag effect="plain" type="danger" size="small" v-if="scope.row.type==2">按钮</el-tag>
					  </template>
				  </el-table-column>
		    <el-table-column prop="status" label="是否启用" width="80">
		      <template slot-scope="scope">
		        <el-switch v-model="scope.row.status" active-color="#13ce66" inactive-color="#ff4949" @change="changeSwitch(scope.row)" :active-value="0" :inactive-value="1"></el-switch>
		      </template>
		    </el-table-column>
		    <el-table-column prop="order_by" label="排序" width="100">
		      <template slot-scope="scope">
		        <el-input v-model="scope.row.order_by" placeholder="请输入内容" size="mini" @input="changInput(scope.row)"></el-input>
		      </template>
		    </el-table-column>
		    <el-table-column fixed="right" label="操作">
		      <template slot-scope="scope">
		        <PersButton type="text" size="mini" label="添加子菜单" v-if="scope.row.type<2"  icon="fa fa-plus" perms="sys:menu:add" @click="add(scope.row)"></PersButton>
		        <PersButton type="text" size="mini" label="编辑" icon="fa fa-pencil" perms="sys:menu:edit" @click="editNode(scope.row)"></PersButton>
		        <PersButton type="text" size="mini" label="删除"  icon="fa fa-trash" perms="sys:menu:del"  @click="delNode(scope.row)"></PersButton>
		      </template>
		    </el-table-column>
		  </el-table>
		</div>
		
		
		<el-dialog :visible.sync="open" width="600px" append-to-body :title="!form.menu_id ? '新增' : '修改'"  >
				   <el-form ref="form" :model="form" :rules="rules" label-width="80px">
				     <el-row>
						 <el-col :span="24">
						   <el-form-item label="菜单类型" prop="type" >
						     <el-radio-group v-model="form.type">
						       <el-radio :label="0">目录</el-radio>
						       <el-radio :label="1">菜单</el-radio>
						       <el-radio :label="2">按钮</el-radio>
						     </el-radio-group>
						   </el-form-item>
						 </el-col>
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
					     <el-form-item label="菜单名称" prop="menu_name">
					       <el-input v-model="form.menu_name" placeholder="请输入菜单名称" size="small" clearable />
					     </el-form-item>
					   </el-col>
					   <el-col :span="12">
					     <el-form-item label="选择图标" prop="icon">
					       <el-input v-model="form.icon" placeholder="请选择图标" size="small"  clearable autocomplete="off">
						    <i slot="suffix" class="el-input__icon fa fa-desktop" :class="form.icon"  @click="iconDialog = true"></i>
							</el-input>
					     </el-form-item>
					   </el-col>
					  
					   
					   <el-col :span="12" v-if="form.type != 2">
					     <el-form-item  label="是否外链">
					       <el-radio-group v-model="form.is_frame">
					         <el-radio :label="0">是</el-radio>
					         <el-radio :label="1">否</el-radio>
					       </el-radio-group>
					     </el-form-item>
					   </el-col>
					   <el-col :span="12" v-if="form.type != 2">
					     <el-form-item  label="路由地址" prop="path">
					       <el-input v-model="form.path" placeholder="请输入路由地址" size="small"/>
					     </el-form-item>
					   </el-col>
					   <el-col :span="12" v-if="form.type != 0">
					     <el-form-item label="组件路径" prop="component">
					       <el-input v-model="form.component" placeholder="请输入组件路径" size="small"/>
					     </el-form-item>
					   </el-col>
					   <el-col :span="12" v-if="form.type != 0">
					     <el-form-item  label="权限标识">
					       <el-input v-model="form.perms" placeholder="请权限标识" maxlength="50" size="small" />
					     </el-form-item>
					   </el-col>
					   <el-col :span="12" v-if="form.type != 2">
					     <el-form-item  label="显示状态">
					     <el-radio-group v-model="form.visible">
					       <el-radio :label="0" >显示</el-radio>
					       <el-radio :label="1">隐藏</el-radio>
					     </el-radio-group>
					     </el-form-item>
					   </el-col>
					   <el-col :span="12" v-if="form.type != 2">
					     <el-form-item  label="菜单状态">
					       <el-radio-group v-model="form.status">
					         <el-radio :label="0" >启用</el-radio>
					         <el-radio :label="1">禁用</el-radio>
					       </el-radio-group>
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
					  <el-button type="primary"  @click="!form.menu_id ? submitForm('form') : subEditForm('form') " size="small">确 定</el-button>
					</div>
					<el-dialog
					      width="30%"
					      title="选择图标"
					      :visible.sync="iconDialog"
					      append-to-body class="icon-body">
					      <el-row >
					        <el-col class="icon-select" :span="4" v-for="(item,i) in fonts" :key="i" ><i :class="item.name" @click="iconSelect(item)"></i></el-col>
					      </el-row>
					      
					
					    </el-dialog>
		</el-dialog>
		
		
	</div>
</template>

<script>
	let _self;
	import Panle from '@/components/Panle';
	import PersButton from '@/components/PersButton'
	import {getMenuList,addMenu,editMenu,delMenu,changeStatus,changeOrder} from '@/api/system/menu'
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
					"menu_id":undefined,
					"type":0,
					"parent_id":0,
					"menu_name":undefined,
					"icon":undefined,
					"is_frame":1,
					"visible":0,
					"status":0,
					"order_by":100,
					"path":undefined,
					"component":undefined,
					"perms":undefined
				},
				open: false,//弹窗
				parentDate:[],
				fonts: fontjson,
				iconDialog:false,
				rules:{
					menu_name: [
					  { required: true, message: "菜单名称不能为空", trigger: "blur" }
					],
					parent_id:[
						{ required: true, message: "上级菜单不能为空", trigger: "blur" }
					],
					type:[{ required: true, message: "菜单类型不能为空", trigger: "blur" }]
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
				getMenuList().then((res)=>{
					_self.loading = false;
					if(res.code==200){
						console.log(res);
						_self.tableData=res.data.menuTree;
						const menu = { id: 0, name: '主菜单', children: [] };
						 menu.children = res.data.pTree;
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
					"menu_id":undefined,
					"type":0,
					"parent_id":0,
					"menu_name":undefined,
					"icon":undefined,
					"is_frame":1,
					"visible":0,
					"status":0,
					"order_by":100,
					"path":undefined,
					"component":undefined,
					"perms":undefined
				}
				if (data != null) {
					_self.form.parent_id = data.id;
				}else{
					_self.form.parent_id = 0;
				}
				_self.open=true;
			},
			iconSelect:function(item) {
			  this.form.icon = item.name;
			  this.iconDialog = false;
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
				addMenu(_self.form).then((res)=>{
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
				_self.form.menu_id = data.id;
				let editForm ={
					"menu_id":data.id,
					"type":data.type,
					"parent_id":data.parentId,
					"menu_name":data.name,
					"icon":data.icon,
					"is_frame":1,
					"visible":data.visible,
					"status":data.status,
					"order_by":data.order_by,
					"path":data.path,
					"component":data.component,
					"perms":data.perms
				}
				Object.assign(_self.form, editForm);
			},
			subEditForm:function(){
				editMenu(_self.form).then((res)=>{
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
			    
				delMenu(data.id).then((res)=>{
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
			changeSwitch:function(data){
				changeStatus(data.id).then((res)=>{
					
					if(res.code==200){
						_self.msgSuccess(res.msg);
						_self.init();
					}else{
						_self.msgError(res.msg);
					}
				})
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
