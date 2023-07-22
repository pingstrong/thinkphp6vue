import request from '@/common/request'

export function login(data) {
 
  return request({
    url: '/login',
    method: 'post',
    data: data
  })
}


export function logout() {
  return request({
    url: '/loginout',
    method: 'get'
  })
}


export function getcode() {
  return request({
    url: '/captcha?t='+new Date().getTime(),
    method: 'get'
  })
}