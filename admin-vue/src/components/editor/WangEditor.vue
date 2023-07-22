<template>
  <div id="editor" ref="editor"></div>
</template>
 
<script>

  let uplod_url = process.env.VUE_APP_API + "/uploads/index"
	import E from 'wangeditor'
  import {getToken} from '@/common/token'

	export default {
    name:'WangEditor',
    props:{
      wangEditorContent:{
        type:String,
      },
      isClear: {
        type: Boolean,
        default: false
      },
      upload_config_id:{
        type:Number,
      }
    },
		data() {
		  return {
		    editor: ""
		  }
    },
    watch: {
      isClear(val) {
        if(val) {
          this.editor.txt.clear()
        }
      }
    },
		mounted() {
		  this.$nextTick(function() {
		    const _this = this
        this.editor = new E(this.$refs.editor)
        this.editor.config.uploadImgMaxLength = 1
        this.editor.config.zIndex = 500
        this.editor.config.uploadFileName = 'file'
        this.editor.config.uploadImgAccept = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']
        this.editor.config.uploadImgMaxSize = 10 * 1024 * 1024
        this.editor.config.uploadImgServer = '#'
        this.editor.create()
        if(_this.wangEditorContent){
          this.editor.txt.html(_this.wangEditorContent)
        }
        this.editor.config.onchange = (html)=>{
          _this.$emit('update:wangEditorContent',html)
        }

        this.editor.config.uploadImgHooks = {
          error: function(xhr, editor, resData) {
              console.log('error', xhr, resData)
          },
          customInsert: function(insertImgFn, result) {
              insertImgFn(result.data)
          }
        }

        this.editor.config.customUploadImg = function (resultFiles, insertImgFn) {
          const config = {
            headers: {
              "token": getToken(),  //token换成从缓存获取
              "x-token": getToken(),
              "Authorization": "Bearer " + getToken()
            } 
          }
            let formdata = new FormData()
            formdata.append('file', resultFiles[0])
            formdata.append('edit', true)
            formdata.append('upload_config_id', _this.upload_config_id)
            _this.$axios.post(uplod_url, formdata, config).then(res => {
              
              insertImgFn(res.data.data.http_url)
            })
        }
		  });
		}
	}
</script>