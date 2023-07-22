import { constantRoutes } from '@/router'
import { getUserRouter } from '@/api/system/menu'
import Layout from '@/layout/index'
const userrouter = {
    state: {
        routes: [],
        addRoutes: []
      },
      mutations: {
        SET_ROUTES: (state, routes) => {
          state.addRoutes = routes
          state.routes = constantRoutes.concat(routes)
        }
      },
      actions: {
        // 生成路由
        GenerateRoutes({ commit }) {
          return new Promise(resolve => {
            // 向后端请求路由数据
            getUserRouter().then(res => {
				//console.log(res.data);
              const accessedRoutes = filterAsyncRouter(res.data)
              accessedRoutes.push({ path: '*', redirect: '/404', hidden: true })
              commit('SET_ROUTES', accessedRoutes)
			  resolve(accessedRoutes)
            })
          })
        }
      }   
}

function filterAsyncRouter(asyncRouterMap) {
    return asyncRouterMap.filter(route => {
		
      if (route.component) {
        
        if (route.component === 'Layout') {
          route.component = Layout
        } else {
          route.component = loadView(route.component)
        }
      }
      if (route.children != null && route.children && route.children.length) {
        route.children = filterAsyncRouter(route.children)
      }
      return true
    })
  }





  export const loadView = (view) => { // 路由懒加载
    return (resolve) =>  require([`@/views/${view}`], resolve)
  }

  export default userrouter