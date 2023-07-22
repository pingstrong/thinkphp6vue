const state={
	collapse:true,
	device: 'desktop',
}
const mutations = {
	COLLAPSE:(state)=>{
		state.collapse = !state.collapse
	},
	IS_COLLAPSE:(state)=>{
		state.collapse = true; 
	},
	NOT_COLLAPSE:(state)=>{
		state.collapse = false; 
	},
}

const actions = {
	changeCollapse({ commit }) {
	  commit('COLLAPSE')
	},
	isCollapse({commit}){
		commit('IS_COLLAPSE')
	},
	notCollapse({commit}){
		commit('NOT_COLLAPSE')
	},
	toggleDevice({ commit }, device) {
	  commit('TOGGLE_DEVICE', device)
	},
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}