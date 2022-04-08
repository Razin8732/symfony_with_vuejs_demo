<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <h1>Posts</h1>
      </div>
    </div>
    <div
      v-if="canCreatePost"
      class="row"
    >
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

            <b-form-file
              v-model="file"
              placeholder="File"
              accept="image/*"
              plain
              class="form-control mt-2"
              @change="onFileChange"
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
        class="row col"
      >
        <error-message :error="error" />
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
          :data-file="post.file"
        />
      </div>
    </div>
  </div>
</template>


<script>
import PostComponent from "../components/PostComponent";
import ErrorMessage from "../components/ErrorMessage";

export default {
  name: "Post",
  components: {
    PostComponent,
    ErrorMessage,
  },
  data() {
    return {
      title: "",
      description: "",
      file: [],
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
    canCreatePost() {
      return this.$store.getters["security/hasRole"]("ROLE_USER");
    },
  },
  created() {
    this.$store.dispatch("post/getAllPosts");
  },
  methods: {
    async create() {
      let formData = new FormData();
      formData.append("title", this.title);
      formData.append("description", this.description);
      formData.append("file", this.file);
      const result = await this.$store.dispatch("post/create", formData);
      if (result != null) {
        this.$data.title = "";
        this.$data.description = "";
        this.$data.file = [];
      }
    },
    onFileChange(e) {
      const file = e.target.files[0];
      this.url = URL.createObjectURL(file);
    },
  },
};
</script>