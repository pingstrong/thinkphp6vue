import request from '@/common/request'

//数据列表
export function index(params) {
	return request({ url: '/article/content/index',method: 'post',data: params})
}
//修改排序开关
export function updateExt(params) {
	return request({ url: '/article/content/updateExt',method: 'post',data: params})
}
//添加
export function add(params) {
	return request({ url: '/article/content/add',method: 'post',data: params})
}
//修改
export function update(params) {
	return request({ url: '/article/content/edit',method: 'post',data: params})
}
export function getUpdateInfo(params) {
	return request({ url: '/article/content/getUpdateInfo',method: 'post',data: params})
}
//删除
export function del(params) {
	return request({ url: '/article/content/delete',method: 'post',data: params})
}
//查看详情
export function detail(params) {
	return request({ url: '/article/content/detail',method: 'post',data: params})
}

export function getSelectHtml() {
	return request({ url: '/article/content/getSelectHtml',method: 'get'})
}
