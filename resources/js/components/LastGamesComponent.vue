<template>
    <ul class="nav float-right">
        <li class="nav-link squished">Last 10 Games</li>
        <li class="nav-link squished" href="#" v-for="game in games" :key="game.id">

        </li>
    </ul>
</template>

<script>
export default {
name: "Last10Games",
    props: ['games'],
}
</script>

<style scoped>

</style>
