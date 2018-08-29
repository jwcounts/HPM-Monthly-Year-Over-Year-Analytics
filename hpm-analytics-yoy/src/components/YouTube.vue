<template>
	<div class="services" id="youtube-service">
		<!-- Import each of the global graphing components you set up -->
		<h2 class="text-center">{{ msg }}</h2>
		<div class="row">
			<div id="youtube-views" class="col-12">
				<yt-views :chart-data="chartData"></yt-views>
			</div>
		</div>
		<div class="row">
			<div id="youtube-subs" class="col-12">
				<yt-subs :chart-data="chartData"></yt-subs>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'YouTube',
	data () {
		return {
			msg: 'YouTube Analytics'
		}
	},
	props: [
		'chart-data'
	]
}
</script>
