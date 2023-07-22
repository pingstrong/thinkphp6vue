<template>
	<div>
		<el-dialog title="修改" width="600px" class="icon-dialog" :visible.sync="show" @open="open" :before-close="closeForm" append-to-body>
			<el-form :size="size" ref="form" :model="form" :rules="rules" :label-width="$store.getters.device !== 'mobile'?'16%':'90px'">
				<el-row >
					<el-col :span="24">
						<el-form-item label="分类名称" prop="title">
							<el-input  v-model="form.title" autoComplete="off" clearable  placeholder="请输入分类名称"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="封面图" prop="thumb">
							<ImagesUpload size="small"  uploadType="2" fileType="image" :image.sync="form.thumb"></ImagesUpload>
						</el-form-item>
					</el-col>
				</el-row>
			</el-form>
			<div slot="footer" class="dialog-footer">
				<el-button :size="size" :loading="loading" type="primary" @click="submit" >
					<span v-if="!loading">确 定</span>
					<span v-else>提 交 中...</span>
				</el-button>
				<el-button :size="size" @click="closeForm">取 消</el-button>
			</div>
		</el-dialog>
	</div>
</template>
<script>
import { update } from '@/api/content/article_cate'
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
import ImagesUpload from '@/components/common/ImagesUpload.vue'

export default {
	name:'goodscataupdate',
	components: {
		Treeselect,
		ImagesUpload
	},
	props: {
		show: {
			type: Boolean,
			default: false
		},
		size: {
			type: String,
			default: 'small'
		},
		info: {
			type: Object,
		},
	},
	data(){
		return {
			form: {
				title:'',
				status:1,
			},
			pids:[],
			loading:false,
			rules: {
			}
		}
	},
	watch:{
		show(val){
			if(val){
				// getFieldList().then(res => {
				// 	if(res.code == 200){
				// 		this.pids = res.data.pids
				// 	}
				// })
			}
		}
	},
	methods: {
		open(){
			this.$nextTick(() => {
				this.form = this.info
			})
			if(this.info.pid == '0' ){
				this.$delete(this.info,'pid')
			}
		},
		submit(){
			this.$refs['form'].validate(valid => {
				if(valid) {
					this.loading = true
					update(this.form).then(res => {
						if(res.code == 200){
							this.$message({message: '操作成功', type: 'success'})
							this.$emit('refesh_list')
							this.closeForm()
						}
					}).catch(()=>{
						this.loading = false
					})
				}
			})
		},
		normalizer(node) {
			if (node.children && !node.children.length) {
				delete node.children
			}
			return {
				id: node.val,
				label: node.key,
				children: node.children
			}
		},
		closeForm(){
			this.$emit('update:show', false)
			this.loading = false
			if (this.$refs['form']!==undefined) {
				this.$refs['form'].resetFields()
			}
		},
	}
}
</script>
<style scoped lang="scss">
  @import '@/assets/css/common.scss'
</style>
