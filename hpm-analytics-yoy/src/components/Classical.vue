<template>
	<div class="services" id="classical-service">
		<!-- Import each of the global graphing components you set up -->
		<h2 class="text-center">{{ msg }}</h2>
		<div class="row justify-content-center">
			<div id="classical-stream" class="col-sm-12 col-md-11">
				<classical-stream :chart-data="chartData"></classical-stream>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Classical',
	data () {
		return {
			msg: 'Classical Streaming Listeners'
		}
	},
	props: [
		'chart-data'
	]
}
</script>
