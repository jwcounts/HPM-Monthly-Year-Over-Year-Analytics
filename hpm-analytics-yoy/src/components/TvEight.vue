<template>
	<div class="services service-active" id="tv8-service">
		<!-- Import each of the global graphing components you set up -->
		<h2 class="text-center">{{ msg }}</h2>
		<div class="row">
			<div id="tv-eight-viewers" class="col-12">
				<tv-eight-viewers :chart-data="chartData"></tv-eight-viewers>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'TvEight',
	data () {
		return {
			msg: 'TV 8 Viewership'
		}
	},
	props: [
		'chart-data'
	]
}
</script>