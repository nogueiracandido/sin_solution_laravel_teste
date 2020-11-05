<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Nova Matrícula</div>
          <div class="card-body">
            <a href="/registration" class="btn btn-primary mb-3"
              ><i class="fas fa-arrow-left"></i> Voltar</a
            >
            <form v-on:submit.prevent>
              <div class="form-row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                  <label for="student_id">Aluno</label>
                   <select
                    :class="alert"
                    id="student_id"
                    v-model="student_id"
                    @change="clearAlertRequire"
                  >
                    <option disabled value="">Selecione um Aluno...</option>
                    <option
                      :value="item.id"
                      v-for="item in students"
                      :key="item.id"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                  <small v-if="required_message" class="text-danger"
                    >Este campo é obrigatório.</small
                  >
                  
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                  <label for="classroom_id">Turma</label>
                  <select
                    :class="alert"
                    id="classroom_id"
                    v-model="classroom_id"
                    @change="clearAlertRequire"
                  >
                    <option disabled value="">Selecione uma Turma...</option>
                    <option
                      :value="item.id"
                      v-for="item in classrooms"
                      :key="item.id"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                  <small v-if="required_message" class="text-danger"
                    >Este campo é obrigatório.</small
                  >
                  
                </div>
              </div>
              <button
                type="submit"
                v-on:click="validateForm"
                class="btn btn-primary mt-3"
              >
                Enviar
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Request } from "../../service/Request";
export default {
   props: ["classrooms","students"],
  data() {
    return {
      student_id:"",
      classroom_id:"",
      alert: "form-control",
      required_message: false,
    };
  },
  methods: {
    validateForm: function () {
      this.student_id == "" || this.classroom_id == "" ? this.alertRequire() : this.store();
    },
    alertRequire: function () {
      this.alert = "form-control is-invalid";
      this.required_message = true;
    },
    clearAlertRequire: function () {
      this.alert = "form-control";
      this.required_message = false;
    },
    store: async function () {
      let store = new Request();
      let url = "/registration";

      let data = {
        student_id: this.student_id,
        classroom_id:this.classroom_id
      };

      let response = await store.customRquest(url, data, 'POST', this.$csrf_token);
      response.status == "success" ? this.clearForm(response.message,1) : response.status == "error" ? this.clearForm(response.message,0) :  this.errorSubmit();
    },
    clearForm: function (message,type) {
      this.student_id = "";
      this.classroom_id = "";
      this.$swal({
        position: "center",
        icon: type == 1 ?"success" : "error",
        title: message,
        showConfirmButton: false,
        timer: 3000,
      });
    },
    errorSubmit: function () {
      this.$swal({
        position: "center",
        icon: "error",
        title: "A Matrícula não pode ser cadastrada!",
        showConfirmButton: false,
        timer: 3000,
      });
    },
  },
};
</script>
