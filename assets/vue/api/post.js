import axios from "axios";

export default {
  getAllPosts() {
    return axios.get("/api/posts");
  },
  getPost(id) {
    return axios.get("/api/posts/" + id);
  },
  create(post) {
    return axios.post("/api/posts", post);
  },
  updatePost(id, post) {
    return axios.put("/api/posts/" + id, post);
  },
  deletePost(id) {
    return axios.delete("/api/posts/" + id);
  }
};