<template>
    <div>
        <div class="flex flex-col flex-1 w-full overflow-y-auto">
            <main class="relative z-0 flex-1 pb-8 px-6 bg-white">
                <div class="grid pb-10 mt-4">
                    <!-- Start Content-->
                    <div class="mb-2">
                        <p class="text-lg font-semibold text-gray-400">
                            Campaigns
                        </p>
                    </div>
                    <div
                        class="
                            grid grid-cols-1
                            gap-2
                            sm:grid-cols-1
                            md:grid-cols-2
                            lg:grid-cols-2
                            xl:grid-cols-2
                            mt-3
                        "
                    >
                        <div
                            class="relative w-full h-52 bg-cover bg-center group rounded-lg overflow-hidden shadow-lg transition duration-300 ease-in-out"
                            style="
                                background-image: url('https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/f868ecef-4b4a-4ddf-8239-83b2568b3a6b/de7hhu3-3eae646a-9b2e-4e42-84a4-532bff43f397.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2Y4NjhlY2VmLTRiNGEtNGRkZi04MjM5LTgzYjI1NjhiM2E2YlwvZGU3aGh1My0zZWFlNjQ2YS05YjJlLTRlNDItODRhNC01MzJiZmY0M2YzOTcuanBnIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.R0h-BS0osJSrsb1iws4-KE43bUXHMFvu5PvNfoaoi8o');
                            "
                        >
                            <div
                                class="absolute inset-0 bg-pink-900 bg-opacity-75 transition duration-300 ease-in-out"
                            ></div>
                            <div
                                class="
                                    relative
                                    w-full
                                    h-full
                                    px-4
                                    sm:px-6
                                    lg:px-4
                                    flex
                                    items-center
                                    justify-center
									cursor-pointer
                                "
								@click="goToCreate"
                            >
                                <div>
                                    <h3 class="text-center text-white text-lg">
                                        Add New Campaign
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div
                            class="relative w-full h-52 bg-cover bg-center group rounded-lg overflow-hidden shadow-lg transition duration-300 ease-in-out"
                            style="
                                background-image: url('https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/f868ecef-4b4a-4ddf-8239-83b2568b3a6b/de7hhu3-3eae646a-9b2e-4e42-84a4-532bff43f397.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2Y4NjhlY2VmLTRiNGEtNGRkZi04MjM5LTgzYjI1NjhiM2E2YlwvZGU3aGh1My0zZWFlNjQ2YS05YjJlLTRlNDItODRhNC01MzJiZmY0M2YzOTcuanBnIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.R0h-BS0osJSrsb1iws4-KE43bUXHMFvu5PvNfoaoi8o');
                            "
                        >
                            <div class="absolute inset-0 bg-blue-900 bg-opacity-75 transition duration-300 ease-in-out"></div>
                            <div
                                class="
                                    relative
                                    w-full
                                    h-full
                                    px-4
                                    sm:px-6
                                    lg:px-4
                                    flex
                                    items-center
									justify-center
									cursor-pointer
                                "
								@click="goToList"
                            >
                                <div>
                                    <h3 class="text-center text-white text-lg">
                                        Show Campaigns
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End Content-->
                </div>
            </main>
        </div>
    </div>
</template>

<script>

export default {
	methods: {
		goToCreate: function() {
			this.$router.push('create');
		},

		goToList: function() {
			this.$router.push('list');
		}
	}
}
</script>
