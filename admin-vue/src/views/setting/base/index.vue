<template>
	<div>
		<el-card shadow="never" class="card">
			<el-form size="small" ref="form" :model="form" :rules="rules" label-width="90px" >
			<el-tabs v-model="activeName" @tab-click="handleTabClick">
				<el-tab-pane style="padding-top:10px" v-bind:key="tindex" :label="tbl_row.title" :name="tbl_row.name" v-for="(tbl_row, tindex) in tablist">
				<el-row v-bind:key="item.id" v-for="(item, key) in form">

					<el-col :span="24">
						<el-form-item v-if="item.type === 'text'" :label="item.title" :prop="item.name">
							<el-input  v-model="form[key].value" autoComplete="off" clearable  placeholder="请输入内容"></el-input>
						</el-form-item>
						<el-form-item v-if="item.type === 'textarea'" :label="item.title" :prop="item.name">
							<el-input  type="textarea" autoComplete="off" v-model="form[key].value"  :autosize="{ minRows: 2, maxRows: 10}" clearable placeholder="请输入内容"/>
						</el-form-item>
						<el-form-item v-if="item.type === 'image'" :label="item.title" :prop="item.name">
							<ImagesUpload size="small"   :image.sync="form[key].value" fileType="image" ></ImagesUpload>
						</el-form-item>
						<el-form-item v-if="item.type === 'images'" :label="item.title" :prop="item.name">
							<ImagesUpload size="small"   :images.sync="form[key].value" fileType="images" ></ImagesUpload>
						</el-form-item>
						<el-form-item v-if="item.type === 'radio'" :label="item.title" :prop="item.name">
							<el-radio-group v-model="form[key].value">
								<el-radio :label="radio_item.label" v-bind:key="radio_key" v-for="(radio_item, radio_key) in item.meta">{{radio_item.title}}</el-radio>
							</el-radio-group>
						</el-form-item>
						<el-form-item v-if="item.type === 'checkbox'" :label="item.title" :prop="item.name">
							<el-checkbox-group v-model="form[key].value">
								<el-checkbox :label="checkbox_item" v-bind:key="checkbox_key" v-for="(checkbox_item, checkbox_key) in item.meta"></el-checkbox>
							</el-checkbox-group>
						</el-form-item>
						<el-form-item v-if="item.type === 'file'" :label="item.title" :prop="item.name">
							<ImagesUpload size="small"   :file.sync="form[key].value" fileType="file" ></ImagesUpload>
						</el-form-item>
						<el-form-item v-if="item.type === 'switch'" :label="item.title" :prop="item.name">
							<el-switch
									v-model="form[key].value"
									active-color="#13ce66"
									inactive-color="#ff4949">
							</el-switch>
						</el-form-item>
						<el-form-item v-if="item.type === 'editor'" :label="item.title" :prop="item.name">
							<WangEditor   :wangEditorContent.sync="form[key].value"></WangEditor>
						</el-form-item>
					</el-col>
				</el-row>
				</el-tab-pane>
				 
			</el-tabs>
				<el-form-item>
					<el-button size="small" type="primary" @click="submit">保存设置</el-button>
				</el-form-item>
			</el-form>
		</el-card>
	</div>
</template>
<script>

import ImagesUpload from '@/components/common/ImagesUpload.vue'
import Tag from '@/components/common/Tag.vue'
import {getList, setKey, getTab} from '@/api/setting/base'
import WangEditor from '@/components/editor/WangEditor.vue'

export default {
	name:'baseconfigindex',
	components: {
		ImagesUpload,
		Tag,
		WangEditor
	},
	data(){
		return {
			form: [],
			tablist: [],
			loading:false,
			activeName:'web',
			rules: {
			}
		}
	},
	mounted(){
		// getInfo().then(res => {
		// 	if(res.status == 200){
		// 		this.form = JSON.stringify(res.data) == '[]' ? {} : res.data
		// 		this.setDefaultVal('keyword')
		// 	}
		// })
		
		this.init();
	},
	methods: {
		init(){
			this.getItemData(this.activeName)
			getTab('base').then(res =>{
				console.log(res)
				this.tablist = res.data
			})
		},
		submit:async function(){

			let result = await setKey(this.activeName, {key:this.activeName, data:this.form})
			this.$message({
				message: result.msg,
				type: "success"
			})
		},
		setDefaultVal(key){
			if(this.form[key] == null || this.form[key] == ''){
				this.form[key] = []
			}
		},
		handleTabClick:async function(e)
		{
			console.log(e.name)
			this.getItemData(e.name)
		},
		getItemData:async function(key)
		{
			let result = await getList(key)
			console.log(result)
			this.form = result.data
		}
	}
}
</script>
<style scoped lang="scss">
// @import '@/assets/scss/common.scss'
</style>
