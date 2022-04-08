<template>
  <div class="row">
    <div class="col-md-12">
      {{ student.name }}
    </div>
    <div class="col-md-12 mt-2">
      {{ student.dob | formatDate }}
    </div>
    <div class="col-md-12 mt-2">
      {{ student.gender }}
    </div>
    <div class="col-md-12 mt-2">
      {{ student.country }}
    </div>
    <a
      class="stretched-link"
      @click="triggerEditForm"
    />
    <a
      class="text-danger deleteIconContainer"
      @click="triggerDelete"
    >
      <i
        class="bi bi-trash"
      />
    </a>
  </div>
</template>

<script>
export default {
  name: 'StudentComponent',
  props: {
    student: {
      type: Object,
      required: true,
    },
  },
  methods: {
    triggerEditForm() {
      this.$parent.triggerEditForm(this.student.id)
    },
    triggerDelete() {
      this.$parent.triggerDelete(this.student.id)
    },
  },
}
</script>
