<template>
  <div>
    <div class="row">
      <div class="col-md-12 py-3">
        <h3>Basic Form Crud</h3>
      </div>
    </div>
    <div
      v-if="canCreateStudent"
      class="row"
    >
      <form
        ref="studentForm"
        @submit="checkForm"
      >
        <input
          id="id"
          v-model="id"
          type="hidden"
          name="id"
        >
        <div class="form-row">
          <div class="col-md-8">
            <label for="name">Full Name</label>
            <input
              id="name"
              v-model="name"
              type="text"
              class="form-control w-50"
              placeholder="Name"
            >
            <label for="date">Date Of Birth</label>
            <input
              id="date"
              v-model="dob"
              type="date"
              name="dob"
              class="form-control w-50 mt-2"
              placeholder="Date Of Birth"
            >
            <div class="form-group">
              <label>Gender</label>
              <br>
              <div class="form-check form-check-inline mt-2">
                <input
                  id="flexRadioDefault1"
                  v-model="gender"
                  class="form-check-input"
                  type="radio"
                  name="gender"
                  value="male"
                >
                <label
                  class="form-check-label"
                  for="flexRadioDefault1"
                >
                  Male
                </label>
              </div>
              <div class="form-check form-check-inline mt-2">
                <input
                  id="flexRadioDefault2"
                  v-model="gender"
                  class="form-check-input"
                  type="radio"
                  name="gender"
                  value="female"
                >
                <label
                  class="form-check-label"
                  for="flexRadioDefault2"
                >
                  Female
                </label>
              </div>
              <div class="form-check form-check-inline mt-2">
                <input
                  id="flexRadioDefault3"
                  v-model="gender"
                  class="form-check-input"
                  type="radio"
                  name="gender"
                  value="other"
                >
                <label
                  class="form-check-label"
                  for="flexRadioDefault3"
                >
                  Other
                </label>
              </div>
            </div>
            <label for="country">Country</label>
            <input
              id="country"
              v-model="country"
              type="text"
              name="country"
              class="form-control w-50 mt-2"
              placeholder="Country"
              list="country_datalist"
            >
            <datalist id="country_datalist">
              <option value="India">
                <option value="Pakistan">
                  <option value="UAS" />
                </option>
              </option>
            </datalist>
          </div>
          <div
            v-if="actionEditBtn == false"
            class="col-md-4"
          >
            <button
              :disabled="name.length == 0 || gender.length == 0 || country.length == 0 || isLoading"
              type="button"
              class="btn btn-primary mt-3"
              @click="create()"
            >
              Create
            </button>
            <button
              type="reset"
              class="btn btn-secondary mt-3"
              @click="resetValues()"
            >
              Reset
            </button>
          </div>
          <div
            v-else
            class="col-md-4"
          >
            <button
              :disabled="name.length == 0 || gender.length == 0 || country.length == 0 || isLoading"
              type="button"
              class="btn btn-primary mt-3"
              @click="update()"
            >
              Update
            </button>
            <button
              type="reset"
              class="btn btn-secondary mt-3"
              @click="resetValues()"
            >
              Cancel
            </button>
          </div>
        </div>
      </form>
    </div>
    <div v-else>
      <div class="row">
        <div class="col-md-12">
          <h3>You don't have permission to create.</h3>
        </div>
      </div>
    </div>

    <div class="row">
      <div
        v-if="isLoading"
        class="col-md-12"
      >
        <p>Loading....</p>
      </div>
      <div
        v-else-if="error"
        class="col-md-12"
      >
        <error-message :error="error" />
      </div>
    </div>
    <div class="row">
      <div
        v-if="students.length === 0"
        class="col-md-12"
      >
        No Students!
      </div>
      <div
        v-for="student in students"
        v-else
        :key="student.id"
        class="col-md-3 border rounded-3 ms-2 p-2 mt-2 position-relative cusrsor-pointer hover-shadow "
      >
        <StudentComponent :student="student" />
      </div>
    </div>
  </div>
</template>

<script>
import StudentComponent from '../components/StudentComponent'
import ErrorMessage from '../components/ErrorMessage'
import axios from 'axios'
import moment from 'moment';
import Swal from 'sweetalert2/dist/sweetalert2.js'
export default {
  name: 'Student',
  components: {
    StudentComponent,
    ErrorMessage,
  },
  data() {
    return {
      id: '',
      name: '',
      dob: '',
      gender: '',
      country: '',
      isLoading: true,
      hasError: false,
      actionEditBtn:false,
      error: '',
      students: [],
    }
  },
  computed: {
    canCreateStudent() {
      return this.$store.getters['security/hasRole']('ROLE_USER')
    }
  },
  created() {
    //   handle list of students here
    this.fetchAllStudents();
  },
  methods: {
    checkForm(e) {
      let birthday = moment(moment.now()).diff(moment(this.dob, "YYYY.MM.DD"),"years");
      if(birthday >= 18) {
        this.hasError = false;
        this.error = '';
      }else{
        this.error = "Must be 18 or above";
        this.hasError = true;
        return false;
      }
    },
    create(){
      var isValid = this.checkForm();
      if(isValid == false){
        return false;
      }else{
        let formdata = new FormData();
        formdata.append('name', this.name);
        formdata.append('dob', this.dob);
        formdata.append('gender', this.gender);
        formdata.append('country', this.country);

        axios.post('api/students/create',formdata)
          .then((response) => {
            this.fetchAllStudents();
            this.resetValues();
         
          })
          .catch((error) => {
            this.hasError = true
            this.error = error
            this.isLoading = false
          });

      }
    },
    update(){
      var isValid = this.checkForm();
      if(isValid == false){
        return false;
      }else{
        let formdata = new FormData();
        formdata.append('name', this.name);
        formdata.append('dob', this.dob);
        formdata.append('gender', this.gender);
        formdata.append('country', this.country);

        axios.post('api/students/'+this.id,formdata)
          .then((response) => {
            this.fetchAllStudents();
            this.resetValues();
          })
          .catch((error) => {
            this.hasError = true
            this.error = error
            this.isLoading = false
          });

      }
    },
    fetchAllStudents(){
      this.isLoading = true;
      axios
        .get('/api/students')
        .then((response) => {
          this.students = response.data
          this.isLoading = false
        })
        .catch((error) => {
          this.hasError = true
          this.error = error
          this.isLoading = false
        })
    },
    triggerEditForm(id){
      this.isLoading = true;
      axios.get('/api/students/'+id)
        .then((response) => {
          let data = response.data;
          this.id = data.id;
          this.name = data.name;
          this.dob =moment(data.dob).format('YYYY-MM-DD');
          this.gender = data.gender;
          this.country = data.country;
          this.isLoading = false
          this.actionEditBtn = true;
        })
        .catch((error) => {
          this.hasError = true
          this.error = error
          this.isLoading = false
        });
    },
    triggerDelete(id){
      this.isLoading = true;
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete('/api/students/'+id)
            .then((response) => {
              this.isLoading = false
              this.fetchAllStudents();
              this.resetValues();
            })
            .catch((error) => {
              this.hasError = true
              this.error = error
              this.isLoading = false
            });
          Swal.fire(
            'Deleted!',
            'Data has been deleted.',
            'success'
          );
        }
      });
     
    },
    // handle create method here
    resetValues(){
      this.name = '';
      this.dob = '';
      this.gender ='';
      this.country ='';
      this.error='';
      this.isLoading = false;
      this.actionEditBtn = false;

    }
  },
}
</script>
