<template>

	<div class="tabs">
		<el-tabs v-model="mainTabsActiveName" type="card" closable @tab-remove="removeTabHandle" class="tabs-list" @tab-click="selectedTabHandle">
			
			<el-tab-pane v-for="item in visitedViews" :key="item.path" :label="item.title" :name="item.path" ref="item">
				<span slot="label"><i :class="item.icon"></i> {{item.title}}</span>
			</el-tab-pane>



		</el-tabs>
		
		<el-dropdown class="tabs-tools" :show-timeout="0" trigger="hover">
			<div style="font-size:20px;width:50px;"><i class="el-icon-arrow-down"></i></div>
			<el-dropdown-menu slot="dropdown">
				<el-dropdown-item @click.native="tabsCloseCurrentHandle">关闭当前标签</el-dropdown-item>
				<el-dropdown-item @click.native="tabsCloseOtherHandle">关闭其它标签</el-dropdown-item>
				<el-dropdown-item @click.native="tabsCloseAllHandle(selectedTag)">关闭全部标签</el-dropdown-item>
				<el-dropdown-item @click.native="tabsRefreshCurrentHandle">刷新当前标签</el-dropdown-item>
			</el-dropdown-menu>
		</el-dropdown>
	</div>
</template>

<script>
	import path from 'path'
	export default {
		data() {
			return {
				mainTabsActiveName: '',
				selectedTag: {},
			}
		},
		computed: {
			visitedViews() {
				return this.$store.state.tagsView.visitedViews

			},
			routes() {
				return this.$store.state.menu.routes
			},

		},
		watch: {
			$route() {
				this.addTags()
				this.removeTabHandle()
			},

		},
		mounted() {
			this.initTags()
			this.addTags()
		},
		methods: {
			initTags() {
				const affixTags = this.affixTags = this.filterAffixTags(this.routes)
				// console.log(affixTags);
				for (const tag of affixTags) {

					if (tag.path) {
						this.$store.dispatch('tagsView/addVisitedView', tag)
					}
				}
			},
			filterAffixTags(routes, basePath = '/') {
				//console.log(routes);
				let tags = []
				if (routes.length == 0) {
					tags.push({
						fullPath: "/index",
						path: "/index",
						name: "首页",
						meta: {
							affix: true,
							icon: "el-icon-s-tools",
							noCache: true,
							title: "首页",
						}
					})

				} else {




					routes.forEach(route => {
						if (route.meta && route.meta.affix) {
							const tagPath = path.resolve(basePath, route.path)
							tags.push({
								fullPath: tagPath,
								path: tagPath,
								name: route.name,
								meta: { ...route.meta
								}
							})
						}
						if (route.children) {
							const tempTags = this.filterAffixTags(route.children, route.path)
							if (tempTags.length >= 1) {
								tags = [...tags, ...tempTags]
							}
						}
					})
				}
				return tags
			},



			selectedTabHandle(tab) {
				//console.log(tab);
               this.$router.push(tab.name);
			   //this.tabsRefreshCurrentHandle();
			},
			removeTabHandle(tabName) {
				//console.log(tabName);
				//console.log(this.visitedViews);

				const delViews = this.visitedViews.filter(item => item.path !== tabName)
				//console.log(delViews);
				if (delViews.length >= 1) {
					if (tabName === this.mainTabsActiveName) {
						this.$router.push({
							path: delViews[delViews.length - 1].path
						}, () => {

						})
					}
					this.$nextTick(() => {
						this.$store.dispatch('tagsView/updateVisitedView', tabName)
					})

				} else {
					this.$router.push("/")
				}

			},
			//关闭当前
			tabsCloseCurrentHandle() {
				//this.removeTabHandle(this.mainTabsActiveName)
			},
			//关闭其它
			tabsCloseOtherHandle() {

				const delViews = this.visitedViews.filter(item => item.name !== this.mainTabsActiveName)
				//console.log(delViews);
				this.visitedViews = delViews;
			},
			//关闭全部
			tabsCloseAllHandle(view) {
				this.$store.dispatch('tagsView/delAllViews').then(({
					visitedViews
				}) => {
					if (this.affixTags.some(tag => tag.path === view.path)) {
						return
					}
					this.toLastView(visitedViews, view)
				})

			},
			toLastView(visitedViews, view) {
				const latestView = visitedViews.slice(-1)[0]
				if (latestView) {
					this.$router.push(latestView.fullPath)
				} else {

					if (view.name === 'Dashboard') {

						this.$router.replace({
							path: '/redirect' + view.fullPath
						})
					} else {
						this.$router.push('/')
					}
				}
			},

			tabsRefreshCurrentHandle() {
				var tempTabName = this.mainTabsActiveName
				
				this.removeTabHandle(tempTabName)

				this.$nextTick(() => {
					this.$router.push({
						path: tempTabName
					})
				})
			},

			addTags() {
				const {
					path
				} = this.$route
				//console.log(this.$route);
				this.mainTabsActiveName = path;
				if (path) {
					this.$store.dispatch('tagsView/addView', this.$route)
				}
				return false
			},






		}
	}
</script>

<style>
	.tabs {
		height: 40px;
		width: 100%;
		background: #FFFFFF;

	}

	.tabs-list {
		margin-right: 50px;
	}

	.tabs-tools {
		position: fixed !important;
		top: 50px;
		right: 0px;
		z-index: 1020;
		height: 40px;
		font-size: 12px !important;
		line-height: 40px;
		cursor: pointer;
		z-index: 3;
		text-align: center;

	}

	.tabs-tools .el-icon-arrow-down {
		font-size: 14px !important;
	}

	.tabs-list .el-tabs__item {
		height: 30px;
		line-height: 30px;
		font-size: 12px;
	}

	.tabs-list>.el-tabs__header .el-tabs__nav {
		border: 0 !important;
	}

	.tabs-list .el-tabs__nav-wrap {}

	.tabs-list>.el-tabs__header {
		border: 0 !important;
		margin: 0;
		top: 5px;
	}

	.tabs .el-tabs__item:nth-child(1) .el-icon-close {
		display: none;
	}
</style>
