<template>
	<div>
		<el-dialog title="查看详情" width="600px" @open="open" class="icon-dialog" :visible.sync="show" :before-close="closeForm" append-to-body>
			<table class="table table-bordered" align="center" width="100%" style="word-break:break-all; margin-bottom:50px;  font-size:13px;">
				<tbody>
					<tr>
						<td class="title" width="100">商品名称：</td>
						<td>
							{{form.goods_name}}
						</td>
					</tr>
					<tr>
						<td class="title" width="100">分类名称：</td>
						<td>
							{{form.class_name}}
						</td>
					</tr>
					<tr>
						<td class="title" width="100">封面图：</td>
						<td>
							<el-image v-if="form.pic" class="table_list_pic" :src="form.pic"  :preview-src-list="[form.pic]"></el-image>
						</td>
					</tr>
					<tr>
						<td class="title" width="100">销售价：</td>
						<td>
							{{form.sale_price}}
						</td>
					</tr>
					<tr>
						<td class="title" width="100">状态：</td>
						<td>
							<span v-if="form.status == '1'">正常</span>
							<span v-if="form.status == '0'">禁用</span>
						</td>
					</tr>
					<tr>
						<td class="title" width="100">排序：</td>
						<td>
							{{form.sortid}}
						</td>
					</tr>
					<tr>
						<td class="title" width="100">发布时间：</td>
						<td>
							{{form.create_time}}
						</td>
					</tr>
				</tbody>
			</table>
		</el-dialog>
	</div>
</template>
<script>
import { detail } from '@/api/content/article'
export default {
	name:'articledetail',
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
