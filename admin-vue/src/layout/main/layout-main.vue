<template>
	<section class="right-container" :class="collapse?'position-left':'position-collapse-left'">
		
		<div class="main-padding" >
	
			 <el-scrollbar style="height:100%;">
	  <transition name="fade-transform" mode="out-in">
	    <keep-alive>
	      <router-view :key="key"/>
	    </keep-alive>
	  </transition>
	  </el-scrollbar>
	  
	  </div>
	  
	</section>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		
		data(){
			return{
				
			}
		},
		computed:{
			...mapState({
			  collapse: state=>state.app.collapse,
			}),
			key() {
			      return this.$route.path
			    }
		},
		
		
	}
</script>

<style lang="scss">
	@import "@/assets/css/transition.scss";
.main-padding	.el-scrollbar__wrap:nth-of-type(1){
	  overflow-x: hidden;
	}

	
	.right-container{
		position: absolute;
		top: 91px;
		
		 right: 1px;
		 bottom: 0px;
		background:#FFFFFF;
	}
	.position-left {
	  left: 190px;
	}
	.position-collapse-left{
	  left: 65px !important;
	}
	.main-padding{
		padding: 10px;
		height: calc(100% - 20px);
		
	}
</style>
