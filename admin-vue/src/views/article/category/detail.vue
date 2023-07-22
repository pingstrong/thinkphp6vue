<template>
	<div>
		<el-dialog title="查看详情" width="600px" @open="open" class="icon-dialog" :visible.sync="show" :before-close="closeForm" append-to-body>
			<table class="table table-bordered" align="center" width="100%" style="word-break:break-all; margin-bottom:50px;  font-size:13px;">
				<tbody>
					<tr>
						<td class="title" width="100">分类名称：</td>
						<td>
							{{form.title}}
						</td>
					</tr>
					<tr>
						<td class="title" width="100">封面图：</td>
						<td>
							<el-image v-if="form.thumb" class="table_list_pic" :src="form.thumb"  :preview-src-list="[form.thumb]"></el-image>
						</td>
					</tr>
				</tbody>
			</table>
		</el-dialog>
	</div>
</template>
<script>
import { detail } from '@/api/content/article_cate'
export default {
	name:'Goodscatadetail',
	props: {
		show: {
			type: Boolean,
			default: true
		},
		size: {
			type: String,
			default: 'mini'
		},
		info: {
			type: Object,
		},
	},
	data() {
		return {
			form:{
			},
		}
	},
	methods: {
		open(){
			detail(this.info).then(res => {
				this.form = res.data
			})
		},
		closeForm(){
			this.$emit('update:show', false)
		}
	}
}
</script>
<style  lang="scss">
	@import '@/assets/css/common.scss';
	.table > tbody > tr > td {
		border-top: 1px solid #e7eaec;
		line-height: 1.42857;
		padding: 8px;
		vertical-align: middle;
	}
	.table .title{
		background-color:#F5F5F6; font-weight:bold; text-align:right
	}
</style>
