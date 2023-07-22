<template>

	<div v-if="!item.hidden">
		<template v-if="hasOneShowingChild(item.children,item) && (!onlyOneChild.children||onlyOneChild.noShowingChildren)&&!item.alwaysShow">
			<menu-link v-if="onlyOneChild.meta" :to="resolvePath(onlyOneChild.path)">
				<el-menu-item :index="resolvePath(onlyOneChild.path)" :class="{'submenu-title-noDropdown':!isNest}">
					<menu-item :icon="onlyOneChild.meta.icon||(item.meta&&item.meta.icon)" :title="onlyOneChild.meta.title" />
				</el-menu-item>
			</menu-link>
		</template>

		<el-submenu v-else ref="subMenu" :index="resolvePath(item.path)" popper-append-to-body>
			<template slot="title">
				<menu-item v-if="item.meta" :icon="item.meta && item.meta.icon" :title="item.meta.title" />
			</template>
			<menu-tree v-for="child in item.children" :key="child.path" :is-nest="true" :item="child" :base-path="resolvePath(child.path)" />
		</el-submenu>
	</div>


</template>

<script>
	import path from 'path'
	import {isExternal} from '@/common/common'
	import MenuLink from './meun-link'
	import MenuItem from './menu-item'
	export default {
		name: 'MenuTree',
		components: {
			MenuLink,
			MenuItem
		},
		props: {
			item: {
				type: Object,
				required: true
			},
			isNest: {
				type: Boolean,
				default: false
			},
			basePath: {
				type: String,
				default: ''
			}
		},
		created() {
			//console.log(this.item);
			//this.item = this.item.filter
		},
		methods: {
			hasOneShowingChild(children = [], parent) {
				const showingChildren = children.filter(item => {
					if (item.hidden) {
						return false
					} else {
						// Temp set(will be used if only has one showing child)
						this.onlyOneChild = item
						return true
					}
				})

				// When there is only one child router, the child router is displayed by default
				if (showingChildren.length === 1) {
					return true
				}

				// Show parent if there are no child router to display
				if (showingChildren.length === 0) {
					this.onlyOneChild = { ...parent,
						path: '',
						noShowingChildren: true
					}
					return true
				}

				return false
			},
			resolvePath(routePath) {

				if (isExternal(routePath)) {

					return routePath
				}
				if (isExternal(this.basePath)) {

					return this.basePath

				}

				return path.resolve(this.basePath, routePath)

			}
		}
	}
</script>

<style>
</style>
