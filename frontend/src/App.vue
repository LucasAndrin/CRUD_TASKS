<script>
import Loading from './components/Loading.vue';
import Layout from './Layout.vue';
export default {
    components: {
        Loading: Loading,
        Layout: Layout
    },

    data() {
        return {
            loading: true,
            authenticated: false,
            user: null
        }
    },

    methods: {
        checkLogin() {
            if (this.token()) {
                this.login();
            } else {
                this.$router.push({name: 'Authentication'});
                this.loading = false;
            }
        },

        token() {
            return localStorage.getItem('access_token');
        },

        login() {
            this.axios.defaults.headers['Authorization'] = `Bearer ${this.token()}`;
                this.axios.get('/api/auth', ).then(response => {
                this.user = response.data;
                this.loading = false;
                this.authenticated = true;
                this.$router.push('/');
            });
        },

        logout() {
            this.axios.post('/api/logout').then(reponse => {
                localStorage.removeItem('access_token');
                location.reload();
            });
        }
    },

    mounted() {
        this.checkLogin();
    },
}
</script>

<template>
    <div>
        <Loading v-if="this.loading" class="d-flex text-indigo vh-100"/>

        <RouterView v-else-if="!this.loading && !this.authenticated" @authenticated="checkLogin()"/>

        <Layout :user="this.user" v-else/>
    </div>
</template>