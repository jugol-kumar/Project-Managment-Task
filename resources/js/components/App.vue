<script setup>
import {onMounted, ref} from 'vue';
import CreateProject from './CreateProject.vue';
import ProjectList from './ProjectList.vue';

const activeTab = ref('list');
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <header class="bg-white shadow mb-12">
            <div
                class="max-w-7xl mx-auto flex justify-between items-center py-6 px-4 sm:px-6 lg:px-8 bg-white shadow rounded-lg">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Projects
                </h2>

                <div class="flex space-x-2">
                    <!-- Project List Tab -->
                    <button
                        @click="activeTab = 'list'"
                        :class="activeTab === 'list'
                            ? 'bg-blue-500 text-white'
                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-medium transition"
                    >
                        Project List
                    </button>

                    <!-- Create Project Tab -->
                    <button
                        @click="activeTab = 'create'"
                        :class="activeTab === 'create'
                            ? 'bg-blue-500 text-white'
                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-medium transition"
                    >
                        Create Project
                    </button>
                </div>
            </div>
        </header>
        <main>
            <div v-show="activeTab === 'create'">
                <CreateProject/>
            </div>
            <div v-show="activeTab === 'list'">
                <ProjectList/>
            </div>
        </main>
    </div>
</template>

<style scoped>
[v-cloak] > * {
    display: none
}

[v-cloak]::before {
    content: "loading...";
    display: block;
}
</style>
