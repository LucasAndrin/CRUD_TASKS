<script>
import Users from './UserAdmin/Users.vue';
import Tasks from './UserCoordinator/Tasks.vue';
export default {
    components: {
        Users: Users,
        Tasks: Tasks
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
        <Users :user="this.user" v-if="user.type === 1" />
        <Tasks :user="this.user" v-if="user.type === 2" />
    </div>
</template>