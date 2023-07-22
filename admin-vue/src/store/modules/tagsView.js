const state = {
  visitedViews: [],
  cachedViews: [],
  
}

const mutations = {
  ADD_VISITED_VIEW: (state, view) => {
	
	if (state.visitedViews.some(v => v.path === view.path)) return
    state.visitedViews.push(
      Object.assign({}, view, {
        title: view.meta.title || 'no-name'
      })
    )
	
  },


  
  UPDATE_VISITED:(state,view)=>{
	  state.visitedViews = state.visitedViews.filter(item => item.path !== view)
  },
  
  
  DEL_ALL_VISITED_VIEWS: state => {
    // keep affix tags
    const affixTags = state.visitedViews.filter(tag => tag.meta.affix)
    state.visitedViews = affixTags
  },
  
  
}

const actions = {
  addView({ dispatch }, view) {
	 
    dispatch('addVisitedView', view)
    //dispatch('addCachedView', view)
	
  },
  addVisitedView({ commit }, view) {
    commit('ADD_VISITED_VIEW', view)
  },
  updateVisitedView({ commit }, view) {
    commit('UPDATE_VISITED', view)
  },
  delAllViews({ dispatch, state }, view) {
    return new Promise(resolve => {
      dispatch('delAllVisitedViews', view)
      //dispatch('delAllCachedViews', view)
      resolve({
        visitedViews: [...state.visitedViews],
        //cachedViews: [...state.cachedViews]
      })
    })
  },
  delAllVisitedViews({ commit, state }) {
    return new Promise(resolve => {
      commit('DEL_ALL_VISITED_VIEWS')
      resolve([...state.visitedViews])
    })
  },
 
  
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
