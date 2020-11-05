<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Editar Endereço {{ zip_code }}</div>
          <div class="card-body">
            <a href="/adress" class="btn btn-primary mb-3"
              ><i class="fas fa-arrow-left"></i> Voltar</a
            >
            <form v-on:submit.prevent>
              <div class="form-row">
                <div class="form-group col-md-2">
                  <label for="zip_code">CEP</label>
                  <input
                    v-maska="'#####-###'"
                    type="text"
                    :class="alert"
                    id="zip_code"
                    v-model="zip_code"
                    @blur="handleCep"
                  />
                  <small v-if="required_message" class="text-danger"
                    >Este campo é obrigatório.</small
                  >
                </div>
                <div class="form-group col-md-6">
                  <label for="street">Logradouro</label>
                  <input
                    type="text"
                    :class="alert"
                    id="street"
                    v-model="street"
                    @blur="clearAlertRequire"
                  />
                  <small v-if="required_message" class="text-danger"
                    >Este campo é obrigatório.</small
                  >
                </div>
                <div class="form-group col-md-4">
                  <label for="number">Número</label>
                  <input
                    type="number"
                    class="form-control"
                    id="number"
                    v-model="number"
                    min="0"
                  />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="complement">Complemento</label>
                  <input
                    type="text"
                    class="form-control"
                    id="complement"
                    v-model="complement"
                  />
                </div>
                <div class="form-group col-md-6">
                  <label for="neighborhood">Bairro</label>
                  <input
                    type="text"
                    class="form-control"
                    id="neighborhood"
                    v-model="neighborhood"
                  />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="city">Cidade</label>
                  <input
                    type="text"
                    class="form-control"
                    id="city"
                    v-model="city"
                  />
                </div>
                <div class="form-group col-md-6">
                  <label for="state">Estado</label>
                  <input
                    type="text"
                    class="form-control"
                    id="state"
                    v-model="state"
                    maxlength="2"
                  />
                </div>
                <div class="form-group col-md-6">
                  <label for="students">Aluno</label>
                  <select class="form-control" id="students">
                    <option :value="adress[0].student.id" :selected="true">
                      {{ adress[0].student.name }}
                    </option>
                    <option
                      :value="item.id"
                      v-for="item in all_students"
                      :key="item.id"
                      v-if="item.id != adress[0].student.id"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                </div>
              </div>
              <button
                type="submit"
                class="btn btn-primary"
                @click="validateForm"
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
import { maska } from "maska";
export default {
  directives: { maska },
  props: ["adress", "all_students"],
  data() {
    return {
      street: "",
      number: "",
      complement: "",
      neighborhood: "",
      city: "",
      state: "",
      zip_code: "",
      alert: "form-control",
      required_message: false,
    };
  },
  mounted() {
    console.log(this.adress[0].id);
    this.street = this.adress[0].street;
    this.number = this.adress[0].number;
    this.complement = this.adress[0].complement;
    this.neighborhood = this.adress[0].neighborhood;
    this.city = this.adress[0].city;
    this.state = this.adress[0].state;
    this.zip_code = `${this.adress[0].zip_code.substring(
      0,
      5
    )}-${this.adress[0].zip_code.substring(5, 8)}`;
  },
  methods: {
    validateForm: function () {
      this.zip_code == "" || this.street == "" || this.students == ""
        ? this.alertRequire()
        : this.update();
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
      let url = "/adress";

      let data = {
        id: this.adress[0].id,
        student_id: document.getElementById("students").value,
        street: this.street,
        number: this.number,
        complement: this.complement,
        neighborhood: this.neighborhood,
        city: this.city,
        state: this.state,
        zip_code: this.zip_code.replace(/\D/g, ""),
      };

      let response = await update.customRquest(
        url,
        data,
        "PUT",
        this.$csrf_token
      );
      response.status == "success"
        ? this.clearForm(response.message)
        : this.errorSubmit();
    },
    handleCep: async function () {
      this.clearAlertRequire();
      if (this.zip_code != "") {
        let zip = new Request();
        let url = `${this.$via_cep}/${this.zip_code}/json`;
        let response = await zip.simpleRequest(url);
        if (!response.erro) {
          this.street = response.logradouro;
          this.complement = response.complemento;
          this.neighborhood = response.bairro;
          this.city = response.localidade;
          this.state = response.uf;
        } else {
          this.clearFields();
        }
      }
    },
    clearForm: function (message) {
      this.$swal({
        position: "center",
        icon: "success",
        title: message,
        showConfirmButton: false,
        timer: 3000,
      });
    },
    clearFields: function () {
      (this.street = ""),
        (this.number = ""),
        (this.complement = ""),
        (this.neighborhood = ""),
        (this.city = ""),
        (this.state = ""),
        (this.zip_code = "");
    },
    errorSubmit: function () {
      this.$swal({
        position: "center",
        icon: "error",
        title: "O Endereço não pode ser cadastrado!",
        showConfirmButton: false,
        timer: 3000,
      });
    },
  },
};
</script>
