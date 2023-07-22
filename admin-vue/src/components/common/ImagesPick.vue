<template>
  <div>
      <el-dialog title="图片管理" width="640px" class="icon-dialog" stylcustom-class="dialog-class" :visible.sync="show" @open="open" :before-close="closeForm" append-to-body>
          <div style="padding-left:10px">
          <el-row :gutter="20">
            <el-col :span="4">
              <el-upload class="upload-demo" ref="upload" multiple :action="actions" :headers="uploadHeader" :on-success="uploadSuccess" >
                <el-button class="el-icon-upload" size="small" type="primary"> 上传图片</el-button>
              </el-upload>
            </el-col>
            <el-col :span="8">
              <el-button class="el-icon-delete" size="small" type="danger" @click="deletePic">批量删除</el-button>
            </el-col>
          </el-row>
          <el-progress v-if="progress" :stroke-width="5" :percentage="progressPercent"></el-progress>
          <el-row style="margin-top:15px;">
              <el-col :span="24">
                <el-row>
                  <div class="image-wrap"  v-for="(item,index) in list" :key="index" @click="selection(item.http_urls, item.fid)">
                      <label v-for="(v, k) in files" :key="k" v-show="item.http_urls === v">
                        <input type="checkbox" :checked="item.http_urls === v">
                        <i>✓</i>
                      </label>
                      <div class="imgStyle">
                        <img :src="item.http_urls" /><br/>
                      </div>
                  </div>
                </el-row>
                 <Page :total="page_data.total" :page.sync="page_data.page" :limit.sync="page_data.limit" @pagination="index" />
              </el-col>
          </el-row>
          </div>
         <div slot="footer" class="dialog-footer">
          <el-button size="small" :loading="loading" type="primary" @click="submit" >
            <span>确 定</span>
          </el-button>
          <el-button size="small" @click="closeForm">取 消</el-button>
        </div>
      </el-dialog>
  </div>
</template>

<script>
  let uploads = process.env.VUE_APP_API
  let uplod_url = process.env.VUE_APP_API + "/upload_file/upload"

  import {listFiles, batchRemove} from '@/api/files/files'
  import Page from '@/components/common/Page.vue'
  import { confirm } from '@/utils/common'
  import {getToken} from '@/common/token'

  export default {
    components: {
        Page,
    },
    props: {
        show: {
            type: Boolean,
            default: false
        },
        singleSelect:{
          type: Boolean,
          default: true
        }
    },
    watch: {
        show(value) {
            if(value){
                this.index()
            }
        }
    },
    data() {
      return {
        actions: uploads + "/uploads/index",
        uploadHeader: {
					"Authorization": "Bearer " + getToken()
				},
        files: [],
        file_ids: [],
        list: [],
          loading: false,
          progressPercent:0,
          progress:false,
          page_data: {
              limit: 20,
              page: 1,
              total:20,
          },
        }
    },
    methods: {
      open(){
          this.files = []
      },
      index() {
        let param = {type: 0, pageSize:this.page_data.limit, page:this.page_data.page}
        this.loading = true
        listFiles(param).then(res => {
            this.list = res.data.list
            this.page_data.total = res.data.total
            this.loading = false
        })
      },
      selection(filepath, id){
        let index = this.files.indexOf(filepath)
        if(this.singleSelect){
          //单张图片
          this.files = []
          this.file_ids = []
          this.files.push(filepath)
          this.file_ids.push(id)
        }else{
          //多选
          if (index === -1) {
            this.files.push(filepath)
            this.file_ids.push(id)
          } else {
            this.files.splice(index, 1)
            this.file_ids.splice(index, 1)
          }
        }
      },
      deletePic(){
        if (this.file_ids.length === 0) {
          return this.$message({
            message: '请选择图片',
            type: 'error'
          })
        }
        confirm({content:'确定要操作吗'}).then(() => {
            batchRemove({ids:this.file_ids}).then(res => {
              this.$message({message: res.msg, type: 'success'})
              this.index()
            })
        })
      },
       beforeUpload(item){
        if(item.type.split('/')[0] === 'image') {
          let tempSize = item.size / 5242880
          if (tempSize > 1) {
            this.$message.error('图片尺寸不得大于5M！')
            return false
          }
        }
      },
      uploadSuccess: function(res) {
				console.log(res);
				if (res.code == 200) {
          this.index()
          this.$message.success(res.msg)
				} else {
          this.$message.error(res.msg)
				}
			},
      upload(item){
          let formdata = new FormData()
           
          formdata.append('file', item.file)
          const config = {
            headers: {
              "token": getToken(),  //token换成从缓存获取
              "x-token":getToken(),
            },
            onUploadProgress: progressEvent => {
              if (progressEvent.lengthComputable) {
                this.progress = true
                this.progressPercent = Number((progressEvent.loaded / progressEvent.total * 100).toFixed(2))
              }
            }
          }
          try {
            this.$axios.post(uplod_url, formdata, config).then(res => {
              if(res.data.err_code === 0){
                this.progressPercent = 0
                this.progress = false
                this.index()
              }
            })
          }catch (error) {
            this.$message.error('上传失败')
          }finally {
            this.$refs.upload && this.$refs.upload.clearFiles()
          }
      },
      submit(){
          
          if(this.singleSelect){
            console.log("update:siglepic")
            this.$emit('update:siglepic', this.files[0])
          }else{
            console.log("update:morepic")
            this.$emit('update:morepic', this.files)
          }
          
          this.closeForm()
      },
      closeForm(){
        this.$emit('update:show', false)
      },
    },
  }
</script>

<style lang="scss" scoped>
.dialog-class{
  z-index: 99999999999;
}
.image-wrap {
    position: relative;
    display: inline-block;
    box-sizing: content-box;
    margin: 10px 15px 0 0;
    vertical-align: top;
    &:hover {
      .icon-wrap {
        opacity: 1;
      }
    }
    .imgStyle img{
      width:100px;
      height: 100px;
      border: 1px solid #d9d9d9;
      border-radius: 6px;
    }
    .icon-wrap {
      position: absolute;
      left: 0;
      border-radius: 6px;
      width: 102px;
      height: 102px;
      cursor: default;
      text-align: center;
      line-height: 100px;
      color: #fff;
      opacity: 0;
      font-size: 20px;
      background-color: rgba(0, 0, 0, .7);
      transition: opacity .3s;
      .el-icon-zoom-in {
        cursor: pointer;
        margin-right: 8px;
      }
      .el-icon-delete {
        cursor: pointer;
      }
    }
}
label {
 font-size: 25px;
 cursor: pointer;
 position: absolute;
 top: -2px;
 right: 0px;
 z-index: 150;
}
 
label i {
 font-size: 15px;
 font-style: normal;
 display: inline-block;
 width: 18px;
 height: 18px;
 text-align: center;
 line-height: 18px;
 color: #fff;
 vertical-align: middle;
 margin: -3px 0px 1px 0px;
}
 
input[type="checkbox"],
input[type="radio"] {
 display: none;
 outline: none;
}
 
input[type="radio"]+i {
 border-radius: 7px;
}
 
input[type="checkbox"]:checked+i,
input[type="radio"]:checked+i {
 background: #67c23a;
 color: #FFF;
}
// @import '@/assets/scss/common.scss'
</style>