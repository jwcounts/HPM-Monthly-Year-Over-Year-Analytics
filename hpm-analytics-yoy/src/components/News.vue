<template>
	<div class="services" id="news-service">
		<!-- Import each of the global graphing components you set up -->
		<h2 class="text-center">{{ msg }}</h2>
		<div class="row">
			<div id="news-listen" class="col-12">
				<news-listen :chart-data="chartData"></news-listen>
			</div>
		</div>
		<div class="row">
			<div id="news-stream" class="col-12">
				<news-stream :chart-data="chartData"></news-stream>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'News',
	data () {
		return {
			msg: 'News 88.7 Listenership'
		}
	},
	props: [
		'chart-data'
	]
}
</script>