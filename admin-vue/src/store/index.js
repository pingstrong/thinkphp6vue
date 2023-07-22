import Vue from "vue";
import Vuex from "vuex";
import app from './modules/app'
import member from './modules/member'
import tagsView from './modules/tagsView'
import menu from "./modules/menu"
import getters from './getters'
Vue.use(Vuex)
const store =  new Vuex.Store({
 
  modules: {
    app:app,
	tagsView:tagsView,
	member:member,
	menu:menu
   },
   getters
  
});


export default store