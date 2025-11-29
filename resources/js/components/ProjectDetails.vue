<template>
    <!-- Root div with click.stop -->
    <div @click.stop class="mt-6 bg-white shadow rounded-lg p-6 max-w-7xl mx-auto border border-gray-200">

        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800">{{ project.title }}</h2>
            <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Project Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-gray-500 font-semibold">Client</p>
                <p class="text-gray-800">{{ project.client }}</p>
            </div>
            <div>
                <p class="text-gray-500 font-semibold">Dates</p>
                <p class="text-gray-800">{{ project.start_date }} - {{ project.end_date }}</p>
            </div>
            <div>
                <p class="text-gray-500 font-semibold">Status</p>
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
            </div>
            <div>
                <p class="text-gray-500 font-semibold">Tasks Count</p>
                <p class="text-gray-800">{{ tasks.length }}</p>
            </div>
            <div>
                <p class="text-gray-500 font-semibold">Created At</p>
                <p class="text-gray-800">{{ formatDate(project.created_at) }}</p>
            </div>
            <div>
                <p class="text-gray-500 font-semibold">Updated At</p>
                <p class="text-gray-800">{{ formatDate(project.updated_at) }}</p>
            </div>
        </div>

        <!-- Optional Description / Notes -->
        <div v-if="project.description" class="mb-6">
            <p class="text-gray-500 font-semibold mb-1">Description</p>
            <p class="text-gray-800">{{ project.description }}</p>
        </div>

        <!-- Add Task Form -->
        <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h3 class="text-lg font-semibold mb-2">Assign New Task</h3>
            <form @submit.prevent="submitTask" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Task Title</label>
                    <input v-model="newTask.title" type="text" placeholder="Task title"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"/>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Deadline</label>
                    <input v-model="newTask.deadline" type="date"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"/>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Assigned User</label>
                    <select v-model="newTask.assigned_user"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option disabled value="">Select user</option>
                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select v-model="newTask.status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="md:col-span-4">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        Add Task
                    </button>
                </div>
            </form>
        </div>

        <!-- Tasks Table -->
        <div>
            <h3 class="text-lg font-semibold mb-2">Tasks</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(task, index) in tasks" :key="task.id" class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ task.title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ task.deadline }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ task.assigned_user?.name }}</td>
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
        </div>

        <!-- Footer / Close -->
        <div class="mt-6 flex justify-end space-x-2">
            <button @click="$emit('close')"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
                Close
            </button>
        </div>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
    project: { type: Object, required: true }
})

const tasks = ref([])
const users = ref([])
const newTask = ref({
    title: '',
    deadline: '',
    assigned_user: '',
    status: 'pending'
})

// Fetch tasks
const fetchTasks = async () => {
    try {
        axios.get('/sanctum/csrf-cookie')
        const res = await axios.get(`/api/projects/${props.project.id}/tasks`)
        tasks.value = res.data
    } catch (err) {
        console.error(err)
    }
}

// Fetch users
const fetchUsers = async () => {
    try {
        const res = await axios.get('/api/users')
        users.value = res.data
    } catch (err) {
        console.error(err)
        alert('Failed to load users.')
    }
}

// Submit new task
const submitTask = async () => {
    if (!newTask.value.title || !newTask.value.assigned_user) {
        alert('Please fill all fields.')
        return
    }
    try {
        await axios.post(`/api/projects/${props.project.id}/tasks`, newTask.value)
        alert('Task added successfully!')
        newTask.value = { title: '', deadline: '', assigned_user: '', status: 'pending' }
        await fetchTasks()
    } catch (err) {
        console.error(err)
    }
}

// Format date
const formatDate = (dateString) => {
    if (!dateString) return '-'
    const options = { year: 'numeric', month: 'short', day: 'numeric' }
    return new Date(dateString).toLocaleDateString(undefined, options)
}

onMounted(() => {
    fetchTasks()
    fetchUsers()
})
</script>

<style scoped>
tbody tr { transition: background-color 0.2s; }
</style>
