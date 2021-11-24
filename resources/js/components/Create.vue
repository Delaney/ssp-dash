<template>
	<div class="w-full bg-gray-800 h-screen">
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
		<div class="bg-gradient-to-b from-blue-800 to-blue-600 h-96"></div>
		<div class="max-w-5xl mx-auto px-6 sm:px-6 lg:px-8 mb-12">
			<div class="bg-gray-900 w-full shadow rounded p-8 sm:p-12 -mt-72">
				<p class="text-3xl font-bold leading-7 text-center text-white">Create New Campaign</p>
				<form action="" method="post" @submit.prevent="process" enctype="multipart/form-data">
					<div class="md:flex items-center mt-12">
						<div class="w-full flex flex-col">
							<label class="font-semibold leading-none text-gray-300">Campaign Name</label>
							<input type="text" v-model="name" class="leading-none text-gray-50 p-3 focus:outline-none focus:border-blue-700 mt-4 border-0 bg-gray-800 rounded" />
						</div>
					</div>
					<div class="md:flex items-center mt-12">
						<div class="w-full md:w-1/2 flex flex-col">
							<label class="font-semibold leading-none text-gray-300">Start Date</label>
							<date-picker v-model="dateFrom" :disabled-date="pastDate" :input-class="'leading-none text-gray-50 p-3 focus:outline-none focus:border-blue-700 mt-4 border-0 bg-gray-800 rounded w-full'" valueType="format"></date-picker>
						</div>
						<div class="w-full md:w-1/2 flex flex-col md:ml-6 md:mt-0 mt-4">
							<label class="font-semibold leading-none text-gray-300">End Date</label>
							<date-picker v-model="dateTo" :disabled-date="pastDate" :input-class="'leading-none text-gray-50 p-3 focus:outline-none focus:border-blue-700 mt-4 border-0 bg-gray-800 rounded w-full'" valueType="format"></date-picker>
						</div>
					</div>
					<div class="md:flex items-center mt-12">
						<div class="w-full md:w-1/2 flex flex-col">
							<label class="font-semibold leading-none text-gray-300">Total Budget</label>
							<input type="number" v-model="totalBudget" class="leading-none text-gray-50 p-3 focus:outline-none focus:border-blue-700 mt-4 border-0 bg-gray-800 rounded"/>
						</div>
						<div class="w-full md:w-1/2 flex flex-col md:ml-6 md:mt-0 mt-4">
							<label class="font-semibold leading-none text-gray-300">Daily Budget</label>
							<input type="number" v-model="dailyBudget" class="leading-none text-gray-50 p-3 focus:outline-none focus:border-blue-700 mt-4 border-0 bg-gray-800 rounded"/>
						</div>
					</div>
					<div>
						<div class="w-full flex flex-col mt-8">
							<label class="font-semibold leading-none text-gray-300">Creative Images</label>
							<div class='flex items-center justify-center w-full mt-4'>
								<label class='flex flex-col border-4 border-dashed w-full h-32 text-white bg-gray-800 hover:bg-gray-700 hover:border-blue-500 group'>
									<div class='flex flex-col items-center justify-center pt-7' v-if="!creatives.length">
										<svg class="w-10 h-10 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
										<p class='lowercase text-sm text-gray-400  pt-1 tracking-wider'>Select one or more photos</p>
									</div>
									<div class='flex flex-col items-center justify-center pt-7' v-else>
										<svg class="w-10 h-10 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
										<p class='lowercase text-sm text-gray-400  pt-1 tracking-wider'>{{ creatives.length }} selected</p>
									</div>
									<input type='file' @change="handleFileUpload($event)" class="hidden" multiple/>
								</label>
							</div>
						</div>
					</div>

					<div class="my-8 text-red-600">
						<p v-if="errors.length">
							<ul>
								<li v-for="(error, index) in errors" :key="index">
									<b>- {{ error }}</b>
								</li>
							</ul>
						</p>
					</div>
					<div class="flex items-center justify-center w-full">
						<button class="mt-9 font-semibold leading-none text-white py-4 px-10 bg-blue-700 rounded hover:bg-blue-600 focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:outline-none">
							Create
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import moment from 'moment';
import axios from 'axios';

export default {
	components: { DatePicker },
    data() {
		return {
			name: 'Good News',
			// dateFrom: null,
			// dateTo: null,
			// totalBudget: 0,
			// dailyBudget: 0,
			dateFrom: "2021-11-23",
			dateTo: "2021-11-27",
			totalBudget: 5000,
			dailyBudget: 400,
			pastDate: (date) => {
				return moment(date).isBefore(moment().format('YYYY MM DD'));
			},
			creatives: [],
			errors: [],
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

		handleFileUpload: function(event) {
			this.creatives = event.target.files;
		}
	},
	props: {
		id: {
			type: Number,
			required: false
		}
	},
	mounted() {
	}
}
</script>

<style scoped>
.mx-datepicker {
	width: 100%;
}
</style>