<script>
import { HalfCircleSpinner } from 'epic-spinners';
export default {
    components: {
        HalfCircleSpinner: HalfCircleSpinner
    },

    data() {
        return {
            loading: false,
            page: true,
            name: {
                value: null,
                validation: null,
            },
            email: {
                value: null,
                validation: null,
            },
            password: {
                value: null,
                validation: null,
            },
            passwordConfirmation: {
                value: null,
                validation: null,
            }
        }
    },

    methods: {
        togglePage() {
            this.page = !this.page
        },

        submit() {
            let url, params;
            if (this.page) {
                url = 'login';
                params = {
                    'email': this.email.value,
                    'password': this.password.value
                }
            } else {
                url = 'register';
                params = {
                    'name': this.name.value,
                    'email': this.email.value,
                    'password': this.password.value,
                    'password_confirmation': this.passwordConfirmation.value
                }
            }

            this.loading = true;
            this.axios.post(`/api/${url}`, params).then(response => {
                this.loading = false;
                localStorage.setItem('access_token', response.data.token);
                this.$emit('authenticated');
            }).catch(error => {
                this.loading = false;
                this.email.validation = null;
                this.password.validation = null;
                this.passwordConfirmation.validation = null;
                Object.keys(error.response.data.errors).forEach((key) => {
                    this[key].validation = error.response.data.errors[key][0];
                });
            });
        }
    },
}
</script>

<template>
    <div class="container-fluid">
        <div class="col-md-4 col-sm-10 rounded-4 mx-auto bg-white shadow mt-5">
            <div class="p-5 position-relative">

                <div class="d-flex align-items-bottom mb-3">
                    <div class="d-flex fs-1 align-middle mb-3">{{ this.page ? 'Sign In' : 'Sign Up' }}</div>
                </div>

                <form @submit.prevent="submit()">
                    <div class="mb-3" v-show="!this.page">
                        <label for="name" class="form-label">Name</label>
                        <input v-model="this.name.value" type="name" class="form-control" :class="{'is-invalid': this.name.validation}" id="name">
                        <div class="invalid-feedback">
                            {{ this.name.validation }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input v-model="this.email.value" type="email" class="form-control" :class="{'is-invalid': this.email.validation}" id="email">
                        <div class="invalid-feedback">
                            {{ this.email.validation }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input v-model="this.password.value" type="password" class="form-control" :class="{'is-invalid': this.password.validation}" id="password">
                        <div class="invalid-feedback">
                            {{ this.password.validation }}
                        </div>
                    </div>
                    <div class="mb-3" v-show="!this.page">
                        <label for="passwordConfirmation" class="form-label">Password Confirmation</label>
                        <input v-model="this.passwordConfirmation.value" type="password" class="form-control" :class="{'is-invalid': this.passwordConfirmation.validation}" id="passwordConfirmation">
                        <div class="invalid-feedback">
                            {{ this.passwordConfirmation.validation }}
                        </div>
                    </div>
                    <button type="submit" class="btn btn-indigo form-control mb-3" @click.prevent="submit()">
                        <HalfCircleSpinner
                            v-if="this.loading"
                            class="m-auto"
                            :animation-duration="1000"
                            :size="25"
                            color="currentColor"
                        />
                        <svg v-else xmlns="http://www.w3.org/2000/svg" height="20px" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path fill="currentColor" d="M223.4 114L54.9 19.7a16.3 16.3 0 0 0-18.2 1.2a15.9 15.9 0 0 0-5.1 17.9l28.1 78.5a4.1 4.1 0 0 0 3.8 2.7h72.2a8.2 8.2 0 0 1 8.3 7.5a8 8 0 0 1-8 8.5H63.5a4.1 4.1 0 0 0-3.8 2.7l-28.1 78.5a16.1 16.1 0 0 0 15.1 21.4a16.5 16.5 0 0 0 7.8-2L223.4 142a16.1 16.1 0 0 0 0-28Z"/></svg>
                    </button>
                    <a class="cursor-pointer text-decoration-none" @click="togglePage()">{{ this.page ? 'Sign Up' : 'Sign In' }}</a>
                </form>

            </div>
        </div>
    </div>
</template>