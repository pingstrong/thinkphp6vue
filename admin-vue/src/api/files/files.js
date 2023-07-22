import request from '@/common/request'




export function addSet(data) {
  return request({
    url: '/files/addset',
    method: 'post',
	data:data
  })
}

export function ListSet() {
  return request({
    url: '/files/indexset',
    method: 'get',
	
  })
}

export function listFiles(data) {
  return request({
    url: '/files/index',
    method: 'post',
	data:data
  })
}

export function delFiles(id) {
  return request({
    url: '/files/del/id/'+id,
    method: 'get',
	
  })
}

export function batchRemove(data) {
  return request({
    url: '/files/batchRemove',
    method: 'post',
	data:data
  })
}