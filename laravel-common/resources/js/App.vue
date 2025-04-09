<template>
  <div class="w-[100vw] h-[100vh] bg-amber-200 flex flex-col items-center justify-center">
      <nav>
          <router-link to="/rooms">Rooms</router-link>
      </nav>

      <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>