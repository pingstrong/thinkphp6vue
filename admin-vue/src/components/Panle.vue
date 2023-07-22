<template>
	<div class="panne">
	   <div class="p-title">{{title}}</div>
	   <p>{{content}}</p>
	  <slot name="slot"></slot>
	</div>
</template>

<script>
	export default{
		name:"Panle",
		
		props:{
			title: {
			  type: String,
			  default:"这是标题"
			},
			content:{
				type:String,
				default:"这是说明"
			}
		}
	}
</script>

<style>
	.panne{
	    padding: 10px 20px;
	    border-radius: 5px;
	    background-color: #ecf5ff;
	    border-color: #d9ecff;
	    color: #409EFF;
	    text-align: left;
		/* box-shadow: 0 5px 7px 1px rgba(184,218,253,.2); */
	 
	}
	 
	 .p-title {
	  margin: 10px;
	}
	.panne p{
	  font-size: 12px;
	  margin: 10px;
	}
</style>
