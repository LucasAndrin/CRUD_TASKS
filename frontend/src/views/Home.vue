<script>
import UserAdminUsers from './UserAdmin/Users.vue';
import UserCoordinatorTasks from './UserCoordinator/Tasks.vue';
import UserResponsibleTasks from './UserResponsible/Tasks.vue';
export default {
    components: {
        UserAdminUsers: UserAdminUsers,
        UserCoordinatorTasks: UserCoordinatorTasks,
        UserResponsibleTasks: UserResponsibleTasks
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
        <UserAdminUsers :user="this.user" v-if="user.type === 1" />
        <UserCoordinatorTasks :user="this.user" v-if="user.type === 2" />
        <UserResponsibleTasks :user="this.user" v-if="user.type === 3"/>
    </div>
</template>