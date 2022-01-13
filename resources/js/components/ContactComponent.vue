<template>
  <div class="col-8 offset-2">
    <div class="card">
      <div class="card-header">
        <img src="/images/logo.png" class="logo_200 mx-auto d-block" alt="">
      </div>
      <div class="card-body">
        <div class="input-group">
          <span class="input-group-text">Nombre</span>
          <input type="text" v-model="name" aria-label="First name" class="form-control" />
        </div>
        <div class="input-group mt-3">
          <span class="input-group-text">Apellido</span>
          <input type="text" v-model="surname" aria-label="First name" class="form-control" />
        </div>
        <div class="input-group mt-3">
          <span class="input-group-text">Email</span>
          <input type="email" v-model="email" aria-label="First name" class="form-control" />
        </div>
        <div class="input-group mt-3">
          <textarea class="form-control" v-model="content" placeholder="Comentarios"></textarea>
        </div>
        <button @click="saveContact()" class="btn btn-primary btn-lg float-end mt-3">Enviar</button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  created() {},
  methods: {
    saveContact() {
      console.log(this.name+this.surname+this.email+this.content);
      return;
      // fetch("/api/post/"+this.$route.params.id)
      //   .then(response => { return response.json() })
      //   .then(json => { this.post = json.data });
    },
  },
  data: function () {
    return {
      name:"",
      surname:"",
      email:"",
      content:""
    };
  },
};
</script>