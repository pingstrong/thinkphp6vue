import{getToken,setToken,removeToken} from '@/common/token'
import {login,logout} from '@/api/login'
import {getInfo} from '@/api/system/member'

const user = {
	state: {
		token: getToken(),
		name: '',
		avatar: '',
		perms:[]
	},
	mutations: {
		SET_TOKEN: (state, token) => {
			state.token = token
		},
		SET_NAME: (state, name) => {
			state.name = name
		},
		SET_AVATAR: (state, avatar) => {
			state.avatar = avatar
		},
		SET_PERMISSON:(state,perms)=>{
			state.perms = perms
		}
	},
	actions: {
		GetInfo({ commit, state }) {
			return new Promise((resolve, reject) => {
				getInfo(state.token).then(res => {
				console.log(res);
				  const user = res.data.userInfo
				  const avatar = user.face == null ? require("@/assets/img/empty-face.png") : process.env.VUE_APP_BASE_API + user.face;
				  commit('SET_NAME', user.username)
				  commit('SET_AVATAR', avatar)
				  commit('SET_PERMISSON',res.data.perms);
				  resolve(res)
				}).catch(error => {
				  reject(error)
				})
			  })
		},
		Login({commit},userInfo){
			return new Promise((resolve,reject)=>{
				login(userInfo).then(res=>{
					console.log(res);
					setToken(res.data)
					commit('SET_TOKEN',res.data)
					resolve()
				}).catch(error=>{
					reject(error)
				})
			})
		},
		loginOut({ commit, state }) {
			return new Promise((resolve, reject) => {
			  logout().then((res) => {
				commit('SET_TOKEN', '')
				
				commit('SET_PERMISSON',[]);
				removeToken()
				resolve()
			  }).catch(error => {
				reject(error)
			  })
			})
		  },
	}
}
export default user