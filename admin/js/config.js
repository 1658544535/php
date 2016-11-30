requirejs.config({
	baseUrl: 'js',
	paths: {
		'jquery': [
			'http://cdn.bootcss.com/jquery/2.1.0/jquery.min',
			'jquery-1.11.2.min'
		],
		'jqForm': 'jquery.form.min',
		'baiduTP': 'baiduTemplate'
	},
	shim: {
		'baiduTP': {
			exports: 'baidu'
		}
	}
})