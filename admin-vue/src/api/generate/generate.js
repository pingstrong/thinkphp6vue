import request from '@/common/request'

export function listGen() {
  return request({
    url: '/generate/selectTable',
    method: 'get',
	
  })
}


export function listCloums(data) {
  return request({
    url: '/generate/selectCloums',
    method: 'post',
	data:data
  })
}


export function generateData(data) {
  return request({
    url: '/generate/getData',
    method: 'post',
	data:data
  })
}

export function genEdit(data) {
  return request({
    url: '/generate/genEdit',
    method: 'post',
	data:data
  })
}


export function addGenerate(data) {
  return request({
    url: '/generate/add',
    method: 'post',
	data:data
  })
}