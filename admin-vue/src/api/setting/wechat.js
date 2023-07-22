import request from '@/common/request'


//公众号菜单配置
export function getMenuAPI(params) {
  return request({
    url: '/common/OfficialAccount/getMenuAPI',
    method: 'get',
    params: params
  })
}
// 
export function createMenuAPI(params) {
    return request({ url: '/common/OfficialAccount/createMenuAPI', method: 'post',data: params})
}

export function getMaterialAPI(params) {
    return request({
      url: '/common/OfficialAccount/getMaterialAPI',
      method: 'get',
      params: params
    })
  }

  export function getMaterialListAPI(params) {
    return request({
      url: '/common/OfficialAccount/getMaterialListAPI',
      method: 'get',
      params: params
    })
  }

  export function getNewsListAPI(params) {
    return request({
      url: '/common/OfficialAccount/getNewsListAPI',
      method: 'get',
      params: params
    })
  }