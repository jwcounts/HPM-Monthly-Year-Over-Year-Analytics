<template>
	<div class="services" id="twitter-service">
		<!-- Import each of the global graphing components you set up -->
		<h2 class="text-center">{{ msg }}</h2>
		<div class="row">
			<div id="twitter-hpm-rts" class="col-12">
				<twitter-hpm-rts :chart-data="chartData"></twitter-hpm-rts>
			</div>
		</div>
		<div class="row">
			<div id="twitter-hpm-likes" class="col-12">
				<twitter-hpm-likes :chart-data="chartData"></twitter-hpm-likes>
			</div>
		</div>
		<div class="row">
			<div id="twitter-news-rts" class="col-12">
				<twitter-news-rts :chart-data="chartData"></twitter-news-rts>
			</div>
		</div>
		<div class="row">
			<div id="twitter-news-likes" class="col-12">
				<twitter-news-likes :chart-data="chartData"></twitter-news-likes>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Twitter',
	data () {
		return {
			msg: 'Twitter Analytics'
		}
	},
	props: [
		'chart-data'
	]
}
</script>
