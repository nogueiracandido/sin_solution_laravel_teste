<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Editar {{ name }}</div>
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
                :disabled="name == undefined ? true : false"
              >
                Atualizar
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
  props: ["classroom"],
  data() {
    return {
      room_id: "",
      name: "",
      alert: "form-control",
      required_message: false,
    };
  },
  mounted() {
   
     this.room_id = this.classroom.id;
      this.name = this.classroom.name;
       },
  methods: {
    validateForm: function () {
      this.name == "" ? this.alertRequire() : this.update();
    },
    alertRequire: function () {
      this.alert = "form-control is-invalid";
      this.required_message = true;
    },
    clearAlertRequire: function () {
      this.alert = "form-control";
      this.required_message = false;
    },
    update: async function () {
      let update = new Request();
      let url = `/classroom`;

      let data = {
        id: this.room_id,
        name: this.name,
      };

      let response = await update.customRquest(
        url,
        data,
        "PUT",
        this.$csrf_token
      );
      response.status == "success"
        ? this.successUpdate(response.message)
        : this.errorUpdate();
    },
    successUpdate: function (message) {
      this.$swal({
        position: "center",
        icon: "success",
        title: message,
        showConfirmButton: false,
        timer: 3000,
      });
    },
    errorUpdate: function () {
      this.$swal({
        position: "center",
        icon: "error",
        title: "O Aluno não pode ser cadastrado!",
        showConfirmButton: false,
        timer: 3000,
      });
    },
  },
};
</script>
