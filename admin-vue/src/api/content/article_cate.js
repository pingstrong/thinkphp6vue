import request from '@/common/request'

//数据列表
export function index(params) {
	return request({ url: '/article/category/index',method: 'post',data: params})
}
//修改排序开关
export function updateExt(params) {
	return request({ url: '/article/category/updateExt',method: 'post',data: params})
}
//添加
export function add(params) {
	return request({ url: '/article/category/add',method: 'post',data: params})
}
//修改
export function update(params) {
	return request({ url: '/article/category/edit',method: 'post',data: params})
}
export function getUpdateInfo(params) {
	return request({ url: '/article/category/getUpdateInfo',method: 'post',data: params})
}
//删除
export function del(params) {
	return request({ url: '/article/category/delete',method: 'post',data: params})
}
//查看详情
export function detail(params) {
	return request({ url: '/article/category/detail',method: 'post',data: params})
}
 

//所有
export function getAll(params) {
	return request({ url: '/article/category/getAll',method: 'post',data: params})
}
 