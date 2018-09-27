<template>
	<div class="content">
		<navbar-vue v-if="!$route.meta.plainLayouts"></navbar-vue>
		<menu-vue v-if="!$route.meta.plainLayouts"></menu-vue>
		<div :class="{'content-wrapper': isActive}">
			<breadcrumb-vue v-if="!$route.meta.plainLayouts"></breadcrumb-vue>
			<div class="content">
				<div class="container-fluid">
					<transition name="fade" mode="out-in">
						<router-view class="mb-auto"></router-view>
					</transition>
					<vue-progress-bar></vue-progress-bar>
				</div>
			</div>
		</div>
		<!-- <div id="vueter">
			<footer-vue v-if="!$route.meta.plainLayouts" class="mt-auto"></footer-vue>
		</div> -->
	</div>
</template>
<script>
	export default {
		
		computed: {
			isActive: function () {
				if(!this.$route.meta.plainLayouts){
					return true;
				}
			}
		},

		components: {
			"navbar-vue": require('./layouts/Navbar.vue'),
			"menu-vue": require('./layouts/Menu.vue'),
			"breadcrumb-vue": require('./layouts/Breadcrumb.vue'),
			"footer-vue": require('./layouts/Footer.vue')
		}
	}
</script>

<style scoped="">
	.fade-enter-active,
	.fade-leave-active {
		transition-duration: 0.3s;
		transition-property: opacity;
		transition-timing-function: ease;
	}

	.fade-enter,
	.fade-leave-active {
		opacity: 0
	}
</style>