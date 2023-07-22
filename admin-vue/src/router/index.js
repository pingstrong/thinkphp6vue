import Vue from "vue"
import Router from "vue-router"
Vue.use(Router)
const originalPush = Router.prototype.push
Router.prototype.push = function push(location) {
	return originalPush.call(this, location).catch(err => err)
}
import Layout from '@/layout';

export const constantRoutes = [{
		path: '',
		component: Layout,
		redirect: 'index',
		children: [{
			path: 'index',
			component: (resolve) => require(['@/views/index'], resolve),
			name: '首页',
			meta: {
				title: '控制台',
				icon: 'fa fa-desktop',
				noCache: true,
				affix: true
			}
		}]
	},
	{
		path: '/login',
		component: (resolve) => require(['@/views/login'], resolve),
		hidden: true
	},
	{
		path: '/404',
		component: (resolve) => require(['@/views/error/404'], resolve),
		hidden: true
	  },
	  {
	  	path:'/redirect',
	  	component:Layout,
	  	hidden:true,
	  	children:[
	  		{
	  		path:'/redirect/:path(.*)',
	  		component: (resolve) => require(['@/views/redirect'], resolve)
	  	      }
	      ]
	  },
	  {
	      path: '/gen',
	      component: Layout,
	      hidden: true,
	      children: [
	        {
	          path: 'edit/:tableId',
	          component: (resolve) => require(['@/views/tool/gen/edit'], resolve),
	          name: 'GenEdit',
	          meta: { title: '修改生成配置' }
	        }
	      ]
	    }
]


// const createRouter = () => new Router({
//   mode: 'hash',
//   routes: constantRoutes
// })
// const router = createRouter()
// export function resetRouter () {
//     const newRouter = createRouter()
//     router.matcher = newRouter.matcher // the relevant part
//   }
  
  
  
//   export default router
export default new Router({
	mode: 'history', // 去掉url中的#
	scrollBehavior: () => ({
		y: 0
	}),
	routes: constantRoutes
})


