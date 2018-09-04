import VueRouter from 'vue-router';
import Dashboard from './components/Dashboard.vue';
import SkpdIndex from './components/master/skpd/SkpdIndex.vue';
import GedungIndex from './components/master/gedung/GedungIndex.vue';
import RakIndex from './components/master/rak/RakIndex.vue';
import BoxIndex from './components/master/box/BoxIndex.vue';
import JenisSuratIndex from './components/master/jenis_surat/JenisSuratIndex.vue';
import SuratIndex from './components/master/surat/SuratIndex.vue';
import ArsipIndex from './components/master/arsip/ArsipIndex.vue';
import Login from './components/auth/Login.vue';

// register routes
let routes = [
	{
		path: '/',
		component: Login,
		name: 'Login',
		meta: { plainLayouts: true }
	},
	{
		path: '/dashboard',
		component: Dashboard,
		name: 'Dashboard',
		meta: { requiresAuth: true }
	},
	{
		path: '/skpd',
		component: SkpdIndex,
		name: 'SkpdIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/gedung',
		component: GedungIndex,
		name: 'GedungIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/rak',
		component: RakIndex,
		name: 'RakIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/box',
		component: BoxIndex,
		name: 'BoxIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/jenis-surat',
		component: JenisSuratIndex,
		name: 'JenisSuratIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/surat',
		component: SuratIndex,
		name: 'SuratIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/arsip',
		component: ArsipIndex,
		name: 'ArsipIndex',
		meta: { requiresAuth: true }
	}
]

export default new VueRouter({
	mode: 'history',
	routes
})