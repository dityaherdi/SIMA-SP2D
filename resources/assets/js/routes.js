import VueRouter from 'vue-router';

// register routes dan components
let routes = [
	{
		path: '/',
		component: require('./components/auth/Login.vue'),
		name: 'Login',
		meta: { plainLayouts: true }
	},
	{
		path: '/dashboard',
		component: require('./components/dashboard/Dashboard.vue'),
		name: 'Dashboard',
		meta: { requiresAuth: true }
	},
	{
		path: '/detail-penyimpanan',
		component: require('./components/dashboard/DetailPenyimpanan.vue'),
		name: 'DetailPenyimpanan',
		meta: { requiresAuth: true }
	},
	{
		path: '/detail-retensi',
		component: require('./components/dashboard/DetailRetensi.vue'),
		name: 'DetailRetensi',
		meta: { requiresAuth: true }
	},
	{
		path: '/skpd',
		component: require('./components/master/skpd/SkpdIndex.vue'),
		name: 'SkpdIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/gedung',
		component: require('./components/master/gedung/GedungIndex.vue'),
		name: 'GedungIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/ruangan',
		component: require('./components/master/ruangan/RuanganIndex.vue'),
		name: 'RuanganIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/rak',
		component: require('./components/master/rak/RakIndex.vue'),
		name: 'RakIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/box',
		component: require('./components/master/box/BoxIndex.vue'),
		name: 'BoxIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/jenis-surat',
		component: require('./components/master/jenis_surat/JenisSuratIndex.vue'),
		name: 'JenisSuratIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/surat',
		component: require('./components/master/surat/SuratIndex.vue'),
		name: 'SuratIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/arsip',
		component: require('./components/master/arsip/ArsipIndex.vue'),
		name: 'ArsipIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/user',
		component: require('./components/master/user/UserIndex.vue'),
		name: 'UserIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/profil',
		component: require('./components/master/user/children/ProfileUser.vue'),
		name: 'Profil',
		meta: { requiresAuth: true }
	},
	{
		path: '*',
		component: require('./components/NotFound.vue'),
		name: 'NotFound'
	}
]

export default new VueRouter({
	mode: 'history',
	routes,
	scrollBehavior (to, from, savedPosition) {
		return { x: 0, y: 0 }
	}	  
})