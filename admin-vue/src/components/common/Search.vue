<template>
    <div v-if="searchVisible" style="margin-bottom:15px">
      <el-form :size="size" inline ref="search" class="searchForm">
          <el-form-item v-for='item in searchForm' :label="item.label" :key='item.prop'>
              <!--单选框-->
              <el-input v-if="item.type==='input'" :style="'width:'+item.width" clearable :placeholder="item.label" v-model="searchData[item.prop]" ></el-input>
              <!--下拉框-->
              <el-select v-if="item.type==='select'" :style="'width:'+item.width" :placeholder="item.label" clearable v-model="searchData[item.prop]">
                  <el-option v-for="(vo,i) in item.data" :key="i"  :label="vo[item.label_key]" :value="vo[item.value_key]"></el-option>
              </el-select>
              <!-- <el-select v-if="item.type==='select'" :style="'width:'+item.width" :placeholder="item.label" clearable v-model="searchData[item.prop]">
                  <el-option v-for="(vo,i) in item.data" :key="i" :label="vo.label" :value="vo.value"></el-option>
              </el-select>  -->
              <Treeselect :default-expand-level="1" v-if="item.type==='treeSelect'" :style="'width:'+item.width"  v-model="searchData[item.prop]" :options="item.data" :normalizer="normalizer" :show-count="true" :placeholder="item.label"/>

              <!--三级联动-->
              <el-cascader :props="{ checkStrictly: true }" filterable v-if="item.type==='shengshiqu'" style="width:100%" v-model="searchData[item.prop]" :options="threeAddressOptions"></el-cascader>
              
              <!--时间区间-->
              <el-date-picker v-if="item.type==='datetime'" type="daterange" value-format="yyyy-MM-dd" v-model="searchData[item.prop]" clearable range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期"></el-date-picker>
          </el-form-item>
          <el-form-item>
            <el-button type="success" :size="size" icon="el-icon-search" @click="search">查询</el-button>
            <el-button :size="size" icon="el-icon-refresh" @click="searchReset">重置</el-button>
          </el-form-item>
      </el-form>
     
    </div>
</template>

<script>
import threeAddressOptions from '@/utils/city-data-level3.js'
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
export default {
    name:'Search',
    components: {
        threeAddressOptions,
        Treeselect
	},
    props:{
        labelWidth:{
            type:String,
            default:'100px'
        },
        size:{
            type:String,
            default:'mini'
        },
        searchForm:{
            type:Array,
            default:[]
        },
        searchVisible:{
            type:Boolean
        },
        searchData:{
            type: Object,
            default:{},
        }
    },
    data () {
        return {
            //searchData:{},
            threeAddressOptions:threeAddressOptions,
        }
    },
    methods: {
        search() {
            this.$emit('update:searchData', this.searchData)
            this.$emit('refesh_list')
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
        searchReset(){
            this.searchData = {}
            this.$emit('refesh_list',[])
        }
    },
}
</script>
<style scoped>
    .el-form-item--mini.el-form-item, .el-form-item--small.el-form-item{margin-bottom:5px}
</style>