<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Lista de Endereços</div>
          <div class="card-body">
            <a href="/adress/create" class="btn btn-primary mb-5"
              ><i class="fas fa-plus"></i> Cadastrar Endereço</a
            >
            <div class="container" id="">
              <div class="filter input-group mb-3">
                <input
                  class="form-control"
                  type="text"
                  placeholder="Filtrar pelo CEP..."
                  v-model="filter_name"
                />
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>CEP</th>
                      <th>Logradouro</th>
                      <th>Número</th>
                      <th>Cidade</th>
                      <th>Aluno</th>
                      <th>Editar</th>
                      <th>Excluir</th>
                    </tr>
                  </thead>
                  <tbody>
                  <tr
                    v-for="(r, index) in filteredRows.slice(
                      pageStart,
                      pageStart + countOfPage
                    )"
                  >
                    <th>{{ (currPage - 1) * countOfPage + index + 1 }}</th>
                    <td>{{ changeCep(r.zip_code) }}</td>
                    <td>{{ r.street }}</td>
                    <td>{{ r.number }}</td>
                    <td>{{ r.city }}</td>
                    <td>{{ r.student.name}}</td>
                    <td><a class="pointer" :href="'/adress/edit/'+r.id"><i class="fas fa-pencil-alt"></i></a></td>
                    <td><a class="pointer" v-on:click="deleteAdress(r.id)"><i class="fas fa-trash-alt"></i></a></td>
                  </tr>
                </tbody>
                </table>
              </div>
              <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                  <li
                    class="page-item"
                    v-bind:class="{ disabled: currPage === 1 }"
                    @click.prevent="setPage(currPage - 1)"
                  >
                    <a class="page-link" href="">Anterior</a>
                  </li>
                  <li
                    class="page-item"
                    v-for="n in totalPage"
                    v-bind:class="{ active: currPage === n }"
                    @click.prevent="setPage(n)"
                  >
                    <a class="page-link" href="">{{ n }}</a>
                  </li>
                  <li
                    class="page-item"
                    v-bind:class="{ disabled: currPage === totalPage }"
                    @click.prevent="setPage(currPage + 1)"
                  >
                    <a class="page-link" href="">Próxima</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8"></div>
    </div>
  </div>
</template>

<script>
import { Request } from "../../service/Request";

export default {
  props:['adresses'],
  data() {
    return {
      rows: this.adresses,
      countOfPage: 5,
      currPage: 1,
      filter_name: "",
    };
  },
  computed: {
    filteredRows: function () {
      var filter_name = this.filter_name.toLowerCase();
      return this.filter_name.trim() !== ""
        ? this.rows.filter(function (d) {
            return `${d.zip_code.substring(0,5)}-${d.zip_code.substring(5,8)}`.toLowerCase().indexOf(filter_name) > -1;
            
          })
        : this.rows;
    },
    pageStart: function () {
      return (this.currPage - 1) * this.countOfPage;
    },
    totalPage: function () {
      return Math.ceil(this.filteredRows.length / this.countOfPage);
    },
  },
  methods: {
    setPage: function (idx) {
      if (idx <= 0 || idx > this.totalPage) {
        return;
      }
      this.currPage = idx;
    },
    changeCep: function(zip){
      return `${zip.substring(0,5)}-${zip.substring(5,8)}`
    },
    deleteAdress: async function (id) {
      let del = new Request();
      let url = "/adress";

      let data = {
        id: id,
      };
      const { value: remove } = await this.$swal({
        title: "Você tem certeza?",
        text: `O Endereço será removido do sistema!`,
        icon: "warning",
        showCancelButton: true,
        focusCancel: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, remover!",
        cancelButtonText: "Cancelar",
      });

      if (remove) {
        this.rows = await del.customRquest(
          url,
          data,
          "DELETE",
          this.$csrf_token
        );

        this.$swal({
          position: "center",
          icon: "success",
          title: `Endereço removido com sucesso.`,
          showConfirmButton: false,
          timer: 3000,
        });
      }
    },
  },
};
</script>

<style scoped>
.pointer {
  cursor: pointer !important;
}
</style>
