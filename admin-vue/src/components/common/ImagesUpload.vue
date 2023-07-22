<template>
  <div>
    <div v-if="fileType == 'images'" class="image-list" style="width:100%"> 

      
        <draggable v-model="imageList" v-bind="{group:'item'}" @change="changeSort">
          <div v-for="(item, index) in imageList" :key="index" class="image-wrap">
            <div class="imgStyle">
              <el-image   style="max-width:200px; max-height:200px" :src="item"  :preview-src-list="[imageList]"></el-image>
            </div>
            <div class="icon-wrap" :style="{bottom:bottom}">
              <i class="el-icon-delete" @click.stop="handleRemoveImages(index)"></i>&nbsp;&nbsp; 
              <!-- <i style="cursor:pointer" :class="showtitle ? 'el-icon-top' : 'el-icon-bottom'" @click.stop="handlePictureCardPreview(index)"></i> -->
            </div>
          </div>
        </draggable>
        <el-upload class="upload-demo" ref="upload" multiple :action="actions" :headers="uploadHeader" :on-success="uploadSuccess">
              <el-button class="el-icon-upload" size="small" type="primary">上传图片</el-button>
            </el-upload>
             <el-tooltip class="item hidden-sm-and-down" effect="dark" :content="'选择图片'" placement="top">
              <el-button class="el-icon-picture" size="small" @click="openImagesPick"></el-button>
        </el-tooltip>
    </div>
    <div v-else-if="fileType == 'image'" class="image-list" style="width:100%">
        <el-row>
            <div v-if="siglepic" > 
                <el-image  style="max-width:200px; max-height:200px" :src="siglepic"  :preview-src-list="[siglepic]"></el-image>
            </div>
            </el-row>
            <el-row>
           
            <el-upload class="upload-demo" ref="upload" :action="actions" :headers="uploadHeader" :on-success="uploadSuccess">
              <el-button class="el-icon-upload" size="small" type="primary">上传图片</el-button>
            </el-upload>
             <el-tooltip class="item hidden-sm-and-down" effect="dark" :content="'选择图片'" placement="top">
              <el-button class="el-icon-picture" size="small" @click="openImagesPick"></el-button>
             </el-tooltip>
				</el-row>
    </div>
    <div v-else-if="fileType == 'file'" class="image-list" style="width:100%">
        
        <div v-if="sigleFile" tabindex="0" class="el-upload-list__item is-success">
              <a @click.stop="handleRemoveFile" class="el-upload-list__item-name"><i class="el-icon-document"></i>{{sigleFile}}</a>
              <label class="el-upload-list__item-status-label">
                <i class="el-icon-upload-success el-icon-circle-check"></i>
              </label>
              <i class="el-icon-close"></i>
        </div>
        <el-upload class="upload-demo" ref="upload" :action="actions" :headers="uploadHeader" :on-success="uploadSuccess">
            <el-button size="small" type="primary">点击上传</el-button>
        </el-upload>
    </div>
    <div v-else class="image-list" style="width:100%">
        <el-upload :action="actions" ref="upload"  multiple :headers="uploadHeader" :on-success="uploadSuccess">
            <el-button size="small" type="primary">点击上传</el-button>
        </el-upload>
        <ul class="el-upload-list el-upload-list--text">
          <li v-for="(item,i) in fileList" :tabindex="i" :key="i" class="el-upload-list__item is-success">
              <a @click.stop="handleRemoveFiles(i)" class="el-upload-list__item-name"><i class="el-icon-document"></i>{{item.name}}</a>
              <label class="el-upload-list__item-status-label">
                <i class="el-icon-upload-success el-icon-circle-check"></i>
              </label>
              <i class="el-icon-close"></i>
          </li>
        </ul>
    </div>
    <el-progress v-if="progress" :stroke-width="5" :percentage="progressPercent"></el-progress>
    <ImagesPick :show.sync="imagesDialogStatus" :singleSelect="fileType == 'image' ? true : false " :morepic.sync="morepic" :siglepic.sync ="siglepic" size="small"></ImagesPick>
  </div>
</template>

