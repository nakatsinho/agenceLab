<script setup>
import { RouterLink, RouterView } from 'vue-router'

</script>

<template>
  <div class="fix-header fix-sidebar card-no-border">
    <!-- <div class="preloader">
      <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
      </svg>
    </div> -->
    <div id="main-wrapper">
      <div class="page-wrapper">
        <RouterLink :to="{ name: 'home' }">Auth</RouterLink>
        <RouterView></RouterView>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
