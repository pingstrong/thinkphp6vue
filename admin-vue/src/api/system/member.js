import request from '@/common/request'

export function getInfo() {
  return request({
    url: '/member/info',
    method: 'get'
  })
}


export function getMemberList(data) {
  return request({
    url: '/member/index',
    method: 'post',
	  data:data
  })
}


export function addMember(data) {
  return request({
    url: '/member/add',
    method: 'post',
	data:data
  })
}

export function editMember(data) {
  return request({
    url: '/member/edit',
    method: 'post',
	data:data
  })
}

export function delMember(id) {
  return request({
    url: '/member/del/id/'+id,
    method: 'get',
	
  })
}



export function changePwd(data) {
  return request({
    url: '/member/changePwd',
    method: 'post',
	data:data
  })
}

export function updateProfile(data) {
  return request({
    url: '/member/updateProfile',
    method: 'post',
	data:data
  })
}

