<template>
	<div class="services" id="website-service">
		<!-- Import each of the global graphing components you set up -->
		<h2 class="text-center">{{ msg }}</h2>
		<div class="row justify-content-center">
			<div id="site-pageviews" class="col-12">
				<site-pageviews :chart-data="chartData"></site-pageviews>
			</div>
			<div id="site-users" class="col-12">
				<site-users :chart-data="chartData"></site-users>
			</div>
			<div id="site-user-device" class="col-12">
				<site-user-device :chart-data="chartData"></site-user-device>
			</div>
			<div id="site-session-device" class="col-12">
				<site-session-device :chart-data="chartData"></site-session-device>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Website',
	data () {
		return {
			msg: 'HoustonPublicMedia.org User Stats'
		}
	},
	props: [
		'chart-data'
	]
}
</script>