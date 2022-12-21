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
            users: [],
            selectedUuid: null,
            search: null,
            loading: false,

            selectedUser: {
                uuid: null,
                name: {
                    value: null,
                    validation: null
                },
                email: {
                    value: null,
                    validation: null
                },
                password: {
                    value: null,
                    validation: null
                },
                password_confirmation: {
                    value: null,
                    validation: null
                },
                type: {
                    value: null,
                    validation: null
                }
            }
        }
    },

    methods: {
        getUsers() {
            this.loading = true;
            this.axios.get('/api/admin/users', {
                params: {
                    'uuid': this.user.uuid,
                    'search': this.search
                }
            }).then(response => {
                this.loading = false;
                this.users = response.data;
            });
        },

        createUser() {
            this.axios.post('/api/admin/users/store', {
                'name': this.selectedUser.name.value,
                'email': this.selectedUser.email.value,
                'password': this.selectedUser.password.value,
                'password_confirmation': this.selectedUser.password_confirmation.value,
                'type': this.selectedUser.type.value
            }).then(response => {
                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    timer: 5000,
                    timerProgressBar: true,
                    icon: 'success',
                    title: 'User created with success!',
                    showConfirmButton: false,
                });
                this.resetSelectedUser();
                this.getUsers();
            }).catch(error => {
                this.selectedUser.name.validation = null;
                this.selectedUser.email.validation = null;
                this.selectedUser.password.validation = null;
                this.selectedUser.password_confirmation.validation = null;
                this.selectedUser.type.validation = null;
                Object.keys(error.response.data.errors).forEach((key) => {
                    this.selectedUser[key].validation = error.response.data.errors[key][0];
                });
            })
        },

        updateUser() {
            console.log(this.selectedUser.uuid);
            this.axios.put('/api/admin/users/update', {
                'uuid': this.selectedUser.uuid,
                'name': this.selectedUser.name.value,
                'email': this.selectedUser.email.value,
                'type': this.selectedUser.type.value
            }).then(response => {
                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    timer: 5000,
                    timerProgressBar: true,
                    icon: 'success',
                    title: 'User updated with success!',
                    showConfirmButton: false,
                });
                this.resetSelectedUser();
                this.getUsers();
            }).catch(error => {
                this.selectedUser.name.validation = null;
                this.selectedUser.email.validation = null;
                this.selectedUser.type.validation = null;
                Object.keys(error.response.data.errors).forEach((key) => {
                    this.selectedUser[key].validation = error.response.data.errors[key][0];
                });
            })
        },

        deleteUser(index) {
            this.axios.delete('/api/admin/users/destroy', {
                params: {
                    'uuid': this.users[index].uuid
                }
            }).then(response => {
                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    timer: 5000,
                    timerProgressBar: true,
                    icon: 'success',
                    title: 'User deleted with sucess!',
                    showConfirmButton: false,
                });
                this.getUsers();
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
            })
        },

        userType(type) {
            switch (type) {
                case 1:
                    return 'Admin';
            
                case 2:
                    return 'Coordinator';
                default:
                    return 'Responsible'
            }
        },

        resetSelectedUser() {
            this.selectedUser = {
                uuid: null,
                name: {
                    value: null,
                    validation: null
                },
                email: {
                    value: null,
                    validation: null
                },
                password: {
                    value: null,
                    validation: null
                },
                password_confirmation: {
                    value: null,
                    validation: null
                },
                type: {
                    value: null,
                    validation: null
                }
            };
        },

        setSelectedUser(index) {
            this.selectedUser = {
                uuid: this.users[index].uuid,
                name: {
                    value: this.users[index].name,
                    validation: null
                },
                email: {
                    value: this.users[index].email,
                    validation: null
                },
                password: {
                    value: null,
                    validation: null
                },
                password_confirmation: {
                    value: null,
                    validation: null
                },
                type: {
                    value: this.users[index].type,
                    validation: null
                }
            };
        }
    },

    mounted() {
        this.getUsers();
    },
}
</script>

