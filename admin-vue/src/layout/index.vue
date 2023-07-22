<template>
	<div class="layout-page">
		<top-bar></top-bar>
		<layout-main></layout-main>
		<menu-bar></menu-bar>
	</div>
	
</template>

<script>
	import TopBar from './header/top-bar'
	import LayoutMain from './main/layout-main'
	import MenuBar from './nav/menu-bar'
	export default{
		components:{
			TopBar,
			LayoutMain,
			MenuBar
		}
	}
</script>

<style>
	.layout-page{
		position: absolute;
		height: 100%;
		width: 100%;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
	}
</style>