<script>
let uplod_url = process.env.VUE_APP_API + "/Uploads/index"
let uploads = process.env.VUE_APP_API;
import draggable from "vuedraggable"
import ImagesPick from '@/components/common/ImagesPick.vue'
import { confirm } from '@/utils/common'
import {getToken} from '@/common/token'
//import {createFile} from '@/api/setting/base'
  export default {
    name:'ImagesUpload',
    components: {draggable,ImagesPick},
    props: {
      picker:{
        type:String,
        default:'',
      },
      images:{
        type:Array,
        default:()=>[]
      },
      image:{
        type:String,
      },
      file:{
        type:String,
      },
      files:{
        type:Array,
        default:()=>[]
      },
      fileType:{
        type:String
      },
      uploadType:{
        type:String,
        default:'1',
      },
      upload_config_id:{
        type:Number,
      }
    },
    data() {
      return {
        loading: false,
        showtitle:false,
        siglepic: this.image,
        morepic: [],
        imageList:this.images,
        sigleFile:this.file,
        fileList:this.files,
        bottom:'12px',
        videoFlag:true,
        progressPercent:0,
        progress:false,
        imagesDialogStatus : false,
        uploadUrl:'',
        actions: uploads + "/uploads/index",
        uploadHeader: {
					"Authorization": "Bearer " + getToken()
				},
      }
    },
    created(){
       
    },
    watch: {
      image() {
       
        this.siglepic = this.image
      },
      images(){
         
        this.imageList = this.images
      },
      file(){
        this.sigleFile = this.file
      },
      files(){
        this.fileList = this.files
      },
      siglepic(new_val, old_val){
        console.log("siglepic", new_val, old_val)
        this.$emit('update:image',this.siglepic)
      },
      morepic(new_val, old_val){
        console.log("morepic", new_val, old_val, "xxxxxxxxxxxxxxx", this.morepic, this.imageList)
        if(this.imageList == null || this.imageList == ""){
          this.imageList = []
        }
        this.$emit('update:images', this.imageList.concat(this.morepic))
      }
    },
    methods: {
      uploadSuccess: function(res) {
				console.log(res);
				if (res.code == 200) {
          let item = {
            file:{name:res.data.name}
          }
          this.setFilePath(item,res.data.http_urls)
          this.$message.success(res.msg)
				} else {
          this.$message.error(res.msg)
				}
			},
      beforeUpload(item){
        if(this.fileType == 'image' || this.fileType == 'images'){
          if(item.type.split('/')[0] !== 'image') {
            this.$message.error('请选择图片')
            return false
          }
        }
        this.loading = true
      },
      upload(item){
          let formdata = new FormData()
          let ali = new FormData()  //此处非常坑 阿里上传file属性必须要放到最后  所以只能赋值对象
          formdata.append('file', item.file)
          formdata.append('upload_config_id', this.upload_config_id)
          const config = {
             headers: {
              "token": getToken(),  //token换成从缓存获取
              "x-token":getToken()
            },
            onUploadProgress: progressEvent => {
              if (progressEvent.lengthComputable) {
                this.progress = true
                this.progressPercent = Number((progressEvent.loaded / progressEvent.total * 100).toFixed(2))
              }
            }
          }
          try {
            
            this.$axios.post(uplod_url, formdata,config).then(res => {
              if (res.data.err_code == 0) {
                if(res.data.data.http_urls){
                  this.setFilePath(item,res.data.data.http_urls)
                }else{
                     
                    this.setFilePath(item,res.data.data)
                    
                }
              }
            })
          }catch (error) {
            console.log(this.$axios, error)
            this.$message.error('上传失败')
          }finally {
            this.loading = false
            this.$refs.upload && this.$refs.upload.clearFiles()
          }
      },
      setFilePath(item,filepath){
        this.progressPercent = 0
        this.progress = false
        if(this.fileType == 'images'){
            this.imageList.push(filepath)
            this.$emit('update:images',this.imageList)
        }else if(this.fileType == 'image'){
            this.siglepic = filepath
            this.$emit('update:image',filepath)
        }else if(this.fileType == 'files'){
            this.fileList.push({url: filepath,name:item.file.name})
            this.$emit('update:files',this.fileList)
        }else{
            this.sigleFile = filepath
            this.$emit('update:file',filepath)
        }
      },
      handleRemoveImages(index) {
        confirm({content:'确定要删除吗'}).then(() => {
            this.imageList.splice(index, 1)
            this.$emit('update:images',this.imageList)
        }).catch(() => {})
      },
      handleRemoveFiles(index) {
        confirm({content:'确定要删除吗'}).then(() => {
            this.fileList.splice(index, 1)
            this.$emit('update:files',this.fileList)
        }).catch(() => {})
      },
      handleRemoveImage() {
        confirm({content:'确定要删除吗'}).then(() => {
            this.siglepic = ''
            this.$emit('update:image','')
        }).catch(() => {})
      },
      handleRemoveFile() {
        confirm({content:'确定要删除吗'}).then(() => {
            this.sigleFile = ''
            this.$emit('update:file','')
        }).catch(() => {})
      },
      handlePictureCardPreview(i){
          this.showtitle = !this.showtitle
          this.showtitle == true ? this.bottom = "45px" : this.bottom = "12px"
      },
      changeSort(){
        this.$emit('update:images',this.imageList)
      },
      openImagesPick(){
        this.imagesDialogStatus = true
      }
    }
  }
</script>

<style  lang="scss">
.upload-demo{display: inline-block; margin-right: 5px;}
.el-upload--picture-card {width:100px; height: 100px; line-height: 100px;}
.el-upload-list--picture-card .el-upload-list__item {width:100px; height: 100px; }
.el-upload-list__item-name{padding-left: 0;}
.el-upload-list__item{line-height: 1.1;}
.image-list, .image-item {
  .image-wrap {
    position: relative;
    display: inline-block;
    box-sizing: content-box;
    margin: 0 10px 0 0;
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
}
.image-item {
  display: inline-flex;
}
.image-uploader {
  display: inline-block;
  .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    width:100px;
    height:100px;
    [class^="el-icon"] {
      line-height: 100px;
      font-size: 24px;
      color: #8c939d;
      text-align: center;
    }
    &:hover {
      border-color: #409EFF;
    }
  }
}
</style>
