<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Nova Turma</div>
          <div class="card-body">
            <a href="/classroom" class="btn btn-primary mb-3"
              ><i class="fas fa-arrow-left"></i> Voltar</a
            >
            <form v-on:submit.prevent>
              <div class="form-row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                  <label for="name">Nome</label>
                  <input
                    type="text"
                    :class="alert"
                    id="name"
                    v-model="name"
                    v-on:keyup="clearAlertRequire"
                  />
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
  data() {
    return {
      name: "",
      alert: "form-control",
      required_message: false,
    };
  },
  methods: {
    validateForm: function () {
      this.name == "" ? this.alertRequire() : this.store();
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
      let url = "/classroom";

      let data = {
        name: this.name,
      };

      let response = await store.customRquest(url, data, 'POST', this.$csrf_token);
      response.status == "success"
        ? this.clearForm(response.message)
        : this.errorSubmit();
    },
    clearForm: function (message) {
      this.name = "";
      this.$swal({
        position: "center",
        icon: "success",
        title: message,
        showConfirmButton: false,
        timer: 3000,
      });
    },
    errorSubmit: function () {
      this.$swal({
        position: "center",
        icon: "error",
        title: "A Turma não pode ser cadastrada!",
        showConfirmButton: false,
        timer: 3000,
      });
    },
  },
};
</script>
