<template>
	<div class="w-full bg-white h-screen">
		<div class="flex flex-wrap place-items-center">
			<section class="relative mx-auto">
				<!-- navbar -->
				<nav class="flex justify-between bg-gray-900 text-white w-screen">
					<div class="px-5 xl:px-12 py-6 flex w-full items-center">
						<!-- Nav Links -->
						<ul class="md:flex px-4 mx-auto font-semibold font-heading space-x-12 self-center">
							<li><router-link to="/create" class="hover:text-gray-200" href="#">Create</router-link></li>
							<li><router-link to="/list" class="hover:text-gray-200" href="#">List</router-link></li>
						</ul>
					</div>
				</nav>
				
			</section>
		</div>
		<div class="mx-auto mb-12">
			<div v-if="loading" class="flex justify-center mt-32">
				<h4 class="text-4xl">Loading...</h4>
			</div>

			<table v-else-if="campaigns.length" class="items-center w-full table-auto bg-transparent border-collapse">
				<thead>
					<tr>
						<th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 font-semibold text-left bg-white text-black border-blue-700">Name</th>
						<th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 font-semibold text-left bg-white text-black border-blue-700">Budget</th>
						<th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 font-semibold text-left bg-white text-black border-blue-700">Start Date</th>
						<th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 font-semibold text-left bg-white text-black border-blue-700">End Date</th>
						<th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 font-semibold text-left bg-white text-black border-blue-700">Created At</th>
						<th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 font-semibold text-left bg-white text-black border-blue-700"></th>
						<th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 font-semibold text-left bg-white text-black border-blue-700"></th>
					</tr>
				</thead>

				<tbody>
					<tr v-for="campaign in campaigns" :key="campaign.id">
						<th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs text-left p-4">
							<span class="font-bold text-black">{{ campaign.name }}</span>
						</th>
						<td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs text-left p-4">
							${{ campaign.total_budget }} USD (${{ campaign.daily_budget }} daily)
						</td>
						<td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs text-left p-4">
							{{ campaign.date_from | formatDate}}
						</td>
						<td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs text-left p-4">
							{{ campaign.date_to | formatDate}}
						</td>
						<td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs text-left p-4">
							{{ campaign.created_at | createdAt}}
						</td>
						<td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs text-left p-4 w-56">
							<button @click="show(campaign.id)" class="w-full font-semibold leading-none text-white py-4 px-10 bg-blue-700 rounded hover:bg-blue-600 focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:outline-none">
								View Creatives
							</button>
						</td>
						<td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs text-left p-4 w-56">
							<button @click="edit(campaign.id)" class="w-full font-semibold leading-none text-white py-4 px-10 bg-black rounded focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:outline-none">
								Edit
							</button>
						</td>
					</tr>
				</tbody>
			</table>

			<div v-else class="flex justify-center mt-32">
				<h4 class="">No Campaigns. <router-link class="text-blue-400" to="/create">Create your first campaign.</router-link></h4>
			</div>
		</div>

		<CreativesModal v-if="showCreatives" @close="showCreatives = false" :creatives="currentCreatives" />
	</div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import moment from 'moment';
import axios from 'axios';
import CreativesModal from './CreativesModal';

export default {
	components: {
		DatePicker,
		CreativesModal
	},
    data() {
		return {
			loading: false,
			campaigns: [],
			showCreatives: false,
			currentCreatives: []
		};
    },
	methods: {
		process: function() {
			this.errors = [];

			if (!this.name) {
				this.errors.push("Campaign Name require.");
			}
			if (!this.dateFrom || !this.dateTo) {
				this.errors.push('Start/End Date Required');
			}
			if (this.totalBudget <= 0 || this.dailyBudget <= 0) {
				this.errors.push('Daily/Total Budget Required');
			} else if (parseFloat(this.dailyBudget) > parseFloat(this.totalBudget)) {
				this.errors.push('Daily Budget cannot be greater than total budget');
			}
			if (!this.creatives.length) {
				this.errors.push('At least one image must be uploaded');
			}

			if (this.errors.length) {
				return true;
			}

			let formData = new FormData();
			formData.append('name', this.name);
			formData.append('date_from', this.dateFrom);
			formData.append('date_to', this.dateTo);
			formData.append('total_budget', this.totalBudget);
			formData.append('daily_budget', this.dailyBudget);
			for( let x = 0; x < this.creatives.length; x++ ){
				formData.append(`creatives[${x}]`, this.creatives[x]);
			}

			axios.post('/api/campaigns/create',
				formData,
				{
					headers: {
						'Content-Type': 'multipart/form-data'
					}
				}).then(function(res) {
					console.log(res);
				}).catch(function(err) {
					console.log(err);
				});
		},

		getCampaigns: function() {
			this.loading = true;
			axios.get('/api/campaigns')
				.then(res => {
					this.campaigns = res.data;
					this.loading = false;
				})
				.catch(err => {
					console.log(err);
				});
		},

		show: function(id) {
			const campaign  = this.campaigns.find(o => o.id == id);
			if (campaign) {
				this.currentCreatives = campaign.creatives;
				this.showCreatives = true;
			}
		},

		edit: function(id) {
			const campaign  = this.campaigns.find(o => o.id == id);
			if (campaign) {
				this.$router.push({ name: 'edit', params: {campaign: campaign }});
			}
		}
	},

	mounted() {
		this.getCampaigns();
	},

	filters: {
		formatDate: (date) => {
			if (moment(date)) return moment(date).format("YYYY-MM-DD");
			else return date;
		},

		createdAt: (date) => {
			if (moment(date)) return moment(date).format("YYYY-MM-DD h:ma");
			else return date;
		}
	}
}
</script>

<style scoped>
.mx-datepicker {
	width: 100%;
}
</style>