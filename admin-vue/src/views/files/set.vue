<template>
	<div>
		<Panle title='存储方式' content="文件存储在本地服务器，请确保服务器的 /uploads/ 目录有写入权限"></Panle>
		  <el-tabs v-model="activeName" @tab-click="handleClick">
		    <el-tab-pane label="本地"   name="0"></el-tab-pane>
		    <el-tab-pane label="七牛云" name="1"></el-tab-pane>
		    <el-tab-pane label="阿里云" name="2"></el-tab-pane>
		    <el-tab-pane label="腾讯云" name="3"></el-tab-pane>
		  </el-tabs>
		  <div>
			   <el-form :model="form" :rules="rules" ref="form"  class="tabform" label-position="center" label-width="120px" >
			     <el-row>
					 <el-col :span="12">
						 <el-form-item label="存储位置" prop="files_ares">
						 <el-radio-group v-model="form.files_ares" @change="radioChange">
						     <el-radio :label="0">本地</el-radio>
						     <el-radio :label="1">七牛云</el-radio>
						     <el-radio :label="2">阿里云</el-radio>
							 <el-radio :label="3">腾讯云</el-radio>
						   </el-radio-group>
						   </el-form-item>
					 </el-col>
				 </el-row>
				 <div :class="activeName=='0'?'show':'hidden'">
					 
				 <el-row>
					 <el-col :span="12">
					   <el-form-item label="AllowExts" prop="allowExts">
					      <el-input v-model="form.allowExts" size="mini" placeholder="设置系统允许上传文件的后缀，多个以英文逗号隔开。如：png,jpg,rar,doc"></el-input>
					   </el-form-item>
					 </el-col> 
				 </el-row>
				 <el-row>
				 <el-col :span="12">
				    <el-form-item label="FileSize" prop="fileSize">
				      <el-input v-model="form.fileSize" size="mini" placeholder="设置系统允许上传文件的大小"></el-input>
				    </el-form-item>
				   </el-col>
				   </el-row>
				   </div>
				   <!-- 七牛云 -->
				   <div :class="activeName=='1'?'show':'hidden'">
					   <el-row>
					   <el-col :span="12">
					   <el-form-item label="空间名称" >
					     <el-input v-model="form.q_bucket" size="mini" placeholder="填写七牛云存储空间名称，如：static"></el-input>
					   </el-form-item>
					   </el-col>
					   </el-row>
					   
					   <el-row>
					   <el-col :span="12">
					   <el-form-item label="访问域名" >
					         <el-input v-model="form.q_domain" size="mini" placeholder="填写七牛云存储访问域名，如：static.ctolog.cc"></el-input>
					         </el-form-item>
					   </el-col>
					   </el-row>
					   
					   
					   
					   <el-row>
					   <el-col :span="12">
					   <el-form-item label="访问密钥" >
					         <el-input v-model="form.q_accessKey" size="mini" placeholder="可以在 [ 七牛云 > 个人中心 ] 设置并获取到访问密钥"></el-input>
					         </el-form-item>
					   </el-col>
					   </el-row>
					   
					   
					   <el-row>
					   <el-col :span="12">
					   <el-form-item label="安全密钥" >
					         <el-input v-model="form.q_secretKey" size="mini" placeholder="可以在 [ 七牛云 > 个人中心 ] 设置并获取到安全密钥。"></el-input>
					         </el-form-item>
					   </el-col>
					   </el-row>
					   
				   </div>
				   <!-- 阿里云 -->
				   <div :class="activeName=='2'?'show':'hidden'">
					   <el-row>
					   <el-col :span="12">
					   	<el-form-item label="空间名称" >
					   	  <el-input v-model="form.a_bucket" size="mini" placeholder="填写OSS存储空间名称，如：oss"></el-input>
					   	  </el-form-item>  
					   </el-col>
					   </el-row>
					   
					   <el-row>
					   <el-col :span="12">
					   	<el-form-item label="数据中心" >
					   	          <el-input v-model="form.a_domain" size="mini" placeholder="填写OSS数据中心访问域名，如：oss-cn-shenzhen.aliyuncs.com"></el-input>
					   	          </el-form-item> 
					   </el-col>
					   </el-row>
					   
					   <el-row>
					   <el-col :span="12">
					   	<el-form-item label="访问域名" >
					   	      <el-input v-model="form.a_domain" size="mini" placeholder="填写OSS存储外部访问域名，如：kyshop.oss-cn-shenzhen.aliyuncs.com"></el-input>
					   	      </el-form-item> 
					   </el-col>
					   </el-row>
					   
					   <el-row>
					   <el-col :span="12">
					   	<el-form-item label="访问密钥" >
					   	      <el-input v-model="form.a_accessKeyId" size="mini" placeholder="可以在 [ 阿里云 > 个人中心 ] 设置并获取到访问密钥。"></el-input>
					   	      </el-form-item> 
					   </el-col>
					   </el-row>
					   
					   <el-row>
					   <el-col :span="12">
					   	<el-form-item label="安全密钥" >
					   	      <el-input v-model="form.a_accessKeySecret" size="mini" placeholder="可以在 [ 阿里云 > 个人中心 ] 设置并获取到安全密钥。"></el-input>
					   	      </el-form-item> 
					   </el-col>
					   </el-row>
					   
				   </div>
				   <!--腾讯云-->
				   
				   <div :class="activeName=='3'?'show':'hidden'">
					   <el-row>
					   <el-col :span="12">
					   <el-form-item label="APPid" prop="appid">
					     <el-input v-model="form.t_appid" size="mini" placeholder="填写账户中心的 APPid"></el-input>
					   </el-form-item>
					   </el-col>
					   </el-row>
					   
					   <el-row>
					   <el-col :span="12">
					   <el-form-item label="项目身份" >
					     <el-input v-model="form.t_secretId" size="mini" placeholder="填写开发者拥有的项目身份识别 ID"></el-input>
					   </el-form-item>
					   </el-col>
					   </el-row>
					   
					   
					   <el-row>
					   <el-col :span="12">
					   <el-form-item label="身份密钥" >
					     <el-input v-model="form.t_secretKey" size="mini" placeholder="填写开发者拥有的身份密钥"></el-input>
					   </el-form-item>
					   </el-col>
					   </el-row>
					   
					   <el-row>
					   <el-col :span="12">
					   <el-form-item label="所有地域" >
					     <el-input v-model="form.t_region" size="mini" placeholder="填写所有地域"></el-input>
					   </el-form-item>
					   </el-col>
					   </el-row>
					   
					   <el-row>
					   <el-col :span="12">
					   <el-form-item label="存储桶名称" >
					     <el-input v-model="form.t_bucket" size="mini" placeholder="填写COS中用于存储桶名称"></el-input>
					   </el-form-item>
					   </el-col>
					   </el-row>
				   </div>
				   
				   <el-col :span="12">
				      <el-form-item label="" >
				      <el-button type="primary" size="mini" @click="submitSet">提交数据</el-button>
				      </el-form-item>
				     </el-col>
				     </el-row>
				    
			   </el-form>
		  </div>
	</div>
