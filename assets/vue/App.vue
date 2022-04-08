<template>
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <router-link
        class="navbar-brand"
        to="/home"
      >
        App
      </router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon" />
      </button>
      <div
        id="navbarNav"
        class="collapse navbar-collapse"
      >
        <ul class="navbar-nav">
          <router-link
            class="nav-item"
            tag="li"
            to="/home"
            active-class="active"
          >
            <a class="nav-link">Home</a>
          </router-link>
          <router-link
            v-if="isAuthenticated"
            class="nav-item"
            tag="li"
            to="/posts"
            active-class="active"
          >
            <a class="nav-link">Posts</a>
          </router-link>
          <router-link
            v-if="isAuthenticated"
            class="nav-item"
            tag="li"
            to="/students"
            active-class="active"
          >
            <a class="nav-link">Students</a>
          </router-link>
          <router-link
            v-if="isAuthenticated == false"
            class="nav-item"
            tag="li"
            to="/login"
            active-class="active"
          >
            <a class="nav-link">Login</a>
          </router-link>
          <li
            v-if="isAuthenticated"
            class="nav-item"
          >
            <a
              class="nav-link"
              href="/api/security/logout"
            >Logout</a>
          </li>
        </ul>
      </div>
    </nav>

    <router-view />
  </div>
</template>

<script>
import axios from 'axios'
import Swal from 'sweetalert2/dist/sweetalert2.js'
export default {
  name: 'App',
  computed: {
    isAuthenticated() {
      return this.$store.getters['security/isAuthenticated']
    },
  },
  created() {
    let isAuthenticated = JSON.parse(
        this.$parent.$el.attributes['data-is-authenticated'].value,
      ),
      user = JSON.parse(this.$parent.$el.attributes['data-user'].value)

    let payload = { isAuthenticated: isAuthenticated, user: user }
    this.$store.dispatch('security/onRefresh', payload)

    axios.interceptors.response.use(undefined, (err) => {
      if (err.response.status === 401) {
        // this.$router.push({ path: '/api/security/logout' })
        window.location.href = '/login';
      }
      return new Promise(() => {
        if (err.response.status === 500) {
          Swal.fire({
            title: 'Error',
            text: 'Internal Server Error',
            icon: 'error',
          })
          // document.open()
          // document.write(err.response.data)
          // document.close()
        }
        throw err
      })
    })
  },
}
</script>
