<template>
	<div class="menu-bar " :class="collapse?'menu-bar-width':'menu-bar-collapse-width'">
		<div class="logo" :class="collapse?'menu-bar-width':'menu-bar-collapse-width'">
		   <img src="@/assets/img/logo1.png"  v-if="collapse==true"/>
		   <img src="@/assets/img/logo2.png" v-if="collapse==false" />
		</div>
		<!-- <div class="usertop" :class="collapse?'usertop':'usertops'">
		     <img src="@/assets/img/empty-face.jpeg"  alt="" class="thumb-md" />
		     <div class="user-info" v-if="collapse!=false">
		       <el-dropdown >
		         <span class="el-dropdown-link">
		          Mr.He<i class="el-icon-caret-bottom el-icon--right"></i>
		         </span>
		         <el-dropdown-menu slot="dropdown">
		           <el-dropdown-item><i class="el-icon-user-solid"></i>编辑资料</el-dropdown-item>
		           <el-dropdown-item><i class="fa fa-unlock-alt" ></i>修改密码</el-dropdown-item>
		           <el-dropdown-item @click.native="loginout()" ><i class="fa fa-sign-out" ></i>退出登录</el-dropdown-item>
		
		         </el-dropdown-menu>
		       </el-dropdown>
		       <div>超级管理员</div>
		
		     </div>
		   </div> -->
		   
		   <div class="nav">
		  
		  <el-scrollbar 
		        wrap-style="overflow-x:hidden;" 
		        style="height: 100%;z-index: 99999;">
		   <el-menu
		         :default-active="activeMenu"
		         :unique-opened="true"
		         background-color="#2f353f"
		         text-color="#909399"
		         active-text-color="#fff" :collapse="!collapse"
		   			class="el-menu-vertical-demo"
		   			 >
		        
		          <menu-tree
		   			   v-for="(route,index) in user_routes"
		   			   :key="route.path + index"
		   			   :item="route"
		   			   :base-path="route.path"
		   			  ></menu-tree>      
		   	
		       </el-menu>
		   </el-scrollbar>
		     </div>
		   
		   
	</div>
</template>

<script>
	
	import MenuTree from './menu-tree'
	import {mapState,mapGetters} from 'vuex'
	export default{
		components:{
		  MenuTree
		},
		computed:{
			...mapState({
			  collapse: state=>state.app.collapse,
			}),
			...mapGetters(["user_routes"]),
			activeMenu() {
			    const route = this.$route;
			    const { meta, path } = route;
			    // if set path, the sidebar will highlight the path you set
			    if (meta.activeMenu) {
			        return meta.activeMenu;
			    }
			    return path;
			},
		},
		methods:{
			loginout:function(){
				
				this.$confirm('确定注销并退出系统吗？', '提示', {
				  confirmButtonText: '确定',
				  cancelButtonText: '取消',
				  type: 'warning'
				}).then(() => {
				  this.$store.dispatch('loginOut').then(() => {
					  this.msgSuccess("退出成功")
				    location.href = '/index';
				  })
				})
				
				
			}
		}
	}
</script>

<style lang="scss">
	
	.menu-bar{
		position: fixed;
		top: 0px;
		left: 0;
		bottom: 0;
		z-index: 1020;
		background: #2f353f;
		text-align: left;
		font-size: 12px !important;
		box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.5);
		.logo {
		  position:absolute;
		  top: 0px;
		  height: 50px;
		  line-height: 50px;
		  width: 100%;
		  cursor:pointer;
		  text-align: center;
		  img {
		      width: 60%;
		      margin-top: 10px;
			
		  }
		  div {
		    font-size: 25px;
		    color: white;
		    text-align: left;
		    padding-left: 20px;
		  }
		}
		.usertop{
		padding-top: 60px;
		padding-left: 20px;
		padding-bottom: 10px;
		padding-right: 20px;
		text-align: center;
		min-height: 60px;
		display: flex;
		align-items: center;
		      .thumb-md {
		    height: 48px;
		    width: 48px;
		    border-radius: 50%;
		    float: left;
			}
			.user-info{
				float: left;
				color: #98a6ad;
				margin-left: 10px;
			   .el-dropdown-link{
			     color: #FFFFFF;
			
			   }
			
			}
		}
		
		.el-menu-item [class^=fa],.el-submenu__title [class^=fa]{
			margin-right: 5px;
			width: 24px;
			    font-size: 12px;
			    text-align: center;
		}
	}
	.menu-bar-width {
	  width: 190px;
	}
	  .menu-bar-collapse-width {
	    width: 65px;
	  }
	  .usertops{
	    padding-top: 60px;
	    padding-left: 5px !important;
	    padding-bottom: 10px !important;;
	    padding-right: 0px !important;;
	  }
	  
	  .nav{
		  height:calc(100% - 100px);
		 
	  	.el-menu-vertical-demo:not(.el-menu--collapse) {
	  	      width: 190px;
	  	      // min-height: 400px;
	  	       height:100%;
	  	    }
	  	.el-menu{
	  		background: transparent;
	  		border-right: 0 !important;
	  		  .el-menu-item, .el-submenu__title{
	  			  height: 50px !important;
	  			  line-height: 50px !important;
	  			  font-size: 12px !important;
	  			  width: 190px;
	  			  
	  			  }
	  			  
	  		.el-submenu /deep/ .el-submenu__title{
	  			position: relative;
	  			z-index: 999;
	  		}
	  		
	  	   
	  	}
	  	
	  }
	  .menu-bar-collapse-width .nav .el-submenu .el-submenu__title{
	  	width: 64px !important;
	  	display: inline-block;
	  	overflow: hidden;
	      span{
	  	  height: 0;
	  	  width: 0;
	  	  overflow: hidden;
	  	  visibility: hidden;
	  	  display: inline-block;
	    }
	  	  .el-submenu__icon-arrow {
	  	    display: none;
	  	  }
	  	  
	  	
	  }
	  .el-menu-item{
	  		font-size: 12px !important;
	  		height: 50px !important;
	  		line-height: 50px !important;
	  	}
	  	
	  .el-menu	a {
	  	  display: inline-block;
	  	  width: 100%;
	  	  overflow: hidden;
	  	  text-decoration: none !important;
	  	}
	  	.el-tooltip__popper{
	  		left: 64px !important;
	  	}
	  	
	  
</style>
