<script>
import { HalfCircleSpinner } from 'epic-spinners'
export default {
    components: {
        HalfCircleSpinner: HalfCircleSpinner
    }
}
</script>

<template>
    <div>
        <HalfCircleSpinner
            class="m-auto"
            :animation-duration="1000"
            :size="100"
            color="currentColor"
        />
    </div>
</template>