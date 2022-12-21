<script>
import Users from './UserAdmin/Users.vue';
export default {
    components: {
        Users: Users
    },

    props: {
        user: {
            type: Object,
            required: true
        }
    }
    
}
</script>

<template>
    <div>
        <Users :user="this.user" />
    </div>
</template>