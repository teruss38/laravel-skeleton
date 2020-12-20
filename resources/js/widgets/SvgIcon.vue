<template>
    <svg class="icon" aria-hidden="true">
        <use :xlink:href="iconName"></use>
    </svg>
</template>

<script>
    export default {
        name: 'svg-icon',
        props: {
            icon: {
                type: String,
                required: true
            },
        },
        computed: {
            iconName() {
                return `#${this.icon}`
            }
        }
    }
</script>

<style scoped>
    .icon {
        width: 1.1em;
        height: 1.1em;
        vertical-align: -0.15em;
        fill: currentColor;
        overflow: hidden;
        padding-right: 0.1em;
    }
</style>
