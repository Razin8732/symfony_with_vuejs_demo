<template>
  <div>
    <div
      class="alert alert-danger"
      role="alert"
    >
      <div v-if="typeof error === 'string'">
        <div v-if="error == ''">
          Internal Server error (500)
        </div>
        <div v-else />
        {{ error }}
      </div>
      <div v-else>
        <div v-if="error.response.data == undefined">
          {{ error.response.data.error }}
        </div>
        <div v-else>
          Somthing went wrong please reload and try again
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ErrorMessage',
  props: {
    error: {
      required: false,
    },
  },
}
</script>
