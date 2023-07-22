<template>
	<div>
	  <el-row :gutter="40" class="panel-group">
		<el-col
		  :xs="12"
		  :sm="12"
		  :lg="6"
		  class="card-panel-col"
		  v-bind:key="index"
		  v-for="(item, index) in statis_list"
		>
		  <div class="card-panel">
			<div
			  class="card-panel-icon-wrapper icon-normal"
			  :style="{ color: item.color }"
			>
			  <svg-icon :icon-class="item.icon" class-name="card-panel-icon" />
			</div>
			<div class="card-panel-description">
			  <div class="card-panel-text">{{ item.title }}</div>
			  <count-to
				:start-val="0"
				:end-val="item.number"
				:duration="2600"
				class="card-panel-num"
			  />
			</div>
		  </div>
		</el-col>
	  </el-row>
	  <el-row style="background: #fff; padding: 16px 16px 0; margin-bottom: 32px">
		<div class="lineChart" id="lineChart"></div>
	  </el-row>
	</div>
  </template>
  
  <script>
  import CountTo from "vue-count-to";
  import echarts from "echarts";
  import { getStatis, getChart } from "@/api/datas/datas";
  
  export default {
	components: {
	  CountTo,
	},
	data() {
	  return {
		chart: null,
		statis_list: [],
	  };
	},
	mounted() {
	  this.init();
	},
	methods: {
	  init: async function () {
		//
		getStatis().then((res) => {
		  this.statis_list = res.data;
		});
		this.initChart();
	  },
	  initChart: async function () {
		console.log(echarts);
		this.chart = echarts.init(document.getElementById("lineChart"));
		getChart().then((res) => {
		  let newVisitis = {
			expectedData: res.data.x,
			actualData: res.data.y,
			title: res.data.title,
		  };
		  this.setOptions(newVisitis);
		});
	  },
	  setOptions({ expectedData, actualData, title } = {}) {
		this.chart.setOption({
		  title: {
			text: title, //主标题文本，'\n'指定换行
			x: "center", //水平安放位置，默认为'left'，可选为：'center' | 'left' | 'right' | {number}（x坐标，单位px）
			textAlign: "center", //水平对齐方式，默认根据x设置自动调整，可选为： left' | 'right' | 'center
		  },
		  areaStyle: {
			color: {
			  type: "linear",
			  x: 0,
			  y: 0,
			  x2: 0,
			  y2: 1,
			  colorStops: [
				{
				  offset: 0,
				  color: "#67c23a", // 0% 处的颜色
				},
				{
				  offset: 1,
				  color: "#409eff", // 100% 处的颜色
				},
			  ],
			  global: false, // 缺省为 false
			},
		  },
		  grid: {
			left: 10,
			right: 10,
			bottom: 20,
			top: 30,
			containLabel: true,
		  },
		  xAxis: {
			type: "category",
			boundaryGap: false,
			data: expectedData,
			axisTick: {
			  show: false,
			},
		  },
  
		  yAxis: {
			type: "value",
			axisTick: {
			  show: false,
			},
		  },
		  series: [
			{
			  data: actualData,
			  type: "line",
			  smooth: true,
			  animationDuration: 2800,
			  animationEasing: "cubicInOut",
			  areaStyle: {
				// normal: {
				// color: '#3888fa',
				// lineStyle: {
				//   color: '#3888fa',
				//   width: 2
				// },
				// areaStyle: {
				//   color: '#f3f8ff'
				// }}
			  },
			},
		  ],
		});
	  },
	  handleSetLineChartData(type) {
		this.$emit("handleSetLineChartData", type);
	  },
	},
  };
  </script>
  
  <style rel="stylesheet/scss" lang="scss" scoped>
  .lineChart {
	width: 100%;
	height: 500px;
  }
  .panel-group {
	margin-top: 18px;
	.card-panel-col {
	  margin-bottom: 32px;
	}
	.card-panel {
	  height: 108px;
	  cursor: pointer;
	  font-size: 12px;
	  position: relative;
	  overflow: hidden;
	  color: #666;
	  background: #fff;
	  box-shadow: 4px 4px 40px rgba(0, 0, 0, 0.05);
	  border-color: rgba(0, 0, 0, 0.05);
	  &:hover {
		.card-panel-icon-wrapper {
		  color: #fff;
		}
		.icon-people {
		  background: #40c9c6;
		}
		.icon-normal {
		  background: #e2e2d7;
		}
		.icon-message {
		  background: #36a3f7;
		}
		.icon-money {
		  background: #f4516c;
		}
		.icon-shopping {
		  background: #34bfa3;
		}
	  }
	  .icon-people {
		color: #40c9c6;
	  }
	  .icon-message {
		color: #36a3f7;
	  }
	  .icon-money {
		color: #f4516c;
	  }
	  .icon-shopping {
		color: #34bfa3;
	  }
	  .card-panel-icon-wrapper {
		float: left;
		margin: 14px 0 0 14px;
		padding: 16px;
		transition: all 0.38s ease-out;
		border-radius: 6px;
	  }
	  .card-panel-icon {
		float: left;
		font-size: 48px;
	  }
	  .card-panel-description {
		float: right;
		font-weight: bold;
		margin: 26px;
		margin-left: 0px;
		.card-panel-text {
		  line-height: 18px;
		  color: rgba(0, 0, 0, 0.45);
		  font-size: 16px;
		  margin-bottom: 12px;
		}
		.card-panel-num {
		  font-size: 20px;
		}
	  }
	}
  }
  </style>
  