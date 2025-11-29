<template>
    <div class="min-h-screen bg-gray-100">
        <header class="bg-white shadow mb-12">
            <div class="max-w-7xl mx-auto flex justify-between items-center py-6 px-4 sm:px-6 lg:px-8 bg-white shadow rounded-lg">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Tasks
                </h2>
            </div>
        </header>

        <main>
            <div class="bg-white shadow rounded-lg p-6 max-w-7xl mx-auto">
                <h2 class="text-2xl font-semibold mb-6">Task List</h2>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(task, index) in tasks" :key="task.id" class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ task.title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ task.project.title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ formatDate(task.deadline) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    :class="{
                                      'bg-green-100 text-green-800': task.status === 'completed',
                                      'bg-yellow-100 text-yellow-800': task.status === 'pending',
                                      'bg-blue-100 text-blue-800': task.status === 'active'
                                    }"
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
                                >
                                  {{ task.status }}
                                </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Buttons -->
                <div class="mt-4 flex justify-end space-x-2">
                    <button
                        @click="fetchProjects(prevPageUrl)"
                        :disabled="!prevPageUrl"
                        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 disabled:opacity-50"
                    >
                        Previous
                    </button>
                    <button
                        @click="fetchProjects(nextPageUrl)"
                        :disabled="!nextPageUrl"
                        class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600 disabled:opacity-50"
                    >
                        Next
                    </button>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";

const tasks = ref([])
const nextPageUrl = ref(null)
const prevPageUrl = ref(null)

// Fetch tasks from API
const fetchProjects = async (url = '/api/user-tasks') => {
    try {
        const response = await axios.get(url)
        tasks.value = response.data.data
        nextPageUrl.value = response.data.next_page_url
        prevPageUrl.value = response.data.prev_page_url
    } catch (error) {
        console.error(error)
        alert('Failed to load tasks.')
    }
}

// Format date
const formatDate = (dateString) => {
    if (!dateString) return '-'
    const options = { year: 'numeric', month: 'short', day: 'numeric' }
    return new Date(dateString).toLocaleDateString(undefined, options)
}

onMounted(() => fetchProjects())
</script>

<style scoped>
tbody tr { transition: background-color 0.2s; }
</style>
