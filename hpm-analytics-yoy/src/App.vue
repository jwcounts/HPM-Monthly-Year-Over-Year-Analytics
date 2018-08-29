<template>
	<div id="app">
		<!-- Main template for the app. Each service is saved as it's own component -->
		<header class="container-fluid">
			<div class="row align-items-center">
				<div class="col">
					<h3>HPM Year-Over-Year Analytics</h3>
				</div>
			</div>
		</header>
		<div class="container-fluid body-wrap">
			<div id="tab" class="row">
				<!--
					If you modified the PHP script to not pull one or more of these services,
					don't forget to remove their entries here
				 -->
				<div v-on:click="updateTab('tv8')" id="tv8-tab" class="col-sm-3 col-lg tv8 tab-active">TV 8</div>
				<div v-on:click="updateTab('news')" id="news-tab" class="col-sm-3 col-lg news">News 88.7</div>
				<div v-on:click="updateTab('classical')" id="classical-tab" class="col-sm-3 col-lg classical">Classical</div>
				<div v-on:click="updateTab('website')" id="website-tab" class="col-sm-3 col-lg website">Website</div>
				<div v-on:click="updateTab('youtube')" id="youtube-tab" class="col-sm-3 col-lg youtube">YouTube</div>
				<div v-on:click="updateTab('facebook')" id="facebook-tab" class="col-sm-3 col-lg facebook">Facebook</div>
				<div v-on:click="updateTab('twitter')" id="twitter-tab" class="col-sm-3 col-lg twitter">Twitter</div>
			</div>
			<div id="chart-wrap">
				<!--
					And here too
				-->
				<TvEight :chart-data="chartData"></TvEight>
				<News :chart-data="chartData"></News>
				<Classical :chart-data="chartData"></Classical>
				<Website :chart-data="chartData"></Website>
				<YouTube :chart-data="chartData"></YouTube>
				<Facebook :chart-data="chartData"></Facebook>
				<Twitter :chart-data="chartData"></Twitter>
			</div>
		</div>
	</div>
</template>

<script>
// Remove the entry here too, and in the "components:" section below
import $ from 'jquery'
import TvEight from '@/components/TvEight'
import Facebook from '@/components/Facebook'
import Twitter from '@/components/Twitter'
import YouTube from '@/components/YouTube'
import News from '@/components/News'
import Classical from '@/components/Classical'
import Website from '@/components/Website'
export default {
	name: 'App',
	props: [
		'chart-data'
	],
	components: { Facebook, Twitter, YouTube, TvEight, News, Classical, Website },
	methods: {
		updateTab: function(service) {
			// Helper function for switching tabs
			if ($('#'+service+'-tab').hasClass('tab-active')) {
				return false;
			} else  {
				$('.services').removeClass('service-active');
				$('#tab div').removeClass('tab-active');
				$('#'+service+'-tab').addClass('tab-active');
				$('#'+service+'-service').addClass('service-active');
			}
		}
	}
}
</script>

<style>
html {
	height: 100%;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	width: 100%;
}
body {
	position: relative;
	min-height: 100%;
}
header,
footer {
	padding: 0 1em;
	background: rgb(25,25,25);
	z-index: 9999;
}
header {
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	width: 100%;
}
footer {
	position: fixed;
	bottom: 0;
	left: 0;
	right: 0;
	width: 100%;
}
header h3 {
	color: white;
	margin: 0;
}
footer p {
	color: white;
	margin: 0;
	padding: 0.25em 0;
}
header div {
	padding: 0.125em 0;
}
form {
	margin: 2em 0;
}
.form-row {
	padding-top: 1em;
	padding-bottom: 1em;
}
label {
	font-weight: bolder;
	font-size: 150%;
}
header label {
	color: white;
	font-size: 100%;
	padding: 0;
	margin: 0;
}
label.form-check-label {
	font-weight: normal;
	font-size: 100%;
}
.alert {
	margin-bottom: 0 !important;
}
.body-wrap {
	padding-top: 9em;
	padding-bottom: 5em;
}
#tab {
	padding: 0 1em 2em;
}
#tab div {
	padding: 0.25em;
	text-align: center;
	margin: 0.5em 0;
}
#tab div:hover {
	opacity: 0.75;
	cursor: pointer;
}
#tab div.tv8 {
	background-color: rgba(204,0,0,0.2);
	border-top: 2px solid rgba(204,0,0,1);
}
#tab div.news {
	background-color: rgba(0,98,136,0.2);
	border-top: 2px solid rgba(0,98,136,1);
}
#tab div.classical {
	background-color: rgba(158,199,49,0.2);
	border-top: 2px solid rgba(158,199,49,1);
}
#tab div.website {
	background-color: rgba(239,168,46,0.2);
	border-top: 2px solid rgba(239,168,46,1);
}
#tab div.facebook {
	background-color: rgba(59,89,152,0.2);
	border-top: 2px solid rgba(59,89,152,1);
}
#tab div.twitter {
	background-color: rgba(29,161,242,0.2);
	border-top: 2px solid rgba(29,161,242,1);
}
#tab div.youtube {
	background-color: rgba(255,0,0,0.2);
	border-top: 2px solid rgba(255,0,0,1);
}
#tab div.tab-active {
	font-weight: bolder;
	color: white;
}
#tab div.tab-active.tv8 {
	background-color: rgba(204,0,0,0.75);
}
#tab div.tab-active.news {
	background-color: rgba(0,98,136,0.75);
}
#tab div.tab-active.classical {
	background-color: rgba(158,199,49,0.75);
}
#tab div.tab-active.website {
	background-color: rgba(239,168,46,0.75);
}
#tab div.tab-active.facebook {
	background-color: rgba(59,89,152,0.75);
}
#tab div.tab-active.twitter {
	background-color: rgba(29,161,242,0.75);
}
#tab div.tab-active.youtube {
	background-color: rgba(255,0,0,0.75);
}
#chart-wrap {
	position: relative;
	min-height: 20em;
}
#chart-wrap .services {
	width: 100%;
	position: absolute;
	visibility: hidden;
	top: 0;
	margin-bottom: 2em;
}
#chart-wrap .services.service-active {
	visibility: visible;
}
#chart-wrap .row div {
	margin-bottom: 1em;
}
@media (min-width: 576px) {
	.body-wrap {
		padding-top: 7em;
	}
	#tab div {
		border-left: 2px solid white;
		border-right: 2px solid white;
	}
}
@media (min-width: 992px) {
	.body-wrap {
		padding-top: 5em;
	}
}
</style>
