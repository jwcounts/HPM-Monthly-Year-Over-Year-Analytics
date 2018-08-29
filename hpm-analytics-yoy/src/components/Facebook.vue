<template>
	<div class="services" id="facebook-service">
		<!-- Import each of the global graphing components you set up -->
		<h2 class="text-center">{{ msg }}</h2>
		<div class="row justify-content-center">
			<div id="fb-likes" class="col-12">
				<fb-likes :chart-data="chartData"></fb-likes>
			</div>
		</div>
		<div class="row">
			<div id="fb-reach" class="col-12">
				<fb-reach :chart-data="chartData"></fb-reach>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Facebook',
	data () {
		return {
			msg: 'Facebook Insights'
		}
	},
	props: [
		'chart-data'
	]
}
</script>