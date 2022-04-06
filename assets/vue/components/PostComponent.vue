<template>
  <!-- <div>
    <div class="card w-100 mt-2">
      <div class="card body">
        <div class="row">
          <div class="col-md-12">
            {{ title }}
          </div>
          <div class="col-md-12">
            {{ description }}
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <div class="col-md-3">
    <div class="row">
      <div class="col-md-12">
        {{ title }}
      </div>
      <div class="col-md-12 mt-2">
        {{ description }}
      </div>
    </div>
  </div>
</template>


<script>
export default {
  name: "PostComponent",
  props: {
    title: {
      type: String,
      required: true,
    },
    description: {
      type: String,
      required: true,
    },
  },
};
</script>