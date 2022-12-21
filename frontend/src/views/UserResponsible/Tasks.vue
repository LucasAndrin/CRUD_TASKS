<script>
import { HalfCircleSpinner } from 'epic-spinners';
export default {
    components: {
        HalfCircleSpinner: HalfCircleSpinner
    },

    props: {
        user: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            tasks: [],
            search: null,
            loading: false
        }
    },

    methods: {
        getTasks() {
            this.loading = true;
            this.axios.get('/api/responsible/tasks', {
                params: {
                    'search': this.search
                }
            }).then(response => {
                this.loading = false;
                this.tasks = response.data;
            });
        },

        progressTask(index) {

        },

        pauseTask(index) {

        },

        completeTask(index) {

        },

        taskStatus(type) {
            switch (type) {
                case 1:
                    return 'Pending';
                case 2:
                    return 'Progress';
                case 3:
                    return 'Stoped';
                default:
                    return 'Completed';
            }
        }
    },

    mounted() {
        this.getTasks();
    },
    
}
</script>

<template>
    <div>
        <div class="d-flex justify-content-end gap-2 mb-3">
            <form class="input-group w-fit-content" @submit.prevent="getTasks()">
                <input v-model="this.search" type="text" class="form-control border-end-0" placeholder="search">
                <button class="btn btn-addon border-start-0 d-flex align-items-center" type="button" @click.prevent="getTasks()">
                    <svg height="20px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 12 12"><path fill="currentColor" d="M5 1a4 4 0 1 0 2.452 7.16l2.694 2.693a.5.5 0 1 0 .707-.707L8.16 7.453A4 4 0 0 0 5 1ZM2 5a3 3 0 1 1 6 0a3 3 0 0 1-6 0Z"/></svg>
                </button>
            </form>
        </div>

        <div class="border rounded-3">

            <table class="table table-rounded table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="align-middle px-3">Descript</th>
                        <th class="align-middle px-3 d-none d-md-table-cell">Coordinator</th>
                        <th class="align-middle px-3 d-none d-lg-table-cell">Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="this.loading">
                        <td colspan="5" class="p-5 align-middle text-indigo">
                            <HalfCircleSpinner
                                class="m-auto"
                                :animation-duration="1000"
                                :size="100"
                                color="currentColor"
                            />
                        </td>
                    </tr>
                    <tr v-for="(task, index) in this.tasks" :key="index" v-else-if="this.tasks.length">
                        <td class="align-middle px-3">{{ task.description }}</td>
                        <td class="align-middle px-3 d-none d-md-table-cell">{{ task.creator.name ? 'Inactive' : 'Active' }}</td>
                        <td class="align-middle px-3 d-none d-lg-table-cell">{{ taskStatus(task.status) }}</td>

                        <td class="align-center p-3">
                            <div class="d-flex justify-content-center gap-3">
                                <svg @click="progressTask(index)" v-show="taskStatus(task.status) == 'Pending' || taskStatus(task.status) == 'Stoped'" height="20px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path fill="currentColor" d="M80 232a15.5 15.5 0 0 1-7.8-2.1A15.8 15.8 0 0 1 64 216V40a15.8 15.8 0 0 1 8.2-13.9a15.5 15.5 0 0 1 16.1.3l144 87.9a16 16 0 0 1 0 27.4l-144 87.9A15.4 15.4 0 0 1 80 232Zm0-192v176l144-88Z"/></svg>
                                <svg @click="pauseTask(index)" v-show="taskStatus(task.status) == 'Progress'" height="20px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path fill="currentColor" d="M200 32h-36a16 16 0 0 0-16 16v160a16 16 0 0 0 16 16h36a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16Zm0 176h-36V48h36ZM92 32H56a16 16 0 0 0-16 16v160a16 16 0 0 0 16 16h36a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16Zm0 176H56V48h36Z"/></svg>
                                <svg @click="completeTask(index)" v-show="taskStatus(task.status) == 'Progress'" height="20px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path fill="currentColor" d="M104 192a8.5 8.5 0 0 1-5.7-2.3l-56-56a8.1 8.1 0 0 1 11.4-11.4l50.3 50.4L210.3 66.3a8.1 8.1 0 0 1 11.4 11.4l-112 112a8.5 8.5 0 0 1-5.7 2.3Z"/></svg>
                            </div>
                        </td>
                    </tr>
                    <tr v-else>
                        <td colspan="5" class="text-center align-center text-indigo">Nothing was found</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>