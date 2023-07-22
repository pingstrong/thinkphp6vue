import request from '@/common/request'

export function listDatas(data) {
  return request({
    url: '/datas/index',
    method: 'post',
	data:data
  })
}



export function getStatis(data) {
  return request({
    url: '/console/getStatis',
    method: 'post',
	data:data
  })
}

export function getChart(data) {
  return request({
    url: '/console/getChart',
    method: 'post',
	data:data
  })
}

export function clearProductData(data) {
  return request({
    url: '/dbmanage/clearProductData',
    method: 'post',
	data:data
  })
}
