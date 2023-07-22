import request from '@/common/request'


//基本配置
export function getList(key) {
  return request({
    url: '/setting/getListByKey?key=' + key,
    method: 'POST',
	
  })
}
  // 
  export function setKey(key, params) {
    return request({ url: '/setting/setItem?key=' + key, method: 'post',data: params})
  }

  export function getTab(type) {
    return request({
      url: '/setting/getTab?type=' + type,
      method: 'get',
    
    })
  }
   