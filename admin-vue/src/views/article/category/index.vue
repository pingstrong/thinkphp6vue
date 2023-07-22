<template>
	<div>
		<el-row :gutter="10">
			<el-col :span="24">
				<el-card shadow="never" class="card">
					<div id="charts_one" style="width:100%;min-height:80vh">
						<div class="btn-group" style="margin-bottom:11px;">
							<div>
								<PersButton type="success" size="mini" label="添加" icon="fa  el-icon-plus" perms="content/article_cate/add" @click="add(ids)"></PersButton>
								<PersButton type="primary" :disabled="single"  size="mini" label="编辑" icon="fa  el-icon-edit" perms="content/article_cate/edit" @click="update(ids)"></PersButton>
								<PersButton type="danger" :disabled="multiple" size="mini" label="删除" icon="fa  el-icon-delete" perms="shop:category:delete" @click="del(ids)"></PersButton>
								<PersButton type="info" :disabled="single" size="mini" label="查看详情" icon="fa  el-icon-view" perms="shop:category:index" @click="detail(ids)"></PersButton>
								
							</div>
							<table-tool :searchVisible.sync="searchVisible" :expand_status="true" :expand="expand" @toggleRowExpansion="toggleRowExpansion" :fieldList="fieldList" @refesh_list="index" :searchTool="true"></table-tool>
						</div>
						<el-table :row-class-name="rowClass" @selection-change="selection"  @row-click="handleRowClick" :tree-props="{children: 'children'}"  :default-expand-all="expand" row-key="id"  :header-cell-style="{ background: '#eef1f6', color: '#606266' }" v-loading="loading"  ref="multipleTable" border class="eltable" :data="list"  style="width: 100%">
							<el-table-column align="center" type="selection" width="42"></el-table-column>
							<el-table-column align="center" type = '' property="id" label="编号" show-overflow-tooltip width="70">
							</el-table-column>
							<el-table-column align="left"   property="title" label="分类名称" show-overflow-tooltip >
							</el-table-column>
							<el-table-column align="center"   property="thumb" label="封面图" show-overflow-tooltip  >
								<template slot-scope="scope">
									<div class="demo-image__preview">
										<el-image style="width:100px" v-if="scope.row.thumb" class="table_list_pic" :src="scope.row.thumb"  :preview-src-list="[scope.row.thumb]"></el-image>
									</div>
								</template>
							</el-table-column>
							<el-table-column :fixed="$store.getters.device !== 'mobile'?'right':false" label="操作" align="center" >
								<template slot-scope="scope">
									<div v-if="scope.row.id">
										<PersButton type="primary" size="mini" label="编辑" icon="fa  el-icon-edit" perms="content/article_cate/edit" @click="update(scope.row)"></PersButton>
										<PersButton type="danger" size="mini" label="删除" icon="fa  el-icon-delete" perms="shop:category:delete" @click="del(scope.row)"></PersButton>
									 </div>
								</template>
							</el-table-column>
						</el-table>
						<Page :total="page_data.total" :page.sync="page_data.page" :limit.sync="page_data.limit" @pagination="index" />
					</div>
				</el-card>
			</el-col>
		</el-row>
		<!--添加-->
		<Add  :show.sync="dialog.addDialogStatus" size="small" @refesh_list="index"></Add>
		<!--修改-->
		<Update :info="updateInfo" :show.sync="dialog.updateDialogStatus" size="small" @refesh_list="index"></Update>
		<!--查看详情-->
		<Detail :info="detailInfo" :show.sync="dialog.detailDialogStatus" size="small" @refesh_list="index"></Detail>
	</div>
</template>
<script>
	import {
		index,
		updateExt,
		getUpdateInfo,
		del,
	} from '@/api/content/article_cate'
	import Search from '@/components/common/Search.vue'
	import Page from '@/components/common/Page.vue'
	import TableTool from '@/components/common/TableTool.vue'
	import Add from './add.vue'
	import Update from './update.vue'
	import Detail from './detail.vue'
	import PersButton from '@/components/PersButton';
	import { confirm,param2Obj } from '@/utils/common'
	export default {
		name:'goodscata',
		components: {
			Search,
			Page,
			TableTool,
			Add,
			Update,
			Detail,
			PersButton
		},
		data(){
			return {
				dialog: {
					addDialogStatus : false,
					updateDialogStatus : false,
					detailDialogStatus : false,
				},
				fieldList:[
					{lable:'编号',checked:true},
					{lable:'状态',checked:true},
					{lable:'排序',checked:true},
				],
				ids: [],
				single:true,
				multiple:true,
				list: [],
				updateInfo:{},
				detailInfo:{},
				loading: false,
				page_data: {
					limit: 20,
					page: 1,
					total:20,
				},
				searchVisible:true,
				searchForm:[],
				searchData:{},
				expand:true,
			}
		},
		mounted(){
			this.init()
		},
		methods: {
			init:async function() {
				this.index()
			},
			index(){
				let param = {pageSize:this.page_data.limit,page:this.page_data.page}
				Object.assign(param, {search: this.searchData})
				Object.assign(param, param2Obj(this.$route.fullPath))
				this.loading = true
				index(param).then(res => {
					this.list = res.data.list
					this.page_data.total = res.data.total
					this.loading = false
				})
			},
			updateExt(row,field){
				if(row.id){
					updateExt({id:row.id,[field]:row[field]}).then(res => {
						this.$message({message: '操作成功', type: 'success'})
					})
				}
			},
			add(){
				this.dialog.addDialogStatus = true
			},
			update(row){
				let id = row.id ? row.id : parseInt(this.ids.join(','))
				getUpdateInfo({id:id}).then(res => {
					if(res.code === 200){
						this.dialog.updateDialogStatus = true
						this.updateInfo = res.data
					}
				})
			},
			del(row){
				confirm({content:'确定要操作吗'}).then(() => {
					let ids = row.id ? row.id : this.ids.join(',')
					del({id:ids}).then(res => {
						this.$message({message: res.msg, type: 'success'})
						this.index()
					})
				}).catch(() => {})
			},
			detail(row){
				this.dialog.detailDialogStatus = true
				this.detailInfo = {id:row.id ? parseInt(row.id) : parseInt(this.ids.join(','))}
			},
			selection(selection) {
				this.ids = selection.map(item => item.id)
				this.single = selection.length != 1
				this.multiple = !selection.length
			},
			handleRowClick(row, rowIndex,event){
				if(event.target.className !== 'el-input__inner'){
					this.$refs.multipleTable.toggleRowSelection(row)
				}
			},
			rowClass ({ row, rowIndex }) {
				for(let i=0;i<this.ids.length;i++) {
					if (row.id === this.ids[i]) {
						return 'rowLight'
					}
				}
			},
			toggleRowExpansion(){
				this.expand = !this.expand
				this.list.forEach(item=>{
					this.$refs.multipleTable.toggleRowExpansion(item,this.expand)
				})
			}
		}
		
	}
</script>
<style  lang="scss">
  @import '@/assets/css/common.scss'
</style>