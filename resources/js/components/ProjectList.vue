<template>
    <div>
        <div v-if="selectedProject !== null">
            <ProjectDetails
                v-if="selectedProject"
                :project="selectedProject"
                @close="clearSelectedProjects"
            />        </div>
        <div v-else class="bg-white shadow rounded-lg p-6 max-w-7xl mx-auto">
            <h2 class="text-2xl font-semibold mb-6">Project List</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client & Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(project, index) in projects" :key="project.id" class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <div>
                                <p class="text-lg font-bold text-slate-700">{{ project.title }}</p>
                                <div class="font-semibold text-slate-500">Tasks: <span>{{ project.tasks_count }}</span></div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <div class="flex flex-col gap-1">
                                <p class="font-semibold text-slate-700">{{ project.client }}</p>
                                <p class="text-gray-500 text-sm">{{ project.start_date }} - {{ project.end_date }}</p>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
            <span
                :class="{
                'bg-green-100 text-green-800': project.status === 'completed',
                'bg-yellow-100 text-yellow-800': project.status === 'pending',
                'bg-blue-100 text-blue-800': project.status === 'active'
              }"
                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
            >
              {{ project.status }}
            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatDate(project.created_at) }}</td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 relative">
                            <button @click="toggleDropdown(project.id)" class="p-2 rounded-full hover:bg-gray-100 transition">
                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </button>

                            <div v-if="dropdownId === project.id" class="absolute right-0 mt-2 w-32 bg-white border rounded shadow-lg z-10">
                                <button @click="showProject(project)" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Show</button>
<!--                                <button @click="editProject(project)" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Edit</button>-->
                                <button @click="deleteProject(project.id)" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

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
    </div>
</template>

<script setup>
import axios from 'axios'
import { ref, onMounted } from 'vue'
import ProjectDetails from './ProjectDetails.vue'

const projects = ref([])
const nextPageUrl = ref(null)
const prevPageUrl = ref(null)

// Dropdown state
const dropdownId = ref(null)
const toggleDropdown = (id) => {
    dropdownId.value = dropdownId.value === id ? null : id
}

const selectedProject = ref(null)
const showProject = (project) => {
    selectedProject.value = project
    dropdownId.value = null
}
const clearSelectedProjects = () =>{
    fetchProjects()
    selectedProject.value = null
}

const editProject = (project) => {
    alert(`Edit project: ${project.title}`)
    dropdownId.value = null
}

const deleteProject = async (id) => {
    if (!confirm('Are you sure you want to delete this project?')) return
    try {
        await axios.delete(`/api/projects/${id}`)
        fetchProjects()
        alert('Project deleted.')
    } catch (error) {
        console.error(error)
        alert('Failed to delete project.')
    }
}

const fetchProjects = async (url = '/api/projects') => {
    try {
        const response = await axios.get(url, )
        projects.value = response.data.data
        nextPageUrl.value = response.data.next_page_url
        prevPageUrl.value = response.data.prev_page_url
    } catch (error) {
        console.error(error)
        alert('Failed to load projects.')
    }
}

onMounted(() => {
    fetchProjects()
})

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'short', day: 'numeric' }
    return new Date(dateString).toLocaleDateString(undefined, options)
}
</script>

<style scoped>
tbody tr {
    transition: background-color 0.2s;
}
</style>
