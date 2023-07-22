import request from '@/common/request'

// 获取用户详细信息
export function getUserRouter() {
  return request({
    url: '/menu/router',
    method: 'get'
  })
}

export function getMenuList() {
  return request({
    url: '/menu/tree',
    method: 'get'
  })
}

export function addMenu(data) {
  return request({
    url: '/menu/add',
    method: 'post',
	data:data
  })
}


export function editMenu(data) {
  return request({
    url: '/menu/edit',
    method: 'post',
	data:data
  })
}


export function delMenu(id) {
  return request({
    url: '/menu/del/id/'+id,
    method: 'get',
	
  })
}


export function changeStatus(id) {
  return request({
    url: '/menu/changeStatus/id/'+id,
    method: 'get',
	
  })
}

export function changeOrder(data) {
  return request({
    url: '/menu/changeOrder',
    method: 'post',
	data:data
  })
}