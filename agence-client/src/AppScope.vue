<script setup>
import './assets/main.css'
import './assets/main.js'
import {  RouterView } from 'vue-router'
import HeaderView from './components/layouts/HeaderView.vue'
import SidebarView from './components/layouts/SidebarView.vue'
import FooterView from './components/layouts/FooterView.vue'

</script>

<template>
  <div id="app" class="fix-header fix-sidebar card-no-border">
    <!-- <div class="preloader">
      <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
      </svg>
    </div> -->
    <div id="main-wrapper">
      <HeaderView />
      <SidebarView />
      <div class="page-wrapper">
        <router-view></router-view>
        <FooterView />
      </div>
    </div>
  </div>
</template>

<style scoped></style>
