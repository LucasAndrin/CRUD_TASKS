<script>
export default {

    props: {
        user: {
            type: Object,
            required: true
        }
    },

    methods: {
        logout() {
            this.$emit('logout');
        }
    },
    
}
</script>

<template>
    <main class="main-pd" id="main-pd">
        <nav class="navbar-top position-fixed start-0 top-0 w-100 d-flex justify-content-between align-items-center bg-white main-pd" id="navbar-top">
            <div class="d-flex justify-content-start align-items-center">
                <svg class="cursor-pointer text-indigo" height="24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 36 36"><path fill="currentColor" d="M32 29H4a1 1 0 0 1 0-2h28a1 1 0 0 1 0 2Z" class="clr-i-outline clr-i-outline-path-1"/><path fill="currentColor" d="M32 19H4a1 1 0 0 1 0-2h28a1 1 0 0 1 0 2Z" class="clr-i-outline clr-i-outline-path-2"/><path fill="currentColor" d="M32 9H4a1 1 0 0 1 0-2h28a1 1 0 0 1 0 2Z" class="clr-i-outline clr-i-outline-path-3"/><path fill="none" d="M0 0h36v36H0z"/></svg>
                <div class="ps-4 fs-4 fw-semibold">{{ $route.name }}</div>
            </div>
        </nav>
    
        <div class="sidebar pt-md-2 pt-1 pe-md-1 pe-2 pb-2 h-100 bg-white border-end sidebar-show" id="sidebar">
            <nav class="nav d-flex flex-column justify-content-between h-100 overflow-hidden">
                <div>
                    <a href="#" class="d-flex justify-content-md-center nav-link text-indigo px-md-3 ps-0">
                        <svg class="w-50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" fill="currentColor"><g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path fill="none" stroke-dasharray="66" stroke-dashoffset="66" stroke-width="2" d="M3 14V5H21V19H3V14"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="66;0"/></path><path fill="currentColor" fill-opacity="0" stroke-dasharray="52" stroke-dashoffset="52" d="M3 16L7 13L10 15L16 10L21 14V19H3Z"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.6s" dur="0.8s" values="52;0"/><animate fill="freeze" attributeName="fill-opacity" begin="1s" dur="0.15s" values="0;0.3"/></path></g><circle cx="7.5" cy="9.5" r="1.5" fill="currentColor" fill-opacity="0"><animate fill="freeze" attributeName="fill-opacity" begin="1s" dur="0.4s" values="0;1"/></circle></svg>
                    </a>

                    <RouterLink to="/" class="d-flex align-items-center gap-3 nav-link text-indigo text-decoration-none mb-2 ps-4 pt-2 pl-2">
                        <svg height="20px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path fill="currentColor" d="M208 224h-48a16 16 0 0 1-16-16v-48h-32v48a16 16 0 0 1-16 16H48a16 16 0 0 1-16-16v-92.5a16 16 0 0 1 5.2-11.8l80-72.7a16 16 0 0 1 21.6 0l80 72.7a16 16 0 0 1 5.2 11.8V208a16 16 0 0 1-16 16Zm-96-80h32a16 16 0 0 1 16 16v48h48v-92.5l-80-72.7l-80 72.7V208h48v-48a16 16 0 0 1 16-16Z"/></svg>
                        <span class="nav_name">Home</span>
                    </RouterLink>
        
                </div>
                
                <a href="#" class="d-flex align-items-center gap-3 nav-link text-indigo text-decoration-none ps-4 pt-2 pl-2" @click="logout()">
                    <svg height="20px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M20.968 18.448a2.577 2.577 0 0 1-2.73 2.5c-2.153.012-4.306 0-6.459 0a.5.5 0 0 1 0-1c2.2 0 4.4.032 6.6 0c1.107-.016 1.589-.848 1.589-1.838V5.647A1.546 1.546 0 0 0 19 4.175a3.023 3.023 0 0 0-1.061-.095h-6.16a.5.5 0 0 1 0-1c2.224 0 4.465-.085 6.687 0a2.567 2.567 0 0 1 2.5 2.67Z"/><path fill="currentColor" d="M3.176 11.663a.455.455 0 0 0-.138.311c0 .015 0 .028-.006.043s0 .027.006.041a.457.457 0 0 0 .138.312l3.669 3.669a.5.5 0 0 0 .707-.707l-2.815-2.816h10.742a.5.5 0 0 0 0-1H4.737L7.552 8.7a.5.5 0 0 0-.707-.707Z"/></svg>
                    <span class="nav_name">SignOut</span>
                </a>
            </nav>
        </div>
        
        <RouterView class="container-fluid pt-3" :user="this.user"/>
    </main>
</template>