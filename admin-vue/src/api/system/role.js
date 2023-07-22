import request from '@/common/request'

export function listRoles(data) {
  return request({
    url: '/role/index',
    method: 'post',
	data:data
  })
}

export function addRoles(data) {
  return request({
    url: '/role/add',
    method: 'post',
	data:data
  })
}

export function delRole(id) {
  return request({
    url: '/role/del/id/'+id,
    method: 'get',
	
  })
}

export function listRolesMenu(id) {
  return request({
    url: '/role/selectRoleMenuId'+'/id/'+id,
    method: 'get',
	
  })
}

export function editRoles(data) {
  return request({
    url: '/role/edit',
    method: 'post',
	data:data
  })
}

export function selectRole() {
  return request({
    url: '/role/selectRole',
    method: 'get',
	
  })
}



