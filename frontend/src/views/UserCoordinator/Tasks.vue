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
            responsibles: [],
            search: null,
            loading: false,
            selectedTask: {
                uuid: null,
                description: {
                    value: null,
                    validation: null
                },
                responsible_uuid: {
                    value: null,
                    validation: null
                }
            }
        }
    },

    methods: {
        getTasks() {
            this.loading = true;
            this.axios.get('/api/coordinator/tasks', {
                params: {
                    'search': this.search
                }
            }).then(response => {
                this.loading = false;
                this.tasks = response.data;
            });
        },

        getResponsibles() {
            this.axios.get('/api/coordinator/responsibles')
            .then(response => {
                this.responsibles = response.data;
            }).catch(error => {
                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    timer: 5000,
                    timerProgressBar: true,
                    icon: 'error',
                    title: error.data.message,
                    showConfirmButton: false,
                });
            });
        },

        createTask() {
            this.axios.post('/api/coordinator/tasks/store', {
                'description': this.selectedTask.description.value,
                'responsible_uuid': this.selectedTask.responsible_uuid.value
            }).then(response => {
                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    timer: 5000,
                    timerProgressBar: true,
                    icon: 'success',
                    title: 'Task created with success!',
                    showConfirmButton: false,
                });
                this.resetSelectedTask();
                this.getTasks();
            }).catch(error => {
                this.selectedTask.description.validation = null;
                this.selectedTask.responsible_uuid.validation = null;
                Object.keys(error.response.data.errors).forEach((key) => {
                    this.selectedTask[key].validation = error.response.data.errors[key][0];
                });
            });
        },

        updateTask() {
            this.axios.put('/api/coordinator/tasks/update', {
                'uuid': this.selectedTask.uuid,
                'description': this.selectedTask.description.value
            }).then(response => {
                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    timer: 5000,
                    timerProgressBar: true,
                    icon: 'success',
                    title: 'Task updated with success!',
                    showConfirmButton: false,
                });
                this.resetSelectedTask();
                this.getTasks();
            }).catch(error => {
                console.log(error.response.data.message);
            });
        },

        resetSelectedTask() {
            this.selectedTask = {
                uuid: null,
                description: {
                    value: null,
                    validation: null
                },
                responsible_uuid: {
                    value: null,
                    validation: null
                }
            };
        },

        setSelectedTask(index) {
            this.selectedTask = {
                uuid: this.tasks[index].uuid,
                description: {
                    value: this.tasks[index].description,
                    validation: null
                },
                responsible_uuid: {
                    value: this.tasks[index].responsible.uuid,
                    validation: null
                }
            };
        },

        taskStatus(type) {
            switch (type) {
                case 1:
                    return 'Pending';
                case 2:
                    return 'Progress';
                case 3:
                    return 'Stopped';
                default:
                    return 'Completed';
            }
        }
    },

    mounted() {
        this.getTasks();
        this.getResponsibles();
    },
}
</script>

<template>
    <div>
        <div class="d-flex justify-content-between gap-2 mb-3">
            <button class="btn btn-indigo rounded-3 text-decoration-none" data-bs-toggle="modal" data-bs-target="#createTask" @click="resetSelectedTask()">
                <div class="d-flex gap-1">
                    <svg height="20px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path fill="currentColor" d="M224 128a8 8 0 0 1-8 8h-80v80a8 8 0 0 1-16 0v-80H40a8 8 0 0 1 0-16h80V40a8 8 0 0 1 16 0v80h80a8 8 0 0 1 8 8Z"/></svg>
                    <div class="d-none d-md-inline-block">Add Task</div>
                </div>
            </button>
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
                        <th class="align-middle px-3 d-none d-sm-table-cell">Responsible</th>
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
                        <td class="align-middle px-3 d-none d-sm-table-cell">{{ task.responsible.name}}</td>
                        <td class="align-middle px-3 d-none d-md-table-cell">{{ task.creator.name }}</td>
                        <td class="align-middle px-3 d-none d-lg-table-cell">{{ taskStatus(task.status) }}</td>

                        <td class="align-center p-3">
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#" class="text-dark" data-bs-toggle="modal" data-bs-target="#updateTask" @click="setSelectedTask(index)">
                                    <svg height="20px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5L2 22l1.5-5.5L17 3z"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr v-else>
                        <td colspan="5" class="text-center align-center text-indigo">Nothing was found</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <form class="modal fade" id="createTask" tabindex="-1" aria-labelledby="createTaskLabel" aria-hidden="true" @submit.prevent="createTask()">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createTaskLabel">Add Task</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <input v-model="this.selectedTask.description.value" type="text" class="form-control" :class="{'is-invalid': this.selectedTask.description.validation}" placeholder="Name">
                                <div class="invalid-feedback">
                                    {{ this.selectedTask.description.validation }}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <select v-model="this.selectedTask.responsible_uuid.value" class="form-control" :class="{'is-invalid': this.selectedTask.responsible_uuid.validation}">
                                    <option v-for="(responsible, index) in this.responsibles" :value="responsible.uuid" :key="index">
                                        {{ responsible.name }}
                                    </option>
                                </select>
                                <div class="invalid-feedback">
                                    {{ this.selectedTask.responsible_uuid.validation }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-indigo rounded-3 text-decoration-none" @click.prevent="createTask()">
                            <div class="d-flex gap-1">
                                <svg height="20px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path fill="currentColor" d="M224 128a8 8 0 0 1-8 8h-80v80a8 8 0 0 1-16 0v-80H40a8 8 0 0 1 0-16h80V40a8 8 0 0 1 16 0v80h80a8 8 0 0 1 8 8Z"/></svg>
                                <div class="d-none d-md-inline-block">Add Task</div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <form class="modal fade" id="updateTask" tabindex="-1" aria-labelledby="updateTaskLabel" aria-hidden="true" @submit.prevent="updateTask()">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateTaskLabel">Add Task</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <input v-model="this.selectedTask.description.value" type="text" class="form-control" :class="{'is-invalid': this.selectedTask.description.validation}" placeholder="Name">
                                <div class="invalid-feedback">
                                    {{ this.selectedTask.description.validation }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-indigo rounded-3 text-decoration-none" @click.prevent="updateTask()">
                            <div class="d-flex gap-1">
                                <svg height="20px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path fill="currentColor" d="M224 128a8 8 0 0 1-8 8h-80v80a8 8 0 0 1-16 0v-80H40a8 8 0 0 1 0-16h80V40a8 8 0 0 1 16 0v80h80a8 8 0 0 1 8 8Z"/></svg>
                                <div class="d-none d-md-inline-block">Add Task</div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>