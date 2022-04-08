<template>
  <div class="row">
    <div class="col-md-12">
      <h3>Login</h3>
    </div>
    <div class="col-md-12">
      <form>
        <div class="row">
          <div class="col-md-6 ml-2">
            <input
              v-model="username"
              type="text"
              class="form-control"
            >
          </div>
          <div class="col-md-6 ml-2">
            <input
              v-model="password"
              type="password"
              class="form-control"
            >
          </div>
          <div class="col-md-6 ml-2">
            <button
              :disabled="
                username.length === 0 || password.length === 0 || isLoading
              "
              type="button"
              class="btn btn-primary"
              @click="performLogin()"
            >
              Login
            </button>
          </div>
        </div>
      </form>
    </div>

    <div
      v-if="isLoading"
      class="row col"
    >
      <p>Loading...</p>
    </div>

    <div
      v-else-if="hasError"
      class="row col"
    >
      <error-component :error="error" />
    </div>
  </div>
</template>

<script>
import ErrorComponent from "../components/ErrorMessage";
export default {
  name: "Login",
  components: {
    ErrorComponent,
  },
  data() {
    return {
      username: "",
      password: "",
    };
  },
  computed: {
    isLoading() {
      return this.$store.getters["security/isLoading"];
    },
    hasError() {
      return this.$store.getters["security/hasError"];
    },
    error() {
      return this.$store.getters["security/error"];
    },
  },

  created() {
    let redirect = this.$route.query.redirect;
    if (this.$store.getters["security/isAuthenticated"]) {
      if (typeof redirect !== "undefined") {
        this.$router.push({ path: redirect });
      } else {
        this.$router.push({ path: "/home" });
      }
    }
  },

  methods: {
    async performLogin() {
      let payload = {
          username: this.$data.username,
          password: this.$data.password,
        },
        redirect = this.$route.query.redirect;
      await this.$store.dispatch("security/login", payload);
      if (!this.$store.getters["security/hasError"]) {
        if (typeof redirect !== "undefined") {
          this.$router.push({ path: redirect });
        } else {
          this.$router.push({ path: "/home" });
        }
      }
    },
  },
};
</script>