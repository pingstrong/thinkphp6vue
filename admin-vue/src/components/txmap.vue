<template>
<!-- // 使用的是抽屉弹出 -->

    <div id="root">
            <div  v-if="addressList" class="address-list">
                <div  class="address-item" v-bind:key="index" v-for="(item, index) in addressList">
                        <span>纬度：{{item.lat}}, 经度：{{item.lng}}, 地名：{{item.name}}, 地址：{{item.address}}</span>
                        <i class="el-icon-delete" @click="deleteAddr(index, item)"></i>
                </div>
            </div>
        <div><el-button type="success" plain @click="showMap()">打开地图</el-button></div>
        <el-dialog
                v-dialogDrag 
                append-to-body
                :visible="showStatus" 
                :show="showStatus"
                width="70%"
                title="腾讯地图选址"
                :center="true"
                :before-close="beforeClose"
                :destroy-on-close="true"
                >
            <!-- // 搜索的表单 -->
            <el-form style="margin-left: 20px" class="searchForm" size="small" :model="searchFrom">
                <el-row :gutter="5">
                    <el-col :span="10">
                        <el-form-item prop="name">
                            <el-input clearable placeholder="请输入搜索位置信息"
                                    v-model="searchFrom.name"
                                    name="name"/>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-button icon="el-icon-search" type="primary" size="mini"
                                @click="searchAddress">搜索位置
                        </el-button>
                    </el-col>
                </el-row>
            </el-form>
            <!-- // 地图显示 注意id必须要加。因为下面会指定id加载地图 -->
            <div :id="container" style="width:100%;height:400px;"></div>
            <!-- // 附近地点显示 -->
            <el-table
                    highlight-current-row
                    :data="nearPointList"
                    max-height="300"
                    style="width: 100%">
                <el-table-column
                        prop="name"
                        label="附近地点名称">
                </el-table-column>
                <el-table-column
                        fixed="right"
                        label="操作"
                        width="100">
                    <template slot-scope="scope">
                        <el-button
                                @click.native.prevent="selectAddress(scope.row)"
                                type="text"
                                size="small">
                            确认选择
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </el-dialog>
    </div>
</template>
<script>
// 引入qqmap
    import maps from 'qqmap'
    import { getSetting } from '@/api/generate/generate.js'

    export default {
        name: "txmap",
         props:{
            addressList:{
                type: Array,
                default: ()=> []
            },
            container:{
                type: String,
                default: 'mapContainer'
            },
            isSingle:{
                type: Boolean,
                default: false
            },
            openLat:{
                type: String,
                default: '23.138347692636582',
            },
            openLng:{
                type: String,
                default: '113.32645502685544'
            }
        },
        data() {
            return {
                rootAddress: '',
                searchFrom: {name: ''},
                nearPointList: [],
                showStatus: false,
                map: '',
                data: '',
                markersArray: [],
                //addressList: []
            }
        },
        mounted() {
        // 初始化地图
            //this.container = this.container + Date.parse(new Date());
            //this.initMap()
        },
        methods: {
        // 搜索地址
            searchAddress() {
                if (!this.searchFrom.name) {
                    this.$message.error('未输入搜索内容')
                    return
                }
                this.setLocationByAddress(this.rootAddress + ',' + this.searchFrom.name)
            },
            // 初始化地图
            initMap:async function() {
                let that = this
                let key_result = await getSetting("houses.lbs_key")
                console.log("初始化地图+++++++++++++++++++++")
                maps.init(key_result.data, () => {
                    if(this.addressList.length >= 1){
                        this.openLat = this.addressList[0].lat
                        this.openLng = this.addressList[0].lng
                    }
                    let latLon = new qq.maps.LatLng(this.openLat, this.openLng)
                    let myOpts = {
                        zoom: 14,
                        center: latLon,
                        mapTypeId: qq.maps.MapTypeId.ROADMAP
                    }
                    that.map = new qq.maps.Map(
                        document.getElementById(this.container),
                        myOpts
                    )
                    qq.maps.event.addListener(that.map, 'click', function (event) {
                        that.setLocationByLatLng(event.latLng.getLat(), event.latLng.getLng())
                    })
                })
                // 经纬度解析类回调函数
                that.geocoder = new qq.maps.Geocoder({
                    complete: function (result) {
                        that.nearPointList = result.detail.nearPois
                        that.map.setCenter(result.detail.location);
                        let marker = new qq.maps.Marker({
                            map: that.map,
                            position: result.detail.location
                        });
                        that.markersArray.push(marker);
                        if (that.markersArray.length > 1) {
                            for (let i = 0; i < that.markersArray.length - 1; i++) {
                                that.markersArray[i].setMap(null);// 清除标记
                            }
                        }
                    }
                });
                // 地址解析回调函数
                that.geocoderLocation = new qq.maps.Geocoder({
                    complete: function (result) {
                       
                        // 查找附近的点
                        let latLng = new qq.maps.LatLng(result.detail.location.lat, result.detail.location.lng);
                        that.geocoder.getAddress(latLng);
                    }
                });
            },
            // 选择地址时间
            selectAddress(row) {
                 
                console.log(row, "@@@@@@")
                this.showStatus = false
                if(this.isSingle === true && this.addressList.length >= 1){
                    this.addressList.splice(0, this.addressList.length)
                }
                this.addressList.push({lat: row.latLng.lat, lng: row.latLng.lng, address: row.address, name: row.name})
            },
            // 父组件调用显示抽屉的方法
            show() {
                this.initMap()
                this.showStatus = true
            },
            // 父组件设置初始显示 省市区数据
            setLocationByAddress(address) {
                this.rootAddress = address
                this.geocoderLocation.getLocation(address);
            },
            // 父组件设置初始显示 经纬度数据
            setLocationByLatLng(lat, lng) {
                let latLng = new qq.maps.LatLng(lat, lng);
                this.geocoder.getAddress(latLng);
            },
            deleteAddr(index, item){
                this.addressList.splice(index, 1)
            },
            showMap(){
                this.container = this.container + Date.parse(new Date());
                this.initMap()
                this.showStatus = true
            },
            beforeClose:function(done){
                this.showStatus = false
                done();
            }

        }
    }
</script>

<style lang="scss" scoped>
    .address-list{
        background: #090;
        .address-item{
            color:#fff;
            padding: 5px 10px;
            span{
                margin-right: 20px;
            }
        }
        margin-bottom: 10px;
    }
</style>