<template>
    <div>
        <div class="d-flex justify-content-between gap-2 mb-3">
            <button class="btn btn-indigo rounded-3 text-decoration-none" data-bs-toggle="modal" data-bs-target="#createUser" @click="resetSelectedUser()">
                <div class="d-flex gap-1">
                    <svg height="20px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path fill="currentColor" d="M224 128a8 8 0 0 1-8 8h-80v80a8 8 0 0 1-16 0v-80H40a8 8 0 0 1 0-16h80V40a8 8 0 0 1 16 0v80h80a8 8 0 0 1 8 8Z"/></svg>
                    <div class="d-none d-md-inline-block">Add User</div>
                </div>
            </button>
            <form class="input-group w-fit-content" @submit.prevent="getUsers()">
                <input v-model="this.search" type="text" class="form-control border-end-0" placeholder="search">
                <button class="btn btn-addon border-start-0 d-flex align-items-center" type="button" @click.prevent="getUsers()">
                    <svg height="20px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 12 12"><path fill="currentColor" d="M5 1a4 4 0 1 0 2.452 7.16l2.694 2.693a.5.5 0 1 0 .707-.707L8.16 7.453A4 4 0 0 0 5 1ZM2 5a3 3 0 1 1 6 0a3 3 0 0 1-6 0Z"/></svg>
                </button>
            </form>
        </div>

        <div class="border rounded-3">

            <table class="table table-rounded table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="align-middle px-3">Name</th>
                        <th class="align-middle px-3 d-none d-sm-table-cell">E-mail</th>
                        <th class="align-middle px-3 d-none d-md-table-cell">Status</th>
                        <th class="align-middle px-3 d-none d-lg-table-cell">Type</th>
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
                    <tr v-for="(user, index) in users" :key="index" v-else-if="this.users.length">
                        <td class="align-middle px-3">{{ user.name }}</td>
                        <td class="align-middle px-3 d-none d-sm-table-cell">{{ user.email}}</td>
                        <td class="align-middle px-3 d-none d-md-table-cell">{{ user.inactivated_at ? 'Inactive' : 'Active' }}</td>
                        <td class="align-middle px-3 d-none d-lg-table-cell">{{ userType(user.type) }}</td>

                        <td class="align-center p-3">
                            <div class="d-flex justify-content-center gap-3">
                                <svg @click="deleteUser(index)" class="cursor-pointer" height="20px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18m-2 0v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6m3 0V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2m-6 5v6m4-6v6"/></svg>
                                <a href="#" class="text-dark" data-bs-toggle="modal" data-bs-target="#updateUser" @click="setSelectedUser(index)">
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

        <form class="modal fade" id="createUser" tabindex="-1" aria-labelledby="createUserLabel" aria-hidden="true" @submit.prevent="createUser()">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createUserLabel">Add User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <input v-model="this.selectedUser.name.value" type="text" class="form-control" :class="{'is-invalid': this.selectedUser.name.validation}" placeholder="Name">
                                <div class="invalid-feedback">
                                    {{ this.selectedUser.name.validation }}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input v-model="this.selectedUser.email.value" type="text" class="form-control" :class="{'is-invalid': this.selectedUser.email.validation}" placeholder="E-mail">
                                <div class="invalid-feedback">
                                    {{ this.selectedUser.email.validation }}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input v-model="this.selectedUser.password.value" type="text" class="form-control" :class="{'is-invalid': this.selectedUser.password.validation}" placeholder="Password">
                                <div class="invalid-feedback">
                                    {{ this.selectedUser.password.validation }}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input v-model="this.selectedUser.password_confirmation.value" type="text" class="form-control" :class="{'is-invalid': this.selectedUser.password_confirmation.validation}" placeholder="Password confirmation">
                                <div class="invalid-feedback">
                                    {{ this.selectedUser.password_confirmation.validation }}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <select v-model="this.selectedUser.type.value" class="form-control" :class="{'is-invalid': this.selectedUser.type.validation}">
                                    <option value="1" selected="selected">Admin</option>
                                    <option value="2">Coordinator</option>
                                    <option value="3">Responsible</option>
                                </select>
                                <div class="invalid-feedback">
                                    {{ this.selectedUser.type.validation }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-indigo rounded-3 text-decoration-none" @click.prevent="createUser()">
                            <div class="d-flex gap-1">
                                <svg height="20px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path fill="currentColor" d="M224 128a8 8 0 0 1-8 8h-80v80a8 8 0 0 1-16 0v-80H40a8 8 0 0 1 0-16h80V40a8 8 0 0 1 16 0v80h80a8 8 0 0 1 8 8Z"/></svg>
                                <div class="d-none d-md-inline-block">Add User</div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <form class="modal fade" id="updateUser" tabindex="-1" aria-labelledby="updateUserLabel" aria-hidden="true" @submit.prevent="updateUser()">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateUserLabel">Update User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <input v-model="this.selectedUser.name.value" type="text" class="form-control" :class="{'is-invalid': this.selectedUser.name.validation}" placeholder="Name">
                                <div class="invalid-feedback">
                                    {{ this.selectedUser.name.validation }}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input v-model="this.selectedUser.email.value" type="text" class="form-control" :class="{'is-invalid': this.selectedUser.email.validation}" placeholder="E-mail">
                                <div class="invalid-feedback">
                                    {{ this.selectedUser.email.validation }}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <select v-model="this.selectedUser.type.value" class="form-control" :class="{'is-invalid': this.selectedUser.type.validation}">
                                    <option value="1" selected="selected">Admin</option>
                                    <option value="2">Coordinator</option>
                                    <option value="3">Responsible</option>
                                </select>
                                <div class="invalid-feedback">
                                    {{ this.selectedUser.type.validation }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-indigo rounded-3 text-decoration-none" @click.prevent="updateUser()">
                            <div class="d-flex gap-1">
                                <svg height="20px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path fill="currentColor" d="M224 128a8 8 0 0 1-8 8h-80v80a8 8 0 0 1-16 0v-80H40a8 8 0 0 1 0-16h80V40a8 8 0 0 1 16 0v80h80a8 8 0 0 1 8 8Z"/></svg>
                                <div class="d-none d-md-inline-block">Update User</div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>