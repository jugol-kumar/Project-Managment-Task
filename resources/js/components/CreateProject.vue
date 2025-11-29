<template>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-lg mt-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Create Project</h2>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Project Title</label>
                    <input
                        v-model="form.title"
                        type="text"
                        placeholder="Enter project title"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Client</label>
                    <input
                        v-model="form.client"
                        type="text"
                        placeholder="Client name"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input
                        v-model="form.start_date"
                        type="date"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input
                        v-model="form.end_date"
                        type="date"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select
                        v-model="form.status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>

            <button
                type="submit"
                class="mt-4 w-full md:w-auto bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition"
            >
                Save Project
            </button>
        </form>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import axios from 'axios'

const form = reactive({
    title: '',
    client: '',
    start_date: '',
    end_date: '',
    status: 'pending',
})

const submitForm = async () => {
    try {
        await axios.post('/api/projects', form)
        alert('Project Created!')
        form.title = ''
        form.client = ''
        form.start_date = ''
        form.end_date = ''
        form.status = 'pending'
    } catch (error) {
        console.error(error)
        alert('Failed to create project.')
    }
}
</script>
