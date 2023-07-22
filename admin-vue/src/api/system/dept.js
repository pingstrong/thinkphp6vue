import request from '@/common/request'



export function getDeptList() {
  return request({
    url: '/dept/tree',
    method: 'get'
  })
}

export function addDept(data) {
  return request({
    url: '/dept/add',
    method: 'post',
	data:data
  })
}


export function editDept(data) {
  return request({
    url: '/dept/edit',
    method: 'post',
	data:data
  })
}

export function changeOrder(data) {
  return request({
    url: '/dept/changeOrder',
    method: 'post',
	data:data
  })
}


export function delDept(id) {
  return request({
    url: '/dept/del/id/'+id,
    method: 'get',
	
  })
}