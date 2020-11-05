<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Novo Endereço</div>
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
                  <select
                    :class="alert"
                    id="students"
                    v-model="students"
                    @change="clearAlertRequire"
                  >
                    <option disabled value="">Selecione uma opção...</option>
                    <option
                      :value="item.id"
                      v-for="item in all_students"
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
                class="btn btn-primary"
                @click="validateForm"
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
import { maska } from "maska";
export default {
  directives: { maska },
  props: ["all_students"],
  data() {
    return {
      street: "",
      number: "",
      complement: "",
      neighborhood: "",
      city: "",
      state: "",
      zip_code: "",
      students: "",
      alert: "form-control",
      required_message: false,
    };
  },
  mounted() {},
  methods: {
  
    validateForm: function () {
      this.zip_code == "" || this.street == "" || this.students == ""
        ? this.alertRequire()
        : this.store();
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
      let url = "/adress";

      let data = {
        student_id: this.students,
        street: this.street,
        number: this.number,
        complement: this.complement,
        neighborhood: this.neighborhood,
        city: this.city,
        state:this.state,
        zip_code:this.zip_code.replace(/\D/g, "")
      };

      let response = await store.customRquest(url,data,"POST",this.$csrf_token);
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
        }
      }
    },
    clearForm: function (message) {
      
      this.street = "",
      this.number = "",
      this.complement = "",
      this.neighborhood = "",
      this.city = "",
      this.state = "",
      this.zip_code = "",
      this.students = "",

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
        title: "O Endereço não pode ser cadastrado!",
        showConfirmButton: false,
        timer: 3000,
      });
    },
  },
};
</script>