</template>

<script>
	var _self;
	import Panle from '@/components/Panle'
	import {addSet,ListSet} from '@/api/files/files'
	export default{
		components:{
			Panle
		},
		data(){
			return{
				activeName:'0',
				form:{
					'files_ares':0
				},
				rules:{
					files_ares:[
						{required: true, message: "请选择存储位置", trigger: "blur"}
					],
					allowExts: [
					  { required: true, message: "允许上传的文件类型", trigger: "blur" }
					],
					fileSize: [
					  { required: true, message: "允许上传文件的大小", trigger: "blur" }
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
				ListSet().then((res)=>{
					console.log(res);
					_self.form = res.data;
				})
			},
			
			handleClick:function(tab, event){
				 _self.form.files_ares = Number(tab.name);
			},
			submitSet:function(){
				_self.$refs['form'].validate((valid) =>{
				  if (valid) {
				    _self.addEditSet();
				  } else {
				    return false;
				  }
				});
			},
			addEditSet:function(){
				addSet(_self.form).then((res)=>{
					console.log(res);
					_self.msgSuccess(res.msg)
					_self.init();
				})
			},
			radioChange:function(e){
				
				_self.activeName = e.toString();
			}
		}
		
		}
</script>

<style lang="scss">
	@import "@/assets/css/common.scss";
	.el-tabs__item{
		font-size: 12px;
	}
	.show{
		display: block;
	}
	.hidden{
		display: none;
	}
</style>
