const path = require('path') 
const { config } = require('process')
const port = process.env.port || process.env.npm_config_port || 8282
const name="后台管理系统"
function resolve(dir) {
    return path.join(__dirname, dir)
}
module.exports={
	lintOnSave:false,
	publicPath:process.env.NODE_ENV === "production" ? "/":"/",
	outputDir:'dist',
	assetsDir:'static',
	productionSourceMap:false,
	devServer:{
		host:'localhost',
		port:port,
		open:true,
		
		
	},
	

	chainWebpack:config=>{
		 config.resolve.symlinks(true);
		 config.resolve.alias.set('@',resolve('src'))
		 config.plugin('html').tap(options=>{
		     options[0].title=name
		     return options
		 })

		 // 配置svg
		 config.module
		 .rule('svg')
		 .exclude.add(resolve('src/icons'))
		 .end()
		 config.module
		 .rule('icons')
		 .test(/\.svg$/)
		 .include.add(resolve('src/icons'))
		 .end()
		 .use('svg-sprite-loader')
		 .loader('svg-sprite-loader')
		 .options({
		 symbolId: 'icon-[name]'
		 })
		 .end()
	}
}

