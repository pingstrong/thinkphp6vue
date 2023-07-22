<template>
	<div>
		<el-dialog title="添加" width="800px" class="icon-dialog" :visible.sync="show" @open="open" :before-close="closeForm" append-to-body>
			<el-form :size="size" ref="form" :model="form" :rules="rules" :label-width="$store.getters.device !== 'mobile'?'16%':'90px'">
			<el-tabs v-model="activeName">
				<el-tab-pane style="padding-top:10px"  label="基本信息" name="基本信息">
				<el-row >
					<el-col :span="24">
						<el-form-item label="名称" prop="title">
							<el-input  v-model="form.title" autoComplete="off" clearable  placeholder="请输入名称"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="所属分类" prop="cate_id">
							<el-select v-model="form.cate_id" placeholder="请选择">
									<el-option
									v-for="item in cate_ids"
									:key="item.id"
									:label="item.title"
									:value="item.id">
									</el-option>
							</el-select>
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
				<el-row >
					<el-col :span="24">
						<el-form-item label="内容详情" prop="content">
							<WangEditor v-if="show"  :isClear="isClear" :wangEditorContent.sync="form.content"></WangEditor>
						</el-form-item>
					</el-col>
				</el-row>
				</el-tab-pane>
				<el-tab-pane style="padding-top:10px"  label="拓展信息" name="拓展信息">
				<el-row >
					<el-col :span="24">
						<el-form-item label="状态" prop="state">
							<el-switch :active-value="true" :inactive-value="false" v-model="form.state"></el-switch>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="排序" prop="sortid">
							<el-input-number controls-position="right" style="width:200px;" autoComplete="off" v-model="form.sortid" clearable :min="0" placeholder="排序"/>
						</el-form-item>
					</el-col>
				</el-row>
				</el-tab-pane>
			</el-tabs>
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
import { add } from '@/api/content/article'
import { getAll as cateList } from '@/api/content/article_cate'
import ImagesUpload from '@/components/common/ImagesUpload.vue'
import WangEditor from '@/components/editor/WangEditor.vue'
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
import GoodsSku from '@/components/sku.vue'
export default {
	name:'goodsadd',
	components: {
		ImagesUpload,
		WangEditor,
		Treeselect,
		GoodsSku
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
	},
	data(){
		return {
			form: {
				title:'',
				thumb:'',
				sortid: 0,
				sale_price:'',
				images:[],
				state: true,
				content:'',
			},
			cate_ids:[],
			isClear:false,
			loading:false,
			activeName:'基本信息',
			rules: {
			},
			
		}
	},
	watch:{
		show(val){
			if(val){
				cateList().then(res => {
					this.cate_ids = res.data.list
				})
			}
		}
	},
	methods: {
		open(){
		},
		submit(){
			this.$refs['form'].validate(valid => {
				if(valid) {
					this.loading = true
					add(this.form).then(res => {
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
			this.isClear = true
		},
	}
}
</script>
<style scoped lang="scss">
 @import '@/assets/css/common.scss'
</style>
