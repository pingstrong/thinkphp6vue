const getters = {
    token: state => state.user.token,
    avatar: state => state.user.avatar,
    name: state => state.user.name,
    user_routes: state => state.menu.routes,
	visitedViews: state => state.tagsView.visitedViews,
	cachedViews: state => state.tagsView.cachedViews,
}
export default getters