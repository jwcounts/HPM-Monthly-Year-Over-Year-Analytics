// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import BootstrapVue from 'bootstrap-vue'
import { Bar,Line } from 'vue-chartjs'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import $ from 'jquery'

Vue.use(BootstrapVue)
Vue.config.productionTip = false

// Set up our main data variables
let chartData = []

/* eslint-disable no-new */
// I set up all of the graphs as global components. There's probably a better way to do it,
// but I couldn't get it working. They are also set to rerender when the dataset is updated,
// which is not ideal, but it was the only way I could get them to work correctly

// TV 8 Viewers
Vue.component('tv-eight-viewers', {
	extends: Bar,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					rectangle: {
						borderWidth: 2
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: 'TV: Cume Persons 2+',
					fontSize: 16
				},
			}
		}
	},
	mounted () {
		this.renderChart(chartData['tv8-viewers'], this.options )
	}
})

// News 88.7 - Weekly Listeners
Vue.component('news-listen', {
	extends: Bar,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					rectangle: {
						borderWidth: 2
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: 'News: Average Weekly Listeners',
					fontSize: 16
				},
			}
		}
	},
	mounted () {
		this.renderChart(chartData['news-weekly-listeners'], this.options )
	}
})

// News 88.7 - Monthly Streamers
Vue.component('news-stream', {
	extends: Bar,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					rectangle: {
						borderWidth: 2
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: 'News: Streaming Unique Listeners',
					fontSize: 16
				},
			}
		}
	},
	mounted () {
		this.renderChart(chartData['news-monthly-streamers'], this.options )
	}
})

// Classical - Monthly Streamers
Vue.component('classical-stream', {
	extends: Bar,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					rectangle: {
						borderWidth: 2
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: 'Classical: Streaming Unique Listeners',
					fontSize: 16
				},
			}
		}
	},
	mounted () {
		this.renderChart(chartData['classical-monthly-streamers'], this.options )
	}
})

// Google Analytics - Site Pageviews
Vue.component('site-pageviews', {
	extends: Bar,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					rectangle: {
						borderWidth: 2
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: 'HPM.org: Overall Pageviews',
					fontSize: 16
				},
			}
		}
	},
	mounted () {
		this.renderChart(chartData['site-overall-pageviews'], this.options )
	}
})

// Google Analytics - Site Users
Vue.component('site-users', {
	extends: Bar,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					rectangle: {
						borderWidth: 2
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: 'HPM.org: Overall Users',
					fontSize: 16
				},
			}
		}
	},
	mounted () {
		this.renderChart(chartData['site-overall-users'], this.options )
	}
})

// Google Analytics - Users by Device
Vue.component('site-user-device', {
	extends: Bar,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					rectangle: {
						borderWidth: 2
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: 'HPM.org: Phone and Tablet Users',
					fontSize: 16
				},
				scales: {
					xAxes: [{
						stacked: true
					}],
					yAxes: [{
						stacked: true
					}]
				}
			}
		}
	},
	mounted () {
		this.renderChart(chartData['site-users-device-type'], this.options )
	}
})

// Google Analytics - Sessions by Device
Vue.component('site-session-device', {
	extends: Bar,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					rectangle: {
						borderWidth: 2
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: 'HPM.org: Phone and Tablet Sessions',
					fontSize: 16
				},
				scales: {
					xAxes: [{
						stacked: true
					}],
					yAxes: [{
						stacked: true
					}]
				}
			}
		}
	},
	mounted () {
		this.renderChart(chartData['site-sessions-device-type'], this.options )
	}
})

// Facebook - Lifetime Page Likes
Vue.component('fb-likes', {
	extends: Line,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					line: {
						tension: 0
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: 'Total Page Likes',
					fontSize: 16
				}
			}
		}
	},
	mounted () {
		this.renderChart(chartData['facebook-likes'], this.options )
	}
})

// Facebook - Average Monthly Reach
Vue.component('fb-reach', {
	extends: Bar,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					rectangle: {
						borderWidth: 2,
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: 'Average Monthly Reach',
					fontSize: 16
				}
			}
		}
	},
	mounted () {
		this.renderChart(chartData['facebook-reach'], this.options )
	}
})

// YouTube - Monthly Views
Vue.component('yt-views', {
	extends: Bar,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					rectangle: {
						borderWidth: 2,
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: 'Monthly Views',
					fontSize: 16
				}
			}
		}
	},
	mounted () {
		this.renderChart(chartData['youtube-views'], this.options )
	}
})

// YouTube - Subscribers Added per Month
Vue.component('yt-subs', {
	extends: Bar,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					rectangle: {
						borderWidth: 2,
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: 'Monthly Subscribers Added',
					fontSize: 16
				}
			}
		}
	},
	mounted () {
		this.renderChart(chartData['youtube-subscribers-added'], this.options )
	}
})

// @HoustonPublicMedia Retweets
Vue.component('twitter-hpm-rts', {
	extends: Bar,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					rectangle: {
						borderWidth: 2
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: '@HoustonPubMedia Retweets',
					fontSize: 16
				}
			}
		}
	},
	mounted () {
		this.renderChart(chartData['twitter-hpm-rts'], this.options )
	}
})

// @HoustonPublicMedia Likes
Vue.component('twitter-hpm-likes', {
	extends: Bar,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					rectangle: {
						borderWidth: 2
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: '@HoustonPubMedia Likes/Favorites',
					fontSize: 16
				}
			}
		}
	},
	mounted () {
		this.renderChart(chartData['twitter-hpm-likes'], this.options )
	}
})

// @HPMNews887 Retweets
Vue.component('twitter-news-rts', {
	extends: Bar,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					rectangle: {
						borderWidth: 2
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: '@HPMNews887 Retweets',
					fontSize: 16
				}
			}
		}
	},
	mounted () {
		this.renderChart(chartData['twitter-news-rts'], this.options )
	}
})

// @HPMNews887 Likes
Vue.component('twitter-news-likes', {
	extends: Bar,
	props: [ 'chartData' ],
	data() {
		return {
			options: {
				elements: {
					rectangle: {
						borderWidth: 2
					}
				},
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: '@HPMNews887 Likes/Favorites',
					fontSize: 16
				}
			}
		}
	},
	mounted () {
		this.renderChart(chartData['twitter-news-likes'], this.options )
	}
})

// Download the dataset from the JSON tile, enter it as chartData and instantiate the app
$.getJSON("https://cdn.hpm.io/assets/analytics/yoy-data.json").always(function(data){
	chartData = data;
	new Vue({
		el: '#app',
		components: { App },
		template: '<App :chart-data="chartData"></App>',
		data: {
			chartData: chartData
		}
	})
});
