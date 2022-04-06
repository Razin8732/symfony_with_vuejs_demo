<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <h1>Posts</h1>
      </div>
    </div>
    <div class="row">
      <form>
        <div class="form-row">
          <div class="col-md-8">
            <input
              v-model="title"
              type="text"
              class="form-control"
              placeholder="Title"
            >
            <textarea
              id="description"
              v-model="description"
              name="description"
              class="form-control mt-2"
              placeholder="Description"
            />
          </div>
          <div class="col-md-4">
            <button
              :disabled="
                title.length === 0 || description.length === 0 || isLoading
              "
              type="button"
              class="btn btn-primary mt-3"
              @click="create()"
            >
              Create Post
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="row">
      <div
        v-if="isLoading"
        class="col-12"
      >
        <p>Loading....</p>
      </div>
      <div
        v-else-if="hasError"
        class="col-12"
      >
        <div
          class="alert alert-danger"
          role="alert"
        >
          {{ error }}
        </div>
      </div>
      <div
        v-else-if="!hasPosts"
        class="col-md-12"
      >
        No Posts!
      </div>
      <div
        v-for="post in posts"
        v-else
        :key="post.id"
        class="col-md-3 border rounded-3 ms-2 p-2 mt-2"
      >
        <PostComponent
          :title="post.title"
          :description="post.description"
        />
      </div>
    </div>
  </div>
</template>


<script>
import PostComponent from "../components/PostComponent";
export default {
  name: "Post",
  components: {
    PostComponent,
  },
  data() {
    return {
      title: "",
      description: "",
    };
  },
  computed: {
    isLoading() {
      return this.$store.getters["post/isLoading"];
    },
    hasError() {
      return this.$store.getters["post/hasError"];
    },
    error() {
      return this.$store.getters["post/error"];
    },
    hasPosts() {
      return this.$store.getters["post/hasPosts"];
    },
    posts() {
      return this.$store.getters["post/posts"];
    },
  },
  created() {
    this.$store.dispatch("post/getAllPosts");
  },
  methods: {
    async create() {
      const result = await this.$store.dispatch("post/create", {
        title: this.$data.title,
        description: this.$data.description,
      });
      if (result != null) {
        this.$data.title = "";
        this.$data.description = "";
      }
    },
  },
};
</script>