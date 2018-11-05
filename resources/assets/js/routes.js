import VueRouter from 'vue-router';
import Dashboard from './components/Dashboard.vue';
import SkpdIndex from './components/master/skpd/SkpdIndex.vue';
import RakIndex from './components/master/rak/RakIndex.vue';
import GedungIndex from './components/master/gedung/GedungIndex.vue';
import RuanganIndex from './components/master/ruangan/RuanganIndex.vue';
import BoxIndex from './components/master/box/BoxIndex.vue';
import JenisSuratIndex from './components/master/jenis_surat/JenisSuratIndex.vue';
import SuratIndex from './components/master/surat/SuratIndex.vue';
import ArsipIndex from './components/master/arsip/ArsipIndex.vue';
import UserIndex from './components/master/user/UserIndex.vue';
import ProfileUser from './components/master/user/children/ProfileUser.vue';
import Login from './components/auth/Login.vue';
import NotFound from './components/NotFound.vue';

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
		path: '/ruangan',
		component: RuanganIndex,
		name: 'RuanganIndex',
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
	},
	{
		path: '/user',
		component: UserIndex,
		name: 'UserIndex',
		meta: { requiresAuth: true }
	},
	{
		path: '/profil',
		component: ProfileUser,
		name: 'Profil',
		meta: { requiresAuth: true }
	},
	{
		path: '*',
		component: NotFound,
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